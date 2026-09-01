# Safe Exam Browser (SEB) — Instructor Setup Guide

**Status as of 2026-09-01: not currently in use.** SEB was briefly enabled on Python's 01.1/01.2 Mastery Checks and Seminar III's Lesson 1 diagnostic, then disabled after discovering it couldn't actually be deployed to students yet (see "Why this got turned off" below). All three currently use **password-only** protection. This guide is for when Jay is ready to roll SEB out for real.

## What SEB actually is

Safe Exam Browser is a **separate application students install on their own device**, not a browser feature or a Moodle setting alone. It locks the device into a single full-screen browser session pointed at one specific quiz, blocking tab-switching, other apps, and (depending on config) copy/paste and screen-reading tools. Moodle's role is just to require that the quiz can only be started from inside SEB, verified by a config-key handshake.

**This means two things have to both be true for a student to take an SEB-locked quiz:**
1. SEB is installed on the device they're using.
2. They open the quiz through a `.seb` configuration file (not a plain browser bookmark) that launches SEB pre-locked to that quiz.

## Why this got turned off (2026-09-01)

Jay reported he "can't even do anything with it right now" as the site admin — meaning SEB isn't installed anywhere yet, so the "Download configuration" button on a Moodle quiz just downloads an inert `.seb` file that does nothing when nothing is installed to open it. On top of that, most students are on school Chromebooks, and **SEB has no ChromeOS build at all** — it's Windows- and Mac-only. For any Chromebook student, SEB is never going to be an option; password-only is the real long-term answer for them regardless of what gets set up for Windows devices.

Given that, dropping the SEB requirement everywhere and relying on password-only was the right call for now, rather than leaving a requirement live that most students literally cannot satisfy.

## Platform support (check this before doing anything else)

| Device | SEB support |
|---|---|
| Windows laptops/desktops | Yes — full native app |
| Mac | Yes — full native app |
| Chromebooks (ChromeOS) | **No.** No official SEB build exists for ChromeOS. Don't plan around this changing. |
| iPad | Yes, but a different app family (SEB for iOS) with its own separate setup — not covered here. |

If FoxCS students are a mix of Windows machines and Chromebooks, SEB can only ever cover the Windows subset. Password-only stays the mechanism for Chromebook students either way.

## Installing SEB (Windows, admin-installed)

1. Download the installer from the official source: **https://safeexambrowser.org/download_en.html** — get the current Windows release. Only use this official site; SEB verifies quiz config keys against its own binary, so a modified/unofficial build could silently break that verification or (worse) be untrustworthy.
2. Run the installer with admin rights on each machine (or push via whatever software-deployment tool the school's IT already uses for lab machines, if Jay has access to one — that scales far better than installing one-by-one).
3. No account or login is needed for SEB itself — it's a locked-down browser shell, not a service.
4. Verify install by opening SEB directly once (Start Menu → Safe Exam Browser) — it should launch to a blank SEB start page.

## Turning SEB back on for a specific quiz (once it's installed)

This is a Moodle-side setting per quiz, not a one-time site setting:

1. In the quiz's **Settings → Extra restrictions on attempts**, find **Safe Exam Browser** and set it to **"Use SEB client config"** (or via the `quizaccess_seb` config directly — the build scripts in `07-infrastructure/moodle-scripts/` already contain working examples of this, e.g. `enable-seb-mastery-check-01-01.php`, or the SEB block in `build-lesson-01-02-mastery-check.php` / `rebuild-seminar3-lesson1.php`).
2. Set a **quit password** (separate from the quiz's own entry password) so SEB can be safely closed after the attempt.
3. Save. The quiz's own page will now show a **"Download configuration"** button.

## What a student actually does

1. Make sure SEB is installed on the device they're using (see above — Windows/Mac only).
2. Go to the quiz in Moodle as normal, in a regular browser.
3. Click **Download configuration** to get the `.seb` file.
4. Open the downloaded `.seb` file (double-click) — this launches SEB, which locks the screen and loads directly into the quiz's password prompt.
5. Enter the quiz password (same one their teacher gives them for password-only quizzes) to start.

For a whole class, it's much faster to **pre-distribute the `.seb` file directly** (shared drive, direct link, etc.) rather than have every student click through Moodle to download it individually — the file itself is quiz-specific and doesn't expose the quiz password.

## Known rough edges to expect

- The `.seb` file is quiz-specific. A new SEB config download is needed any time SEB is re-enabled after being toggled off (like it was today) — old downloaded `.seb` files reference a `configkey` hash that changes when the quiz's SEB settings are saved again.
- If a student's device already has a browser extension that conflicts with SEB's lockdown (the "Gemini extension to scan the screen" concern Jay raised for Seminar III's diagnostic — see `foxcs_seminar3_status_20260830.md`), SEB's `activateurlfiltering`/`filterembeddedcontent` settings (already configured in the build scripts) are the intended defense, but should be spot-checked on a real device before trusting them for a live assessment.
- Don't re-enable SEB on a quiz you haven't personally tested end-to-end on a real (non-admin) student account first — admin accounts sometimes bypass access-rule checks that apply to real students, so "it worked when I tested it" as admin doesn't guarantee it works for a student.
