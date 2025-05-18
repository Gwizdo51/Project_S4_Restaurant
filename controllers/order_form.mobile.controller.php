<?php

// import the required models
require_once './models/order_form_mobile.class.php';
require_once './models/receipt.class.php';
require_once './models/category.class.php';
require_once './models/product.class.php';

// get the server ID and the table ID from the route
$server_id = $route_regex_matches[1];
$table_id = $route_regex_matches[2];

// get the current receipt ID for this table
$result_array = Receipt::get_table_current_receipt_id_and_number((int) $table_id);
$receipt_id = $result_array['id_bon'];
$table_number = $result_array['numero_table'];

// get the form from the session or create a new one
$order_form = OrderFormMobile::get($receipt_id, FORM_SESSION_NAMES[2]);

// update the order form object if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_form->update($_POST);
}

// select the action based on the step
if ($order_form->get_step() === 4) {
    // the form is completed or canceled, return to the server hub
    $keep = false;
    header("Location: /mobile/{$server_id}");
}
else {
    $keep = true;
    // display the page
    // - header
    $tab_title = "Nouvelle commande - Table {$table_id} - ".WEBSITE_TITLE;
    require './views/header.inc.view.php';
    // - page content
    switch ($order_form->get_step()) {
        case 0:
            // display the sumup view
            $order_form_items_list = $order_form->get_items_list();
            // - part 1
            if (count($order_form_items_list) === 0) {
                $display_no_items_message = '';
                $display_columns_descriptions = ' d-none';
                $disable_confirm_button = ' disabled';
            }
            else {
                $display_no_items_message = ' d-none';
                $display_columns_descriptions = '';
                $disable_confirm_button = '';
            }
            require './views/order_form_sumup_pt1.mobile.view.php';
            // - list of items
            for ($item_index = 0; $item_index < count($order_form_items_list); $item_index++) {
                $item = $order_form_items_list[$item_index];
                $product_label = $item->get_product_label();
                $details = str_replace("\n", '<br>', $item->get_details());
                require './views/templates/order_form_item.template.mobile.view.php';
            }
            // - part 2
            require './views/order_form_sumup_pt2.mobile.view.php';
            break;
        case 1:
            // get the list of categories
            $categories_array = Category::get_all_categories_json();
            // display the category selection view
            // - part 1
            if (count($categories_array) === 0) {
                $display_no_categories_message = '';
            }
            else {
                $display_no_categories_message = ' d-none';
            }
            require './views/order_form_select_category_pt1.mobile.view.php';
            // - list of categories
            foreach ($categories_array as $category_id => $category_label) {
                require './views/templates/order_form_category.template.mobile.view.php';
            }
            // - part 2
            require './views/order_form_select_category_pt2.mobile.view.php';
            break;
        case 2:
            // get the list of products of the selected category
            $category_array = Category::get_all_category_products_json($order_form->get_current_category_id());
            // var_dump_pre($category_array);
            // display the product selection view
            // - part 1
            $category_label = array_keys($category_array)[0];
            require './views/order_form_select_product_pt1.mobile.view.php';
            // - list of products
            foreach ($category_array[$category_label] as $product_array) {
                $product_id = $product_array['id'];
                $product_label = $product_array['label'];
                $product_price = $price_formatter->formatCurrency($product_array['prix'], "EUR");
                require './views/templates/order_form_product.template.mobile.view.php';
            }
            // - part 2
            require './views/order_form_select_product_pt2.mobile.view.php';
            break;
        case 3:
            // get the product order options from the form
            $product_order_options_array = $order_form->get_current_order_options();
            // display the product details view
            // - part 1
            $product_label = $order_form->get_current_product_json()['label'];
            require './views/order_form_product_details_pt1.mobile.view.php';
            // - list of options
            foreach ($product_order_options_array as $option_id => $option_array) {
                $option_label = $option_array['label'];
                require './views/templates/order_form_option.template.mobile.view.php';
                $choice_type_id = $option_array['id_type_choix'];
                $is_first_choice = true;
                foreach ($option_array['choix'] as $choice_id => $choice_label) {
                    if ($choice_type_id === 1) {
                        // radio buttons
                        $type = 'radio';
                        $checked = '';
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
                    require './views/templates/order_form_choice.template.mobile.view.php';
                }
                echo "</div>\n</div>\n</div>\n";
            }
            // - part 2
            require './views/order_form_product_details_pt2.mobile.view.php';
            break;
        default:
            throw new RuntimeException('This error should never be thrown');
    }
}

// finish processing
$order_form->end($keep);
