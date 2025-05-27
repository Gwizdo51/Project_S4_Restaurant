<?php

class Reservation {

    private string $input_name_client;
    private ?bool $name_client_is_valid = null;
    private string $input_datetime;
    private ?bool $datetime_is_valid = null;
    private string $input_number_people;
    private ?bool $number_people_is_valid = null;
    private string $input_details;
    /**
     * table_id => table_number
     * @var int[]
     */
    private array $reserved_tables;

    public function get_input_name_client(): string {
        return $this->input_name_client;
    }
    public function get_name_client_is_valid(): ?bool {
        return $this->name_client_is_valid;
    }

    public function get_input_datetime(): string {
        return $this->input_datetime;
    }
    public function get_datetime_is_valid(): ?bool {
        return $this->datetime_is_valid;
    }

    public function get_input_number_people(): string {
        return $this->input_number_people;
    }
    public function get_number_people_is_valid(): ?bool {
        return $this->number_people_is_valid;
    }

    public function get_input_details(): string {
        return $this->input_details;
    }

    /**
     * @return int[]
     */
    public function get_reserved_tables(): array {
        return $this->reserved_tables;
    }

    public function form_is_valid(): bool {
        return $this->name_client_is_valid and $this->datetime_is_valid and $this->number_people_is_valid;
    }

    /**
     * @param string $input_name_client
     * @param string $input_datetime
     * @param string $input_number_people
     * @param string $input_details
     * @param int[] $reserved_tables
     */
    public function __construct($input_name_client = '', $input_datetime = '', $input_number_people = '', $input_details = '', $reserved_tables = []) {
        $this->input_name_client = $input_name_client;
        $this->input_datetime = $input_datetime;
        $this->input_number_people = $input_number_people;
        $this->input_details = $input_details;
        $this->reserved_tables = $reserved_tables;
    }

    /**
     * @param string[] $post_array
     * @param int[] $tables_array
     * @return self
     */
    public static function get_from_post($post_array, $tables_array): self {
        // gather the checked tables IDs and numbers in an array
        $reserved_tables = [];
        foreach (array_keys($post_array) as $key) {
            if (is_int($key)) {
                $table_id = (int) $key;
                $reserved_tables[$table_id] = $tables_array[$table_id];
            }
        }
        $reservation = new self(
            $post_array['name'],
            $post_array['datetime'],
            $post_array['number_people'],
            $post_array['details'],
            $reserved_tables
        );
        $reservation->validate_form();
        return $reservation;
    }

    private function validate_form(): void {
        // sanitize the user input
        $this->input_name_client = sanitize_input($this->input_name_client);
        $this->input_datetime = sanitize_input($this->input_datetime);
        $this->input_number_people = sanitize_input($this->input_number_people);
        $this->input_details = sanitize_input($this->input_details);
        $this->name_client_is_valid = strlen($this->input_name_client) !== 0;
        // try-except to catch malformed dates
        try {
            $datetime = new DateTimeImmutable($this->input_datetime);
            $now = new DateTimeImmutable("now");
            $today_midnight = $now->setTime(0, 0, 0);
            // the datetime input is valid if it is greater than today at midnight
            $this->datetime_is_valid = !((bool) $today_midnight->diff($datetime)->invert);
        }
        catch (Exception $e) {
            $this->datetime_is_valid = false;
        }
        $this->number_people_is_valid = preg_match('~^(\d+)$~u', $this->input_number_people);
    }

    public function save_to_db(): int {
        $db_connection = get_db_connection();
        // prepare statements
        $query = 'INSERT INTO `reservation` (nom_client, date, nombre_personnes, notes) VALUES
                (?, ?, ?, ?)';
        $insert_reservation_statement = $db_connection->prepare($query);
        $query = 'INSERT INTO `reserver` (ID_reservation, ID_table) VALUES
                (?, ?)';
        $insert_table_reservation_statement = $db_connection->prepare($query);
        // insert the reservation
        $datetime = (new DateTimeImmutable($this->input_datetime))->format('Y-m-d H:i:s');
        $number_people = (int) $this->input_number_people;
        $insert_reservation_statement->bind_param('ssis', $this->input_name_client, $datetime, $number_people, $this->input_details);
        $insert_reservation_statement->execute();
        // get the last inserted row id
        $id_query = 'SELECT LAST_INSERT_ID() id';
        $result_cursor = $db_connection->query($id_query);
        $row = $result_cursor->fetch_assoc();
        $reservation_id = (int) $row['id'];
        // insert the reserved tables
        foreach (array_keys($this->reserved_tables) as $table_id) {
            $insert_table_reservation_statement->bind_param('ii', $reservation_id, $table_id);
            $insert_table_reservation_statement->execute();
        }
        $db_connection->close();
        return $reservation_id;
    }

    /**
     * @param int $id
     * @return Reservation
     */
    public static function get_from_db($id): Reservation {
        $db_connection = get_db_connection();
        // prepare and run statement
        $query = 'SELECT r1.nom_client, r1.date, r1.nombre_personnes, r1.notes, t.ID_table, t.numero numero_table
                FROM `reservation` r1
                LEFT JOIN `reserver` r2 ON r2.ID_reservation = r1.ID_reservation
                LEFT JOIN `table` t ON t.ID_table = r2.ID_table
                WHERE r1.ID_reservation = ?
                ORDER BY t.numero';
        $statement = $db_connection->prepare($query);
        $statement->bind_param('i', $id);
        $statement->execute();
        $result_cursor = $statement->get_result();
        $reservation = null;
        while ($row = $result_cursor->fetch_assoc()) {
            if ($reservation === null) {
                // "2025-05-10T19:22"
                $reservation = new self(
                    $row['nom_client'],
                    (new DateTimeImmutable($row['date']))->format('Y-m-d\TH:i'),
                    $row['nombre_personnes'],
                    $row['notes']
                );
                if ($row['ID_table'] !== null) {
                    $reservation->reserved_tables[$row['ID_table']] = $row['numero_table'];
                }
            }
            else {
                $reservation->reserved_tables[$row['ID_table']] = $row['numero_table'];
            }
        }
        $db_connection->close();
        return $reservation;
    }

    /**
     * @param int $id
     * @return void
     */
    public function update_in_db($id): void {
        // get the original reservation from the database
        $saved_reservation = self::get_from_db($id);
        $db_connection = get_db_connection();
        // prepare statements
        $query = 'UPDATE `reservation`
                SET nom_client = ?, date = ?, nombre_personnes = ?, notes = ?
                WHERE ID_reservation = ?';
        $update_reservation_statement = $db_connection->prepare($query);
        $query = 'DELETE FROM `reserver`
                WHERE ID_reservation = ? AND ID_table = ?';
        $delete_table_reservation_statement = $db_connection->prepare($query);
        $query = 'INSERT INTO `reserver` (ID_reservation, ID_table) VALUES
                (?, ?)';
        $create_table_reservation_statement = $db_connection->prepare($query);
        // update the basic info
        $datetime = (new DateTimeImmutable($this->input_datetime))->format('Y-m-d H:i:s');
        $number_people = (int) $this->input_number_people;
        $update_reservation_statement->bind_param('ssisi', $this->input_name_client, $datetime, $number_people, $this->input_details, $id);
        $update_reservation_statement->execute();
        // update the reserved tables
        // remove all tables that are not reserved anymore
        foreach (array_keys($saved_reservation->reserved_tables) as $old_table_id) {
            if (!in_array($old_table_id, array_keys($this->reserved_tables))) {
                $delete_table_reservation_statement->bind_param('ii', $id, $old_table_id);
                $delete_table_reservation_statement->execute();
            }
        }
        // add all tables that were not reserved before
        foreach (array_keys($this->reserved_tables) as $new_table_id) {
            if (!in_array($new_table_id, array_keys($saved_reservation->reserved_tables))) {
                $create_table_reservation_statement->bind_param('ii', $id, $new_table_id);
                $create_table_reservation_statement->execute();
            }
        }
        $db_connection->close();
    }

    /**
     * Returns the JSON-like array of reservations for today and in the future
     * @return array
     */
    public static function get_all_incoming_reservations_json(): array {
        $db_connection = get_db_connection();
        $query = "SELECT r1.ID_reservation, r1.nom_client, r1.date, (CAST(r1.date AS DATE) = CAST(NOW() AS DATE)) for_today, r1.nombre_personnes, t.numero numero_table
                FROM `reservation` r1
                LEFT JOIN `reserver` r2 ON r1.ID_reservation = r2.ID_reservation
                LEFT JOIN `table` t ON t.ID_table = r2.ID_table
                WHERE CAST(r1.date AS DATE) >= CAST(NOW() AS DATE)
                AND r1.date_suppression IS NULL
                ORDER BY r1.date";
        $result_cursor = $db_connection->query($query);
        $reservations_array = [];
        while ($row = $result_cursor->fetch_assoc()) {
            $reservation_id = (int) $row['ID_reservation'];
            // if the reservation already exists in the array, add the table number to it
            if (array_key_exists($reservation_id, $reservations_array)) {
                $reservations_array[$reservation_id]['tables'][] = (int) $row['numero_table'];
            }
            // otherwise, add the reservation to the array
            else {
                $reservations_array[$reservation_id] = [
                    'nom_client' => $row['nom_client'],
                    'date' => $row['date'],
                    'for_today' => (int) $row['for_today'] === 1,
                    'nombre_personnes' => $row['nombre_personnes'],
                    'tables' => []
                ];
                if ($row['numero_table'] !== null) {
                    $reservations_array[$reservation_id]['tables'][] = (int) $row['numero_table'];
                }
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
        // prepare and run statement
        $query = 'UPDATE `reservation`
                SET date_suppression = NOW()
                WHERE ID_reservation = ?';
        $statement = $db_connection->prepare($query);
        $statement->bind_param('i', $id);
        $statement->execute();
        return ['success' => true];
    }
}
