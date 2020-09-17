<?php


    echo 'Fin du jeu';
    echo '<br/>';

    echo $_GET['winner'] . ' à gagné !' . '<br/>';


    echo $_SESSION['player1'] . ' => ' . $_SESSION['fiche1']['total'];
    echo '<br/>';

    echo $_SESSION['player2'] . ' => ' . $_SESSION['fiche2']['total'];