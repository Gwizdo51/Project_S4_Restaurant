<?php

// import the required models
require_once './models/sector.class.php';
require_once './models/table.class.php';

$sector_id = (int) $route_regex_matches[1];
// get the tables that can be and the tables that are assigned to the sector
$selectable_tables = Table::get_assignable_tables_ids_and_numbers_json($sector_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // get the sector from the POST array
    $sector = Sector::get_from_post($_POST, $selectable_tables);
    // if the sector is valid ...
    if ($sector->form_is_valid()) {
        // update the sector in the database
        $sector->update_in_db($sector_id);
        // redirect the user to the sectors tab
        header("Location: /fixe/configuration/secteurs");
        exit();
    }
}
else {
    // get the reservation from the database
    $sector = Sector::get_from_db($sector_id);
}

// display the page
$tab_title = 'Configuration - Modifier secteur - '.WEBSITE_TITLE;
$page_title = 'Modifier un secteur';
require_once './controllers/sector_form_display.fixed.controller.php';
