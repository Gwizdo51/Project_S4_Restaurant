<?php

$category_id = (int) $route_regex_matches[1];
$product_id = (int) $route_regex_matches[2];

// display the page
$tab_title = 'Configuration - Modifier produit - '.WEBSITE_TITLE;
$page_title = 'Modifier un produit';
require_once './controllers/settings_product_form_display.fixed.controller.php';
