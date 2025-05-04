<?php

// import the required models
require_once './models/order.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo json_encode(Order::set_order_to_ready($_POST['order-id']));
}
else {
    echo 'Wrong use of this API';
}
