<?php

require_once './models/order.class.php';
require_once './models/item.class.php';

abstract class OrderForm {
    protected int $id_receipt;
    /**
     * @var Item[]
     */
    protected array $items_list;
    protected int $step;

    public function get_step(): int {
        return $this->step;
    }

    /**
     * Loads the OrderForm from the session if it is there,
     * creates a new one otherwise
     * @return OrderForm
     */
    abstract public static function get(): OrderForm;

    /**
     * Loads the form from the session
     * @return OrderForm
     */
    abstract protected static function load_from_session(): OrderForm;

    /**
     * Saves the form in the session
     * @return void
     */
    abstract protected function save_to_session(): void;

    /**
     * Deletes the form from the session
     * @return void
     */
    abstract protected static function delete_from_session(): void;

    /**
     * Updates the state of the form based on the POST array
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
        $items_list_kitchen <- empty array
        $items_list_bar <- empty array
        for each item in $items_list :
            if the item is to be prepared in the kitchen :
                add it to $items_list_kitchen
            else :
                add it to $items_list_bar
        if $items_list_kitchen is not empty :
            create a new order for the kitchen in the database
            for each item in $items_list_kitchen :
                add the item to the new order in the database
        if $items_list_bar is not empty :
            create a new order for the bar in the database
            for each item in $items_list_bar :
                add the item to the new order in the database
        */
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
            $id_new_order = Order::create_order_to_prepare($this->id_receipt, 1);
            foreach ($items_list_kitchen as $item) {
                $item->set_id_order($id_new_order);
                $item->save_to_db();
            }
        }
        if (count($items_list_bar) !== 0) {
            $id_new_order = Order::create_order_to_prepare($this->id_receipt, 2);
            foreach ($items_list_bar as $item) {
                $item->set_id_order($id_new_order);
                $item->save_to_db();
            }
        }
    }
}
