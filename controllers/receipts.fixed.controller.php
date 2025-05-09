<?php

// import the required models
require_once './models/receipt.class.php';

// get the list of all the current receipts from the database
$receipts_array = Receipt::get_all_current_receipts_json();

// display the page
// - header
$tab_title = 'Bons de commande - '.WEBSITE_TITLE;
require './views/header.inc.view.php';
// - side navbar
echo generate_navbar(3);
// - page title
$page_title = 'Bons de commande';
require './views/page_title.inc.fixed.view.php';
// - receipt HTML template
echo "\n<!-- receipt template -->\n";
echo "<template id=\"template-receipt\">\n";
// template variables
$receipt_id = '';
$table_id = '';
$total = '';
require './views/templates/receipt.template.fixed.view.php';
// - page content
// part 1 (no receipts message)
if (count($receipts_array) === 0) {
    $no_receipts_message_display_none_css_class = '';
}
else {
    $no_receipts_message_display_none_css_class = ' d-none';
}
require './views/receipts_pt1.fixed.view.php';
// receipts list
foreach ($receipts_array as $receipt_id => $receipt_array) {
    $table_id = $receipt_array['numero_table'];
    $total = $receipt_array['total'];
    require './views/templates/receipt.template.fixed.view.php';
}
// part 2 (JS)
require './views/receipts_pt2.fixed.view.php';
