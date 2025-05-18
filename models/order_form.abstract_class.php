<?php

require_once './models/order.class.php';
require_once './models/item.class.php';
require_once './models/product.class.php';

abstract class OrderForm {

    protected int $id_receipt;
    // form_session_name is either :
    // - form_fixed_add_products_with_order
    // - form_fixed_add_products_no_order
    // - form_mobile_add_order
    protected string $form_session_name;
    /**
     * @var Item[]
     */
    protected array $items_list = [];
    protected array $current_product_json;
    protected array $current_order_options;
    protected int $step = 0;

    public function get_step(): int {
        return $this->step;
    }

    /**
     * @return Item[]
     */
    public function get_items_list(): array {
        return $this->items_list;
    }

    public function get_current_order_options(): array {
        return $this->current_order_options;
    }

    public function get_current_product_json(): array {
        return $this->current_product_json;
    }

    /**
     * Removes an item from $items_list by index
     * @param int $index
     * @return void
     */
    protected function remove_item($index): void {
        unset($this->items_list[$index]);
        // reset the array indices
        $this->items_list = array_values($this->items_list);
    }

    /**
     * Loads the OrderForm from the session if it is there,
     * creates a new one otherwise
     * @param int $id_receipt
     * @param string $form_session_name
     * @return OrderForm
     */
    abstract public static function get($id_receipt, $form_session_name): OrderForm;

    /**
     * Loads the form from the session
     * @param int $id_receipt
     * @param string $form_session_name
     * @return OrderForm
     */
    protected static function load_from_session($id_receipt, $form_session_name): OrderForm {
        return unserialize($_SESSION['order_forms'][$id_receipt][$form_session_name]);
    }

    /**
     * Saves the form in the session
     * @return void
     */
    private function save_to_session(): void {
        /* pseudocode :
        if $id_receipt is not in the keys of $_SESSION['order_forms'], add it as an empty array
        save the form in $_SESSION['order_forms'][$id_receipt][$form_session_name]
        */
        if (!array_key_exists($this->id_receipt, $_SESSION['order_forms'])) {
            $_SESSION['order_forms'][$this->id_receipt] = [];
        }
        $_SESSION['order_forms'][$this->id_receipt][$this->form_session_name] = serialize($this);
    }

    /**
     * Deletes the form from the session
     * @param int $id_receipt
     * @param string $form_session_name
     * @return void
     */
    private function delete_from_session(): void {
        /* pseudocode :
        delete $_SESSION['order_forms'][$id_receipt][$form_session_name]
        if $_SESSION['order_forms'][$id_receipt] is empty, delete it
        */
        unset($_SESSION['order_forms'][$this->id_receipt][$this->form_session_name]);
        if (count($_SESSION['order_forms'][$this->id_receipt]) === 0) {
            unset($_SESSION['order_forms'][$this->id_receipt]);
        }
    }

    /**
     * Updates the form based on the current step and the last POST request
     * @param string[] $post_array
     * @return void
     */
    abstract public function update($post_array): void;

    /**
     * Called by the controller before displaying the view
     * @param bool $keep
     *   "true" if the form needs to be saved in the session,
     *   "false if it needs to be deleted
     * @return void
     */
    public function end($keep): void {
        if ($keep) {
            $this->save_to_session();
        }
        else {
            $this->delete_from_session();
        }
    }

    /**
     * Adds the order(s) to the database
     * @return void
     */
    protected function process(): void {
        /* pseudocode :
        $new_order <- true if a new order has to be created
        $items_list_kitchen <- empty array
        $items_list_bar <- empty array
        for each item in $items_list :
            if the item is to be prepared in the kitchen :
                add it to $items_list_kitchen
            else :
                add it to $items_list_bar
        if $items_list_kitchen is not empty :
            if $new_order :
                create a new order for the kitchen in the database
            else :
                create a delivered order for the kitchen in the database
            for each item in $items_list_kitchen :
                add the item to the order in the database
        if $items_list_bar is not empty :
            if $new_order :
                create a new order for the bar in the database
            else :
                create a delivered order for the bar in the database
            for each item in $items_list_bar :
                add the item to the new order in the database
        */
        $new_order = $this->form_session_name !== FORM_SESSION_NAMES[1];
        $items_list_kitchen = [];
        $items_list_bar = [];
        foreach ($this->items_list as $item) {
            if ($item->get_id_place() === 1) {
                $items_list_kitchen[] = $item;
            }
            else {
                $items_list_bar[] = $item;
            }
        }
        if (count($items_list_kitchen) !== 0) {
            $id_new_order = Order::create_order($this->id_receipt, 1, $new_order);
            foreach ($items_list_kitchen as $item) {
                $item->set_id_order($id_new_order);
                $item->save_to_db();
            }
        }
        if (count($items_list_bar) !== 0) {
            $id_new_order = Order::create_order($this->id_receipt, 2, $new_order);
            foreach ($items_list_bar as $item) {
                $item->set_id_order($id_new_order);
                $item->save_to_db();
            }
        }
    }

    /**
     * Summary of generate_details_string
     * @param string[] $post_array
     * @return string
     */
    protected function generate_details_string($post_array): string {
        $item_details_string_list = [];
        foreach (array_keys($this->current_order_options) as $option_id) {
            $order_option_array = $this->current_order_options[$option_id];
            $item_details = "{$order_option_array['label']} : ";
            if ($order_option_array['id_type_choix'] === 1) {
                // unique choice -> get the selected choice in the POST array
                $item_details .= $order_option_array['choix'][(int) $post_array[$option_id]];
            }
            else {
                // multiple choices
                $at_least_one_choice_selected = false;
                $selected_choices_strings_array = [];
                foreach (array_keys($post_array) as $post_array_key) {
                    $regex_matches = [];
                    if (preg_match("~^{$option_id}_(\d+)$~u", $post_array_key, $regex_matches)) {
                        $at_least_one_choice_selected = true;
                        $selected_choices_strings_array[] = $order_option_array['choix'][(int) $regex_matches[1]];
                    }
                }
                if (!$at_least_one_choice_selected) {
                    $selected_choices_strings_array[] = '-';
                }
                $item_details .= implode(', ', $selected_choices_strings_array);
            }
            $item_details_string_list[] = $item_details;
        }
        // add the user input details
        $details = sanitize_input($post_array['details']);
        if (strlen($details) !== 0) {
            $item_details_string_list[] = $details;
        }
        return implode("\n", $item_details_string_list);
    }
}
