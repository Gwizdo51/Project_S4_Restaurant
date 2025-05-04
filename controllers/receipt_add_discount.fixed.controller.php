<?php

// import all required models
require_once './models/receipt.class.php';

$id_receipt = $route_regex_matches[1];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $discount_amount = (float) $_POST['amount'];
    if ($_POST['addOrRemove'] === 'add') {
        $discount_amount = -$discount_amount;
    }
    // modify the discount of the receipt in the database
    $result_array = Receipt::set_discount($id_receipt, $discount_amount);
    if ($result_array['success']) {
        // redirect to the receipt details page
        header("Location: /fixe/bons/{$id_receipt}");
        exit();
    }
    else {
        // display an error page
        echo 'Error while processing the request';
    }
}
else {
    // display the page
    // - header
    $tab_title = "Bon n°{$id_receipt} - Modification du total - ".WEBSITE_TITLE;
    require './views/header.inc.view.php';
    // - side navbar
    echo generate_navbar(3);
    // - page title
    $page_title = "Bon n°{$id_receipt} - Modifier le total";
    require './views/page_title.inc.fixed.view.php';
    // - page content
    require './views/receipt_add_discount.fixed.view.php';
}
