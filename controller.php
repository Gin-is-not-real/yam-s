<?php
session_start();

$GLOBALS['index'] = array('les 1', 'les 2', 'les 3', 'les 4', 'les 5', 'les 6', 'brelan', 'carré', 'full', 'petite suite', 'grande suite', 'yams', 'chance', 'total'
);
/*
$GLOBALS['max']
array contenant le maximum de points pour chaque score
*/
$GLOBALS['max'] = array(5, 10, 15, 20, 25, 30, 18, 24, 25, 30, 40, 50, 30);

$_SESSION['gen_fiche1'] = generateFiche($_SESSION['fiche1']);
$_SESSION['gen_fiche2'] = generateFiche($_SESSION['fiche2']);

    function generateFiche($fiche) {
        $count = count($_SESSION['current_fiche']);
        $str = '';
        for($i = 0; $i < $count ; $i++) {

            $index = $GLOBALS['index'][$i];
            $label_points = $fiche[$index] != null ? ' points' : ' _ '; 

            $str .= '<p><label for="' . $index . '" >' . $index . ' = ' . $fiche[$index] . $label_points . '</label>';
        }
            return $str;        
    }

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
            'total' => null
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

/*
Cette fonction permet de valider le score choisi par l'utilisateur et l'inscrire sur sa fiche
*/
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

/*
cette fonction verifie si toutes les lignes de scores ont étés remplies. Si c'est le cas c'est la fin de la partie
*/
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
 
/*
VALIDATION DES DES
Cette fonction récupére les valeurs des dés (stock et board) dont dispose le joueur a la fin de ses lancés et les stocke dans $tab_dices
*/
    function validateDices() {
        $tab_dices = array();
        $index_tab_dices = 0;

        for($i = 1; $i < 6; $i++) {
            if($_POST['hidden_stock' . $i] != null) {
                $tab_dices[$index_tab_dices] = $_POST['hidden_stock' . $i];  
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

/*
QUELS DES DIFFERENTS A OBTENU LE JOUEUR
creation d'un array ne contenant qu'une occurence de chaque dés de tab dices
*/
    function whatDices($tab_dices) {
        $tab_numbers = array();
        foreach($tab_dices as $nbr) {
            if(!in_array($nbr, $tab_numbers)) {
                $tab_numbers[] = $nbr;
            }
        }
        return $tab_numbers;
    }

/*
COMBIEN D'EXEMPLAIRE DE CHAQUE DES
*/
    function whatOccurences($tab_dices, $tab_numbers) {
        foreach($tab_numbers as $nbr) {
            $occurence = 0;

            foreach($tab_dices as $dice) {
                if($nbr == $dice) {
                    $occurence += 1;
                }
            }
        $occurences[$nbr] = $occurence;            
        }

        return $occurences;
    }

//CALCULS DES POINTS SELON LES DES
/*
Pour chaque ligne de score, cette fonction calcule les points qu'il est possible de marquer et les stocke dans $points
*/
    function displayPossibilities() {

        $_GET['tab_dices'] = validateDices();
        $tab_numbers = whatDices($_GET['tab_dices']);
        $occurences = whatOccurences($_GET['tab_dices'], $tab_numbers);
   
        $points = array();
        $possibility;

        //get[values] a la fin equivault a $points mais avec des index numeriques

//les simples (les 1, les 2 etc..)

        for($i = 1; $i < 7; $i++){
            $possibility = 0;

            foreach($_GET['tab_dices'] as $dice_value) {
                if($dice_value == $i) {
                    $possibility += $i;
                }
            }
            $points[$i] = $possibility;            
        }

//les complexes

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
        $possibility = 0;
        foreach($_GET['tab_dices'] as $td_value) {
            $possibility += $td_value;
            $points['chance'] = $possibility;
        }

        //get values[]
        /*
        $points stocke les points possibles avec le nom de la ligne de score comme index
        $_GET['values'] stocke les valeurs de $points mais avec des index numériques, pour pouvoir être traités par des boucles
        */
        $_GET['values'] = array();
        foreach($points as $value) {
            $_GET['values'][] = $value;
        }

        require ("scoreView.php");
    }


    