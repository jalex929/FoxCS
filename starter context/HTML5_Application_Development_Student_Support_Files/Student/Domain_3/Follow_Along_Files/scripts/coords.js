window.onload = function () {
    var element = document.getElementById('canvas');

    element.addEventListener('click', (e) => {
        var msg = `Your click position was X: ${e.offsetX} / Y: ${e.offsetY}`;
        document.getElementById('output').innerHTML = msg;
    })
}