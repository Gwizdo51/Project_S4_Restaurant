<?php

require_once './models/order_form.abstract_class.php';

class OrderFormFixed extends OrderForm {

    public function __construct($id_receipt, $form_session_name) {
        if (!in_array($form_session_name, FORM_SESSION_NAMES)) {
            throw new RuntimeException("\"{$form_session_name}\" is not a valid form session name");
        }
        $this->id_receipt = $id_receipt;
        $this->form_session_name = $form_session_name;
    }

    public static function get($id_receipt, $form_session_name): OrderFormFixed {
        // load the form from the session if it is saved
        if (array_key_exists($id_receipt, $_SESSION['order_forms']) and array_key_exists($form_session_name, $_SESSION['order_forms'][$id_receipt])) {
            return self::load_from_session($id_receipt, $form_session_name);
        }
        // otherwise, return a new one
        else {
            return new self($id_receipt, $form_session_name);
        }
    }

    public function update($post_array): void {
        /* steps :
         * - 0 : order sumup
         * - 1 : select a product
         * - 2 : input product details
         * - 3 : confirm/cancel order
         */
        // var_dump_pre($post_array);
        $post_array_key_regex_matches = [];
        if ($this->step === 0) {
            if (array_key_exists('cancel_order', $post_array)) {
                $this->step = 3;
            }
            elseif (array_key_exists('confirm_order', $post_array)) {
                $this->process();
                $this->step = 3;
            }
            elseif (preg_match('~^(\d+)$~u', array_keys($post_array)[0], $post_array_key_regex_matches)) {
                $this->remove_item($post_array_key_regex_matches[1]);
            }
            elseif (array_key_exists('add_product', $post_array)) {
                $this->step = 1;
            }
        }
        elseif ($this->step === 1) {
            if (array_key_exists('back', $post_array)) {
                $this->step = 0;
            }
            elseif (preg_match('~^(\d+)$~u', array_keys($post_array)[0], $post_array_key_regex_matches)) {
                // request the product json from the database
                $current_product_id = (int) $post_array_key_regex_matches[1];
                $this->current_product_json = Product::get_product_json($current_product_id);
                // request the product options json from the database
                $this->current_order_options = Product::get_product_order_options_json($current_product_id);
                $this->step = 2;
            }
        }
        elseif ($this->step === 2) {
            if (array_key_exists('back', $post_array)) {
                $this->step = 1;
            }
            elseif (array_key_exists('add', $post_array)) {
                // make a new item from the form and add it to the list
                $new_item = new Item(
                    $this->current_product_json['id_produit'],
                    $this->current_product_json['label'],
                    $this->generate_details_string($post_array),
                    $this->current_product_json['id_lieu_preparation']
                );
                $this->items_list[] = $new_item;
                // return to the sumup view
                $this->step = 0;
            }
        }
        else {
            throw new RuntimeException('This error should never be thrown');
        }
    }
}
