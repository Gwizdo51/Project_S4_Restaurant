<?php

// import the required models
require_once './models/option.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // delete the option
    Option::delete_option((int) $_POST['deleteOption']);
}

// get all options in the database
$options_array = Option::get_all_options_json();

// display the page
// - header
$tab_title = 'Configuration - Options de commande - '.WEBSITE_TITLE;
require './views/header.inc.fixed.view.php';
// - side navbar
echo generate_navbar(6);
// - page title
$page_title = 'Options de commande';
require './views/page_title.inc.fixed.view.php';
// - page content
// part 1
if (count($options_array) === 0) {
    $display_columns_descriptions = ' d-none';
    $display_no_options_message = '';
}
else {
    $display_columns_descriptions = '';
    $display_no_options_message = ' d-none';
}
require './views/settings_options_pt1.fixed.view.php';
// list of option
foreach ($options_array as $option_id => $option_array) {
    $option_label = $option_array['label'];
    $option_choice_type = $option_array['id_type_choix'] === 1 ? 'Unique' : 'Multiple';
    $html_choices_list = [];
    foreach ($option_array['choix'] as $choice_label) {
        $html_choices_list[] = "<li>{$choice_label}</li>";
    }
    $option_choices = implode('', $html_choices_list);
    require './views/templates/option.template.fixed.view.php';
}
// part 2
require './views/settings_options_pt2.fixed.view.php';
