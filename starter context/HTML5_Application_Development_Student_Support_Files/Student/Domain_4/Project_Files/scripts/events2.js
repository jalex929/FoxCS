window.onload = function() {

    // apply a single event listener
    // let card = document.getElementById('card1');

    // card.addEventListener('click', function () {
    //     // card.classList.add('card-highlight');
    //     // this.classList.toggle('card-highlight');
    // })

    // so we know we can pass a function in, lets declare a function and add it to an event listener
    // the cardClick() function is being reused, but the add event listener would need to be applied to each card on the page
    // so it's only slightly more optimized vs. the first example
    // but also introduced bug where flex-container can take the style
    // see events3.js for how to loop through the elements
    var card1 = document.getElementById('card1');
    var card2 = document.getElementById('card2');
    var card3 = document.getElementById('card3');
    var card4 = document.getElementById('card4');

    function cardClick(event) {
        console.log(event.target);
        event.path[1].classList.add('card-highlight');
    }

    card1.addEventListener('click', cardClick);
    card2.addEventListener('click', cardClick);
    card3.addEventListener('click', cardClick);
    card4.addEventListener('click', cardClick);


}