<?php

    $title = 'Accueil';
    ob_start();

/*
no phase
*/
    if(!isset($_GET['phase'])) {
        ?>
        <form action="index.php?action=names" method="post">
            <div>
                <label for="in_player1">Entrez un nom pour le joueur 1</label>
                <input type="text" name="player1" value="Joueur 1" />
            </div>
            <div>
                <label for="in_player2">Entrez un nom pour le joueur 2</label>
                <input type="text" name="player2" value="Joueur 2" />
            </div>
            
            <input type="submit" value="VALIDER">

        </form>
<?php
    }
/*
phase test
*/
    elseif($_GET['phase'] == 'test') {
        echo 'Qui sera le premier joueur ?';
        ?>

        <form action="index.php?action=init" method="post"> 
            <div>
                <label for="diceTest1"><?= $_SESSION['player1']; ?>, lancer un Dé:</label>
                <input id="diceTest1" type="button" name="diceTest1" value="Lancer" autocomplete="off" />
            </div>
            <div>
                <label for="diceTest2"><?= $_SESSION['player2']; ?>, lancer un Dé:</label>
                <input id="diceTest2" type="button" name="diceTest2" value="Lancer" autocomplete="off" />
            </div>

            <p id="noticeTest"></p>
            
            <input type="hidden" id="first_player" name="first_player">
            <input type="hidden" id="second_player" name="second_player">

            <input type="submit" id="submit" value="JOUER" disabled>
        </form>
        
        <input type="hidden" id="passPlayer1" value="<?= $_SESSION['player1']; ?>" />
        <input type="hidden" id="passPlayer2" value="<?= $_SESSION['player2']; ?>" />

<!--SRIPT JS POUR LE LANC2 DES DES-->
    <script src="../yam's2/scriptIndex.js"></script>

<?php
    }

    elseif($_GET['phase'] == 'start') {
        echo $_SESSION['current_player'];
?>
        <form action="index.php?action=play&phase=1" method="post">
            <input type="submit" value="Lancer les dés" />
        </form>
<?php
    }

    elseif($_GET['phase'] == 'end') {
        echo 'Fin du jeu';
        echo '<br/>';
    
        echo $_GET['winner'] . ' à gagné !' . '<br/></br>';
    
        echo $_SESSION['player1'] . ' => ' . $_SESSION['fiche1']['total'] . ' points';
        echo '<br/>';
    
        echo $_SESSION['player2'] . ' => ' . $_SESSION['fiche2']['total'] . ' points';
        echo '<br/></br>';
?>
        <form action="indexView.php" method="post">
            <input type="submit" value="Rejouer" />
        </form>

<?php
    }

    $content = ob_get_clean();
    require('template.php');
?>