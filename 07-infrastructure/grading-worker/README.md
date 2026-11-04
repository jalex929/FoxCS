# Grading worker: on-submission grading with AI review on the Claude subscription

**Status: built and tested, not running on the droplet.** Nothing here has been installed. See "Before this goes live" below.

The whole loop costs nothing beyond the Claude subscription. The AI step uses Claude Code in non-interactive mode (`claude -p`), signed in to Jay's Claude account, not the paid API.

## How a submission moves

1. **Event listener (Moodle).** `07-infrastructure/local-plugins/foxcsgradequeue/` observes `\mod_assign\event\assessable_submitted`. For an allowlisted Coding Exercise it copies the submitted file to `/srv/foxcs-queue/files/moodle-sub-<id>/` and atomically drops an event JSON into `/srv/foxcs-queue/incoming/`. It never grades and never blocks a submission: if the queue is down, the submission still goes through.
2. **Worker (`portfolio-showcase/grader/review_worker.py`, run by `foxcs-review-worker.service`).** It checks the queue every 30 seconds and runs each event through `on_submission.py`:
   - `flawless` and `does_not_run` are settled by the program run. They become drafts with no AI call.
   - `runs_with_issues` needs judgment. The worker sends the code, the exercise rubric, and the run results (as trusted facts) to `claude -p` with the same system prompt and strict output schema the eval harness measures.
   - Anything the deterministic grader holds goes straight to Jay.
3. **Release check (Jay, weekly).** `grader/release_check.py --outputs /srv/foxcs-queue/review/outputs --rubrics ... --submissions /srv/foxcs-queue/review/submissions --drafts /srv/foxcs-queue/drafts.jsonl` blocks anything that can't be right, flags score/rationale disagreements, and picks the spot-check sample. Then the usual batch approval and grade-API push.

No result reaches a student without that approval. Failed AI reviews land in `failed/` with a reason and are never retried automatically: move one back to `incoming/` to try again, or grade it by hand.

## Why this stays free

- **Default backend is `claude-code`.** Before it processes anything, the worker runs `claude auth status --json` (no model call) and refuses to start unless `authMethod` is `claude.ai` (a `/login` session) or `oauth_token` (a `claude setup-token` token) with no API key in play. It exits with code 2, and the unit is set not to restart on that code.
- **API-key variables are removed** from the `claude` child process (`ANTHROPIC_API_KEY`, `ANTHROPIC_AUTH_TOKEN`), because Claude Code prefers an API key over the subscription when both are present.
- **`--bare` is never used.** It skips the subscription login and requires an API key.
- **Isolation without losing the login.** Each call runs in an empty temp folder with `--safe-mode` (no CLAUDE.md, hooks, plugins, skills, or MCP servers), `--tools ""`, `--strict-mcp-config`, and `--no-session-persistence`, so nothing on the server changes what the grader sees.
- **The paid path still exists, on purpose.** `--backend api` is there for comparison runs and has to be asked for by name.

Subscription usage counts against the plan's normal limits, shared with interactive Claude Code use. A week of held Coding Exercises is a few dozen short calls. If a limit is hit, those reviews fail into `failed/` and can be requeued later.

**Worth confirming:** that unattended, scheduled use of a subscription token on a server fits the current Claude plan terms. `claude setup-token` exists for this kind of non-interactive use, but the terms are Anthropic's to state, not this repo's.

## Before this goes live

1. **Sandbox the student-code runs.** This is the same blocker `on_submission.py` already has, and here it matters more: the worker holds the subscription token. Student programs must run as a **different Unix user** (or in a container) with no network, a read-only filesystem except a scratch folder, and no read access to `/etc/foxcs/`, `/var/lib/foxcs-grader/`, or the worker's process environment. A program running as the worker's own user could read the token.
2. **Back up first** (`/home/jay/moodle-backups/backup_moodle.sh`), per CLAUDE.md, before installing the plugin.
3. **Install the plugin.** Copy `local-plugins/foxcsgradequeue/` to `<moodle>/local/foxcsgradequeue/`, run `admin/cli/upgrade.php`, then set *Site administration > Plugins > Local plugins > FoxCS grading queue*: queue folder `/srv/foxcs-queue`, and the ID numbers of the Coding Exercises that have an exercise spec. Each one's ID number goes in its assignment settings.
4. **Create the queue and users.**
   ```bash
   sudo groupadd --system foxcs-queue
   sudo useradd --system --gid foxcs-queue --home /var/lib/foxcs-grader --shell /usr/sbin/nologin foxcs-grader
   sudo usermod -aG foxcs-queue www-data
   # Group-writable and setgid, so the worker can move events the web server wrote, whatever its umask.
   sudo install -d -o www-data -g foxcs-queue -m 2770 /srv/foxcs-queue /srv/foxcs-queue/incoming /srv/foxcs-queue/files
   ```
5. **Sign the worker in to the subscription.** On a machine with a browser, run `claude setup-token` and sign in with the Claude account. Put the token on the droplet as `CLAUDE_CODE_OAUTH_TOKEN=...` in `/etc/foxcs/claude-subscription.env` (owner root, mode 600). systemd reads it as root and passes it only to the service.
6. **Check it before enabling.**
   ```bash
   # Runs as the service user with the service's token, without putting the token on a command line.
   sudo systemd-run --pipe --wait -p User=foxcs-grader -p EnvironmentFile=/etc/foxcs/claude-subscription.env \
     -p Environment=CLAUDE_CONFIG_DIR=/var/lib/foxcs-grader/claude claude auth status --json   # authMethod must be oauth_token
   ```
   Then a one-pass dry run with a synthetic event, no `--watch`.
7. **Enable.** `sudo cp foxcs-review-worker.service /etc/systemd/system/ && sudo systemctl enable --now foxcs-review-worker`. Logs: `journalctl -u foxcs-review-worker`.

## Tests

- Worker: `portfolio-showcase/grader/tests/test_review_worker.py`. It runs the real deterministic grader with a fake AI backend, including a handoff into the release check that shows a contradicting or invented-evidence review gets blocked.
- `claude -p` backend and the subscription preflight: `portfolio-showcase/evals/tests/test_run_model.py`, with a fake CLI.
- Plugin logic: `php 07-infrastructure/local-plugins/foxcsgradequeue/tests/test_queue_lib.php`.
- A CI contract test feeds an event written by the PHP plugin code into the Python worker's parser, so the two sides can't drift apart.

All of these run in CI with no Moodle, no subscription, and no network. None of it has been exercised against the live site or a real `claude -p` call yet. The first real check is step 6 above.
