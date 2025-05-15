<?php

// import the required models
require_once './models/server.class.php';

// send back a JSON
header('Content-Type: application/json; charset=utf-8');
echo json_encode(Server::get_server_hub_data_json($route_regex_matches[1]));
