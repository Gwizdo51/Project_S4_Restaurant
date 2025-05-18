<?php

require_once './models/order_form.abstract_class.php';

class OrderFormMobile extends OrderForm {

    private int $current_category_id = -1;

    public function get_current_category_id(): int {
        return $this->current_category_id;
    }

    public function __construct($id_receipt) {
        $this->id_receipt = $id_receipt;
        $this->form_session_name = FORM_SESSION_NAMES[2];
    }

    public static function get($id_receipt, $form_session_name): OrderFormMobile {
        // load the form from the session if it is saved
        if (array_key_exists($id_receipt, $_SESSION['order_forms']) and array_key_exists($form_session_name, $_SESSION['order_forms'][$id_receipt])) {
            return self::load_from_session($id_receipt, $form_session_name);
        }
        // otherwise, return a new one
        else {
            return new self($id_receipt);
        }
    }

    public function update($post_array): void {
        /* steps :
         * - 0 : order sumup
         * - 1 : select a category
         * - 2 : select a product
         * - 3 : input product details
         * - 4 : confirm/cancel order
         */
        // var_dump_pre($post_array);
        $post_array_key_regex_matches = [];
        if ($this->step === 0) {
            if (array_key_exists('cancel_order', $post_array)) {
                $this->step = 4;
            }
            elseif (array_key_exists('confirm_order', $post_array)) {
                $this->process();
                $this->step = 4;
            }
            elseif (preg_match('~^(\d+)$~u', array_keys($post_array)[0], $post_array_key_regex_matches)) {
                $this->remove_item($post_array_key_regex_matches[1]);
            }
            elseif (array_key_exists('add_item', $post_array)) {
                $this->step = 1;
            }
        }
        elseif ($this->step === 1) {
            if (array_key_exists('back', $post_array)) {
                $this->step = 0;
            }
            elseif (preg_match('~^(\d+)$~u', array_keys($post_array)[0], $post_array_key_regex_matches)) {
                // remember which category was clicked
                $this->current_category_id = (int) $post_array_key_regex_matches[1];
                $this->step = 2;
            }
        }
        elseif ($this->step === 2) {
            // var_dump_pre($post_array);
            if (array_key_exists('back', $post_array)) {
                $this->step = 1;
            }
            elseif (preg_match('~^(\d+)$~u', array_keys($post_array)[0], $post_array_key_regex_matches)) {
                // request the product json from the database
                $current_product_id = (int) $post_array_key_regex_matches[1];
                $this->current_product_json = Product::get_product_json($current_product_id);
                // request the product options json from the database
                $this->current_order_options = Product::get_product_order_options_json($current_product_id);
                $this->step = 3;
            }
        }
        elseif ($this->step === 3) {
            if (array_key_exists('back', $post_array)) {
                $this->step = 2;
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
