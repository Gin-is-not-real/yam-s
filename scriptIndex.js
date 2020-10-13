var passPlayer1 = document.querySelector("#passPlayer1").value;
var passPlayer2 = document.querySelector("#passPlayer2").value;

var diceTest1 = document.querySelector('#diceTest1');
diceTest1.addEventListener('click', roll);
var diceTest2 = document.querySelector('#diceTest2');
diceTest2.addEventListener('click', roll);

var noticeTest = document.querySelector('#noticeTest');

var hiddenFirstPlayer = document.querySelector('#first_player');
var hiddenSecondPlayer = document.querySelector('#second_player');

var submit = document.querySelector('#submit');

function roll() {
    var dice = Math.floor(Math.random() * Math.floor(6)) +1; 
    //si le dé n'est pas encore lancé, on le lance
    if(this.value === 'Lancer' ) {
        this.value = dice;
    }
    //ici on verifie quel dé est le plus fort pour le stocké dans hidden, et rendre able le bouton jouer
    if(diceTest1.value != "Lancer" && diceTest2.value !="Lancer"){
                    
        if(diceTest1.value > diceTest2.value) {

            hiddenFirstPlayer.value = passPlayer1;
            hiddenSecondPlayer.value = passPlayer2;

            noticeTest.innerHTML = passPlayer1 + " sera le premier joueur";

            submit.disabled = false;
        }
        else if(diceTest1.value < diceTest2.value) {

            hiddenFirstPlayer.value = passPlayer2;
            hiddenSecondPlayer.value = passPlayer1;

            noticeTest.innerHTML = passPlayer2 + " sera le premier joueur";

            submit.disabled = false;
        }
        else if(diceTest1.value == diceTest2.value) {
            console.log("égalité ");
            noticeTest.innerHTML = diceTest1.value + " et " + diceTest2.value + ": égalité, relancez les dés";

            diceTest1.value = "Lancer";
            diceTest2.value = "Lancer";
        }
    }        
}