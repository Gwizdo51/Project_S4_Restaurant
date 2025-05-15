<?php

// import the required models
require_once './models/order.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // send back a JSON
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(Order::set_order_state($_POST['order-id'], 2));
}
else {
    echo 'Wrong use of this API';
}
