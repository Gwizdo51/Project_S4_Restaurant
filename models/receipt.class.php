<?php

class Receipt {
    /* Static methods
     * - get all current receipts (waiting for payment)
     */

    /**
     * Returns the JSON-like array of all current receipts
     * @return array
     */
    public static function get_all_current_receipts_json(): array {
        $db_connection = get_db_connection();
        $query = 'SELECT b.ID_bon, t.numero `numero_table`, SUM(p.prix) - b.remise `total` FROM `bon` b
                  JOIN `table` t ON b.ID_table = t.ID_table
                  JOIN `commande` c ON b.ID_bon = c.ID_bon
                  JOIN `item` i ON c.ID_commande = i.ID_commande
                  JOIN `produit` p ON i.ID_produit = p.ID_produit
                  WHERE b.date_suppression IS NULL
                  GROUP BY b.ID_bon
                  ORDER BY b.date_creation, b.ID_bon';
        $result_cursor = $db_connection->query($query);
        $receipts_array = [];
        while ($row = $result_cursor->fetch_assoc()) {
            // var_dump_pre($row);
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
        // get the total and the eventual discount of the receipt
        $query = "SELECT b.remise, SUM(p.prix) - b.remise `total` FROM `bon` b
                  JOIN `commande` c ON b.ID_bon = c.ID_bon
                  JOIN `item` i ON c.ID_commande = i.ID_commande
                  JOIN `produit` p ON i.ID_produit = p.ID_produit
                  WHERE b.ID_bon = {$id}
                  GROUP BY b.ID_bon";
        $result_cursor = $db_connection->query($query);
        $row = $result_cursor->fetch_assoc();
        $receipt_details_array = [
            'remise' => str_replace('.', ',', sprintf("%.2f", - (float) $row['remise'])),
            'total' => str_replace('.', ',', $row['total']),
            'produits' => []
        ];
        // get the list of products in the receipt
        $query = "SELECT p.label_produit, p.prix `prix_unitaire`, COUNT(p.ID_produit) `quantite`, SUM(p.prix) `total` FROM `bon` b
                  JOIN `commande` c ON b.ID_bon = c.ID_bon
                  JOIN `item` i ON c.ID_commande = i.ID_commande
                  JOIN `produit` p ON i.ID_produit = p.ID_produit
                  WHERE b.ID_bon = {$id}
                  GROUP BY p.ID_produit
                  ORDER BY p.ID_produit";
        $result_cursor = $db_connection->query($query);
        while ($row = $result_cursor->fetch_assoc()) {
            $product_array = [
                'label' => $row['label_produit'],
                'quantite' => $row['quantite'],
                'prix_unitaire' => str_replace('.', ',', $row['prix_unitaire']),
                'total' => str_replace('.', ',', $row['total'])
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
        $query = "UPDATE `bon`
                  SET remise = {$amount}
                  WHERE ID_bon = {$id}";
        $result = $db_connection->query($query);
        $result_array = [];
        $result_array['success'] = (bool) $result;
        $db_connection->close();
        return $result_array;
    }

    /**
     * @param int $id
     * @return bool[]
     */
    public static function set_to_payed($id): array {
        $db_connection = get_db_connection();
        $result_array = [
            'successQuery1' => false,
            'successQuery2' => false
        ];
        // add a deletion date to the receipt
        $query_1 = "UPDATE `bon`
                    SET date_suppression = NOW()
                    WHERE ID_bon = {$id}";
        $result_array['successQuery1'] = (bool) $db_connection->query($query_1);
        if (!$result_array['successQuery1']) {
            $db_connection->close();
            return $result_array;
        }
        // set the associated table to "to clean"
        $query_2 = "UPDATE `table`
                    SET ID_etat_table = 3
                    WHERE ID_table = (
                        SELECT ID_table FROM `bon`
                        WHERE ID_bon = {$id}
                    )";
        $result_array['successQuery2'] = (bool) $db_connection->query($query_2);
        $db_connection->close();
        return $result_array;
    }
}
