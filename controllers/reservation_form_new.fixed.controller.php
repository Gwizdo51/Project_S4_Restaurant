<?php

// import the required models
require_once './models/reservation.class.php';
require_once './models/table.class.php';

// get all tables in the restaurant
$tables_array = Table::get_tables_ids_and_numbers_json();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // get the reservation from the POST array
    $reservation = Reservation::get_from_post($_POST, $tables_array);
    // if the reservation is valid ...
    if ($reservation->form_is_valid()) {
        // save the reservation to the database
        $reservation->save_to_db();
        // redirect the user to the reservations tab
        header('Location: /fixe/reservations');
        exit();
    }
}
else {
    // create an empty reservation
    $reservation = new Reservation();
}

// display the page
$tab_title = 'Nouvelle réservation - '.WEBSITE_TITLE;
$page_title = 'Nouvelle réservation';
require_once './controllers/reservation_form_display.fixed.controller.php';
