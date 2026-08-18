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
// const player4 = new Player('Dianna', 'Thompson', 10);

// let baseballTeam = [player1, player2, player3, player4]; // create object array
// console.log(baseballTeam); // log object array

// PROPERTIES //
// console.log('First Name:', player1.fName, 'Last Name:', player1.lName);

// for (let player in baseballTeam) {
//     console.log(baseballTeam[player].fName);
// }

// METHODS //

// console.log(player1.greeting());

// INHERITANCE //
// class Coach extends Player {
//     removePlayer(playerFirstName) {
//         baseballTeam = baseballTeam.filter(p => {
//             return p.fName == playerFirstName? false : true;
//         })
//         console.log(baseballTeam);
//     }
// }

// const coach1 = new Coach('Nicky', 'Moon', 34);
// baseballTeam.push(coach1);
// console.log(baseballTeam);
// coach1.removePlayer('Bob');