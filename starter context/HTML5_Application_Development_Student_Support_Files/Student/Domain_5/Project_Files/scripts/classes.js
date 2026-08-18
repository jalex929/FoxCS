// INSTANTIATION //

class Player {
    constructor(fName, lName, age) {
        this.fName = fName,
        this.lName = lName,
        this.age = age
        this.greeting = function() {
            return "Welcome, " + this.fName + " " + this.lName + ".";
        }
    }
}

const player1 = new Player('Bob', 'Reynolds', 13); // player1 instantiated
const player2 = new Player('Julian', 'Costa', 12); // player2 instantiated
const player3 = new Player('Monty', 'Fowler', 14); // player3 instantiated
// instantiate a new player object as directed in the project workbook


let baseballTeam = [player1, player2, player3, player4]; // store four players into an array
console.log(baseballTeam); // log object array

// PROPERTIES //

// add a for-loop that prints the first name of each player in the baseballTeam object array
// for-loop line 2
// for-loop line 3

// METHODS //

// console.log the player1 welcome message
// console.log the player3 welcome message


// INHERITANCE //
class Coach extends Player {
    removePlayer(playerFirstName) {
        baseballTeam = baseballTeam.filter(p => {
            return p.fName == playerFirstName? false : true;
        })
        console.log(baseballTeam);
    }
}

// add code
// add code
// add code
// add code
