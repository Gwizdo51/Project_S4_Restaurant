<?php

require_once './models/order_form.abstract_class.php';

class OrderFormFixed extends OrderForm {

    private function __construct($id_receipt, $form_session_name) {
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
        var_dump_pre($post_array);
        // ...
    }
}
