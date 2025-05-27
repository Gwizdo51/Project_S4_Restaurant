<?php

class Receipt {
    /**
     * Creates a new receipt in the database
     * @param int $id_table
     * @param int $id_server
     * @return int
     */
    public static function create_receipt($id_table, $id_server): int {
        $db_connection = get_db_connection();
        // prepare statements
        $query = 'INSERT INTO `bon` (ID_table, ID_serveur) VALUES
                                (?, ?)';
        $insert_receipt_statement = $db_connection->prepare($query);
        $query = 'UPDATE `table`
                SET ID_etat_table = 2
                WHERE ID_table = ?';
        $update_table_statement = $db_connection->prepare($query);
        // create a new receipt in the database
        $insert_receipt_statement->bind_param('ii', $id_table, $id_server);
        $insert_receipt_statement->execute();
        // get the new receipt ID
        $id_query = 'SELECT LAST_INSERT_ID() id';
        $result_cursor = $db_connection->query($id_query);
        $row = $result_cursor->fetch_assoc();
        $id_receipt = (int) $row['id'];
        // set the table state to "occupied"
        $update_table_statement->bind_param('i', $id_table);
        $update_table_statement->execute();
        $db_connection->close();
        return $id_receipt;
    }

    /**
     * Returns the JSON-like array of all current receipts
     * @return array
     */
    public static function get_all_current_receipts_json(): array {
        $db_connection = get_db_connection();
        $query = 'SELECT b.ID_bon, t.numero `numero_table`, COALESCE(SUM(p.prix) - b.remise, 0) `total`
                FROM `bon` b
                JOIN `table` t ON b.ID_table = t.ID_table
                LEFT JOIN `commande` c ON b.ID_bon = c.ID_bon
                LEFT JOIN `item` i ON c.ID_commande = i.ID_commande
                LEFT JOIN `produit` p ON i.ID_produit = p.ID_produit
                WHERE b.date_suppression IS NULL
                GROUP BY b.ID_bon
                ORDER BY b.date_creation, b.ID_bon';
        $result_cursor = $db_connection->query($query);
        $receipts_array = [];
        while ($row = $result_cursor->fetch_assoc()) {
            $receipts_array[(int) $row['ID_bon']] = [
                'numero_table' => $row['numero_table'],
                'total' => str_replace('.', ',', $row['total'])
            ];
        }
        $db_connection->close();
        return $receipts_array;
    }

    /**
     * Returns the JSON-like array containing the details of
     * the receipt with the specified ID
     * @param int $id
     * @return array
     */
    public static function get_receipt_details_json($id): array {
        $db_connection = get_db_connection();
        // prepare statements
        $query = 'SELECT b.remise, COALESCE(SUM(p.prix) - b.remise, 0) total, b.ID_bon
                FROM `bon` b
                LEFT JOIN `commande` c ON b.ID_bon = c.ID_bon
                LEFT JOIN `item` i ON c.ID_commande = i.ID_commande
                LEFT JOIN `produit` p ON i.ID_produit = p.ID_produit
                WHERE b.ID_bon = ?
                GROUP BY b.ID_bon';
        $get_receipt_info_statement = $db_connection->prepare($query);
        $query = 'SELECT p.label_produit, p.prix `prix_unitaire`, COUNT(p.ID_produit) `quantite`, SUM(p.prix) `total`
                FROM `bon` b
                JOIN `commande` c ON b.ID_bon = c.ID_bon
                JOIN `item` i ON c.ID_commande = i.ID_commande
                JOIN `produit` p ON i.ID_produit = p.ID_produit
                WHERE b.ID_bon = ?
                GROUP BY p.ID_produit
                ORDER BY p.ID_produit';
        $get_receipt_products_statement = $db_connection->prepare($query);
        // get the total and the discount of the receipt
        $get_receipt_info_statement->bind_param('i', $id);
        $get_receipt_info_statement->execute();
        $result_cursor = $get_receipt_info_statement->get_result();
        $row = $result_cursor->fetch_assoc();
        $receipt_details_array = [
            'remise' => format_price((float) $row['remise']),
            'total' => format_price((float) $row['total']),
            'produits' => []
        ];
        // get the list of products in the receipt
        $get_receipt_products_statement->bind_param('i', $id);
        $get_receipt_products_statement->execute();
        $result_cursor = $get_receipt_products_statement->get_result();
        while ($row = $result_cursor->fetch_assoc()) {
            $product_array = [
                'label' => $row['label_produit'],
                'quantite' => (int) $row['quantite'],
                'prix_unitaire' => format_price((float) $row['prix_unitaire']),
                'total' => format_price((float) $row['total'])
            ];
            $receipt_details_array['produits'][] = $product_array;
        }
        $db_connection->close();
        return $receipt_details_array;
    }

    /**
     * @param int $id
     * @param float $amount
     * @return bool[]
     */
    public static function set_discount($id, $amount): array {
        $db_connection = get_db_connection();
        // prepare statement
        $query = 'UPDATE `bon`
                  SET remise = ?
                  WHERE ID_bon = ?';
        $statement = $db_connection->prepare($query);
        // execute statement
        $statement->bind_param('di', $amount, $id);
        $statement->execute();
        $db_connection->close();
        return ['success' => true];
    }

    /**
     * @param int $id
     * @return bool[]
     */
    public static function set_to_payed($id): array {
        $db_connection = get_db_connection();
        // prepare statements
        $query = 'UPDATE `bon`
                SET date_suppression = NOW()
                WHERE ID_bon = ?';
        $delete_receipt_statement = $db_connection->prepare($query);
        $query = 'UPDATE `commande`
                SET ID_etat_commande = 3
                WHERE ID_bon = ?';
        $update_orders_statement = $db_connection->prepare($query);
        $query = 'UPDATE `table`
                SET ID_etat_table = 3
                WHERE ID_table = (
                    SELECT ID_table FROM `bon`
                    WHERE ID_bon = ?
                )';
        $update_table_statement = $db_connection->prepare($query);
        // add a deletion date to the receipt
        $delete_receipt_statement->bind_param('i', $id);
        $delete_receipt_statement->execute();
        // set every order of the receipt to "delivered"
        $update_orders_statement->bind_param('i', $id);
        $update_orders_statement->execute();
        // set the associated table to "to clean"
        $update_table_statement->bind_param('i', $id);
        $update_table_statement->execute();
        $db_connection->close();
        return ['success' => true];
    }

    /**
     * @param int $id_table
     * @return int[]
     */
    public static function get_table_current_receipt_id_and_number($id_table): array {
        $db_connection = get_db_connection();
        // prepare statement
        $query = 'SELECT b.ID_bon, t.numero
                FROM `table` t
                JOIN `bon` b ON t.ID_table = b.ID_table
                WHERE t.ID_table = ?
                AND b.date_suppression IS NULL';
        $statement = $db_connection->prepare($query);
        // execute statement
        $statement->bind_param('i', $id_table);
        $statement->execute();
        $result_cursor = $statement->get_result();
        $row = $result_cursor->fetch_assoc();
        $result_array = [
            'id_bon' => $row['ID_bon'],
            'numero_table' => $row['numero']
        ];
        $db_connection->close();
        return $result_array;
    }
}
