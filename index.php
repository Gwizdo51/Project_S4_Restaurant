<?php
// front controller

// import all libraries
require_once './lib/utils.php';

// session cookie
// session_start();

// echo $_GET['route'];
switch ($_GET['route']) {
    case '/commandes-cuisine':
        require_once './controllers/kitchen_orders.controller.php';
        break;
    case '/api/get/kitchen-orders':
        require_once './api/get_orders.api.php?place=kitchen';
        break;
    case '/api/set/order-ready':
        require_once './api/set_order_ready.api.php';
        break;
    default:
        require_once './controllers/not_found.controller.php';
}
