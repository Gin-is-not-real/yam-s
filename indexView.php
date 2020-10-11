<?php

    $title = 'Accueil';
    ob_start();

/*
no phase
*/
    if(!isset($_GET['phase'])) {
        ?>
        <form action="index.php?action=solo" method="post">
            <input type="submit" value="Solo" />
        </form>
        <form action="index.php?action=vs" method="post">
            <input type="submit" value="vs" />
        </form>
        <?php
    }
/*
phase mode
*/
    elseif($_GET['phase'] == 'names') {
        ?>
        <form action="index.php?action=names" method="post">
            <div>
                <label for="in_player1">Entrez un nom pour le joueur 1</label>
                <input type="text" name="player1" value="Joueur 1" />
            </div>
            <div>
                <label for="in_player2">Entrez un nom pour <?= $_SESSION['mode'] == 'solo' ? ' le bot' : ' le joueur 2' ?></label>
                <input type="text" name="player2" value="<?= $_SESSION['mode'] == 'solo' ? 'Jeanne Droïde' : 'Joueur 2' ?>" />
            </div>
 
            <input type="submit" value="VALIDER" />

        </form>
<?php
    }
/*
phase test
*/
    elseif($_GET['phase'] == 'test') {
        echo 'ici la phase test <br/>';
        ?>

        <form action="index.php?action=init" method="post"> 
            <div>
                <label for="dice1"><?= $_SESSION['player1']; ?>, lancer un Dé:</label>
                <input id="dice1" type="button" name="dice1" value="Lancer" autocomplete="off" />
            </div>

            <div>
                <label for="dice2"><?= $_SESSION['mode'] == 'vs' ? $_SESSION['player2'] . ', lancer un Dé:' : 'Lancer un dés pour ' . $_SESSION['player2'] . ':'?></label>
                <input id="dice2" type="button" name="dice2" value="Lancer" autocomplete="off" />
            </div>

            <p id="notice"></p>
            
            <input type="hidden" id="first_player" name="first_player">
            <input type="hidden" id="second_player" name="second_player">

            <input type="submit" id="submit" value="JOUER" disabled>
        </form>

<!--SRIPT JS POUR LE LANC2 DES DES-->
    <script type="text/javascript">

        var dice1 = document.querySelector('#dice1');
        dice1.addEventListener('click', roll);
        var dice2 = document.querySelector('#dice2');
        dice2.addEventListener('click', roll);

        var notice = document.querySelector('#notice');

        var hidden1 = document.querySelector('#first_player');
        var hidden2 = document.querySelector('#second_player');

        var submit = document.querySelector('#submit');

        function roll() {

            var dice = Math.floor(Math.random() * Math.floor(6)) +1; 
            //si le dé n'est pas encore lancé, on le lance
            if(this.value === 'Lancer' ) {
                this.value = dice;
            }
            //ici on verifie quel dé est le plus fort pour le stocké dans hidden, et rendre able le bouton jouer
            if(dice1.value != "Lancer" && dice2.value !="Lancer"){
                    
                if(dice1.value > dice2.value) {

                    hidden1.value = <?= json_encode($_SESSION['player1']); ?>;
                    hidden2.value = <?= json_encode($_SESSION['player2']); ?>

                    notice.innerHTML = <?= json_encode($_SESSION['player1']); ?> + " sera le premier joueur";

                    submit.disabled = false;
                }
                else if(dice1.value < dice2.value) {

                    hidden1.value = <?= json_encode($_SESSION['player2']); ?>;
                    hidden2.value = <?= json_encode($_SESSION['player1']); ?>;

                    notice.innerHTML = <?= json_encode($_SESSION['player2']); ?> + " sera le premier joueur";

                    submit.disabled = false;
                }
                else if(dice1.value == dice2.value) {
                    console.log("égalité ");
                    notice.innerHTML = dice1.value + " et " + dice2.value + ": égalité, relancez les dés";

                    dice1.value = "Lancer";
                    dice2.value = "Lancer";
                    
                }
            }        
        }
/*
        function iaRoll(dice) {

                setTimeout(() => {
                    dice.click();
                    //#
                    console.log("rolled: " + dice.value);

                }, 1000);                

        }
*/      
    </script>

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
    
        echo $_GET['winner'] . ' à gagné !' . '<br/>';
    
        echo $_SESSION['player1'] . ' => ' . $_SESSION['fiche1']['total'];
        echo '<br/>';
    
        echo $_SESSION['player2'] . ' => ' . $_SESSION['fiche2']['total'];
        echo '<br/>';
?>
        <form action="indexView.php" method="post">
            <input type="submit" value="Rejouer" />
        </form>

<?php
    }

    $content = ob_get_clean();
    require('template.php');
?>