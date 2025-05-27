<?php

class Table {
    /**
     * Returns the total number of tables in the restaurant
     * @return int
     */
    public static function get_total_number_of_tables(): int {
        $db_connection = get_db_connection();
        $query = "SELECT COUNT(*) nombre_tables
                FROM `table` t
                WHERE t.date_suppression IS NULL";
        $result_cursor = $db_connection->query($query);
        $row = $result_cursor->fetch_assoc();
        $number_of_tables = (int) $row['nombre_tables'];
        $db_connection->close();
        return $number_of_tables;
    }

    /**
     * id => number
     * @return int[]
     */
    public static function get_tables_ids_and_numbers_json(): array {
        $db_connection = get_db_connection();
        $query = "SELECT t.ID_table, t.numero
                FROM `table` t
                WHERE t.date_suppression IS NULL
                ORDER BY t.numero";
        $result_cursor = $db_connection->query($query);
        $tables_array = [];
        while ($row = $result_cursor->fetch_assoc()) {
            $tables_array[(int) $row['ID_table']] = (int) $row['numero'];
        }
        $db_connection->close();
        return $tables_array;
    }

    /**
     * id => number
     * @param int $sector_id
     * @return int[]
     */
    public static function get_assignable_tables_ids_and_numbers_json($sector_id = 0): array {
        $db_connection = get_db_connection();
        // prepare and run statement
        $query = 'SELECT t.ID_table, t.numero
                FROM `table` t
                WHERE t.date_suppression IS NULL
                AND (
                    t.ID_secteur IS NULL
                    OR t.ID_secteur = ?
                )
                ORDER BY t.numero';
        $statement = $db_connection->prepare($query);
        $statement->bind_param('i', $sector_id);
        $statement->execute();
        $result_cursor = $statement->get_result();
        $tables_array = [];
        while ($row = $result_cursor->fetch_assoc()) {
            $tables_array[$row['ID_table']] = $row['numero'];
        }
        $db_connection->close();
        return $tables_array;
    }

    /**
     * Summary of set_state
     * @param int $table_id
     * @param int $state_id
     * @return bool[]
     */
    public static function set_state($table_id, $state_id): array {
        $db_connection = get_db_connection();
        // prepare and run statement
        $query = 'UPDATE `table`
                SET ID_etat_table = ?
                WHERE ID_table = ?';
        $statement = $db_connection->prepare($query);
        $statement->bind_param('ii', $state_id, $table_id);
        $statement->execute();
        $db_connection->close();
        return ['success' => true];
    }

    /**
     * @param int $new_number
     * @return void
     */
    public static function set_total_number_of_tables($new_number) {
        $db_connection = get_db_connection();
        // prepare statements
        $query = 'INSERT INTO `table` (numero, ID_etat_table) VALUES
                (?, 1)';
        $create_table_statement = $db_connection->prepare($query);
        $query = 'SELECT ID_table FROM `table`
                WHERE date_suppression IS NULL
                AND numero = ?';
        $get_id_table_statement = $db_connection->prepare($query);
        $query = 'DELETE FROM `reserver`
                WHERE ID_table = ?
                AND ID_reservation IN (
                    SELECT r.ID_reservation
                    FROM `reservation` r
                    WHERE r.date_suppression IS NULL
                    AND CAST(r.date AS DATE) >= CAST(NOW() AS DATE)
                )';
        $delete_table_reservation_statement = $db_connection->prepare($query);
        $query = 'UPDATE `table`
                SET date_suppression = NOW(), ID_secteur = NULL
                WHERE ID_table = ?';
        $delete_table_statement = $db_connection->prepare($query);
        // get the orginal number of tables from the database
        $query = "SELECT COUNT(*) nombre_tables FROM `table` t
                  WHERE t.date_suppression IS NULL";
        $result_cursor = $db_connection->query($query);
        $row = $result_cursor->fetch_assoc();
        $original_number_of_tables = (int) $row['nombre_tables'];
        // if the new number is higher ...
        if ($new_number > $original_number_of_tables) {
            for ($i = $original_number_of_tables; $i < $new_number; $i++) {
                // compute the new table number
                $table_number = $i + 1;
                // add the new table
                $create_table_statement->bind_param('i', $table_number);
                $create_table_statement->execute();
            }
        }
        else {
            // for each table to delete ...
            for ($i = $new_number; $i < $original_number_of_tables; $i++) {
                // compute the number of the table to delete
                $table_number = $i + 1;
                // get the ID of the table with this number
                $get_id_table_statement->bind_param('i', $table_number);
                $get_id_table_statement->execute();
                $result_cursor = $get_id_table_statement->get_result();
                $row = $result_cursor->fetch_assoc();
                $table_id = $row['ID_table'];
                // delete all entries in the `reserver` table on this table for today and in the future
                $delete_table_reservation_statement->bind_param('i', $table_id);
                $delete_table_reservation_statement->execute();
                // unassign the table from its sector and delete the table
                $delete_table_statement->bind_param('i', $table_id);
                $delete_table_statement->execute();
            }
        }
        $db_connection->close();
    }
}
