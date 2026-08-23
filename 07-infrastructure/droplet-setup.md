# DigitalOcean Droplet Setup

A small remote Linux server Jay can SSH into from any personal, unblocked device (a low-power laptop, a Chromebook, etc.) to run Claude Code and this repo's grading tooling without being tethered to a specific desktop. **Not a workaround for any device-level restriction** — this exists purely so work isn't tied to one machine's hardware, same as remoting into any dev box. Everything (Node.js, npm, git, Claude Code itself) is installed and runs *on the droplet* — the local device only needs an SSH client, which Windows/macOS/Linux all ship with.

The droplet's current public IP isn't recorded here on purpose — it can change if the droplet is ever destroyed and recreated (it already has been, twice, during initial setup). Check the DigitalOcean dashboard for the live IP.

## Spec used

- Ubuntu 24.04 LTS
- 1 vCPU / 1GB RAM ($6/mo tier) — Claude Code itself is lightweight (mostly network calls to Anthropic, not local compute), 1GB is comfortable headroom for Node/npm
- Region: NYC1
- Monitoring: enabled (free, no downside)
- Startup script: none — setup was done manually so each step could be verified

**Cost note:** this is a real recurring charge, billed hourly whether it's actively being used or not, ~$6-12/mo depending on size. Destroy or power off the droplet if it'll sit unused for a while.

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

## Not yet done

- Authenticating Claude Code on the droplet (one-time interactive login).
- Getting the FoxCS repo onto the droplet (`git clone`) and deciding how it authenticates to GitHub from there (SSH deploy key vs. `gh auth login` device flow).
- Per-device SSH keys for any device beyond the one this was first set up from.
