<div id="hub">

<?php


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
?>

    <div class="hub" id="player1">  
<?php
    echo '<p>' . $_SESSION['player1'] . '</p>';
    $fiche = generateFiche($_SESSION['fiche1']);
    echo $fiche;
?>
    </div>

    <br/>

    <div class="hub" id="player2">
<?php
    echo '<p>' . $_SESSION['player2'] . '</p>';
    $fiche = generateFiche($_SESSION['fiche2']);
    echo $fiche;
?>
    </div>  

    <style type="text/css" >
        #hub {
            border: 1px solid black;
            display: flex;
            justify-content: space-between;
        }
        .hub {
            border: 1px solid black;
        }
    </style>