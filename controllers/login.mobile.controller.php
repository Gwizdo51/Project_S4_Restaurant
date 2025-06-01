<?php

// import the required models
require_once './models/server.class.php';
$servers_array = Server::get_all_active_servers_json();

// display the page
// - header
$tab_title = 'Identification du serveur - '.WEBSITE_TITLE;
require './views/header.inc.view.php';
// - page content
// part 1
if (count($servers_array) === 0) {
    $display_no_servers_message = '';
    $display_columns_descriptions = ' d-none';
}
else {
    $display_no_servers_message = ' d-none';
    $display_columns_descriptions = '';
}
require './views/login_pt1.mobile.view.php';
// list of servers
foreach ($servers_array as $server_id => $server_array) {
    $server_name = $server_array['nom'];
    $sector_name = $server_array['secteur'] ?? '-';
    require './views/templates/server.template.mobile.view.php';
}
// part 2
require './views/login_pt2.mobile.view.php';
