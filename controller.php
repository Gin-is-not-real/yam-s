<?php
session_start();

$GLOBALS['index'] = array('les 1', 'les 2', 'les 3', 'les 4', 'les 5', 'les 6', 'brelan', 'carré', 'full', 'petite suite', 'grande suite', 'yams', 'chance', 'total'
);

    function initPlayers() {

        $_SESSION['player1'] = $_POST['player1'];
        $_SESSION['player2'] = $_POST['player2'];

        $_SESSION['fiche1'] = initFiche();
        $_SESSION['fiche2'] = initFiche();
        
        $_GET['phase'] = 'test';
        require('indexView.php');
    }
    function initFiche() {
        $fiche = array(
            'les 1' => null,
            'les 2' => null,
            'les 3' => null,
            'les 4' => null,
            'les 5' => null,
            'les 6' => null,
            'brelan' => null,
            'carré' => null,
            'full' => null,
            'petite suite' => null,
            'grande suite' => null,
            'yams' => null,
            'chance' => null,
            'total' => 0
        );
        return $fiche;
    }


    function initGame() {

        if(isset($_POST['first_player'])) {
            $_SESSION['current_player'] = $_POST['first_player'];            
        }
        else {
            $_SESSION['current_player'] = $_SESSION['current_player'] == $_SESSION['player1'] ? $_SESSION['player2'] : $_SESSION['player1'];
        }


        $_SESSION['current_fiche'] = ($_SESSION['current_player'] == $_SESSION['player1']) ? $_SESSION['fiche1'] : $_SESSION['fiche2'];

        $_GET['phase'] = 'start';
        require('indexView.php');
    }

    function turn($phase) {
        $_GET['current_player'] = $_SESSION['current_player'];
        $_GET['phase'] = $phase;
        require('gameView.php');
    }

    function putScore() {
        $score = $_POST['radio'];

        if($_SESSION['current_player'] == $_SESSION['player1']) {
            $_SESSION['fiche1'][$_POST['radio_id']]= $score;
            $_SESSION['fiche1']['total'] += $score;
        }
        else {
            $_SESSION['fiche2'][$_POST['radio_id']]= $score;
            $_SESSION['fiche2']['total'] += $score;
        }

        verifyEndGame();
    }


    function verifyEndGame() {
        if(in_array(null, $_SESSION['fiche1']) OR in_array(null, $_SESSION['fiche2']) ) {
            initGame();             
        }
        else {
            $_GET['winner'] = $_SESSION['fiche1']['total'] > $_SESSION['fiche2']['total'] ? $_SESSION['player1'] : $_SESSION['player2'];

            $_GET['phase'] = 'end';
            require('indexView.php');
        }
    }

//PROPOSITION POINTS    
    function validateDices() {
        $tab_dices = array();
        $index_tab_dices = 0;

        for($i = 1; $i < 6; $i++) {
            if($_POST['hidden' . $i] != null) {
                $tab_dices[$index_tab_dices] = $_POST['hidden' . $i];  
                $index_tab_dices ++;              
            } 
        }
        for($i = 1; $i < 6; $i++) {
            if($_POST['hidden_board' . $i] != null) {
                $tab_dices[$index_tab_dices] = $_POST['hidden_board' . $i];
                $index_tab_dices ++;
            }
        }
        return $tab_dices;
    }

//CALCULS DES POINTS SELON LES DES
    function displayPossibilities() {
        $_GET['tab_dices'] = validateDices();
/*
        $_SESSION['index'] = array('les 1', 'les 2', 'les 3', 'les 4', 'les 5', 'les 6', 'brelan', 'carré', 'full', 'petite suite', 'grande suite', 'yams', 'chance', 'total'
    );
*/
        //get[values] a la fin

        
        $points = array();
        $possibility;
        $occurences = array();
        $occurence;

//pour les simples (les 1, les 2 etc..)
        for($i = 1; $i < 7; $i++){
            $possibility = 0;

            foreach($_GET['tab_dices'] as $value) {
                if($value == $i) {
                    $possibility += $i;
                }
            }
            $points[$i] = $possibility;            
        }

//les complexes
        //creation d'un array ne contenant qu'une occurence de chaque dés de tab dices
        $tab_numbers = array();
        foreach($_GET['tab_dices'] as $nbr) {
            if(!in_array($nbr, $tab_numbers)) {
                $tab_numbers[] = $nbr;
            }
        }

        //combien de fois tab_dices contient chaque nbr
        foreach($tab_numbers as $nbr) {
            $occurence = 0;

            foreach($_GET['tab_dices'] as $dice) {
                if($nbr == $dice) {
                    $occurence += 1;
                }
            }
        $occurences[$nbr] = $occurence;            
        }

        //brelan
        if(in_array(3, $occurences)) {
            $key = array_search(3, $occurences);
            $points['brelan'] = 3 * $key;
        }
        else {
            $points['brelan'] = 0;
        }

        //carré
        if(in_array(4, $occurences)) {
            $key = array_search(4, $occurences);
            $points['carré'] = 4 * $key;
        }
        else {
            $points['carré'] = 0;
        }

        //full
        $points['Full'] =  (in_array(3, $occurences) AND in_array(2, $occurences)) ? 25 : 0;

        //petite suite, grande suite
        $points['petite suite'] = 0;
        $points['grande suite'] = 0;

        $points['petite suite'] = (
            in_array(1, $tab_numbers) AND 
            in_array(2, $tab_numbers) AND 
            in_array(3, $tab_numbers) AND 
            in_array(4, $tab_numbers)) ? 30 : 0;

        if($points['petite suite'] != 30) {
            $points['petite suite'] = (
                in_array(2, $tab_numbers) AND 
                in_array(3, $tab_numbers) AND 
                in_array(4, $tab_numbers) AND 
                in_array(5, $tab_numbers)) ? 30 : 0;            
        }

        if($points['petite suite'] != 30) {
            $points['petite suite'] = (
                in_array(3, $tab_numbers) AND 
                in_array(4, $tab_numbers) AND 
                in_array(5, $tab_numbers) AND 
                in_array(6, $tab_numbers)) ? 30 : 0;
        }

        $points['grande suite'] = (
            in_array(1, $tab_numbers) AND 
            in_array(2, $tab_numbers) AND 
            in_array(3, $tab_numbers) AND 
            in_array(4, $tab_numbers) AND 
            in_array(5, $tab_numbers)) ? 40 : 0;

        if($points['grande suite'] != 40) {
            $points['grande suite'] = (
                in_array(2, $tab_numbers) AND 
                in_array(3, $tab_numbers) AND 
                in_array(4, $tab_numbers) AND 
                in_array(5, $tab_numbers) AND 
                in_array(6, $tab_numbers)) ? 40 : 0;            
        }

        //yams
        $points['yams'] = in_array(5, $occurences) ? 50 : 0;

        //chance
        foreach($_GET['tab_dices'] as $value) {
            $possibility += $value;
            $points['chance'] = $possibility;
        }

        //get values[]
        $_GET['values'] = array();
        foreach($points as $value) {
            $_GET['values'][] = $value;
        }

        require ("scoreView.php");
    }


    