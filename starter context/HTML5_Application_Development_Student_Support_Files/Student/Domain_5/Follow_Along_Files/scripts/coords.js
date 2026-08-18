window.onload = function () {
    var element = document.getElementById('canvas');

    // passing the event object into a function WITHOUT using arrow functions
    element.addEventListener('click', function(event) {
        console.log(event);
        var msg = "Your click position was X: " + event.offsetX + " / Y: " + event.offsetY;
        document.getElementById('output').innerHTML = msg;
    })
    
    // using arrow functions and template strings
    // element.addEventListener('click', (event) => {
    //     console.log(event);
    //     var msg = `Your click position was X: ${event.offsetX} / Y: ${event.offsetY}`;
    //     document.getElementById('output').innerHTML = msg;
    // }) 
}