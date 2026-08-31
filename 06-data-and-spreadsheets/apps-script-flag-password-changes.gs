/**
 * Flags which students' Moodle password actually changed between two
 * versions of the private roster, so the login-email Apps Script can send
 * an "UPDATED — disregard your previous login email" message only to the
 * students whose password text is genuinely different, instead of resending
 * everyone.
 *
 * Background: a batch of accounts hit Moodle's 8-character password minimum
 * and had their passwords lengthened in a later roster version. Separately,
 * some Moodle accounts silently had a stale password out of sync with the
 * roster for reasons unrelated to the roster text itself — that is a
 * different, already-resolved backend problem and is NOT what this script
 * detects. This script only answers one question: "does the password value
 * a student was already emailed still match the current roster?"
 *
 * Deliberately ignores student_email / guardian_email entirely — matching
 * is by `codename` only, which is the stable identifier across roster
 * versions. Email columns are never read, compared, or logged by this
 * script.
 *
 * USAGE
 * 1. Paste this file into your existing Apps Script project (Extensions >
 *    Apps Script from either roster sheet, or any bound/standalone project
 *    that already has Sheets access).
 * 2. Run flagPasswordChangesForFoxCSRoster() once — it's pre-wired to the
 *    current "before" (original) and "after" (corrected) roster sheets.
 * 3. Check the new `password_changed` column added to the end of the
 *    corrected roster's row data (TRUE/FALSE). Wire your send-email flow to
 *    treat TRUE as "send the UPDATED notice", same way it already treats
 *    `send_login_email`.
 * 4. For any FUTURE roster revision (V2 -> V3, etc.), call the generic
 *    compareRosterPasswords() function directly with the two sheet IDs —
 *    don't just re-run the FoxCS-specific wrapper, since that one is pinned
 *    to this specific pair of sheets.
 */

// ---- Pinned to the current roster pair. Update if a new round is needed. ----
const FOXCS_ROSTER_OLD_SPREADSHEET_ID = '1PSotXfmzaTj_5lKpSocQIdl26aEhkQUhptUcp3_9FZA'; // "FoxCS Private Roster 2026-27 (Codenames — DO NOT SHARE)"
const FOXCS_ROSTER_NEW_SPREADSHEET_ID = '1lDVSsXhmYSVJPDv1pV_e00smD7Wk5MvboKQC92lP6ag'; // "FoxCS Private Roster 2026-27 - Corrected Passwords (2026-08-31)"
const FOXCS_ROSTER_SHEET_NAME = 'Sheet1'; // adjust if your tab is named differently
const PASSWORD_CHANGED_COLUMN_NAME = 'password_changed';

/**
 * One-click entry point for the current V1 -> V2 diff. Adds/updates a
 * `password_changed` column on the corrected (new) roster.
 */
function flagPasswordChangesForFoxCSRoster() {
  compareRosterPasswords(
    FOXCS_ROSTER_OLD_SPREADSHEET_ID,
    FOXCS_ROSTER_SHEET_NAME,
    FOXCS_ROSTER_NEW_SPREADSHEET_ID,
    FOXCS_ROSTER_SHEET_NAME,
    PASSWORD_CHANGED_COLUMN_NAME
  );
}

/**
 * Generic, reusable version — pass any two roster spreadsheet/sheet
 * references and it will match rows by `codename` and flag password
 * changes on the "new" sheet.
 *
 * @param {string} oldSpreadsheetId
 * @param {string} oldSheetName
 * @param {string} newSpreadsheetId
 * @param {string} newSheetName
 * @param {string} outputColumnName  Header name to add/update on the new sheet.
 */
function compareRosterPasswords(oldSpreadsheetId, oldSheetName, newSpreadsheetId, newSheetName, outputColumnName) {
  const oldSheet = SpreadsheetApp.openById(oldSpreadsheetId).getSheetByName(oldSheetName);
  const newSheet = SpreadsheetApp.openById(newSpreadsheetId).getSheetByName(newSheetName);

  const oldPasswordByCodename = readCodenamePasswordMap_(oldSheet);

  const newData = newSheet.getDataRange().getValues();
  const newHeader = newData[0];
  const codenameCol = requireColumn_(newHeader, 'codename');
  const passwordCol = requireColumn_(newHeader, 'initial_password');

  let outputCol = newHeader.indexOf(outputColumnName);
  if (outputCol === -1) {
    outputCol = newHeader.length;
    newSheet.getRange(1, outputCol + 1).setValue(outputColumnName);
  }

  let changed = 0, unchanged = 0, newRows = 0;
  const results = [];

  for (let r = 1; r < newData.length; r++) {
    const codename = newData[r][codenameCol];
    if (!codename) {
      results.push(['']); // blank placeholder row, leave untouched
      continue;
    }
    const currentPassword = newData[r][passwordCol];
    const priorPassword = oldPasswordByCodename[codename];

    let flag;
    if (priorPassword === undefined) {
      flag = false; // no prior record -> nothing to "update", this is a first send
      newRows++;
    } else if (priorPassword !== currentPassword) {
      flag = true;
      changed++;
    } else {
      flag = false;
      unchanged++;
    }
    results.push([flag]);
  }

  newSheet.getRange(2, outputCol + 1, results.length, 1).setValues(results);

  Logger.log(
    'compareRosterPasswords: %s changed, %s unchanged, %s new codenames (no prior record). ' +
    'Column "%s" written to sheet "%s".',
    changed, unchanged, newRows, outputColumnName, newSheetName
  );
}

/**
 * Reads a sheet into a { codename: initial_password } map. Only touches the
 * `codename` and `initial_password` columns — never reads email columns.
 */
function readCodenamePasswordMap_(sheet) {
  const data = sheet.getDataRange().getValues();
  const header = data[0];
  const codenameCol = requireColumn_(header, 'codename');
  const passwordCol = requireColumn_(header, 'initial_password');

  const map = {};
  for (let r = 1; r < data.length; r++) {
    const codename = data[r][codenameCol];
    if (!codename) continue;
    map[codename] = data[r][passwordCol];
  }
  return map;
}

function requireColumn_(header, name) {
  const idx = header.indexOf(name);
  if (idx === -1) {
    throw new Error('Expected column "' + name + '" not found in header row: ' + header.join(', '));
  }
  return idx;
}
