window.onload = function () {
    var element = document.getElementById('canvas');

    element.addEventListener('click', (eventObj) => {
        console.log(eventObj);
        var msg = `Your click position was X: ${eventObj.offsetX} / Y: ${eventObj.offsetY}`;
        document.getElementById('output').innerHTML = msg;
        // draw circle();
        drawCircle(eventObj.offsetX, eventObj.offsetY);
    })

    function drawCircle(x, y) {
        console.log('drawCircle fires', x, y);
        var canvas = document.getElementById('canvas');
        var ctx = canvas.getContext('2d');
        ctx.beginPath();
        ctx.arc(x, y, 20, 0, 2 * Math.PI);
        ctx.fill();
    }
}