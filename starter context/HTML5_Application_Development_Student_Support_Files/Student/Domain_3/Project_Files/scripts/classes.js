// first let's talk about what a class is
// a class is a template or blueprint used to create objects

// new template created, when a new player is created, the code runs
// class Player {
//     constructor() {
//         console.log('Player created');
//     }
// }

// now we will create an object template that has properties (key value pairs)
// these properties can be accessed as properties of an object
// class Player {
//     constructor() {
//         this.fName = "Bob",
//         this.lName = "Reynolds",
//         this.age = 13
//     }
// }

// const player1 = new Player();
// console.log(player1);
// console.log(player1.fName);

// but we want to be able to pass in parameters so that each object can have different key/value pairs
// we can also assign methods to an object 
// rather than simply logging out an object, let's also add each object to an array
// then array methods can be used to maniplate data easily
class Player {
    constructor(fName, lName, age) {
        this.fName = fName,
        this.lName = lName,
        this.age = age
        this.greeting = function() {
            return "Welcome, " + this.fName + " " + this.lName + ".";
        }
        console.log(`${this.fName} has joined the team!`);
    }
}

const player1 = new Player('Bob', 'Reynolds', 13);
const player2 = new Player('Julian', 'Costa', 12);
const player3 = new Player('Monty', 'Fowler', 14);
const player4 = new Player('Dianna', 'Thompson', 10);

let baseballTeam = [player1, player2, player3, player4];
console.log(baseballTeam);


for (let player in baseballTeam) {
    console.log(baseballTeam[player].fName);
}

// inheritence
class Coach extends Player {
    removePlayer(playerFirstName) {
        baseballTeam = baseballTeam.filter(p => {
            return p.fName == playerFirstName? false : true;
        })
        console.log(baseballTeam);
    }
}

const coach1 = new Coach('Nicky', 'Moon', 34);
baseballTeam.push(coach1);
console.log(baseballTeam);
coach1.removePlayer('Bob');