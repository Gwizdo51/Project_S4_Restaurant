<?php

// import the required models
require_once './models/server.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // receive a JSON
    $json_content = json_decode(file_get_contents('php://input'), true);
    // send back a JSON
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(Server::update_servers($json_content));
}
else {
    echo 'Wrong use of this API';
}
