<?php

class DBManager {
    // mysql connection
    private static ?mysqli $connection = null;

    private static function connect(): void {
        if (self::$connection == null) {
            self::$connection = new mysqli('mysql_container', 'root', '123456789', 'esaip_s4_restaurant');
        }
    }

    public static function disconnect(): void {
        if (self::$connection) {
            self::$connection->close();
        }
    }
    /**
     * Generates the JSON containing all the orders to be prepared in the specified place
     * @param string $place
     * @return string
     */
    public static function get_orders_json($place): string {
        self::connect();
        // request all orders from the database
        // format the result into a JSON string
    }
}
