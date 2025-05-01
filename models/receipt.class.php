<?php

class Receipt {
    /* Static methods
     * - get all current receipts (waiting for payment)
     */

    /**
     * Returns the JSON-like array of all current receipts
     * @return array
     */
    public static function get_all_current_receipts(): array {
        $db_connection = get_db_connection();
        $query = 'SELECT b.ID_bon, t.numero `numero_table`, SUM(p.prix) `total` FROM `bon` b'
               .' JOIN `table` t ON b.ID_table = t.ID_table'
               .' JOIN `commande` c ON b.ID_bon = c.ID_bon'
               .' JOIN `item` i ON c.ID_commande = i.ID_commande'
               .' JOIN `produit` p ON i.ID_produit = p.ID_produit'
               .' WHERE b.date_suppression IS NULL'
               .' GROUP BY b.ID_bon;';
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
}
