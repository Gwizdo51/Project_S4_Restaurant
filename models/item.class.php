<?php

class Item {
    private int $id_order;
    private int $id_product;
    private string $product_label;
    private string $details;
    private int $id_place;

    /**
     * @param int $id_product
     * @param string $product_label
     * @param string $details
     * @param int $id_place
     * @param int $id_order
     */
    public function __construct($id_product, $product_label, $details, $id_place, $id_order = -1) {
        $this->id_product = $id_product;
        $this->product_label = $product_label;
        $this->details = $details;
        $this->id_place = $id_place;
        $this->id_order = $id_order;
    }

    /**
     * @param int $id_order
     * @return void
     */
    public function set_id_order($id_order): void {
        $this->id_order = $id_order;
    }

    public function get_id_place(): int {
        return $this->id_place;
    }

    public function get_product_label(): string {
        return $this->product_label;
    }

    public function get_details(): string {
        return $this->details;
    }

    /**
     * Saves the item in the database and returns the ID of the created row
     * @return int
     */
    public function save_to_db(): int {
        $db_connection = get_db_connection();
        $insert_query = "INSERT INTO `item` (ID_commande, ID_produit, details) VALUES
                         ({$this->id_order}, {$this->id_product}, '{$this->details}')";
        $db_connection->query($insert_query);
        // get the last inserted row id
        $id_query = 'SELECT LAST_INSERT_ID() `id`';
        $result_cursor = $db_connection->query($id_query);
        $row = $result_cursor->fetch_assoc();
        $id_item = (int) $row['id'];
        $db_connection->close();
        return $id_item;
    }
}
