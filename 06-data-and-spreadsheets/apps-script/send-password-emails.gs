/**
 * FoxCS Student Login Email Sender
 *
 * Required spreadsheet columns:
 * first_name
 * student_email
 * class_period
 * course
 * codename
 * initial_password
 * active_status
 *
 * Automatically adds:
 * send_login_email
 * login_email_sent
 * login_email_sent_at
 * duplicate_email
 * email_course_count
 * courses_for_email
 *
 * Run while signed into:
 * JAFox7@cps.edu
 */


/**
 * Adds the FoxCS Emails menu whenever the spreadsheet opens.
 */
function onOpen() {
  SpreadsheetApp.getUi()
    .createMenu("FoxCS Emails")
    .addItem(
      "Set Up Selection Checkboxes",
      "setupEmailCheckboxes"
    )
    .addItem(
      "Clear All Selection Checkboxes",
      "clearAllEmailCheckboxes"
    )
    .addSeparator()
    .addItem(
      "Flag Duplicate Emails",
      "flagDuplicateEmails"
    )
    .addSeparator()
    .addItem(
      "Send Test Email",
      "sendTestLoginEmail"
    )
    .addItem(
      "Send Selected Students",
      "sendSelectedLoginEmails"
    )
    .addItem(
      "Send By Class",
      "sendLoginEmailsByClass"
    )
    .addItem(
      "Send All Eligible Students",
      "sendFoxCSLoginEmails"
    )
    .addToUi();
}


/**
 * TEST EMAIL
 *
 * Sends exactly one test message to JAFox7@cps.edu.
 *
 * Does NOT:
 * - read the roster
 * - mark anyone as sent
 * - modify checkboxes
 */
function sendTestLoginEmail() {
  const testEmail = "JAFox7@cps.edu";

  const firstName = "FoxCSTest";
  const username = "foxcstest";
  const password = "placeholder";

  const subject =
    "TEST: Your FoxCS Course Website Login";

  const plainTextBody = buildPlainTextEmail(
    firstName,
    username,
    password
  );

  const htmlBody = buildHtmlEmail(
    firstName,
    username,
    password
  );

  MailApp.sendEmail({
    to: testEmail,
    subject: subject,
    body: plainTextBody,
    htmlBody: htmlBody,
    name: "Mr. Fox"
  });

  console.log(
    `Test email sent successfully to ${testEmail}`
  );
}


/**
 * SET UP CHECKBOXES
 *
 * Creates the send_login_email column if necessary
 * and adds checkboxes to all student rows.
 */
function setupEmailCheckboxes() {
  const spreadsheet =
    SpreadsheetApp.getActiveSpreadsheet();

  const sheet =
    spreadsheet.getActiveSheet();

  const data =
    sheet.getDataRange().getValues();

  if (data.length < 1) {
    throw new Error(
      "No spreadsheet headers found."
    );
  }

  const headers =
    data[0].map(
      header => String(header).trim()
    );

  let selectColumn =
    headers.indexOf("send_login_email");

  if (selectColumn === -1) {
    selectColumn = headers.length;

    sheet
      .getRange(
        1,
        selectColumn + 1
      )
      .setValue(
        "send_login_email"
      );
  }

  const lastRow =
    sheet.getLastRow();

  if (lastRow > 1) {
    sheet
      .getRange(
        2,
        selectColumn + 1,
        lastRow - 1,
        1
      )
      .insertCheckboxes();
  }

  spreadsheet.toast(
    "Email selection checkboxes are ready.",
    "FoxCS Emails",
    5
  );
}


/**
 * CLEAR ALL CHECKBOXES
 *
 * Clears only the send_login_email checkboxes.
 *
 * Does NOT clear:
 * - login_email_sent
 * - login_email_sent_at
 * - student data
 */
function clearAllEmailCheckboxes() {
  const spreadsheet =
    SpreadsheetApp.getActiveSpreadsheet();

  const sheet =
    spreadsheet.getActiveSheet();

  const data =
    sheet.getDataRange().getValues();

  if (data.length < 2) {
    return;
  }

  const headers =
    data[0].map(
      header => String(header).trim()
    );

  const selectColumn =
    headers.indexOf("send_login_email");

  if (selectColumn === -1) {
    spreadsheet.toast(
      "No send_login_email column was found.",
      "FoxCS Emails",
      5
    );

    return;
  }

  const lastRow =
    sheet.getLastRow();

  if (lastRow > 1) {
    sheet
      .getRange(
        2,
        selectColumn + 1,
        lastRow - 1,
        1
      )
      .setValue(false);
  }

  spreadsheet.toast(
    "All email selection checkboxes have been cleared.",
    "FoxCS Emails",
    5
  );
}


/**
 * FLAG DUPLICATE EMAILS
 *
 * Looks for student_email values that appear more than once.
 *
 * Matching is:
 * - case-insensitive
 * - whitespace-insensitive
 *
 * Blank email addresses are ignored.
 *
 * Automatically creates:
 * duplicate_email
 * email_course_count
 * courses_for_email
 */
function flagDuplicateEmails() {
  const spreadsheet =
    SpreadsheetApp.getActiveSpreadsheet();

  const sheet =
    spreadsheet.getActiveSheet();

  const data =
    sheet.getDataRange().getValues();

  if (data.length < 2) {
    spreadsheet.toast(
      "No student data found.",
      "FoxCS Emails",
      5
    );

    return;
  }

  const headers =
    data[0].map(
      header => String(header).trim()
    );


  /*********************************
   * REQUIRED COLUMNS
   *********************************/

  const emailColumn =
    headers.indexOf("student_email");

  const courseColumn =
    headers.indexOf("course");

  const classPeriodColumn =
    headers.indexOf("class_period");


  if (emailColumn === -1) {
    throw new Error(
      "Missing required column: student_email"
    );
  }

  if (courseColumn === -1) {
    throw new Error(
      "Missing required column: course"
    );
  }

  if (classPeriodColumn === -1) {
    throw new Error(
      "Missing required column: class_period"
    );
  }


  /*********************************
   * CREATE OUTPUT COLUMNS
   *********************************/

  let duplicateColumn =
    headers.indexOf("duplicate_email");

  if (duplicateColumn === -1) {
    duplicateColumn = headers.length;

    sheet
      .getRange(
        1,
        duplicateColumn + 1
      )
      .setValue(
        "duplicate_email"
      );

    headers.push(
      "duplicate_email"
    );
  }


  let countColumn =
    headers.indexOf("email_course_count");

  if (countColumn === -1) {
    countColumn = headers.length;

    sheet
      .getRange(
        1,
        countColumn + 1
      )
      .setValue(
        "email_course_count"
      );

    headers.push(
      "email_course_count"
    );
  }


  let coursesColumn =
    headers.indexOf("courses_for_email");

  if (coursesColumn === -1) {
    coursesColumn = headers.length;

    sheet
      .getRange(
        1,
        coursesColumn + 1
      )
      .setValue(
        "courses_for_email"
      );

    headers.push(
      "courses_for_email"
    );
  }


  /*********************************
   * BUILD EMAIL MAP
   *********************************/

  const emailMap = {};


  for (
    let i = 1;
    i < data.length;
    i++
  ) {

    const row = data[i];

    const email =
      String(
        row[emailColumn] || ""
      )
        .trim()
        .toLowerCase();


    /**
     * Ignore blank email addresses.
     */
    if (!email) {
      continue;
    }


    const course =
      String(
        row[courseColumn] || ""
      ).trim();

    const classPeriod =
      String(
        row[classPeriodColumn] || ""
      ).trim();


    /**
     * Build a readable class label.
     *
     * Example:
     * 6th - Game Programming I
     */
    let classLabel = "";

    if (
      classPeriod &&
      course
    ) {
      classLabel =
        `${classPeriod} - ${course}`;
    } else if (course) {
      classLabel = course;
    } else if (classPeriod) {
      classLabel = classPeriod;
    }


    if (!emailMap[email]) {
      emailMap[email] = {
        count: 0,
        classes: []
      };
    }


    emailMap[email].count++;


    /**
     * Avoid listing the exact same
     * class twice.
     */
    if (
      classLabel &&
      !emailMap[email]
        .classes
        .includes(classLabel)
    ) {
      emailMap[email]
        .classes
        .push(classLabel);
    }
  }


  /*********************************
   * WRITE RESULTS
   *********************************/

  let duplicateRowCount = 0;

  const duplicateEmails = new Set();


  for (
    let i = 1;
    i < data.length;
    i++
  ) {

    const rowNumber =
      i + 1;

    const row =
      data[i];

    const email =
      String(
        row[emailColumn] || ""
      )
        .trim()
        .toLowerCase();


    /**
     * Blank emails get blank flag fields.
     */
    if (!email) {

      sheet
        .getRange(
          rowNumber,
          duplicateColumn + 1
        )
        .clearContent();

      sheet
        .getRange(
          rowNumber,
          countColumn + 1
        )
        .clearContent();

      sheet
        .getRange(
          rowNumber,
          coursesColumn + 1
        )
        .clearContent();

      continue;
    }


    const emailInfo =
      emailMap[email];


    if (
      emailInfo &&
      emailInfo.count > 1
    ) {

      sheet
        .getRange(
          rowNumber,
          duplicateColumn + 1
        )
        .setValue(
          "DUPLICATE"
        );

      sheet
        .getRange(
          rowNumber,
          countColumn + 1
        )
        .setValue(
          emailInfo.count
        );

      sheet
        .getRange(
          rowNumber,
          coursesColumn + 1
        )
        .setValue(
          emailInfo.classes.join("; ")
        );

      duplicateRowCount++;
      duplicateEmails.add(email);

    } else {

      /**
       * Clear previous duplicate flags
       * if the duplicate no longer exists.
       */
      sheet
        .getRange(
          rowNumber,
          duplicateColumn + 1
        )
        .clearContent();

      sheet
        .getRange(
          rowNumber,
          countColumn + 1
        )
        .setValue(1);

      sheet
        .getRange(
          rowNumber,
          coursesColumn + 1
        )
        .setValue(
          emailInfo
            ? emailInfo.classes.join("; ")
            : ""
        );
    }
  }


  /*********************************
   * FINISHED
   *********************************/

  spreadsheet.toast(
    `${duplicateEmails.size} student email(s) appear more than once across ${duplicateRowCount} roster rows.`,
    "Duplicate Email Check Complete",
    8
  );
}


/**
 * SEND SELECTED STUDENTS
 *
 * Sends only to rows where send_login_email
 * is checked.
 *
 * If a selected student was already SENT or RESENT,
 * the email is sent again and the status becomes RESENT.
 */
function sendSelectedLoginEmails() {
  sendLoginEmails({
    mode: "selected"
  });
}


/**
 * SEND BY CLASS
 *
 * Enter either:
 *
 * - a class_period value, such as:
 *   6th
 *
 * OR
 *
 * - an exact course value, such as:
 *   Game Programming I
 *
 * Matching is case-insensitive.
 *
 * Students already marked SENT or RESENT are skipped.
 */
function sendLoginEmailsByClass() {
  const ui =
    SpreadsheetApp.getUi();

  const response =
    ui.prompt(
      "Send FoxCS Login Emails",
      "Enter the exact class period or course name:",
      ui.ButtonSet.OK_CANCEL
    );

  if (
    response.getSelectedButton() !==
    ui.Button.OK
  ) {
    return;
  }

  const classValue =
    response
      .getResponseText()
      .trim();

  if (!classValue) {
    return;
  }

  sendLoginEmails({
    mode: "class",
    classValue: classValue
  });
}


/**
 * SEND ALL ELIGIBLE STUDENTS
 *
 * Sends to every eligible row that:
 *
 * - has an email
 * - is active/test
 * - has login information
 * - has not already been marked SENT or RESENT
 */
function sendFoxCSLoginEmails() {
  sendLoginEmails({
    mode: "all"
  });
}


/**
 * CENTRAL SEND FUNCTION
 *
 * Supported modes:
 *
 * selected
 * class
 * all
 */
function sendLoginEmails(options) {
  const spreadsheet =
    SpreadsheetApp.getActiveSpreadsheet();

  const sheet =
    spreadsheet.getActiveSheet();

  const data =
    sheet.getDataRange().getValues();

  if (data.length < 2) {
    throw new Error(
      "No student data found."
    );
  }

  const headers =
    data[0].map(
      header => String(header).trim()
    );


  /*********************************
   * REQUIRED HEADERS
   *********************************/

  const requiredHeaders = [
    "first_name",
    "student_email",
    "class_period",
    "course",
    "codename",
    "initial_password",
    "active_status"
  ];

  requiredHeaders.forEach(
    header => {
      if (!headers.includes(header)) {
        throw new Error(
          `Missing required column: ${header}`
        );
      }
    }
  );


  /*********************************
   * TRACKING COLUMNS
   *********************************/

  let sentColumn =
    headers.indexOf(
      "login_email_sent"
    );

  let sentAtColumn =
    headers.indexOf(
      "login_email_sent_at"
    );

  let selectColumn =
    headers.indexOf(
      "send_login_email"
    );


  /**
   * Add login_email_sent if missing.
   */
  if (sentColumn === -1) {
    sentColumn =
      headers.length;

    sheet
      .getRange(
        1,
        sentColumn + 1
      )
      .setValue(
        "login_email_sent"
      );

    headers.push(
      "login_email_sent"
    );
  }


  /**
   * Add login_email_sent_at if missing.
   */
  if (sentAtColumn === -1) {
    sentAtColumn =
      headers.length;

    sheet
      .getRange(
        1,
        sentAtColumn + 1
      )
      .setValue(
        "login_email_sent_at"
      );

    headers.push(
      "login_email_sent_at"
    );
  }


  /**
   * Add send_login_email if missing.
   */
  if (selectColumn === -1) {
    selectColumn =
      headers.length;

    sheet
      .getRange(
        1,
        selectColumn + 1
      )
      .setValue(
        "send_login_email"
      );

    headers.push(
      "send_login_email"
    );

    const lastRow =
      sheet.getLastRow();

    if (lastRow > 1) {
      sheet
        .getRange(
          2,
          selectColumn + 1,
          lastRow - 1,
          1
        )
        .insertCheckboxes();
    }
  }


  /*********************************
   * COLUMN LOCATIONS
   *********************************/

  const firstNameColumn =
    headers.indexOf(
      "first_name"
    );

  const emailColumn =
    headers.indexOf(
      "student_email"
    );

  const classPeriodColumn =
    headers.indexOf(
      "class_period"
    );

  const courseColumn =
    headers.indexOf(
      "course"
    );

  const usernameColumn =
    headers.indexOf(
      "codename"
    );

  const passwordColumn =
    headers.indexOf(
      "initial_password"
    );

  const activeStatusColumn =
    headers.indexOf(
      "active_status"
    );


  /*********************************
   * COUNTERS
   *********************************/

  let sentCount = 0;

  let resentCount = 0;

  let skippedNoEmail = 0;

  let skippedInactive = 0;

  let skippedIncomplete = 0;

  let skippedAlreadySent = 0;

  let skippedNotSelected = 0;

  let skippedWrongClass = 0;

  let errorCount = 0;


  /*********************************
   * VALID STATUSES
   *********************************/

  const allowedStatuses = [
    "active",
    "test"
  ];


  /*********************************
   * PROCESS STUDENT ROWS
   *********************************/

  for (
    let i = 1;
    i < data.length;
    i++
  ) {

    const rowNumber =
      i + 1;

    const row =
      data[i];


    /*********************************
     * CHECK EMAIL FIRST
     *********************************/

    const email =
      String(
        row[emailColumn] || ""
      ).trim();

    /**
     * Immediately skip rows without
     * student email addresses.
     */
    if (!email) {
      skippedNoEmail++;
      continue;
    }


    /*********************************
     * GET STUDENT VALUES
     *********************************/

    const firstName =
      String(
        row[firstNameColumn] || ""
      ).trim();

    const classPeriod =
      String(
        row[classPeriodColumn] || ""
      ).trim();

    const course =
      String(
        row[courseColumn] || ""
      ).trim();

    const username =
      String(
        row[usernameColumn] || ""
      ).trim();

    const password =
      String(
        row[passwordColumn] || ""
      ).trim();

    const activeStatus =
      String(
        row[activeStatusColumn] || ""
      )
        .trim()
        .toLowerCase();


    /*********************************
     * STATUS CHECK
     *********************************/

    if (
      !allowedStatuses.includes(
        activeStatus
      )
    ) {
      skippedInactive++;
      continue;
    }


    /*********************************
     * LOGIN INFORMATION CHECK
     *********************************/

    /**
     * First name is optional.
     *
     * If no first name is listed,
     * the email will use "Hey there!"
     */
    if (
      !username ||
      !password
    ) {
      skippedIncomplete++;
      continue;
    }


    /*********************************
     * SELECTED MODE CHECK
     *********************************/

    if (
      options.mode === "selected"
    ) {

      const selected =
        sheet
          .getRange(
            rowNumber,
            selectColumn + 1
          )
          .getValue() === true;

      if (!selected) {
        skippedNotSelected++;
        continue;
      }
    }


    /*********************************
     * CLASS MODE CHECK
     *********************************/

    if (
      options.mode === "class"
    ) {

      const target =
        String(
          options.classValue || ""
        )
          .trim()
          .toLowerCase();

      const periodMatches =
        classPeriod
          .toLowerCase() ===
        target;

      const courseMatches =
        course
          .toLowerCase() ===
        target;

      if (
        !periodMatches &&
        !courseMatches
      ) {
        skippedWrongClass++;
        continue;
      }
    }


    /*********************************
     * ALREADY SENT CHECK
     *********************************/

    const alreadySent =
      String(
        sheet
          .getRange(
            rowNumber,
            sentColumn + 1
          )
          .getValue() || ""
      )
        .trim()
        .toUpperCase();


    /**
     * SELECTED mode intentionally allows
     * a resend if the student is checked.
     *
     * CLASS and ALL modes skip anyone
     * already marked SENT or RESENT.
     */
    if (
      options.mode !== "selected" &&
      (
        alreadySent === "SENT" ||
        alreadySent === "RESENT"
      )
    ) {
      skippedAlreadySent++;
      continue;
    }


    /*********************************
     * BUILD EMAIL
     *********************************/

    const subject =
      "Your FoxCS Course Website Login";

    const plainTextBody =
      buildPlainTextEmail(
        firstName,
        username,
        password
      );

    const htmlBody =
      buildHtmlEmail(
        firstName,
        username,
        password
      );


    /*********************************
     * DETERMINE SEND STATUS
     *********************************/

    let sendStatus = "SENT";

    /**
     * A manually selected student who
     * previously received an email is a resend.
     */
    if (
      options.mode === "selected" &&
      (
        alreadySent === "SENT" ||
        alreadySent === "RESENT"
      )
    ) {
      sendStatus = "RESENT";
    }


    /*********************************
     * SEND EMAIL
     *********************************/

    try {

      MailApp.sendEmail({
        to: email,
        subject: subject,
        body: plainTextBody,
        htmlBody: htmlBody,
        name: "Mr. Fox"
      });


      /*********************************
       * MARK AS SENT / RESENT
       *********************************/

      sheet
        .getRange(
          rowNumber,
          sentColumn + 1
        )
        .setValue(
          sendStatus
        );


      /**
       * Timestamp always updates to the
       * most recent successful send.
       */
      sheet
        .getRange(
          rowNumber,
          sentAtColumn + 1
        )
        .setValue(
          new Date()
        );


      /*********************************
       * CLEAR SELECTED CHECKBOX
       *********************************/

      /**
       * Automatically uncheck a student
       * after a successful selected send.
       */
      if (
        options.mode === "selected"
      ) {

        sheet
          .getRange(
            rowNumber,
            selectColumn + 1
          )
          .setValue(false);
      }


      /*********************************
       * UPDATE COUNTERS
       *********************************/

      if (sendStatus === "RESENT") {
        resentCount++;

        console.log(
          `Resent login email to ${firstName || "student"} (${email})`
        );
      } else {
        sentCount++;

        console.log(
          `Sent login email to ${firstName || "student"} (${email})`
        );
      }


    } catch (error) {

      /*********************************
       * RECORD ERROR
       *********************************/

      sheet
        .getRange(
          rowNumber,
          sentColumn + 1
        )
        .setValue(
          `ERROR: ${error.message}`
        );


      console.error(
        `Error sending to ${email}: ${error.message}`
      );


      errorCount++;
    }
  }


  /*********************************
   * SUMMARY
   *********************************/

  const summary =
`FoxCS Login Email Send Complete

New emails sent: ${sentCount}
Emails resent: ${resentCount}
Skipped - no email: ${skippedNoEmail}
Skipped - inactive: ${skippedInactive}
Skipped - incomplete login info: ${skippedIncomplete}
Skipped - already sent: ${skippedAlreadySent}
Skipped - not selected: ${skippedNotSelected}
Skipped - different class: ${skippedWrongClass}
Errors: ${errorCount}`;


  console.log(summary);


  /**
   * Toast is non-blocking.
   */
  spreadsheet.toast(
    summary,
    "FoxCS Email Sender",
    10
  );
}


/**
 * Builds the plain-text version
 * of the student login email.
 *
 * If firstName is blank:
 * Hey there!
 *
 * Otherwise:
 * Hi FirstName,
 */
function buildPlainTextEmail(
  firstName,
  username,
  password
) {

  const greeting =
    firstName
      ? `Hi ${firstName},`
      : "Hey there!";

  return `${greeting}

Here is your login information for our FoxCS course website.

Website:
https://foxcs.online

Username: ${username}
Password: ${password}

Please keep this login information somewhere you can access it throughout the year.

Your password has been assigned to you and should not be changed. Keeping this assigned password allows me to help you recover your login information if you forget it.

Warmly,

Mr. Fox`;
}


/**
 * Builds the HTML version
 * of the student login email.
 *
 * If firstName is blank:
 * Hey there!
 *
 * Otherwise:
 * Hi FirstName,
 */
function buildHtmlEmail(
  firstName,
  username,
  password
) {

  const greeting =
    firstName
      ? `Hi ${escapeHtml(firstName)},`
      : "Hey there!";

  return `
    <p>
      ${greeting}
    </p>

    <p>
      Here is your login information for our FoxCS course website.
    </p>

    <p>
      <strong>Website:</strong><br>
      <a href="https://foxcs.online">
        foxcs.online
      </a>
    </p>

    <p>
      <strong>Username:</strong>
      ${escapeHtml(username)}
      <br>

      <strong>Password:</strong>
      ${escapeHtml(password)}
    </p>

    <p>
      Please keep this login information somewhere you can access it throughout the year.
    </p>

    <p>
      Your password has been assigned to you and should not be changed.
      Keeping this assigned password allows me to help you recover your
      login information if you forget it.
    </p>

    <p>
      Warmly,<br><br>
      Mr. Fox
    </p>
  `;
}


/**
 * Escapes special characters before inserting
 * spreadsheet values into an HTML email.
 */
function escapeHtml(value) {
  return String(value)
    .replace(
      /&/g,
      "&amp;"
    )
    .replace(
      /</g,
      "&lt;"
    )
    .replace(
      />/g,
      "&gt;"
    )
    .replace(
      /"/g,
      "&quot;"
    )
    .replace(
      /'/g,
      "&#039;"
    );
}
