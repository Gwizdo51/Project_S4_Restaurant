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
        $result_array = ['success' => true];
        $db_connection = get_db_connection();
        // update the servers in $json_content['changed']
        foreach ($json_content['changed'] as $server_to_update) {
            $id_sector = $server_to_update['sectorId'] === 0 ? 'NULL' : $server_to_update['sectorId'];
            $server_name = sanitize_input($server_to_update['serverName']);
            $update_query = "UPDATE `serveur`
                            SET nom = '{$server_name}', ID_secteur = {$id_sector}
                            WHERE ID_serveur = {$server_to_update['serverId']}";
            $db_connection->query($update_query);
        }
        // add the servers in $json_content['new']
        if (count($json_content['new']) !== 0) {
            $insert_query = 'INSERT INTO `serveur` (nom, ID_secteur) VALUES ';
            $strings_array = [];
            foreach ($json_content['new'] as $server_to_add) {
                $id_sector = $server_to_add['sectorId'] === 0 ? 'NULL' : $server_to_add['sectorId'];
                $server_name = sanitize_input($server_to_add['serverName']);
                $strings_array[] = "('{$server_name}', {$id_sector})";
            }
            $insert_query .= implode(', ', $strings_array);
            $db_connection->query($insert_query);
        }
        // delete the servers in $json_content['toDelete']
        if (count($json_content['toDelete']) !== 0) {
            $delete_query = 'UPDATE `serveur`
                            SET date_suppression = NOW()
                            WHERE ';
            $strings_array = [];
            foreach ($json_content['toDelete'] as $id_server_to_delete) {
                $strings_array[] = "ID_serveur = {$id_server_to_delete}";
            }
            $delete_query .= implode(' OR ', $strings_array);
            $db_connection->query($delete_query);
        }
        $db_connection->close();
        return $result_array;
    }
}
