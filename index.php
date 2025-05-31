<?php
// front controller

// import all libraries
require_once './lib/config.php';
require_once './lib/utils.php';

// session cookie
session_start();
// setup the session array structure
session_setup();
// session_destroy();
// var_dump_pre($_SESSION);

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

$route = $_GET['route'];
$route_regex_matches = [];
// remove trailing forward slashes
if (preg_match('~^(.+)/$~u', $route, $route_regex_matches)) {
    header("Location: {$route_regex_matches[1]}");
}
// pages
elseif ($route === '/accueil') {
    require_once './controllers/main_landing.controller.php';
}
// MOBILE
elseif ($route === '/mobile') {
    require_once './controllers/login.mobile.controller.php';
}
elseif (preg_match('~^/mobile/(\d+)$~u', $route, $route_regex_matches)) {
    require_once './controllers/server_hub.mobile.controller.php';
}
// /mobile/3/nouvelle-commande
elseif (preg_match('~^/mobile/(\d+)/nouvelle-commande/(\d+)$~u', $route, $route_regex_matches)) {
    require_once './controllers/order_form.mobile.controller.php';
}
elseif (preg_match('~^/mobile/(\d+)/nouvelle-commande$~u', $route, $route_regex_matches)) {
    // redirect to the server hub
    header("Location: /mobile/{$route_regex_matches[1]}");
}
// FIXE
elseif ($route === '/fixe') {
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
    require_once './controllers/settings_categories.fixed.controller.php';
}
elseif (preg_match('~^/fixe/configuration/carte/categories/(\d+)$~u', $route, $route_regex_matches)) {
    require_once './controllers/settings_category.fixed.controller.php';
}
elseif (preg_match('~^/fixe/configuration/carte/categories/(\d+)/nouveau-produit$~u', $route, $route_regex_matches)) {
    require_once './controllers/settings_product_form_new.fixed.controller.php';
}
elseif (preg_match('~^/fixe/configuration/carte/categories/(\d+)/(\d+)$~u', $route, $route_regex_matches)) {
    require_once './controllers/settings_product_form_modify.fixed.controller.php';
}
elseif ($route === '/fixe/configuration/carte/options') {
    require_once './controllers/settings_options.fixed.controller.php';
}
elseif ($route === '/fixe/configuration/carte/options/nouvelle-option') {
    require_once './controllers/settings_option_form_new.fixed.controller.php';
}
elseif (preg_match('~^/fixe/configuration/carte/options/(\d+)$~u', $route, $route_regex_matches)) {
    require_once './controllers/settings_option_form_modify.fixed.controller.php';
}
elseif ($route === '/fixe/configuration/secteurs') {
    require_once './controllers/settings_sectors.fixed.controller.php';
}
elseif ($route === '/fixe/configuration/secteurs/nouveau-secteur') {
    require_once './controllers/settings_sector_form_new.fixed.controller.php';
}
elseif (preg_match('~^/fixe/configuration/secteurs/(\d+)$~u', $route, $route_regex_matches)) {
    require_once './controllers/settings_sector_form_modify.fixed.controller.php';
}
elseif ($route === '/fixe/configuration/serveurs') {
    require_once './controllers/settings_servers.fixed.controller.php';
}
elseif ($route === '/fixe/configuration/horaires') {
    // ...
}
// API
elseif (preg_match('~^/api/get-orders-to-prepare/(\d+)$~u', $route, $route_regex_matches)) {
    require_once './api/get_orders_to_prepare.api.php';
}
elseif ($route === '/api/set-order-ready') {
    require_once './api/set_order_ready.api.php';
}
elseif ($route === '/api/set-order-delivered') {
    require_once './api/set_order_delivered.api.php';
}
elseif ($route === '/api/get-current-receipts') {
    require_once './api/get_current_receipts.api.php';
}
elseif ($route === '/api/create-receipt') {
    require_once './api/create_receipt.api.php';
}
elseif ($route === '/api/cancel-reservation') {
    require_once './api/cancel_reservation.api.php';
}
elseif (preg_match('~^/api/get-server-hub-data/(\d+)$~u', $route, $route_regex_matches)) {
    require_once './api/get_server_hub_data.api.php';
}
elseif ($route === '/api/set-table-state') {
    require_once './api/set_table_state.api.php';
}
elseif ($route === '/api/get-server-settings') {
    require_once './api/get_server_settings_data.api.php';
}
elseif ($route === '/api/update-servers') {
    require_once './api/update-servers.api.php';
}
elseif ($route === '/api/order-option') {
    require_once './api/order_option.api.php';
}
elseif ($route == '/api/category') {
    require_once './api/category.api.php';
}
elseif ($route == '/api/product') {
    require_once './api/product.api.php';
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
