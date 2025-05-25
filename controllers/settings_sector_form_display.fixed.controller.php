<?php

// sector form page display script
// - header
require './views/header.inc.fixed.view.php';
// - side navbar
echo generate_navbar(6);
// - page title
require './views/page_title.inc.fixed.view.php';
// - page content
// part 1
$name_sector_is_valid = $sector->get_name_sector_is_valid();
$name_sector_is_valid_message_class = ' d-none';
if ($name_sector_is_valid === null) {
    $name_sector_is_valid_input_class = '';
}
else {
    if ($name_sector_is_valid) {
        $name_sector_is_valid_input_class = ' is-valid';
    }
    else {
        $name_sector_is_valid_input_class = ' is-invalid';
        $name_sector_is_valid_message_class = '';
    }
}
$display_no_tables_message = count($selectable_tables) === 0 ? '' : ' d-none';
require './views/settings_sector_form_pt1.fixed.view.php';
// list of tables
$assigned_tables = $sector->get_assigned_tables();
foreach ($selectable_tables as $table_id => $table_number) {
    $checked = in_array($table_number, $assigned_tables) ? ' checked' : '';
    require './views/templates/form_table_checkbox.template.fixed.view.php';
}
// part 2
require './views/settings_sector_form_pt2.fixed.view.php';
