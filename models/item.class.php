<?php

class Item {
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
    public function __construct($id_product, $product_label, $details, $id_place) {
        $this->id_product = $id_product;
        $this->product_label = $product_label;
        $this->details = $details;
        $this->id_place = $id_place;
    }

    public function get_id_place(): int {
        return $this->id_place;
    }

    public function get_id_product(): int {
        return $this->id_product;
    }

    public function get_product_label(): string {
        return $this->product_label;
    }

    public function get_details(): string {
        return $this->details;
    }
}
