<?php

// get the server ID from the route
$server_id = $route_regex_matches[1];
// $server_name = 'server_name';

// display the page
// - header
$tab_title = 'Identification du serveur - '.WEBSITE_TITLE;
require './views/header.inc.view.php';
// - page content
require './views/server_hub.mobile.view.php';
