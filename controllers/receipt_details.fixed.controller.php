<?php

// import the required models
require_once './models/receipt.class.php';

$id_receipt = $route_regex_matches[1];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (array_key_exists('confirmPayment', $_POST)) {
        // set the receipt as "payed" in the database
        $result_array = Receipt::set_to_payed($id_receipt);
        if ($result_array['successQuery1'] and $result_array['successQuery2']) {
            // delete the order forms for this receipt from the session, if there are any
            if (array_key_exists($id_receipt, $_SESSION['order_forms'])) {
                unset($_SESSION['order_forms'][$id_receipt]);
            }
            // redirect to the receipt list page
            header("Location: /fixe/bons");
            exit();
        }
        else {
            // display an error page
            echo 'Error while processing the request';
        }
    }
    else {
        echo 'bad POST request';
    }
}
else {
    // get the receipt details from the database
    $receipt_details_array = Receipt::get_receipt_details_json($id_receipt);
    // display the page
    // - header
    $tab_title = "Bon n°{$id_receipt} - ".WEBSITE_TITLE;
    require './views/header.inc.view.php';
    // - side navbar
    echo generate_navbar(3);
    // - page title
    $page_title = "Bon n°{$id_receipt}";
    require './views/page_title.inc.fixed.view.php';
    // - page content
    // part 1
    require './views/receipt_details_pt1.fixed.view.php';
    // products list
    foreach ($receipt_details_array['produits'] as $product_array) {
        $label = $product_array['label'];
        $quantity = $product_array['quantite'];
        $unit_price = $product_array['prix_unitaire'];
        $product_total = $product_array['total'];
        require './views/templates/receipt_product.template.fixed.view.php';
    }
    // part 2
    // the user can not start 2 separate order forms for the same receipt
    $disable_add_products_with_order_button = '';
    $disable_add_products_no_order_button = '';
    if (array_key_exists($id_receipt, $_SESSION['order_forms'])) {
        if (array_key_exists(FORM_SESSION_NAMES[0], $_SESSION['order_forms'][$id_receipt])) {
            $disable_add_products_no_order_button = ' disabled';
        }
        if (array_key_exists(FORM_SESSION_NAMES[1], $_SESSION['order_forms'][$id_receipt])) {
            $disable_add_products_with_order_button = ' disabled';
        }
    }
    $discount = $receipt_details_array['remise'];
    $receipt_total = $receipt_details_array['total'];
    require './views/receipt_details_pt2.fixed.view.php';
}
