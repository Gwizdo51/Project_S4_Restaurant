<?php

class Reservation {

    /**
     * Returns the JSON-like array of reservations for today and in the future
     * @return array
     */
    public static function get_all_incoming_reservations_json(): array {
        $db_connection = get_db_connection();
        $query = "SELECT r1.ID_reservation, r1.nom_client, r1.date, (CAST(r1.date AS DATE) = CAST(NOW() AS DATE)) for_today, r1.nombre_personnes, t.numero numero_table
                  FROM `reservation` r1
                  JOIN `reserver` r2 ON r1.ID_reservation = r2.ID_reservation
                  JOIN `table` t ON t.ID_table = r2.ID_table
                  WHERE CAST(r1.date AS DATE) >= CAST(NOW() AS DATE)
                  AND r1.date_suppression IS NULL
                  AND t.date_suppression IS NULL
                  ORDER BY r1.date";
        $result_cursor = $db_connection->query($query);
        $reservations_array = [];
        while ($row = $result_cursor->fetch_assoc()) {
            $reservation_id = (int) $row['ID_reservation'];
            // if the reservation already exists in the array, add the table number to it
            if (array_key_exists($reservation_id, $reservations_array)) {
                $reservations_array[$reservation_id]['tables'][] = $row['numero_table'];
            }
            // otherwise, add the reservation to the array
            else {
                $reservations_array[$reservation_id] = [
                    'nom_client' => $row['nom_client'],
                    'date' => $row['date'],
                    'for_today' => (int) $row['for_today'] === 1,
                    'nombre_personnes' => $row['nombre_personnes'],
                    'tables' => [
                        $row['numero_table']
                    ]
                ];
            }
        }
        $db_connection->close();
        return $reservations_array;
    }

    /**
     * @param int $id
     * @return array
     */
    public static function cancel_reservation($id): array {
        $db_connection = get_db_connection();
        $query = "UPDATE `reservation`
                  SET date_suppression = NOW()
                  WHERE ID_reservation = {$id}";
        $result = $db_connection->query($query);
        $result_array = [
            'success' => (bool) $result
        ];
        $db_connection->close();
        return $result_array;
    }
}
