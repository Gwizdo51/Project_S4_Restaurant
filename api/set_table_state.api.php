<?php

// import the required models
require_once './models/table.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // send back a JSON
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(Table::set_state($_POST['tableId'], $_POST['stateId']));
}
else {
    echo 'Wrong use of this API';
}
