<?php

// import the required models
require_once './models/server.class.php';

// get the server ID from the route
$server_id = $route_regex_matches[1];
// get its name from the database
$server_name = Server::get_server_name_json($server_id);

// display the page
// - header
$tab_title = $server_name.' - '.WEBSITE_TITLE;
require './views/header.inc.view.php';
// - page content
require './views/server_hub.mobile.view.php';
