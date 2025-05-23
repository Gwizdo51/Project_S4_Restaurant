<?php

// display the page
// - header
$tab_title = 'Configuration - Carte - '.WEBSITE_TITLE;
require './views/header.inc.fixed.view.php';
// - side navbar
echo generate_navbar(6);
// - page title
$page_title = 'Modification de la carte';
require './views/page_title.inc.fixed.view.php';
// - page content
require './views/settings_menu.fixed.view.php';
