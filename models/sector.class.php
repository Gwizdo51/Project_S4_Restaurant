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
        // prepare statements
        $query = 'INSERT INTO `secteur` (nom) VALUES (?)';
        $create_sector_statement = $db_connection->prepare($query);
        $query = 'UPDATE `table`
                SET ID_secteur = ?
                WHERE ID_table = ?';
        $assign_table_statement = $db_connection->prepare($query);
        // insert the sector
        $create_sector_statement->bind_param('s', $this->input_name_sector);
        $create_sector_statement->execute();
        // get the last inserted row id
        $id_query = 'SELECT LAST_INSERT_ID() id';
        $result_cursor = $db_connection->query($id_query);
        $row = $result_cursor->fetch_assoc();
        $sector_id = (int) $row['id'];
        // assign each selected table to the sector
        foreach (array_keys($this->assigned_tables) as $table_id) {
            $assign_table_statement->bind_param('ii', $sector_id, $table_id);
            $assign_table_statement->execute();
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
        // prepare and run statement
        $query = 'SELECT s.nom, t.ID_table, t.numero
                FROM `secteur` s
                LEFT JOIN `table` t ON s.ID_secteur = t.ID_secteur
                WHERE s.ID_secteur = ?
                AND t.date_suppression IS NULL
                ORDER BY t.numero';
        $statement = $db_connection->prepare($query);
        $statement->bind_param('i', $sector_id);
        $statement->execute();
        $result_cursor = $statement->get_result();
        $sector = null;
        while ($row = $result_cursor->fetch_assoc()) {
            if ($sector === null) {
                $sector = new self(
                    $row['nom'],
                );
                if ($row['ID_table'] !== null) {
                    $sector->assigned_tables[$row['ID_table']] = $row['numero'];
                }
            }
            else {
                $sector->assigned_tables[$row['ID_table']] = $row['numero'];
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
        $db_connection = get_db_connection();
        // prepare statements
        $query = 'UPDATE `secteur`
                SET nom = ?
                WHERE ID_secteur = ?';
        $update_sector_statement = $db_connection->prepare($query);
        $query = 'UPDATE `table`
                SET ID_secteur = NULL
                WHERE ID_table = ?';
        $unassign_table_statement = $db_connection->prepare($query);
        $query = 'UPDATE `table`
                SET ID_secteur = ?
                WHERE ID_table = ?';
        $assign_table_statement = $db_connection->prepare($query);
        // update the sector's name
        $update_sector_statement->bind_param('si', $this->input_name_sector, $sector_id);
        $update_sector_statement->execute();
        // update the assigned tables
        // unassign all tables that are not assigned anymore
        foreach (array_keys($saved_sector->assigned_tables) as $old_table_id) {
            if (!in_array($old_table_id, array_keys($this->assigned_tables))) {
                $unassign_table_statement->bind_param('i', $old_table_id);
                $unassign_table_statement->execute();
            }
        }
        // assign all tables that were not assigned before
        foreach (array_keys($this->assigned_tables) as $new_table_id) {
            if (!in_array($new_table_id, array_keys($saved_sector->assigned_tables))) {
                $assign_table_statement->bind_param('ii', $sector_id, $new_table_id);
                $assign_table_statement->execute();
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
        // prepare statements
        $query = 'UPDATE `table`
                SET ID_secteur = NULL
                WHERE ID_secteur = ?';
        $unassign_tables_statement = $db_connection->prepare($query);
        $query = 'UPDATE `serveur`
                SET ID_secteur = NULL
                WHERE ID_secteur = ?';
        $unassign_servers_statement = $db_connection->prepare($query);
        $query = 'UPDATE `secteur`
                SET date_suppression = NOW()
                WHERE ID_secteur = ?';
        $delete_sector_statement = $db_connection->prepare($query);
        // unassign all tables from this sector
        $unassign_tables_statement->bind_param('i', $sector_id);
        $unassign_tables_statement->execute();
        // unassign all servers to this sector
        $unassign_servers_statement->bind_param('i', $sector_id);
        $unassign_servers_statement->execute();
        // delete the sector
        $delete_sector_statement->bind_param('i', $sector_id);
        $delete_sector_statement->execute();
        $db_connection->close();
    }
}
