$(document).ready(function() {
    var canvas = document.getElementById('canvas');
    var ctx = canvas.getContext('2d');
    drawField();

    function drawField () {
        // draw goal boxes
        ctx.strokeStyle = '#F5F5F5';
        ctx.lineWidth = 5;
        ctx.strokeRect(0, 100, 100, 200);
        ctx.strokeRect(700, 100, 100, 200);
        ctx.strokeRect(0, 150, 50, 100);
        ctx.strokeRect(750, 150, 50, 100);

        // draw center circles
        ctx.beginPath();
        ctx.arc(400, 200, 50, 0, 2 * Math.PI);
        ctx.stroke();

        ctx.beginPath();
        ctx.arc(400, 200, 10, 0, 2 * Math.PI);
        ctx.fillStyle = "#F5F5F5";
        ctx.fill();
        ctx.stroke();

        // draw center line
        ctx.beginPath();
        ctx.moveTo(400, 0);
        ctx.lineTo(400, 400);
        ctx.stroke();

        // draw text
        // ctx.font = "24px Tahoma";
        // ctx.fillStyle = "#F5F5F5";
        // ctx.fillText("Hello World! Stadium", 500, 360);
        // ctx.translate(-420, -310);
        // ctx.fillText("Hello World! Stadium", 510, 360);
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