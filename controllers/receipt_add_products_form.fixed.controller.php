<?php

// import the order form model
require_once './models/order_form_fixed.class.php';

$id_receipt = $route_regex_matches[1];

// get the form from the session or create a new one
$order_form = OrderFormFixed::get($id_receipt, $form_session_name);

// update the order form object if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_form->update($_POST);
}

// select the action based on the step
if ($order_form->get_step() === 3) {
    // the form is completed or canceled, redirect to the receipt details page
    $keep = false;
    header("Location: /fixe/bons/{$id_receipt}");
}
else {
    $keep = true;
    // setup the common view variables
    if ($form_session_name === FORM_SESSION_NAMES[0]) {
        $tab_title = "Bon n°{$id_receipt} - Ajout de produits avec commande - ".WEBSITE_TITLE;
        $page_title = "Bon n°{$id_receipt} - Ajouter des produits avec commande";
    }
    else {
        $tab_title = "Bon n°{$id_receipt} - Ajout de produits sans commande - ".WEBSITE_TITLE;
        $page_title = "Bon n°{$id_receipt} - Ajouter des produits sans commande";
    }
    // - header
    require './views/header.inc.view.php';
    // - side navbar
    echo generate_navbar(3);
    // - page title
    require './views/page_title.inc.fixed.view.php';
    // - page content
    switch ($order_form->get_step()) {
        case 0:
            // display the sumup view
            $order_form_items_list = $order_form->get_items_list();
            // - part 1
            $display_no_items_message = count($order_form_items_list) === 0 ? '' : ' d-none';
            require './views/receipt_add_products_form_sumup_pt1.fixed.view.php';
            // - list of items
            // foreach ($order_form_items_list as $item) {
            for ($item_index = 0; $item_index < count($order_form_items_list); $item_index++) {
                $item = $order_form_items_list[$item_index];
                $product_label = $item->get_product_label();
                $details = $item->get_details();
                require './views/templates/receipt_add_products_form_item.template.fixed.view.php';
            }
            // - part 2
            require './views/receipt_add_products_form_sumup_pt2.fixed.view.php';
            break;
        case 1:
            // ...
            require './views/receipt_add_products_form_select_product.fixed.view.php';
            break;
        case 2:
            // ...
            require './views/receipt_add_products_form_product_details.fixed.view.php';
            break;
        default:
            throw new RuntimeException("This error should never be thrown");
    }
}

// finish processing
$order_form->end($keep);
// var_dump_pre($_SESSION);
