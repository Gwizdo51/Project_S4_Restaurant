<?php

// import the required models
require_once './models/receipt.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // send back a JSON
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(Receipt::create_receipt($_POST['tableId'], $_POST['serverId']));
}
else {
    echo 'Wrong use of this API';
}
