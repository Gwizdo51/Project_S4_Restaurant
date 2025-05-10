<?php
// front controller

// import all libraries
require_once './lib/config.php';
require_once './lib/utils.php';

// session cookie
session_start();
session_setup();
// var_dump_pre($_SESSION);
// session_destroy();

// set the timezone
date_default_timezone_set('Europe/Paris');

// test - remove element from array
// $test_array = [];
// $test_array[] = 'a';
// $test_array[] = 'b';
// $test_array[] = 'c';
// var_dump_pre($test_array);
// unset($test_array[1]);
// // the indices get messed up
// var_dump_pre($test_array);
// // reset the indices with "array_values"
// $test_array = array_values($test_array);
// var_dump_pre($test_array);

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
elseif (preg_match('~^/fixe/bons/(\d+)/modifier-total$~u', $route, $route_regex_matches)) {
    require_once './controllers/receipt_add_discount.fixed.controller.php';
}
elseif (preg_match('~^/fixe/bons/(\d+)/ajouter-produits-avec-commande$~u', $route, $route_regex_matches)) {
    $form_session_name = FORM_SESSION_NAMES[0];
    require_once './controllers/receipt_add_products_form.fixed.controller.php';
}
elseif (preg_match('~^/fixe/bons/(\d+)/ajouter-produits-sans-commande$~u', $route, $route_regex_matches)) {
    $form_session_name = FORM_SESSION_NAMES[1];
    require_once './controllers/receipt_add_products_form.fixed.controller.php';
}
elseif ($route === '/fixe/reservations') {
    require_once './controllers/reservations.fixed.controller.php';
}
elseif ($route === '/fixe/reservations/nouvelle-reservation') {
    require_once './controllers/reservation_form_new.fixed.controller.php';
}
elseif (preg_match('~^/fixe/reservations/(\d+)$~u', $route, $route_regex_matches)) {
    require_once './controllers/reservation_form_modify.fixed.controller.php';
}
elseif ($route === '/fixe/configuration') {
    require_once './controllers/settings.fixed.controller.php';
}
elseif ($route === '/fixe/configuration/carte') {
    require_once './controllers/settings_menu.fixed.controller.php';
}
elseif ($route === '/fixe/configuration/carte/categories') {
    // ...
}
elseif ($route === '/fixe/configuration/carte/options') {
    // ...
}
elseif ($route === '/fixe/configuration/secteurs') {
    require_once './controllers/settings_sectors.fixed.controller.php';
}
elseif ($route === '/fixe/configuration/serveurs') {
    require_once './controllers/settings_servers.fixed.controller.php';
}
elseif ($route === '/fixe/configuration/horaires') {
    require_once './controllers/settings_schedule.fixed.controller.php';
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
elseif ($route === '/api/cancel-reservation') {
    require_once './api/cancel_reservation.api.php';
}
// tests bootstrap
elseif ($route === '/test-bootstrap') {
    require_once './views/tests/test_bootstrap.html';
}
elseif ($route === '/test-bootstrap-kitchen-orders') {
    require_once './views/tests/test_bootstrap_kitchen_orders.html';
}
// 404
else {
    require_once './controllers/not_found.controller.php';
}
