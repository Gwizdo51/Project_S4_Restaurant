<?php

// display the page
// - header
$tab_title = 'Commandes cuisine - '.WEBSITE_TITLE;
require './views/header.inc.fixed.view.php';
// - side navbar
echo generate_navbar(1);
// - page title
$page_title = 'Commandes cuisine';
require './views/page_title.inc.fixed.view.php';
// - page content
$id_place = 1;
require './views/orders.fixed.view.php';
