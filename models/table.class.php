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
}
