<!-- <div id="hub"> -->

    <div class="hub" id="hub1">  
<?php
    echo '<p>' . $_SESSION['player1'] . '</p>';
    echo $_SESSION['gen_fiche1'];
?>
    </div>

    <br/>

    <div class="hub" id="hub2">
<?php
    echo '<p>' . $_SESSION['player2'] . '</p>';
    echo $_SESSION['gen_fiche2'];
?>
    </div>  

<!-- </div> -->
    <style type="text/css" >
/*   
        #hub {
            border: 1px solid black;
            display: flex;
            justify-content: space-between;
        }
*/
        .hub {
            border: 1px solid black;
        }

        #hub1 {
            float: left;
        }
        #hub2 {
            float: right;
        }
    </style>