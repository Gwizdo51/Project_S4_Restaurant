<?php

// import the required models
require_once './models/sector.class.php';
require_once './models/table.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (array_key_exists('updateTableNumber', $_POST)) {
        Table::set_total_number_of_tables((int) $_POST['numberTables']);
    }
    elseif (array_key_exists('deleteSector', $_POST)) {
        Sector::delete_sector((int) $_POST['deleteSector']);
    }
}

// get the original number of tables
$original_tables_number = Table::get_total_number_of_tables();
// get the list of sectors
$sectors_array = Sector::get_sectors_json();

// display the page
// - header
$tab_title = 'Configuration - Secteurs - '.WEBSITE_TITLE;
require './views/header.inc.fixed.view.php';
// - side navbar
echo generate_navbar(6);
// - page title
$page_title = 'Gestion des secteurs';
require './views/page_title.inc.fixed.view.php';
// - page content
// part 1
if (count($sectors_array) === 0) {
    // display the "no sectors" message
    $display_no_sectors_message = '';
    // hide the columns descriptions
    $display_columns_descriptions = ' d-none';
}
else {
    // hide the "no sectors" message
    $display_no_sectors_message = ' d-none';
    // display the columns descriptions
    $display_columns_descriptions = '';
}
require './views/settings_sectors_pt1.fixed.view.php';
// list of sectors
foreach ($sectors_array as $sector_id => $sector_array) {
    $sector_name = $sector_array['nom'];
    $tables_assigned = implode(', ', $sector_array['tables']);
    require './views/templates/sector.template.fixed.view.php';
}
// part 2
require './views/settings_sectors_pt2.fixed.view.php';
