<div class="hub" id="hub1">  
<?php
    echo '<p>' . 'Fiche de ' . $_SESSION['player1'] . '</p>';
    echo $_SESSION['gen_fiche1'];
?>
</div>

<style type="text/css" >

    .hub {
        border: 1px solid black;
        width: 25%;
    }

<?php
    if($_SESSION['current_player'] == $_SESSION['player1']) {
?>

        #hub1 {
            float: left;
        }
        #hub2 {
            color: grey;
        }

<?php
    }
    else {
?>

        #hub1 {
            float: right;
        }
        #hub1 {
            color: grey;
        }

<?php
    }
?>
    </style>