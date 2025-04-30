<?php
// front controller

// import all libraries
require_once './lib/config.php';
require_once './lib/utils.php';

// session cookie
// session_start();

// echo $_GET['route'];
$route = $_GET['route'];
$route_regex_matches = [];
// pages
if ($route === '/fixe/cuisine') {
    require_once './controllers/kitchen_orders.fixed.controller.php';
}
else if ($route === '/fixe/bar') {
    require_once './controllers/bar_orders.fixed.controller.php';
}
else if (preg_match('~^/fixe/bons/(\d+)$~u', $route, $route_regex_matches)) {
    require_once './controllers/test_order_id.controller.php';
}
// API
else if (preg_match('~^/api/get-orders/([a-z]+)$~u', $route, $route_regex_matches)) {
    require_once './api/get_orders.api.php';
}
else if ($route === '/api/set-order-ready') {
    require_once './api/set_order_ready.api.php';
}
// tests bootstrap
else if ($route === '/test-bootstrap') {
    require_once './views/test_bootstrap.php';
}
else if ($route === '/test-bootstrap-kitchen-orders') {
    require_once './views/test_bootstrap_kitchen_orders.php';
}
// 404
else {
    require_once './controllers/not_found.controller.php';
}
