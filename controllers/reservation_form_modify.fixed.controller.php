<?php

// import the required models
require_once './models/reservation.class.php';
require_once './models/table.class.php';

$reservation_id = $route_regex_matches[1];
$total_number_of_tables = Table::get_total_number_of_tables();
// var_dump_pre(Reservation::get_from_db($reservation_id));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // get the reservation from the POST array
    $reservation = Reservation::get_from_post($_POST);
    // if the reservation is valid ...
    if ($reservation->form_is_valid()) {
        // save the reservation to the database
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
// - header
$tab_title = 'Modifier réservation - '.WEBSITE_TITLE;
require './views/header.inc.view.php';
// - side navbar
echo generate_navbar(4);
// - page title
$page_title = 'Modifier réservation';
require './views/page_title.inc.fixed.view.php';
// - page content
// part 1
$name_client_is_valid = $reservation->get_name_client_is_valid();
$name_client_is_valid_message_class = ' d-none';
if ($name_client_is_valid === null) {
    $name_client_is_valid_input_class = '';
}
else {
    if ($name_client_is_valid) {
        $name_client_is_valid_input_class = ' is-valid';
    }
    else {
        $name_client_is_valid_input_class = ' is-invalid';
        $name_client_is_valid_message_class = '';
    }
}
$datetime_is_valid = $reservation->get_datetime_is_valid();
$datetime_is_valid_message_class = ' d-none';
if ($datetime_is_valid === null) {
    $datetime_is_valid_input_class = '';
}
else {
    if ($datetime_is_valid) {
        $datetime_is_valid_input_class = ' is-valid';
    }
    else {
        $datetime_is_valid_input_class = ' is-invalid';
        $datetime_is_valid_message_class = '';
    }
}
$number_people_is_valid = $reservation->get_number_people_is_valid();
$number_people_is_valid_message_class = ' d-none';
if ($number_people_is_valid === null) {
    $number_people_is_valid_input_class = '';
}
else {
    if ($number_people_is_valid) {
        $number_people_is_valid_input_class = ' is-valid';
    }
    else {
        $number_people_is_valid_input_class = ' is-invalid';
        $number_people_is_valid_message_class = '';
    }
}
require './views/reservation_form_pt1.fixed.view.php';
// list of tables
$reserved_tables = $reservation->get_reserved_tables();
for ($index_table = 0; $index_table < $total_number_of_tables; $index_table++) {
    $number_table = $index_table + 1;
    $checked = in_array($number_table, $reserved_tables) ? ' checked' : '';
    require './views/templates/reservation_form_table.template.fixed.view.php';
}
// part 1
require './views/reservation_form_pt2.fixed.view.php';
