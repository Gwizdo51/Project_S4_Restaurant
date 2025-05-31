<?php

$category_id = (int) $route_regex_matches[1];
$product_id = 0;

// display the page
$tab_title = 'Configuration - Nouveau produit - '.WEBSITE_TITLE;
$page_title = 'Ajouter un produit';
require_once './controllers/settings_product_form_display.fixed.controller.php';
