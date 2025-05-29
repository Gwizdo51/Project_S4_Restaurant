<?php

// import the required models
require_once './models/category.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // respond with a JSON
    header('Content-Type: application/json; charset=utf-8');
    // return all categories in the database
    echo json_encode(Category::get_all_categories_json());
}
elseif (in_array($_SERVER['REQUEST_METHOD'], ['PUT', 'POST', 'DELETE'])) {
    // receive a JSON and respond with a JSON
    $json_content = json_decode(file_get_contents('php://input'), true);
    header('Content-Type: application/json; charset=utf-8');
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'PUT':
            // create a new category
            echo json_encode(Category::create($json_content));
            break;
        case 'POST':
            // update a category
            echo json_encode($json_content);
            break;
        case 'DELETE':
            // delete a category
            echo json_encode(Category::delete($json_content));
            break;
    }
}
else {
    // unrecognised method
    http_response_code(405);
}
