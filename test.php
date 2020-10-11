<?php

echo 'Stock: ' . '</br>';
for($i = 1; $i < 6; $i++) {
    echo $_POST['hidden' . $i] . '</br>';
}

echo 'Board: ' . '</br>';
for($i = 1; $i < 6; $i++) {
    echo $_POST['hidden_board' . $i] . '</br>';
}