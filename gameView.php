<?php
    $title = 'Game';
    ob_start();

    echo 'C\'est au tour de ' . $_SESSION['current_player'];
    echo '<br/>' . '(lancé ' . $_GET['phase'] . '/3)' . '<br/>';
    
/*
phase=1
*/
    if($_GET['phase'] == 1) {

        $board = array(
            1=> rand(1, 6),//index commence à 1
            rand(1, 6),
            rand(1, 6),
            rand(1, 6),
            rand(1, 6)
        );

        $stock = array(1 => null, null, null, null, null);

    }
/*
phase = 2
*/
    else {
        for($i = 1; $i < 6; $i++) {

            $stock[$i] = (isset($_POST['hidden_stock' . $i])) ? $_POST['hidden_stock' . $i] : null;  
            
            $board[$i] = $stock[$i] == null ? rand(1, 6) : null;
        }
    }    

/*
all
*/
include('hub1.php');
include('hub2.php');
?>
<div id="gameBoard">
    <div>Cliquer sur un dé pour le deplacer</div>
    <div><?= $_SESSION['current_player']; ?> garde:</div> 

<?php
    for($i = 1; $i < 6; $i++) {
        $type = $stock[$i] == null ? 'hidden' : 'button';

        echo '<input type="' . $type .'" id="stock' . $i . '" value="' . $stock[$i] . '"/>';
        }
?>


    <form action="index.php?action=play&phase=<?=$_GET['phase'] +1; ?>" method="post">

        <div><?= $_SESSION['current_player']; ?> a lancé:</div> 
<?php
        for($i = 1; $i < 6; $i++) {
            $type = $board[$i] == null ? 'hidden' : 'button';

            echo '<input type="' . $type .'" id="board' . $i . '" value="' . $board[$i] . '"/>';

            echo '<input type="hidden" id="hidden_stock' . $i . '" name="hidden_stock' . $i . '" value="' . $stock[$i] . '" />';

            echo '<input type="hidden" id="hidden_board' . $i . '" name="hidden_board' . $i . '" value="' . $board[$i] . '" />';
        }
?>
        <input type="submit" value=" <?= $_GET['phase'] == 3 ? 'Valider le score' : 'Relancer'; ?>" />
    </form>
</div>


<script src="../yam's2/scriptGame.js">

</script>

<?php
$content = ob_get_clean();
require('template.php');