<?php

// display the page
// - header
$tab_title = 'Commandes bar - '.WEBSITE_TITLE;
require './views/header.inc.view.php';
// - side navbar
echo generate_navbar(2);
// - page title
$page_title = 'Commandes bar';
require './views/page_title.inc.fixed.view.php';
// - page content
$id_place = 2;
require './views/orders.fixed.view.php';
