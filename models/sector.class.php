<?php

class Sector {

    private string $input_name_sector;
    private ?bool $name_sector_is_valid = null;
    /**
     * table_id => table_number
     * @var int[]
     */
    private array $assigned_tables;

    public function get_input_name_sector(): string {
        return $this->input_name_sector;
    }
    public function get_name_sector_is_valid(): ?bool {
        return $this->name_sector_is_valid;
    }

    /**
     * @return int[]
     */
    public function get_assigned_tables(): array {
        return $this->assigned_tables;
    }

    public function form_is_valid(): bool {
        return $this->name_sector_is_valid;
    }

    /**
     * @param ?string $input_name_sector
     * @param int[] $assigned_tables
     */
    public function __construct($input_name_sector = null, $assigned_tables = []) {
        $this->input_name_sector = $input_name_sector ?? self::get_new_sector_name();
        $this->assigned_tables = $assigned_tables;
    }

    /**
     * Returns the next sector name (number of sectors + 1)
     * @return string
     */
    private static function get_new_sector_name(): string {
        return 'Secteur '.(self::get_sector_count() + 1);
    }

    /**
     * @param string[] $post_array
     * @param int[] $selectable_tables
     * @return self
     */
    public static function get_from_post($post_array, $selectable_tables): self {
        // gather the checked tables IDs and numbers in an array
        $tables_to_assign = [];
        foreach (array_keys($post_array) as $key) {
            if (is_int($key)) {
                $table_id = (int) $key;
                $tables_to_assign[$table_id] = $selectable_tables[$table_id];
            }
        }
        $sector = new self(
            $post_array['name'],
            $tables_to_assign
        );
        $sector->validate_form();
        return $sector;
    }

    private function validate_form(): void {
        // sanitize the user input
        $this->input_name_sector = sanitize_input($this->input_name_sector);
        $this->name_sector_is_valid = strlen($this->input_name_sector) !== 0;
    }

    public function save_to_db(): int {
        $db_connection = get_db_connection();
        // insert the sector
        $insert_query = "INSERT INTO `secteur` (nom) VALUES
                        ('{$this->input_name_sector}')";
        $db_connection->query($insert_query);
        // get the last inserted row id
        $id_query = 'SELECT LAST_INSERT_ID() id';
        $result_cursor = $db_connection->query($id_query);
        $row = $result_cursor->fetch_assoc();
        $sector_id = (int) $row['id'];
        // assign each selected table to the sector
        if (count($this->assigned_tables) !== 0) {
            $update_query = "UPDATE `table`
                            SET ID_secteur = {$sector_id}
                            WHERE ";
            $query_parts = [];
            foreach (array_keys($this->assigned_tables) as $table_id) {
                $query_parts[] = "ID_table = {$table_id}";
            }
            $update_query .= implode(' OR ', $query_parts);
            $db_connection->query($update_query);
        }
        $db_connection->close();
        return $sector_id;
    }

    /**
     * @param int $id
     * @return Sector
     */
    public static function get_from_db($sector_id): Sector {
        $db_connection = get_db_connection();
        $query = "SELECT s.nom, t.ID_table, t.numero
                FROM `secteur` s
                LEFT JOIN `table` t ON s.ID_secteur = t.ID_secteur
                WHERE s.ID_secteur = {$sector_id}
                AND t.date_suppression IS NULL
                ORDER BY t.numero";
        $result_cursor = $db_connection->query($query);
        $sector = null;
        while ($row = $result_cursor->fetch_assoc()) {
            if ($sector === null) {
                $sector = new self(
                    $row['nom'],
                );
                if ($row['ID_table'] !== null) {
                    $sector->assigned_tables[(int) $row['ID_table']] = (int) $row['numero'];
                }
            }
            else {
                $sector->assigned_tables[(int) $row['ID_table']] = (int) $row['numero'];
            }
        }
        $db_connection->close();
        return $sector;
    }

    /**
     * @param int $id
     * @return void
     */
    public function update_in_db($sector_id): void {
        // get the original sector from the database
        $saved_sector = self::get_from_db($sector_id);
        // update the sector's name
        $db_connection = get_db_connection();
        $update_query = "UPDATE `secteur`
                        SET nom = '{$this->input_name_sector}'
                        WHERE ID_secteur = {$sector_id}";
        $db_connection->query($update_query);
        // update the assigned tables
        // unassign all tables that are not assigned anymore
        foreach (array_keys($saved_sector->assigned_tables) as $old_table_id) {
            if (!in_array($old_table_id, array_keys($this->assigned_tables))) {
                // $delete_query = "DELETE FROM `reserver`
                //                 WHERE ID_reservation = {$id} AND ID_table = {$old_table_id}";
                $update_query = "UPDATE `table`
                                SET ID_secteur = NULL
                                WHERE ID_table = {$old_table_id}";
                $db_connection->query($update_query);
            }
        }
        // assign all tables that were not assigned before
        foreach (array_keys($this->assigned_tables) as $new_table_id) {
            if (!in_array($new_table_id, array_keys($saved_sector->assigned_tables))) {
                // $create_query = "INSERT INTO `reserver` (ID_reservation, ID_table) VALUES
                //                 ({$id}, {$new_table_id})";
                $update_query = "UPDATE `table`
                                SET ID_secteur = {$sector_id}
                                WHERE ID_table = {$new_table_id}";
                $db_connection->query($update_query);
            }
        }
        $db_connection->close();
    }

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

    public static function get_sector_count(): int {
        $db_connection = get_db_connection();
        $query = "SELECT COUNT(*) nombre_secteurs
                FROM `secteur` s
                WHERE s.date_suppression IS NULL";
        $result_cursor = $db_connection->query($query);
        $row = $result_cursor->fetch_assoc();
        $sector_count = (int) $row['nombre_secteurs'];
        $db_connection->close();
        return $sector_count;
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
