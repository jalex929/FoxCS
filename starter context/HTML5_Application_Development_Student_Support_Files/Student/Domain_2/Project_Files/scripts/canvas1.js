$(document).ready(function() {
    var canvas = document.getElementById('canvas');
    var ctx = canvas.getContext('2d');

    // translate example
    ctx.fillRect(10, 10, 60, 60);
    // add code
    ctx.fillRect(10, 10, 100, 100);

    // // rotate example
    // ctx.fillStyle = 'yellow';
    // ctx.arc(0, 0, 25, 0, Math.PI*2);
    // ctx.fillRect(200, 20, 200, 100)
    // // add code
    // ctx.fillRect(200, 20, 200, 100);
    // ctx.fill();
    // ctx.stroke();

    // // scale example
    // ctx.arc(100, 100, 40, 0, 2 * Math.PI);
    // // add code
    // ctx.arc(100, 100, 40, 0, 2 * Math.PI);
    // ctx.fill();
});