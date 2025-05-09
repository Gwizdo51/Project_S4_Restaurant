<?php

// import the required models
require_once './models/reservation.class.php';

// get the list of all reservations for today and in the future
$reservations_array = Reservation::get_all_incoming_reservations_json();
// var_dump_pre($reservations_array);

// display the page
// - header
$tab_title = 'Réservations - '.WEBSITE_TITLE;
require './views/header.inc.view.php';
// - side navbar
echo generate_navbar(4);
// - page title
$page_title = 'Liste des réservations';
require './views/page_title.inc.fixed.view.php';
// - page content
// part 1
if (count($reservations_array) === 0) {
    $display_no_reservations_message = '';
    $display_columns_descriptions = ' d-none';
}
else {
    $display_no_reservations_message = ' d-none';
    $display_columns_descriptions = '';
}
require './views/reservations_pt1.fixed.view.php';
// list of reservations
foreach ($reservations_array as $reservation_id => $reservation_array) {
    $reservation_date = new DateTime($reservation_array['date']);
    if ($reservation_array['for_today']) {
        $border_color = 'warning';
        $date_text_color = ' text-warning-emphasis';
        $date_time = 'Aujourd\'hui<br>'.$reservation_date->format('H:i');
    }
    else {
        $border_color = 'secondary';
        $date_text_color = '';
        $date_time = $reservation_date->format('d/m<br>H:i');
    }
    // $date_time = (new DateTime($reservation_array['date']))->format('d/m<br>H:i');
    $client_name = $reservation_array['nom_client'];
    $number_people = $reservation_array['nombre_personnes'];
    $tables_reserved = implode(', ', $reservation_array['tables']);
    require './views/templates/reservation.template.fixed.view.php';
}
// part 2
require './views/reservations_pt2.fixed.view.php';
