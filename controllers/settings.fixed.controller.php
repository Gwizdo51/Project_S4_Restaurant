<?php

// display the page
// - header
$tab_title = 'Configuration - '.WEBSITE_TITLE;
require './views/header.inc.view.php';
// - side navbar
echo generate_navbar(6);
// - page title
$page_title = 'Configuration de l\'application';
require './views/page_title.inc.fixed.view.php';
// - page content
require './views/settings.fixed.view.php';
