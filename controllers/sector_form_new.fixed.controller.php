<?php

// import the required models
require_once './models/sector.class.php';
require_once './models/table.class.php';

// get the tables that can be assigned to the sector
$selectable_tables = Table::get_assignable_tables_ids_and_numbers_json();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // get the sector from the POST array
    $sector = Sector::get_from_post($_POST, $selectable_tables);
    // if the sector is valid ...
    if ($sector->form_is_valid()) {
        // save the sector to the database
        $sector->save_to_db();
        // redirect the user to the sectors tab
        header("Location: /fixe/configuration/secteurs");
        exit();
    }
}
else {
    // create an empty reservation
    $sector = new Sector();
}

// display the page
$tab_title = 'Configuration - Nouveau secteur - '.WEBSITE_TITLE;
$page_title = 'Ajouter un secteur';
require_once './controllers/sector_form_display.fixed.controller.php';
