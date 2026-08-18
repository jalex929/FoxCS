// ^\s*(\d{3})[-](\d{4})\s*$ regex for ###-####

function checkPhone() {
    let userInput = document.getElementById('phone').value;
    let regEx = /^\s*(\d{3})[-](\d{4})\s*$/;

    // boolean value to represents the userInput tested against the regular expression
    console.log(regEx.test(userInput));

    if (regEx.test(userInput)) {
        console.log('Valid Phone Number');
    } else {
        alert('Please use valid phone number format. (xxx-xxxx)');
    }
}