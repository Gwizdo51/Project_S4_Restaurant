<?php

class Sector {
    public static function get_sectors_json(): array {
        $db_connection = get_db_connection();
        $query = "SELECT s.ID_secteur, s.nom, t.numero `numero_table`
                FROM `secteur` s
                LEFT JOIN `table` t ON s.ID_secteur = t.ID_secteur
                WHERE s.date_suppression IS NULL
                ORDER BY s.ID_secteur, t.numero";
        $result_cursor = $db_connection->query($query);
        $sectors_array = [];
        while ($row = $result_cursor->fetch_assoc()) {
            $sector_id = (int) $row['ID_secteur'];
            // if the sector is already in the array ...
            if (array_key_exists($sector_id, $sectors_array)) {
                // add the table number to the sector
                $sectors_array[$sector_id]['tables'][] = (int) $row['numero_table'];
            }
            else {
                // add the sector to the array
                $tables_array = $row['numero_table'] === null ? [] : [(int) $row['numero_table']];
                $sectors_array[$sector_id] = [
                    'nom' => $row['nom'],
                    'tables' => $tables_array
                ];
            }
        }
        $db_connection->close();
        return $sectors_array;
    }

    /**
     * @param int $sector_id
     * @return void
     */
    public static function delete_sector($sector_id): void {
        $db_connection = get_db_connection();
        // unassign all tables from this sector
        $update_query = "UPDATE `table`
                        SET ID_secteur = NULL
                        WHERE ID_secteur = {$sector_id}";
        $db_connection->query($update_query);
        // unassign all servers to this sector
        $update_query = "UPDATE `serveur`
                        SET ID_secteur = NULL
                        WHERE ID_secteur = {$sector_id}";
        $db_connection->query($update_query);
        // delete the sector
        $update_query = "UPDATE `secteur`
                        SET date_suppression = NOW()
                        WHERE ID_secteur = {$sector_id}";
        $db_connection->query($update_query);
        $db_connection->close();
    }
}
