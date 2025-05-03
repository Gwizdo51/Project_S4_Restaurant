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
if ($route === '/fixe') {
    require_once './controllers/landing.fixed.controller.php';
}
elseif ($route === '/fixe/cuisine') {
    require_once './controllers/kitchen_orders.fixed.controller.php';
}
elseif ($route === '/fixe/bar') {
    require_once './controllers/bar_orders.fixed.controller.php';
}
elseif ($route === '/fixe/bons') {
    require_once './controllers/receipts.fixed.controller.php';
}
elseif (preg_match('~^/fixe/bons/(\d+)$~u', $route, $route_regex_matches)) {
    require_once './controllers/receipt_details.fixed.controller.php';
}
// API
elseif (preg_match('~^/api/get-orders-to-prepare/(\d+)$~u', $route, $route_regex_matches)) {
    require_once './api/get_orders_to_prepare.api.php';
}
elseif ($route === '/api/set-order-ready') {
    require_once './api/set_order_ready.api.php';
}
elseif ($route === '/api/get-current-receipts') {
    require_once './api/get_current_receipts.api.php';
}
// tests bootstrap
elseif ($route === '/test-bootstrap') {
    require_once './views/tests/test_bootstrap.php';
}
elseif ($route === '/test-bootstrap-kitchen-orders') {
    require_once './views/tests/test_bootstrap_kitchen_orders.php';
}
// 404
else {
    require_once './controllers/not_found.controller.php';
}
