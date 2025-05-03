<?php

// import the required models
require_once './models/receipt.class.php';

$id_receipt = $route_regex_matches[1];
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
$discount = $receipt_details_array['remise'];
$receipt_total = $receipt_details_array['total'];
require './views/receipt_details_pt2.fixed.view.php';
