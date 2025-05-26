<?php

// import the required models
require_once './models/option.class.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (!array_key_exists('id', $_GET)) {
            http_response_code(400);
            header('Content-Type: text/plain; charset=utf-8');
            echo 'no "id" in GET parameters';
            exit();
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(Option::get_option_json((int) $_GET['id']));
        break;
    case 'POST':
        // receive a JSON
        $json_content = json_decode(file_get_contents('php://input'), true);
        // update an order option in the database
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(Option::update_option($json_content));
        break;
    case 'PUT':
        // receive a JSON
        $json_content = json_decode(file_get_contents('php://input'), true);
        // add a new order option in the database
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(Option::create_option($json_content));
        break;
    default:
        // unrecognised method
        http_response_code(405);
}
