$(document).ready(function() {
    var canvas = document.getElementById('canvas');
    var ctx = canvas.getContext('2d');

    // draw goal boxes
    // ctx.strokeStyle = '#F5F5F5';
    ctx.lineWidth = 5;
    // ctx.strokeRect(0, 100, 100, 200);
    ctx.strokeRect(700, 100, 100, 200);
    ctx.strokeRect(0, 150, 50, 100);
    ctx.strokeRect(750, 150, 50, 100);

    // small center circle
    // ctx.fillStyle = "#F5F5F5";   
    ctx.arc(400, 200, 10, 0, 2 * Math.PI);
    ctx.fill();

    // large center circle
    // ctx.beginPath();
    // ctx.arc(400, 200, 50, 0, 2 * Math.PI);
    // ctx.stroke();

    // // draw center line
    // ctx.beginPath();
    // ctx.moveTo(400, 0);
    // ctx.lineTo(400, 400);
    // ctx.stroke();
});