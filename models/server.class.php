<?php

class Server {
    public static function get_all_active_servers_json(): array {
        $db_connection = get_db_connection();
        $query = "SELECT ser.ID_serveur, ser.nom 'nom_serveur', sec.nom 'nom_secteur'
                FROM `serveur` ser
                LEFT JOIN `secteur` sec ON ser.ID_secteur = sec.ID_secteur
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
        // prepare and run statement
        $query = 'SELECT s.nom FROM `serveur` s
                WHERE s.ID_serveur = ?';
        $statement = $db_connection->prepare($query);
        $statement->bind_param('i', $id);
        $statement->execute();
        $result_cursor = $statement->get_result();
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
        // prepare and run statement
        $query = 'SELECT t.ID_table, t.numero, t.ID_etat_table,
                res1.ID_reservation, res1.nom_client, res1.date, res1.nombre_personnes, res1.notes,
                c.ID_commande, c.ID_lieu_preparation
                FROM `serveur` ser
                JOIN `secteur` sec ON ser.ID_secteur = sec.ID_secteur
                JOIN `table` t ON sec.ID_secteur = t.ID_secteur
                LEFT JOIN (
                    SELECT r2.* FROM `reserver` r2
                    JOIN `reservation` r1 ON r2.ID_reservation = r1.ID_reservation
                    WHERE CAST(r1.date AS DATE) = CAST(NOW() AS DATE)
                    AND r1.date_suppression IS NULL
                ) res2 ON t.ID_table = res2.ID_table
                LEFT JOIN `reservation` res1 ON res2.ID_reservation = res1.ID_reservation
                LEFT JOIN (
                    SELECT b.* FROM `bon` b
                    WHERE b.date_suppression IS NULL
                ) b ON t.ID_table = b.ID_table
                LEFT JOIN (
                    SELECT c.* FROM `commande` c
                    WHERE c.ID_etat_commande = 2
                ) c ON b.ID_bon = c.ID_bon
                WHERE t.date_suppression IS NULL
                AND ser.ID_serveur = ?
                ORDER BY t.numero, res1.date, c.ID_commande';
        $statement = $db_connection->prepare($query);
        $statement->bind_param('i', $id_server);
        $statement->execute();
        $result_cursor = $statement->get_result();
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

    public static function get_server_settings_json(): array {
        $data_array = [
            'serveurs' => [],
            'secteurs' => []
        ];
        $db_connection = get_db_connection();
        $servers_query = "SELECT ser.ID_serveur, ser.nom, sec.ID_secteur
                        FROM `serveur` ser
                        LEFT JOIN `secteur` sec ON ser.ID_secteur = sec.ID_secteur
                        WHERE ser.date_suppression IS NULL
                        ORDER BY ser.ID_serveur";
        $servers_result_cursor = $db_connection->query($servers_query);
        while ($row = $servers_result_cursor->fetch_assoc()) {
            $data_array['serveurs'][(int) $row['ID_serveur']] = [
                'nom' => $row['nom'],
                'id_secteur' => (int) $row['ID_secteur']
            ];
        }
        $sectors_query = "SELECT sec.ID_secteur, sec.nom
                        FROM `secteur` sec
                        WHERE sec.date_suppression IS NULL
                        ORDER BY sec.ID_secteur";
        $sectors_result_cursor = $db_connection->query($sectors_query);
        while ($row = $sectors_result_cursor->fetch_assoc()) {
            $data_array['secteurs'][(int) $row['ID_secteur']] = $row['nom'];
        }
        $db_connection->close();
        return $data_array;
    }

    /**
     * @param array $json_content
     * @return array
     */
    public static function update_servers($json_content): array {
        $db_connection = get_db_connection();
        // prepare statements
        $query = 'UPDATE `serveur`
                SET nom = ?, ID_secteur = ?
                WHERE ID_serveur = ?';
        $update_server_statement = $db_connection->prepare($query);
        $query = 'INSERT INTO `serveur` (nom, ID_secteur) VALUES
                (?, ?)';
        $create_server_statement = $db_connection->prepare($query);
        $query = 'UPDATE `serveur`
                SET date_suppression = NOW()
                WHERE ID_serveur = ?';
        $delete_server_statement = $db_connection->prepare($query);
        // update the servers in $json_content['changed']
        foreach ($json_content['changed'] as $server_to_update) {
            $sector_id = $server_to_update['sectorId'] === 0 ? null : $server_to_update['sectorId'];
            $server_name = sanitize_input($server_to_update['serverName']);
            $update_server_statement->bind_param('sii', $server_name, $sector_id, $server_to_update['serverId']);
            $update_server_statement->execute();
        }
        // add the servers in $json_content['new']
        foreach ($json_content['new'] as $server_to_add) {
            $sector_id = $server_to_add['sectorId'] === 0 ? null : $server_to_add['sectorId'];
            $server_name = sanitize_input($server_to_add['serverName']);
            $create_server_statement->bind_param('si', $server_name, $sector_id);
            $create_server_statement->execute();
        }
        // delete the servers in $json_content['toDelete']
        foreach ($json_content['toDelete'] as $server_to_delete_id) {
            $delete_server_statement->bind_param('i', $server_to_delete_id);
            $delete_server_statement->execute();
        }
        $db_connection->close();
        return ['success' => true];
    }
}
