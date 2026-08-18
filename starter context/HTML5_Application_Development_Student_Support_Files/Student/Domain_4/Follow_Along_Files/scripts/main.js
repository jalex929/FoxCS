// this jQuery adds inline styles for display and messes with changing screen sizes
// still changes styles inline but at least toggles away .icon button and keeps menu
$(document).ready(function() {
    if (window.innerWidth < 500) {
        $('#comments').attr('cols', 24);
    }
    else {
        $('#comments').attr('cols', 50);
    }
    $('.icon').click(function() {
        $('.link-list').toggle();
        $('.icon').toggle();
    })

});


$(window).resize(function() {
    if (window.innerWidth < 500) {
        $('#comments').attr('cols', 24);
    }
    else {
        $('#comments').attr('cols', 50);
    }
});
