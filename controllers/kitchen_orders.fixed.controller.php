<?php

// display the page
// - header
$tab_title = "Commandes cuisine - {$WEBSITE_TITLE}";
require './views/header.inc.view.php';
// - side navbar
echo generate_navbar(2);
// - page title
$page_title = 'Commandes cuisine';
require './views/page_title.inc.fixed.view.php';
// - page content
$place = 'cuisine';
require './views/orders.fixed.view.php';
