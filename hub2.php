<div class="hub" id="hub2">  
<?php
    echo '<p>' . 'Fiche de ' . $_SESSION['player2'] . '</p>';
    echo $_SESSION['gen_fiche2'];
?>
    </div>

    <style type="text/css" >

        .hub {
            border: 1px solid black;
            width: 25%;
        }

<?php
    if($_SESSION['current_player'] == $_SESSION['player2']) {
?>      

        #hub2 {
            float: left;
        }
        #hub1 {
            color: grey;
        }

<?php
    }
    else {
?>

        #hub2 {
            float: right;
        }
        #hub2 {
            color: grey;
        }

<?php        
    }
?>
    </style>