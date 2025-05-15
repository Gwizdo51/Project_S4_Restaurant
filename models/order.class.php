<?php

class Order {
    /* static methods:
     * - get all orders waiting for preparation in a specific place (kitchen or bar)
     * - set an order as ready to be collected
     */

    /**
     * Returns the JSON-like array containing all the orders to be prepared
     * in a specific place (kitchen or bar)
     * @param string $id_place
     * @return array
     */
    public static function get_all_orders_to_prepare_json($id_place): array {
        // get all commands to be prepared in a specific place ("cuisine" or "bar")
        // informations to get : table number, list of items (labels + details), time of creation
        $db_connection = get_db_connection();
        $query = "SELECT c.ID_commande, c.date_creation, p.label_produit, i.details, t.numero
                  FROM `commande` c
                  JOIN `etat_commande` e ON c.ID_etat_commande = e.ID_etat_commande
                  JOIN `lieu_preparation` l ON c.ID_lieu_preparation = l.ID_lieu_preparation
                  JOIN `item` i ON c.ID_commande = i.ID_commande
                  JOIN `produit` p ON i.ID_produit = p.ID_produit
                  JOIN `bon` b ON c.ID_bon = b.ID_bon
                  JOIN `table` t ON b.ID_table = t.ID_table
                  WHERE e.ID_etat_commande = 1
                  AND l.ID_lieu_preparation = {$id_place}
                  ORDER BY c.date_creation, c.ID_commande, p.label_produit";
        $result_cursor = $db_connection->query($query);
        /*
        {
            "1": {
                "date_creation": "2025-03-30 12:12:29",
                "numero_table": 4,
                "items": [
                    {
                        "label": "Flan",
                        "details": ""
                    },
                    {
                        "label": "Salade verte",
                        "details": ""
                    }
                ]
            }
        }
        */
        $orders_array = [];
        while ($row = $result_cursor->fetch_assoc()) {
            $order_number = (int) $row['ID_commande'];
            // if the order number already exists in the array, add the item to the order
            if (array_key_exists($order_number, $orders_array)) {
                $orders_array[$order_number]["items"][] = [
                    'label' => $row['label_produit'],
                    'details' => $row['details']
                ];
            }
            // otherwise, add the new order
            else {
                $orders_array[$order_number] = [
                    'date_creation' => $row['date_creation'],
                    'numero_table' => $row['numero'],
                    'items' => [
                        [
                            'label' => $row['label_produit'],
                            'details' => $row['details']
                        ]
                    ]
                ];
            }
        }
        $db_connection->close();
        return $orders_array;
    }

    /**
     * @param int $id_order
     * @param int $id_state
     * @return bool[]
     */
    // public static function set_order_to_ready($id): array {
    public static function set_order_state($id_order, $id_state): array {
        $db_connection = get_db_connection();
        // UPDATE `commande`
        // SET ID_etat_commande = 2
        // WHERE ID_commande = $id;
        $query = "UPDATE `commande`
                SET ID_etat_commande = {$id_state}
                WHERE ID_commande = {$id_order}";
        $result = $db_connection->query($query);
        $result_array = ['success' => (bool) $result];
        $db_connection->close();
        return $result_array;
    }

    /**
     * Creates a new order in the database and returns the ID of the row created
     * @param int $id_receipt
     * @param int $id_place
     * @param bool $new_order
     * @return int
     *   The ID of the newly created row
     */
    public static function create_order($id_receipt, $id_place, $new_order): int {
        // set the order as "to prepare" or as "delivered" depending on $new_order
        $id_order_state = $new_order ? 1 : 3;
        $db_connection = get_db_connection();
        // insert the new order
        $insert_query = "INSERT INTO `commande` (ID_bon, ID_etat_commande, ID_lieu_preparation) VALUES
                         ({$id_receipt}, {$id_order_state}, {$id_place})";
        $db_connection->query($insert_query);
        // get the last inserted row id
        $id_query = 'SELECT LAST_INSERT_ID() `id`';
        $result_cursor = $db_connection->query($id_query);
        $row = $result_cursor->fetch_assoc();
        $id_order = (int) $row['id'];
        $db_connection->close();
        return $id_order;
    }
}
