<?php

$option_id = (int) $route_regex_matches[1];

// display the page
$tab_title = 'Configuration - Modifier option de commande - '.WEBSITE_TITLE;
$page_title = 'Modifier une option de commande';
require_once './controllers/settings_option_form_display.fixed.controller.php';
