window.onload = function() {

    let card1 = document.getElementById('card1');

    card1.addEventListener('click', function () {
        card1.classList.add('card-highlight');
        // this.classList.toggle('card-highlight');
    })


    // adding eventListeners to each individual element is inefficient
    // you'd need these 6 lines of code for every card element on the page
    let card2 = document.getElementById('card2');

    card2.addEventListener('click', function () {
        card2.classList.add('card-highlight');
        // this.classList.toggle('card-highlight');
    })
}

// go to an link events2.js

