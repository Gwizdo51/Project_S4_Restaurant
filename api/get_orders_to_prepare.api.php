<?php

// import the required models
require_once './models/order.class.php';

// send back a JSON
header('Content-Type: application/json; charset=utf-8');
// header('Content-Type: application/vnd.api+json; charset=utf-8');
echo json_encode(Order::get_all_orders_to_prepare_json((int) $route_regex_matches[1]));
