<?php

class Table {
    /**
     * Returns the total number of tables in the restaurant
     * @return int
     */
    public static function get_total_number_of_tables(): int {
        $db_connection = get_db_connection();
        $query = "SELECT COUNT(*) nombre_tables FROM `table` t
                  WHERE t.date_suppression IS NULL";
        $result_cursor = $db_connection->query($query);
        $row = $result_cursor->fetch_assoc();
        $number_of_tables = (int) $row['nombre_tables'];
        $db_connection->close();
        return $number_of_tables;
    }

    /**
     * Summary of set_state
     * @param int $id_table
     * @param int $id_state
     * @return bool[]
     */
    public static function set_state($id_table, $id_state): array {
        $db_connection = get_db_connection();
        $query = "UPDATE `table`
                SET ID_etat_table = {$id_state}
                WHERE ID_table = {$id_table}";
        $result = $db_connection->query($query);
        $result_array = ['success' => (bool) $result];
        $db_connection->close();
        return $result_array;
    }

    /**
     * @param int $new_number
     * @return void
     */
    public static function set_total_number_of_tables($new_number) {
        $db_connection = get_db_connection();
        // get the orginal number of tables from the database
        $query = "SELECT COUNT(*) nombre_tables FROM `table` t
                  WHERE t.date_suppression IS NULL";
        $result_cursor = $db_connection->query($query);
        $row = $result_cursor->fetch_assoc();
        $original_number_of_tables = (int) $row['nombre_tables'];
        // if the new number is higher ...
        if ($new_number > $original_number_of_tables) {
            // var_dump_pre('more tables');
            $insert_query = 'INSERT INTO `table` (numero, ID_etat_table) VALUES ';
            $insert_values = [];
            // for each table to add ...
            for ($i = $original_number_of_tables; $i < $new_number; $i++) {
                // compute the new table number
                $table_number = $i + 1;
                // add the values to $insert_values
                $insert_values[] = "({$table_number}, 1)";
            }
            $insert_query .= implode(', ', $insert_values);
            $db_connection->query($insert_query);
        }
        else {
            // for each table to delete ...
            for ($i = $new_number; $i < $original_number_of_tables; $i++) {
                // compute the number of the table to delete
                $table_number = $i + 1;
                // get the ID of the table with this number
                $query = "SELECT ID_table FROM `table`
                        WHERE date_suppression IS NULL
                        AND numero = {$table_number}";
                $result_cursor = $db_connection->query($query);
                $row = $result_cursor->fetch_assoc();
                $table_id = (int) $row['ID_table'];
                // delete all entries in the `reserver` table on this table for today and in the future
                $delete_query = "DELETE FROM `reserver`
                                WHERE ID_table = {$table_id}
                                AND ID_reservation IN (
                                    SELECT r.ID_reservation
                                    FROM `reservation` r
                                    WHERE r.date_suppression IS NULL
                                    AND CAST(r.date AS DATE) >= CAST(NOW() AS DATE)
                                )";
                $db_connection->query($delete_query);
                // unassign the table from its sector and delete the table
                $update_query = "UPDATE `table`
                                SET date_suppression = NOW(), ID_secteur = NULL
                                WHERE ID_table = {$table_id}";
                $db_connection->query($update_query);
            }
        }
        $db_connection->close();
    }
}
