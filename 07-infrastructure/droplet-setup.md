# DigitalOcean Droplet Setup

A small remote Linux server Jay can SSH into from any personal, unblocked device (a low-power laptop, a Chromebook, etc.) to run Claude Code and this repo's grading tooling without being tethered to a specific desktop. **Not a workaround for any device-level restriction** — this exists purely so work isn't tied to one machine's hardware, same as remoting into any dev box. Everything (Node.js, npm, git, Claude Code itself) is installed and runs *on the droplet* — the local device only needs an SSH client, which Windows/macOS/Linux all ship with.

The droplet's current public IP isn't recorded here on purpose — it can change if the droplet is ever destroyed and recreated (it already has been, twice, during initial setup). Check the DigitalOcean dashboard for the live IP.

## Quick Start: Setting Up a New Device (plain-language walkthrough)

Use this section when getting a *different* computer (e.g. an older laptop) able to connect for the first time. It assumes zero prior familiarity with any of these terms — everything is explained as it comes up.

### Step 1 — Get the connection key onto this device

To prove it's really you connecting, the droplet checks for a small file called an SSH key (already set up on Jay's main desktop, in a folder called `.ssh`). The simplest way to get a new device working is to copy that same key file over rather than making a brand new one:

1. On the desktop where the key already exists, find these two files: `C:\Users\Jay Fox\.ssh\id_ed25519` and `C:\Users\Jay Fox\.ssh\id_ed25519.pub`.
2. Copy both files onto a USB drive (or another private transfer method — not email, since one of these two files is meant to stay secret).
3. On the new device, create a folder called `.ssh` inside your user folder if one doesn't already exist, and copy both files into it.
4. In that same `.ssh` folder on the new device, create a file named `config` (no file extension) containing:
   ```
   Host foxcs-droplet
       HostName <droplet's current public IPv4 — check the DigitalOcean dashboard>
       User jay
       IdentityFile ~/.ssh/id_ed25519
   ```

*(A more locked-down approach — a separate key per device, so one device's access can be revoked without affecting others — is possible later; see "SSH key setup" below. Not necessary to start.)*

### Step 2 — Connect

1. Open **PowerShell** (Windows Start menu → type "PowerShell" → Enter) or **Terminal** (Mac).
2. Type `ssh foxcs-droplet` and press Enter.
3. Everything you type after this happens *on the remote server*, not on the device in front of you — think of it as remote-controlling a different computer.

### Step 3 — Start a session that survives disconnects

Type `tmux new -s work` and press Enter. `tmux` just means "keep this session running even if my connection drops or I close the laptop" — a safety net so nothing gets lost if wifi hiccups or the lid closes. A green bar at the bottom of the window means it's active.

If reconnecting later (rather than starting fresh), type `tmux attach -t work` instead — this picks back up exactly where you left off.

### Step 4 — Run Claude Code

1. Type `claude` and press Enter.
2. The first time on a new device, it'll print a web address (starts with `https://`). Select and copy that text, then open it in any browser (on any device — doesn't have to be the same one).
3. Log in with the Anthropic account and approve it there.
4. Switch back to the terminal — it should confirm you're logged in. (This login is tied to this specific installation, so a brand-new droplet would need this step again — but once done here, this device won't need to repeat it.)

**Where the actual work happens, and why this satisfies "goes through the droplet":** the browser is only used for that one moment of proving "yes, this is really me" — it's not an ongoing relay for anything after that. What actually happens:

1. `claude` runs *on the droplet* (you're SSH'd in, so that process is on the remote server, not the laptop in front of you).
2. That droplet-side process generates the login URL and waits.
3. Approving the URL in a browser (any device) is a one-time human click, nothing more.
4. Once approved, the droplet-side process receives and **stores the login credentials on the droplet's own filesystem** (a config folder under `jay`'s home directory).
5. From then on, every real Claude Code request — reading files, running the agent, calling the model — is a network call made **directly from the droplet to Anthropic's servers**. The laptop's only role, before and after login, is displaying the terminal text over SSH; it never touches the actual API traffic.

### Step 5 — Get to the actual project

Type `cd ~/FoxCS` and press Enter — this moves into the FoxCS repo folder, already cloned onto the droplet. From here, everything works the same as running Claude Code locally: read/edit files, run the grader, `git pull`/`git push`, etc.

## Spec used

- Ubuntu 24.04 LTS
- 1 vCPU / 1GB RAM ($6/mo tier) — Claude Code itself is lightweight (mostly network calls to Anthropic, not local compute), 1GB is comfortable headroom for Node/npm
- Region: NYC1
- Monitoring: enabled (free, no downside)
- Startup script: none — setup was done manually so each step could be verified

**Cost note:** this is a real recurring charge, billed hourly whether it's actively being used or not, ~$6-12/mo depending on size. **Powering off does NOT stop billing** — DigitalOcean charges the full rate as long as the droplet exists, powered on or off, since the disk/IP/resources stay reserved either way. The only way to actually stop being charged is to **destroy** the droplet, which deletes everything on it (this whole setup, the cloned repo) unless a snapshot is taken first (snapshots have their own small ongoing storage cost, much cheaper than a running droplet). If this will sit unused for a while and the cost matters, take a snapshot, destroy the droplet, and restore from the snapshot later — otherwise just leave it running.

## SSH key setup — do this before creating the droplet

Pasting a long SSH public key into DigitalOcean's browser-based Console (the emergency/recovery terminal) is unreliable — the console simulates keystrokes and can inject a stray newline mid-line on long pastes, corrupting the key, and DigitalOcean's own droplet agent (DOTTY) manages/rewrites `~/.ssh/authorized_keys` between console sessions in a way that can silently wipe manual edits. Both bit us during initial setup.

**Reliable path:** add the SSH key through DigitalOcean's normal SSH key manager (**Settings → Security → SSH Keys**, or the "Add SSH Key" option shown directly in the droplet-creation flow) *before* creating the droplet, then make sure that key is checked under "Authentication" when the droplet is created. DigitalOcean provisions it into `authorized_keys` automatically via cloud-init at first boot — no console step needed at all.

Each device that needs access should ideally get its own key pair (`ssh-keygen -t ed25519 -C "<device-label>"`) added to the droplet's authorized keys, rather than copying one private key between devices — makes it possible to revoke one device's access later without touching the others.

## What's installed

- Node.js 22.x (via NodeSource) + npm
- git
- tmux
- build-essential
- Claude Code CLI (`npm install -g @anthropic-ai/claude-code`)

## Hardening done

- Created a non-root sudo user (`jay`, passwordless sudo via `/etc/sudoers.d/jay`) — verified it could log in and use `sudo` *before* touching root access, so there was no risk of getting locked out.
- `PermitRootLogin no` and `PasswordAuthentication no` in `/etc/ssh/sshd_config` — SSH key auth only, no root login at all, verified both (successful `jay` login, rejected `root` login) after restarting `sshd`.
- UFW firewall enabled, only `OpenSSH` (port 22) allowed in.

## Connecting

Add an alias to `~/.ssh/config` on each device that needs access (this is device-local, not something to commit anywhere):

```
Host foxcs-droplet
    HostName <droplet's current public IPv4>
    User jay
    IdentityFile ~/.ssh/id_ed25519
```

Then just `ssh foxcs-droplet` from PowerShell/Terminal.

## Day-to-day usage

1. `ssh foxcs-droplet`
2. Start or resume a `tmux` session — this is what makes the "on the go" part actually work: if the connection drops (lid closed, wifi lost, switching devices), the session keeps running on the droplet and picks back up exactly where it left off.
   - First time: `tmux new -s work`
   - Reconnecting: `tmux attach -t work`
3. `cd` into the project folder and run `claude` as usual.
4. Just close the terminal/laptop when done — no explicit logout needed, tmux keeps it alive.

## GitHub access

The droplet has its own dedicated SSH key (`~/.ssh/github_deploy` on the droplet) added to the FoxCS repo as a **Deploy Key** (repo-scoped, not tied to Jay's personal GitHub account, "Allow write access" enabled) — see GitHub repo Settings → Deploy keys. Repo is cloned at `~/FoxCS` on the droplet. Scoped this way so revoking the droplet's access later (or if it's ever compromised) doesn't touch anything else.

## Not yet done

- Per-device SSH keys for any device beyond the one this was first set up from (currently every device shares one key pair, copied device to device — see the Quick Start above; splitting into one key per device is a nice-to-have, not urgent).
