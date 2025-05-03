<?php

require_once './models/order_form.abstract_class.php';

class OrderFormFixed extends OrderForm {

    private function __construct() {
        // ...
    }

    public static function get(): OrderForm {
        // ...
    }

    protected static function load_from_session(): OrderForm {
        // ...
    }

    protected function save_to_session(): void {
        // ...
    }

    protected static function delete_from_session(): void {
        // ...
    }

    public function update($post_array): void {
        // ...
    }
}
