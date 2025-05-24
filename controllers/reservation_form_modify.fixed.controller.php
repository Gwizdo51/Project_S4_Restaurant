<?php

// import the required models
require_once './models/reservation.class.php';
require_once './models/table.class.php';

$reservation_id = $route_regex_matches[1];
// get all tables in the restaurant
$tables_array = Table::get_tables_ids_and_numbers_json();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // get the reservation from the POST array
    $reservation = Reservation::get_from_post($_POST, $tables_array);
    // if the reservation is valid ...
    if ($reservation->form_is_valid()) {
        // update the reservation in the database
        $reservation->update_in_db($reservation_id);
        // redirect the user to the reservations tab
        header("Location: /fixe/reservations");
        exit();
    }
}
else {
    // get the reservation from the database
    $reservation = Reservation::get_from_db($reservation_id);
}

// display the page
$tab_title = 'Modifier réservation - '.WEBSITE_TITLE;
$page_title = 'Modifier réservation';
require_once './controllers/reservation_form_display.fixed.controller.php';
