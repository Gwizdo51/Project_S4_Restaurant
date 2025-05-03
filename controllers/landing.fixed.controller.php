<?php

// display the page
// - header
$tab_title = 'Accueil fixe - '.WEBSITE_TITLE;
require './views/header.inc.view.php';
// - side navbar
echo generate_navbar(-1);
// - page title
$page_title = 'Accueil interface fixe';
require './views/page_title.inc.fixed.view.php';
// - page content
require './views/landing.fixed.view.php';
