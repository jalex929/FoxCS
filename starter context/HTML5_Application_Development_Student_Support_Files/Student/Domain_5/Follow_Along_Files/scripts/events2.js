window.onload = function() {

    var card1 = document.getElementById('card1');
    var card2 = document.getElementById('card2');
    var card3 = document.getElementById('card3');
    var card4 = document.getElementById('card4');

    // function
    function cardClick() {
        console.log(this);
        this.classList.add('card-highlight');
        // this.classList.toggle('card-highlight');
    }

    card1.addEventListener('click', cardClick);
    card2.addEventListener('click', cardClick);
    card3.addEventListener('click', cardClick);
    card4.addEventListener('click', cardClick);
}