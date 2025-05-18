<?php

// import the order form model
require_once './models/order_form_fixed.class.php';
require_once './models/product.class.php';

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
    // display the page
    // - header
    require './views/header.inc.fixed.view.php';
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
            if (count($order_form_items_list) === 0) {
                $display_no_items_message = '';
                $display_columns_title = ' d-none';
                $disable_confirm_button = ' disabled';
            }
            else {
                $display_no_items_message = ' d-none';
                $display_columns_title = '';
                $disable_confirm_button = '';
            }
            require './views/receipt_add_products_form_sumup_pt1.fixed.view.php';
            // - list of items
            for ($item_index = 0; $item_index < count($order_form_items_list); $item_index++) {
                $item = $order_form_items_list[$item_index];
                $product_label = $item->get_product_label();
                $details = str_replace("\n", '<br>', $item->get_details());
                require './views/templates/receipt_add_products_form_item.template.fixed.view.php';
            }
            // - part 2
            require './views/receipt_add_products_form_sumup_pt2.fixed.view.php';
            break;
        case 1:
            // get the list of categories and products from the database
            $products_array = Product::get_all_products_by_category_json();
            // display the product selection view
            // - part 1
            require './views/receipt_add_products_form_select_product_pt1.fixed.view.php';
            // - list of categories and items
            foreach (array_keys($products_array) as $category_label) {
                // add the category name
                // <h3 class="mt-3 mx-3 ps-3">• Softs</h3>
                // <div class="row mx-2">
                echo "<h3 class=\"mb-2 mx-3 ps-3\">• {$category_label}</h3>\n<div class=\"row mx-2 mb-2\">\n";
                foreach ($products_array[$category_label] as $product_array) {
                    // add the product button
                    $product_id = $product_array['id'];
                    $product_label = $product_array['label'];
                    require './views/templates/receipt_add_products_form_product.template.fixed.view.php';
                }
                echo "</div>\n";
            }
            // - part 2
            require './views/receipt_add_products_form_select_product_pt2.fixed.view.php';
            break;
        case 2:
            // get the product order options from the form
            $product_order_options_array = $order_form->get_current_order_options();
            // display the product details view
            // - part 1
            $product_label = $order_form->get_current_product_json()['label'];
            $display_no_options_message = count($product_order_options_array) === 0 ? '' : ' d-none';
            require './views/receipt_add_products_form_product_details_pt1.fixed.view.php';
            // - list of order options
            foreach ($product_order_options_array as $option_id => $option_array) {
                $option_label = $option_array['label'];
                require './views/templates/receipt_add_products_form_option.template.fixed.view.php';
                $choice_type_id = $option_array['id_type_choix'];
                $is_first_choice = true;
                foreach ($option_array['choix'] as $choice_id => $choice_label) {
                    if ($choice_type_id === 1) {
                        // radio buttons
                        $checked = '';
                        $type = 'radio';
                        if ($is_first_choice) {
                            $checked = ' checked';
                            $is_first_choice = false;
                        }
                        $name = $option_id;
                        $value = $choice_id;
                    }
                    else {
                        // checkboxes
                        $type = 'checkbox';
                        $checked = '';
                        $name = "{$option_id}_{$choice_id}";
                        $value = '';
                    }
                    require './views/templates/receipt_add_products_form_choice.template.fixed.view.php';
                }
                echo "</div>\n</div>\n</div>\n";
            }
            // - part 2
            require './views/receipt_add_products_form_product_details_pt2.fixed.view.php';
            break;
        default:
            throw new RuntimeException('This error should never be thrown');
    }
}

// finish processing
$order_form->end($keep);
