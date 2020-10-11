<?php
require('controller.php');

    try {

        if(isset($_GET['action'])) {

            if($_GET['action'] == 'solo') {
                chooseMode('solo');
            }
            elseif($_GET['action'] == 'vs') {
                chooseMode('vs');
            }

            elseif($_GET['action'] == 'names') {
                initPlayers();
            }

            elseif($_GET['action'] == 'init') {
                initGame();
            }

            elseif($_GET['action'] == 'play') {

                if($_SESSION['mode'] == 'solo' AND $_SESSION['current_player'] == $_SESSION['player2']) {
                    turnIa($_GET['phase']);
                }           

                else {
                    if($_GET['phase'] == 4) {
                        //$_GET['tab_dices'] = validateDices();
                        displayPossibilities(); 
                    }

                    else {
                        turn($_GET['phase']);
                    }                    
                }

                
            }
            elseif($_GET['action'] == 'putScore') {
                putScore();
            }

        } 
        else {
            require('indexView.php');
        }

    } catch(Exception $e) {
        echo 'Erreur: ' . $e->getMessage();
    }