<?php

// reservation form page display script
// - header
require './views/header.inc.fixed.view.php';
// - side navbar
echo generate_navbar(4);
// - page title
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
// show every table in the restaurant
foreach ($tables_array as $table_id => $table_number) {
    // check every table in $reserved_tables
    $checked = in_array($table_number, $reserved_tables) ? ' checked' : '';
    require './views/templates/form_table_checkbox.template.fixed.view.php';
}
// part 2
require './views/reservation_form_pt2.fixed.view.php';
