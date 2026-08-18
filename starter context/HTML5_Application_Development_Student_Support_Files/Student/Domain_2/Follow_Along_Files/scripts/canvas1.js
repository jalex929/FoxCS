$(document).ready(function() {
    var canvas = document.getElementById('canvas');
    var ctx = canvas.getContext('2d');

    // translate example
    // ctx.fillRect(10, 10, 60, 60);
    // ctx.translate(250,250);
    // ctx.fillRect(10, 10, 100, 100);

    // possibility to show the adjusted frame of reference by drawing a circle at 0, 0
    // ctx.arc(0, 0, 15, 0, Math.PI * 2);
    // ctx.stroke();
    // ctx.fill();

    // // rotate example
    // ctx.fillStyle = 'yellow';
    // ctx.arc(0, 0, 25, 0, Math.PI*2);
    // // ctx.rotate(Math.PI/4);
    // ctx.fillRect(200, 20, 200, 100)
    // ctx.fill();
    // ctx.stroke();

    // // scale example
    ctx.arc(100, 100, 40, 0, 2 * Math.PI);
    ctx.scale(2, 2);
    ctx.arc(100, 100, 40, 0, 2 * Math.PI);
    ctx.fill();
});