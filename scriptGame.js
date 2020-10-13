var board1 = document.querySelector('#board1');
board1.addEventListener('click', change);
var board2 = document.querySelector('#board2');
board2.addEventListener('click', change);
var board3 = document.querySelector('#board3');
board3.addEventListener('click', change);
var board4 = document.querySelector('#board4');
board4.addEventListener('click', change);
var board5 = document.querySelector('#board5');
board5.addEventListener('click', change);

var stock1 = document.querySelector('#stock1');
stock1.addEventListener('click', change);
var stock2 = document.querySelector('#stock2');
stock2.addEventListener('click', change);
var stock3 = document.querySelector('#stock3');
stock3.addEventListener('click', change);
var stock4 = document.querySelector('#stock4');
stock4.addEventListener('click', change);
var stock5 = document.querySelector('#stock5');
stock5.addEventListener('click', change);

function change() {
    console.log("this id: " + this.id);
    var diceId = (this.id).charAt(5);
    console.log("id: " + diceId);
    this.type = "hidden";

    var other = (this.id).includes("board") ? "stock" + diceId : "board" + diceId;

    other_dice = document.querySelector('#' + other);
    other_dice.type = "button";
    other_dice.value = this.value;

    hidden_stock = document.querySelector('#hidden_stock' + diceId);
    hidden_stock.value = other.includes("stock") ? this.value : null;

    hidden_board = document.querySelector('#hidden_board' + diceId);
    hidden_board.value = other.includes("board") ? this.value : null;

    console.log(hidden_stock.name + " " + hidden_stock.value);

}