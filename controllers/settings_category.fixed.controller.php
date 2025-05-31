<?php

$category_id = (int) $route_regex_matches[1];

// display the page
// - header
$tab_title = 'Configuration - Modifier catégorie - '.WEBSITE_TITLE;
require './views/header.inc.fixed.view.php';
// - side navbar
echo generate_navbar(6);
// - page title
$page_title = 'Modifier une catégorie';
require './views/page_title.inc.fixed.view.php';
// - page content
require './views/settings_category.fixed.view.php';
