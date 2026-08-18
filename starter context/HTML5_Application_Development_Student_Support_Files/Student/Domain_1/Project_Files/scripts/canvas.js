$(document).ready(function() {
    var canvas = document.getElementById('canvas');
    var ctx = canvas.getContext('2d');
    drawField();

    function drawField () {
        // goal boxes
        // set the stroke style property to be equal to white (#F5F5F5)
        ctx.lineWidth = 5;
        // add code for the large rectangle on the left side of the canvas using the strokeRect() method
        ctx.strokeRect(700, 100, 100, 200);
        ctx.strokeRect(0, 150, 50, 100);
        ctx.strokeRect(750, 150, 50, 100);

        // center circles
        ctx.beginPath();
        // add code for the center circle using the arc() method
        ctx.stroke();

        ctx.beginPath();
        ctx.arc(400, 200, 10, 0, 2 * Math.PI);
        // set the fill style property to be equal to white (#F5F5F5)
        ctx.fill();
        ctx.stroke();

        // center line
        ctx.beginPath();
        // move to the coordinates (400, 0) on the canvas
        // draw a line to the coordinates (400, 400) on the canvas
        ctx.stroke();
    }
    
    const ball = {
        x: 400,
        y: 200,
        size: 15,
        dx: 5,
        dy: 5
    };

    function drawBall() {
        ctx.beginPath();
        ctx.arc(ball.x, ball.y, ball.size, 0, Math.PI * 2);
        ctx.fillStyle = '#CF5E06';
        ctx.strokeStyle = "black";
        ctx.lineWidth = "3";
        ctx.fill();
        ctx.stroke();
    }
    
    function update(event) {
        var animateOn = true;
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        drawField();
        drawBall();
        ball.x += ball.dx;
        ball.y += ball.dy;

        if (ball.y + ball.size > canvas.height || ball.y - ball.size < 0) {
            ball.dy *= -1;
        }

        if (ball.x + ball.size > canvas.width || ball.x - ball.size < 0) {
            if (ball.y < 250 && ball.y > 150) {
                alert("Nice shot!");
                animateOn = false;
            }
            else {
                ball.dx *= -1;
            }
        }
        
        if (animateOn == true) { requestAnimationFrame(update); 
            // console.log('looped'); 
        };
    }

    document.getElementById('canvas').addEventListener('click', (e) => {
        // console.log(canvas);
        ball.x = e.offsetX;
        ball.y = e.offsetY;
    })
    document.getElementById('canvas').addEventListener('click',(e) => {
        update(e);
    },{ once: true });
});