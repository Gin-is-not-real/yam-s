var score_submit = document.querySelector("#score_submit");
score_submit.addEventListener("click", check);
        
function check() {
    var radios = document.getElementsByName('radio');
    var hidden = document.querySelector('#hidden_radio');

    var radioId;
    for(var i = 0; i < radios.length; i++) {
        if(radios[i].checked) {
            radioId = radios[i].id;
        }
    }
    hidden.value = radioId;
}