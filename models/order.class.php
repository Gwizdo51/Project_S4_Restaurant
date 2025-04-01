<?php

class Order {
    /* static methods:
    - get all orders waiting for preparation in a specific place (kitchen or bar)
    - set an order as ready to be collected
    */

    /**
     * Returns the JSON containing all the orders to be prepared
     * in a specific place (kitchen or bar)
     * @param string $place
     * @return string
     */
    public static function get_all_orders_to_prepare($place): string {
        // get all commands to be prepared in a specific place ("cuisine" or "bar")
        // informations to get : table number, list of items (labels + details), time of creation
        $db_connection = get_db_connection();
        $query = 'SELECT c.ID_commande, c.date_creation, p.label_produit, i.details, t.numero'
            .' FROM `commande` c'
            .' JOIN `etat_commande` e ON c.ID_etat_commande = e.ID_etat_commande'
            .' JOIN `lieu_preparation` l ON c.ID_lieu_preparation = l.ID_lieu_preparation'
            .' JOIN `item` i ON c.ID_commande = i.ID_commande'
            .' JOIN `produit` p ON i.ID_produit = p.ID_produit'
            .' JOIN `bon` b ON c.ID_bon = b.ID_bon'
            .' JOIN `table` t ON b.ID_table = t.ID_table'
            .' WHERE e.label_etat_commande = "à préparer"'
            ." AND l.label_lieu = '$place'"
            .' ORDER BY c.date_creation, c.ID_commande;';
        $result_cursor = mysqli_query($db_connection, $query);
        /*
        {
            "1": {
                "date_creation": "2025/03/30 12:12:29",
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
        while ($row = mysqli_fetch_assoc($result_cursor)) {
            // var_dump_pre($row);
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
        // var_dump_pre($orders_array);
        // var_dump_pre(json_encode($orders_array));
        return json_encode($orders_array);
    }

    public static function set_order_to_ready($id): string {

    }
}
