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
}
