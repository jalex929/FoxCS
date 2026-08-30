/**
 * Bound to "FoxCS Private Roster 2026-27 (Codenames — DO NOT SHARE)".
 * MVP per Jay 2026-08-30: one command, sends every student with a filled-in
 * student_email their login info. No per-student selection UI in this pass
 * (Jay explicitly simplified from an earlier per-student/self-service design
 * to "push out emails to everyone with one command" for the MVP) — add
 * selection-based sending later if the class actually needs it.
 *
 * Sends as whoever authorizes/runs the script, which is Jay's own CPS
 * account (jafox7@cps.edu) since he owns this Sheet — MailApp always sends
 * as the authorizing user, there is no separate "from" address to set.
 *
 * One-time setup (Claude Code has no way to attach this itself):
 *   1. Open the Sheet -> Extensions -> Apps Script.
 *   2. Delete the placeholder Code.gs content, paste this file's contents in.
 *   3. Save, reload the Sheet. A "FoxCS Tools" menu appears.
 *   4. Run "FoxCS Tools > Send Password Emails to All Students".
 *      First run will prompt for authorization -- approve as jafox7@cps.edu.
 */

const COL = {
  FIRST_NAME: 0, LAST_NAME: 1, STUDENT_EMAIL: 2, CLASS_PERIOD: 3, COURSE: 4,
  CODENAME: 5, ROSTER_POSITION: 6, INITIAL_PASSWORD: 7, GUARDIAN_EMAIL: 8,
  SCHOOL_STUDENT_ID: 9, ACTIVE_STATUS: 10,
};

function onOpen() {
  SpreadsheetApp.getUi()
    .createMenu('FoxCS Tools')
    .addItem('Send Password Emails to All Students', 'sendAllPasswordEmails')
    .addToUi();
}

function sendAllPasswordEmails() {
  const sheet = SpreadsheetApp.getActiveSpreadsheet().getSheets()[0];
  const data = sheet.getDataRange().getValues();
  const ui = SpreadsheetApp.getUi();

  let sent = 0;
  let skippedNoEmail = 0;
  let skippedNotActive = 0;

  for (let i = 1; i < data.length; i++) {
    const row = data[i];
    if (row[COL.ACTIVE_STATUS] !== 'active') { skippedNotActive++; continue; }

    const email = row[COL.STUDENT_EMAIL];
    if (!email) { skippedNoEmail++; continue; }

    const firstName = row[COL.FIRST_NAME] || 'Student';
    const codename = row[COL.CODENAME];
    const password = row[COL.INITIAL_PASSWORD];
    const course = row[COL.COURSE];

    const subject = 'Your FoxCS Moodle Login';
    const body =
      'Hi ' + firstName + ',\n\n' +
      'Here is your login for the FoxCS ' + course + ' Moodle site (https://foxcs.online):\n\n' +
      '  Username: ' + codename + '\n' +
      '  Password: ' + password + '\n\n' +
      'If you run into trouble logging in, let Mr. Fox know.\n\n' +
      '- Mr. Fox';

    MailApp.sendEmail({ to: email, subject: subject, body: body, name: 'Jay Fox' });
    sent++;
  }

  ui.alert(
    'Password emails sent',
    'Sent: ' + sent + '\n' +
    'Skipped (no email on file): ' + skippedNoEmail + '\n' +
    'Skipped (not active): ' + skippedNotActive,
    ui.ButtonSet.OK
  );
}
