<?php

class Server {
    public static function get_all_active_servers_json(): array {
        $db_connection = get_db_connection();
        $query = "SELECT ser.ID_serveur, ser.nom 'nom_serveur', sec.nom 'nom_secteur'
                  FROM `serveur` ser
                  JOIN `secteur` sec ON ser.ID_secteur = sec.ID_secteur
                  WHERE ser.date_suppression IS NULL
                  ORDER BY ser.ID_serveur";
        $result_cursor = $db_connection->query($query);
        $servers_array = [];
        while ($row = $result_cursor->fetch_assoc()) {
            $servers_array[(int) $row['ID_serveur']] = [
                'nom' => $row['nom_serveur'],
                'secteur' => $row['nom_secteur']
            ];
        }
        $db_connection->close();
        return $servers_array;
        // return [];
    }

    /**
     * @param int $id
     * @return string
     */
    public static function get_server_name_json($id): string {
        $db_connection = get_db_connection();
        $query = "SELECT s.nom FROM `serveur` s
                  WHERE s.ID_serveur = {$id}";
        $result_cursor = $db_connection->query($query);
        $row = $result_cursor->fetch_assoc();
        $server_name = $row['nom'];
        $db_connection->close();
        return $server_name;
    }

    /**
     * @param int $id_server
     * @return array
     */
    public static function get_server_hub_data_json($id_server): array {
        $db_connection = get_db_connection();
        $query = "SELECT t.ID_table, t.numero, t.ID_etat_table,
                res1.ID_reservation, res1.nom_client, res1.date, res1.nombre_personnes, res1.notes,
                c.ID_commande, c.ID_lieu_preparation
                FROM `serveur` ser
                JOIN `secteur` sec ON ser.ID_secteur = sec.ID_secteur
                JOIN `table` t ON sec.ID_secteur = t.ID_secteur
                LEFT JOIN (
                    SELECT r2.* FROM `reserver` r2
                    JOIN `reservation` r1 ON r2.ID_reservation = r1.ID_reservation
                    WHERE CAST(r1.date AS DATE) >= CAST(NOW() AS DATE)
                ) res2 ON t.ID_table = res2.ID_table
                LEFT JOIN `reservation` res1 ON res2.ID_reservation = res1.ID_reservation
                LEFT JOIN `bon` b ON t.ID_table = b.ID_table
                LEFT JOIN (
                    SELECT c.* FROM `commande` c
                    WHERE c.ID_etat_commande = 2
                ) c ON b.ID_bon = c.ID_bon
                WHERE t.date_suppression IS NULL
                AND res1.date_suppression IS NULL
                AND b.date_suppression IS NULL
                AND ser.ID_serveur = {$id_server}
                ORDER BY t.numero, res1.date, c.ID_commande";
        $result_cursor = $db_connection->query($query);
        $data_array = [];
        while ($row = $result_cursor->fetch_assoc()) {
            $table_id = (int) $row['ID_table'];
            if (array_key_exists($table_id, $data_array)) {
                // if there is another reservation for today on this table ...
                if ($row['ID_reservation'] !== null and !array_key_exists((int) $row['ID_reservation'], $data_array[$table_id]['reservations'])) {
                    // add the reservation to the array
                    $data_array[$table_id]['reservations'][(int) $row['ID_reservation']] = [
                        'nomClient' => $row['nom_client'],
                        'date' => $row['date'],
                        'nombrePersonnes' => $row['nombre_personnes'],
                        'notes' => $row['notes']
                    ];
                }
                // if there is another order to be delivered to this table ...
                if ($row['ID_commande'] !== null and !array_key_exists((int) $row['ID_commande'], $data_array[$table_id]['commandes'])) {
                    // add the order to the array
                    $data_array[$table_id]['commandes'][(int) $row['ID_commande']] = [
                        'id_lieu_preparation' => (int) $row['ID_lieu_preparation']
                    ];
                }
            }
            else {
                // add the table to the array
                $data_array[$table_id] = [
                    'numero' => (int) $row['numero'],
                    'etat' => (int) $row['ID_etat_table']
                ];
                // if there is a reservation for today on this table ...
                if ($row['ID_reservation'] !== null) {
                    // add the reservation to the array
                    $reservation_id = (int) $row['ID_reservation'];
                    $data_array[$table_id]['reservations'] = [
                        $reservation_id => [
                            'nomClient' => $row['nom_client'],
                            'date' => $row['date'],
                            'nombrePersonnes' => $row['nombre_personnes'],
                            'notes' => $row['notes']
                        ]
                    ];
                }
                // if there is a order to be delivered to this table ...
                if ($row['ID_commande'] !== null) {
                    // add the order to the array
                    $order_id = (int) $row['ID_commande'];
                    $data_array[$table_id]['commandes'] = [
                        $order_id => [
                            'id_lieu_preparation' => (int) $row['ID_lieu_preparation']
                        ]
                    ];
                }
            }
        }
        // reset the indices of the reservations array for each table to keep the ordering by date of reservation
        foreach ($data_array as $table_id => $table_array) {
            if (array_key_exists('reservations', $table_array)) {
                // $table_array['reservations'] = array_values($table_array['reservations']);
                $data_array[$table_id]['reservations'] = array_values($table_array['reservations']);
            }
        }
        $db_connection->close();
        return $data_array;
        // return [];
    }
}
