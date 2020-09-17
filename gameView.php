<?php
    $title = 'Game';
    ob_start();

    echo 'ici le game view';
    echo '<br/>current player: ' . $_SESSION['current_player'];
    echo '<br/>phase: ' . $_GET['phase'] . '<br/>';


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

            $stock[$i] = (isset($_POST['hidden' . $i])) ? $_POST['hidden' . $i] : null;  
            
            $board[$i] = $stock[$i] == null ? rand(1, 6) : null;
        }
    }    



/*
all
*/
?>
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

            echo '<input type="' . $type .'" id="dice_' . $i . '" value="' . $board[$i] . '"/>';

            echo '<input type="hidden" id="hidden' . $i . '" name="hidden' . $i . '" value="' . $stock[$i] . '" />';

            echo '<input type="hidden" id="hidden_board' . $i . '" name="hidden_board' . $i . '" value="' . $board[$i] . '" />';
        }
?>
        <input type="submit" value=" <?= $_GET['phase'] == 3 ? 'Valider le score' : 'Relancer'; ?>" />
    </form>

<?php
    include('hub.php');
    /*
    echo '<br/>' . 'current fiche' . '<br/>';
    print_r($_SESSION['current_fiche']);
    */
?>

<script type="text/javascript">
    var dice1 = document.querySelector('#dice_1');
    dice1.addEventListener('click', change);
    var dice2 = document.querySelector('#dice_2');
    dice2.addEventListener('click', change);
    var dice3 = document.querySelector('#dice_3');
    dice3.addEventListener('click', change);
    var dice4 = document.querySelector('#dice_4');
    dice4.addEventListener('click', change);
    var dice5 = document.querySelector('#dice_5');
    dice5.addEventListener('click', change);

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
        var id = (this.id).charAt(5);
        this.type = "hidden";

        var other = (this.id).includes("dice") ? "stock" + id : "dice_" + id;

        other_dice = document.querySelector('#' + other);
        other_dice.type = "button";
        other_dice.value = this.value;

        hidden = document.querySelector('#hidden' + id);
        hidden.value = other.includes("stock") ? this.value : null;

        hidden_board = document.querySelector('#hidden_board' + id);
        hidden_board.value = other.includes("dice") ? this.value : null;

        console.log(hidden.name + " " + hidden.value);

    }
</script>
<?php
    
$content = ob_get_clean();
require('template.php');