<?php

// import the required models
require_once './models/order.class.php';

echo json_encode(Order::get_all_orders_to_prepare_json($route_regex_matches[1]));
