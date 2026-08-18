$(document).ready( function() {
    $('#getLocButton').click(function() {
        // reference geolocation API
        let geoRefAPI = window.navigator.geolocation;

        // use getCurrentPosition() method to retrieve geolocation object once API is called
        geoRefAPI.getCurrentPosition(printCoordinates);

        // function to print to HTML using location object
        function printCoordinates(locObj) {
            console.log(locObj);
            $('#latitude').html('Your latitude is: ' + parseFloat(locObj.coords.latitude).toFixed(1));
            // add code to print longitude to #longitude
            // $('#longitude').html('Your longitude is: ' + parseFloat(locObj.coords.longitude).toFixed(1));
        }
    })
});