<?php

// import the required models
require_once './models/reservation.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // send back a JSON
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(Reservation::cancel_reservation($_POST['reservation_id']));
}
else {
    echo 'Wrong use of this API';
}
