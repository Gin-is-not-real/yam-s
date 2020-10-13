<?php
    $title = "Score";
    ob_start();

    echo $_SESSION['current_player'] . ', choisissez un score à marquer;' . '<br/>';

    echo '(Dés: ';
    $score = $_GET['tab_dices'];
    foreach($score as $value) {
        echo $value . ', ';   
    }
    echo ')' . '<br/>';

    include('hub1.php');
    include('hub2.php');
?>
    <form action="index.php?action=putScore" method="post">
<?php
        $count = count($GLOBALS['index']);
        //echo $count;
        for($i = 0; $i < $count -1; $i++){
            $index_i = $GLOBALS['index'][$i];
            $help_max = ' (max ' . $GLOBALS['max'][$i] . ' pnts)';

            $score = $_SESSION['current_fiche'][$index_i] != 0 ? $_SESSION['current_fiche'][$index_i] : $_GET['values'][$i];

            echo '<p><label for="' . $index_i . '" >' . $index_i . $help_max . ' = ' . $score . ' points</label>';

            if($_SESSION['current_fiche'][$index_i] === null) {
                echo '<input type="radio" id="' . $index_i . '" name="radio" value="' . $_GET['values'][$i] .'" required /></p>'; 
            }             
        }
?>
        <input type="hidden" name="radio_id" id="hidden_radio" value="" />
        <br/>
        <input type="submit" id="score_submit" value="Inscrire" />
    </form>

<!-- JS -->
    <script src="../yam's2/scriptScore.js">

    </script>