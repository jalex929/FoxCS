window.onload = function() {
    // apply event listeners to each card by looping

    // get a NodeList containing all HTML elements with the class flex-item
    let cards = document.querySelectorAll('.flex-item');
    
    // loop through the NodeList and apply each eventListener to it
    cards.forEach(card => {
        card.addEventListener('mouseover', function() {
            this.classList.add('card-highlight');
        })
        card.addEventListener('mouseout', function() {
            this.classList.remove('card-highlight');
        })
    })
}