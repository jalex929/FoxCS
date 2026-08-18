$(document).ready(function() {
    $('#mailingListBtn').click(function() {
        let user_firstName = $('#user_firstName').val();
        let userEmail = $('#mailingList').val();
        
        // add code    
        
        // clear fields
        $('#user_firstName').val('');
        $('#mailingList').val('');

        // other common storage methods
        // getItem(key) // get item by key
        // removeItem() // remove item by key
        // clear() // clear storage
        // key(index) // get key by index
        // length // get length of the local storage, often used to loop through storage contents
    })
})