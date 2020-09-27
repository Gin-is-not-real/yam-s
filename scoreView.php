<?php
    $title = "Score";
    ob_start();

    echo 'ici le score view <br/>';
    echo 'joueur: ' . $_SESSION['current_player'] . '<br/>';

    $score = $_GET['tab_dices'];
    foreach($score as $value) {
        echo $value . ', ';
        
    }
    echo '<br/>';


?>
    <form action="index.php?action=putScore" method="post">
<?php
        $count = count($GLOBALS['index']);
        //echo $count;
        for($i = 0; $i < $count -1; $i++){

            $score = $_SESSION['current_fiche'][$GLOBALS['index'][$i]] != 0 ? $_SESSION['current_fiche'][$GLOBALS['index'][$i]] : $_GET['values'][$i];

            echo '<p><label for="' . $GLOBALS['index'][$i] . '" >' . $GLOBALS['index'][$i] . ' = ' . $score . ' points</label>';

            if($_SESSION['current_fiche'][$GLOBALS['index'][$i]] === null) {
                echo '<input type="radio" id="' . $GLOBALS['index'][$i] . '" name="radio" value="' . $_GET['values'][$i] .'" required /></p>'; 
            }
 
                      
        }
?>
        <input type="hidden" name="radio_id" id="hidden" value="" />
        <br/>
        <input type="submit" id="submit" value="Inscrire" />
    </form>

<!-- JS -->
    <script type="text/javascript">
        var submit = document.querySelector("#submit");
        submit.addEventListener("click", check);
        
        function check() {
            var radios = document.getElementsByName('radio');
            var hidden = document.querySelector('#hidden');

            var id;
            for(var i = 0; i < radios.length; i++) {
                if(radios[i].checked) {
                    id = radios[i].id;
                }
            }
            hidden.value = id;
        }
    </script>

        

<?php

include('hub.php');
/*
    echo 'current_fiche' . '<br/>';
    print_r($_SESSION['current_fiche']);

    echo '<br/>' . 'numbers' . '<br/>';
    print_r($tab_numbers);

    echo '<br/>' . 'occurences' . '<br/>';
    print_r($occurences);
*/



