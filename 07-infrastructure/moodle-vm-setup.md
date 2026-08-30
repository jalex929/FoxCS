# Moodle: Build/Dev Instance on the FoxCS Droplet

A **build and development** Moodle instance running on the `foxcs-droplet` (see `droplet-setup.md` for how that droplet itself was provisioned — SSH access, hardening, GitHub deploy key). **Not the production host** — Jay's plan is to build the Moodle side (themes, plugins, course structure, H5P content, iframe-embedded interactive components from this repo's component library) here, then host the real, student-facing instance somewhere else once it's ready. Where "elsewhere" is hasn't been decided yet — see Known gaps.

This is also a **separate Moodle instance** from the one on Jay's local Windows machine (`C:\Users\Jay Fox\server\moodle`, version 5.3dev) referenced in the root `CLAUDE.md` history — that local install still exists but is not this one, and neither shares a database or content with the other. Content built on one does not automatically appear on either of the others.

## Why this exists

Moodle work was paused 2026-08-04 (see `decisions-log.md`) pending a proven MVP content/grading loop. Resumed 2026-08-28 at Jay's explicit direction. See the 2026-08-28 `decisions-log.md` entry for the full reversal record.

## Stack

- **OS:** Ubuntu 24.04 LTS (the droplet's existing OS — no separate provisioning needed)
- **Moodle:** 5.2.2+ (Build: 20260818) — the latest stable branch as of 2026-08-28 (`MOODLE_502_STABLE`). Note: no Moodle "5.5.5" exists; if that version number comes up again, it's not real — check `git ls-remote --heads https://github.com/moodle/moodle.git` for the actual latest `MOODLE_xxx_STABLE` branch.
- **Web server:** Apache 2.4 + `libapache2-mod-php8.3`
- **PHP:** 8.3 (Ubuntu 24.04's default), with `curl gd mbstring xml soap zip intl mysqli pdo_mysql apcu opcache sodium` enabled
- **Database:** MariaDB 10.11, database `moodle`, user `moodleuser`

## Paths

| What | Where |
|---|---|
| Moodle code (git clone, `MOODLE_502_STABLE`) | `/var/www/moodle` — owned `jay:www-data`, world/group-readable, so Jay/Claude Code can edit plugins and themes directly without `sudo` |
| Web-exposed root (Apache `DocumentRoot`) | `/var/www/moodle/public` — **Moodle 5.x moved the webroot into a `public/` subdirectory**; `config.php` and CLI scripts (`admin/cli/*.php`) live one level up, outside the web-exposed tree |
| `moodledata` (uploads, cache, sessions) | `/var/www/moodledata` — owned `jay:www-data`, mode `2770` (setgid so files created by either the CLI-as-jay or Apache-as-www-data stay group-writable) |
| `config.php` | `/var/www/moodle/config.php` — mode `640`, owner `jay:www-data`. **Gotcha:** any edit that rewrites this file (rather than a true in-place patch) resets it to `jay:jay` and breaks Apache with a 500 (`Permission denied` in `moodle-error.log`) until re-chowned to `jay:www-data`. Check this first if the site 500s after a config change. |
| Apache vhost | `/etc/apache2/sites-available/moodle.conf` |
| DB password | `~/.moodle_db_pass` on the droplet (`chmod 600`, not in git) |
| Admin password | Set at install time to a temporary placeholder — **change this via the Moodle admin UI before real use**, see Known gaps below |

## Access

- **URL (from the droplet itself, e.g. `curl`):** `http://localhost`
- **URL (from Jay's browser):** not directly reachable — the firewall only allows SSH in (see Firewall below). Use an SSH tunnel: `ssh -L 8080:localhost:80 foxcs-droplet`, then browse `http://localhost:8080` on your own machine.
- **Admin login:** username `admin`
- **Firewall:** `ufw` allows only `22/tcp` (SSH) in, same as the droplet's original hardening in `droplet-setup.md`. Ports 80/443 were briefly opened and then deliberately closed again 2026-08-28 once the plan clarified this droplet is build/dev-only, not the production host — confirmed closed via an external fetch (connection refused from outside), since curling the droplet's own public IP *from itself* is misleading: Linux routes that traffic over loopback locally, so it looks reachable even when the firewall correctly blocks real external traffic. Don't trust a self-curl test of this box's own public IP as a reachability check — verify externally.
- **Cron:** system crontab (user `jay`) runs `/usr/bin/php /var/www/moodle/admin/cli/cron.php` every minute. Moodle's cron has its own keep-alive window, so it's normal to see more than one `cron.php` process alive briefly at once — not a stuck process.

## Known gaps — resolve before choosing/moving to a production host

- **Production hosting target not yet decided.** This droplet is deliberately not it — figure out where the real, student-facing instance will actually live (a proper hosting provider, a resized/dedicated droplet, managed Moodle hosting, etc.) before there's real content and student data to migrate.
- **No TLS / no domain** on this dev instance — not needed for a build-only box reached over SSH tunnel, but whatever the eventual production host is will need both before real credentials or student data touch it.
- **Temporary admin password** set at install time — fine for a build/dev instance, but rotate before treating this as anything more.
- **Droplet sizing.** `droplet-setup.md` describes this box as a lightweight ($6-12/mo, originally spec'd 1GB RAM tier though currently showing ~1.9GB total) remote dev box for running Claude Code — not sized with a live LMS in mind, but that's fine since it's build-only. Don't assume this sizing is adequate for the eventual production host without separately checking.
- **No backups configured** for the `moodle` database or `moodledata` yet.

## Day-to-day

Same SSH/tmux/Claude Code workflow as `droplet-setup.md` describes generally — this just adds Moodle as another thing running on the same box. `git status`/`git log` inside `/var/www/moodle` work normally for tracking upstream Moodle updates (it's a real clone of `moodle/moodle`, currently `--depth 1` — a shallow clone, so pulling further history later needs `git fetch --unshallow` first if ever needed); this is separate from the FoxCS repo itself.

## Migrating to the eventual production host

Not yet done — once a production host is chosen, moving this build's course structure/content/plugins over will mean either a Moodle course backup (`.mbz`) restore for course-level content, or a full `moodledata` + database dump for a complete site migration. Revisit this section once the host is picked.
