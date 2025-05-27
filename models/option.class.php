<?php

class Option {
    public static function get_all_options_json(): array {
        $db_connection = get_db_connection();
        $query = "SELECT o.ID_option, o.label_option, o.ID_type_choix, c.label_choix
                FROM `option_commande` o
                LEFT JOIN `choix` c ON o.ID_option = c.ID_option
                WHERE o.date_suppression IS NULL
                AND c.date_suppression IS NULL
                ORDER BY o.ID_option, c.ID_choix";
        $result_cursor = $db_connection->query($query);
        $options_array = [];
        while ($row = $result_cursor->fetch_assoc()) {
            $option_id = (int) $row['ID_option'];
            // if the option is already in the array ...
            if (array_key_exists($option_id, $options_array)) {
                // add the choice to the option
                $options_array[$option_id]['choix'][] = $row['label_choix'];
            }
            else {
                // add the option to the array
                $choices_array = $row['label_choix'] === null ? [] : [$row['label_choix']];
                $options_array[$option_id] = [
                    'label' => $row['label_option'],
                    'id_type_choix' => (int) $row['ID_type_choix'],
                    'choix' => $choices_array
                ];
            }
        }
        $db_connection->close();
        return $options_array;
    }

    /**
     * @param int $option_id
     * @return array
     */
    public static function get_option_json($option_id): array {
        $db_connection = get_db_connection();
        // prepare statement
        $query = 'SELECT o.label_option, o.ID_type_choix, c.label_choix
                FROM `option_commande` o
                LEFT JOIN `choix` c ON o.ID_option = c.ID_option
                WHERE c.date_suppression IS NULL
                AND o.ID_option = ?
                ORDER BY c.ID_choix';
        $statement = $db_connection->prepare($query);
        // execute the statement
        $statement->bind_param('i', $option_id);
        $statement->execute();
        $result_cursor = $statement->get_result();
        $option_array = [
            'choix' => []
        ];
        while ($row = $result_cursor->fetch_assoc()) {
            // add the option label and choice type if there are not there yet
            if (!array_key_exists('label', $option_array)) {
                $option_array['label'] = $row['label_option'];
                $option_array['id_type_choix'] = $row['ID_type_choix'];
            }
            // if the choice is not null, add it to the choices array
            if ($row['label_choix'] !== null) {
                $option_array['choix'][] = $row['label_choix'];
            }
        }
        $db_connection->close();
        return $option_array;
    }

    /**
     * Sanitizes the JSON received from the user
     * @param array $json_content
     * @return array
     */
    private static function sanitize_json($json_content): array {
        $sanitized_json = [
            'id' => sanitize_input($json_content['id']),
            'label' => sanitize_input($json_content['label']),
            'choiceTypeId' => sanitize_input($json_content['choiceTypeId']),
            'choices' => []
        ];
        foreach ($json_content['choices'] as $choice_label_input) {
            $sanitized_json['choices'][] = sanitize_input($choice_label_input);
        }
        return $sanitized_json;
    }

    /**
     * @param array $json_content
     * @return array
     */
    public static function create_option($json_content): array {
        // sanitize the user input
        $sanitized_json = self::sanitize_json($json_content);
        $db_connection = get_db_connection();
        // prepare statements
        $insert_option_statement = $db_connection->prepare('INSERT INTO `option_commande` (label_option, ID_type_choix) VALUES (?, ?)');
        $insert_choice_statement = $db_connection->prepare('INSERT INTO `choix` (label_choix, ID_option) VALUES (?, ?)');
        // create the order option
        $insert_option_statement->bind_param('si', $sanitized_json['label'], $sanitized_json['choiceTypeId']);
        $insert_option_statement->execute();
        // get the ID of the last inserted option
        $id_query = 'SELECT LAST_INSERT_ID() id';
        $result_cursor = $db_connection->query($id_query);
        $row = $result_cursor->fetch_assoc();
        $option_id = (int) $row['id'];
        // create all the related choices
        foreach ($sanitized_json['choices'] as $choice_label) {
            $insert_choice_statement->bind_param('si', $choice_label, $option_id);
            $insert_choice_statement->execute();
        }
        $db_connection->close();
        return ['success' => true];
    }

    /**
     * @param array $json_content
     * @return array
     */
    public static function update_option($json_content): array {
        // sanitize the user input
        $sanitized_json = self::sanitize_json($json_content);
        $db_connection = get_db_connection();
        // prepare statements
        $query = 'UPDATE `option_commande`
                SET label_option = ?, ID_type_choix = ?
                WHERE ID_option = ?';
        $update_option_statement = $db_connection->prepare($query);
        $query = 'SELECT c.ID_choix
                FROM `choix` c
                WHERE c.date_suppression IS NULL
                AND c.ID_option = ?';
        $get_choices_statement = $db_connection->prepare($query);
        $query = 'UPDATE `choix`
                SET label_choix = ?
                WHERE ID_choix = ?';
        $update_choice_label_statement = $db_connection->prepare($query);
        $query = 'UPDATE `choix`
                SET date_suppression = NOW()
                WHERE ID_choix = ?';
        $delete_choice_statement = $db_connection->prepare($query);
        $query = 'INSERT INTO `choix` (label_choix, ID_option) VALUES (?, ?)';
        $insert_new_choice_statement = $db_connection->prepare($query);
        // update the option basic info
        $update_option_statement->bind_param('sii', $sanitized_json['label'], $sanitized_json['choiceTypeId'], $sanitized_json['id']);
        $update_option_statement->execute();
        // get the list of current choices for this option
        $get_choices_statement->bind_param('i', $sanitized_json['id']);
        $get_choices_statement->execute();
        $result_cursor = $get_choices_statement->get_result();
        $current_choices_ids = [];
        while ($row = $result_cursor->fetch_assoc()) {
            $current_choices_ids[] = (int) $row['ID_choix'];
        }
        // for each choice in $json_content, update a choice in the database, until either list empties
        while (count($current_choices_ids) > 0 and count($sanitized_json['choices']) > 0) {
            $update_choice_label_statement->bind_param('si', $sanitized_json['choices'][0], $current_choices_ids[0]);
            $update_choice_label_statement->execute();
            // remove the first element from both lists
            unset($current_choices_ids[0]);
            $current_choices_ids = array_values($current_choices_ids);
            unset($sanitized_json['choices'][0]);
            $sanitized_json['choices'] = array_values($sanitized_json['choices']);
        }
        // delete each remaining choice in the database
        foreach ($current_choices_ids as $choice_id_to_delete) {
            $delete_choice_statement->bind_param('i', $choice_id_to_delete);
            $delete_choice_statement->execute();
        }
        // create each remaining choice in $json_content
        foreach ($sanitized_json['choices'] as $choice_label_to_create) {
            $insert_new_choice_statement->bind_param('si', $choice_label_to_create, $sanitized_json['id']);
            $insert_new_choice_statement->execute();
        }
        $db_connection->close();
        return ['success' => true];
    }

    /**
     * @param int $option_id
     * @return void
     */
    public static function delete_option($option_id): void {
        $db_connection = get_db_connection();
        // prepare statement
        $query = 'UPDATE `option_commande`
                SET date_suppression = NOW()
                WHERE ID_option = ?';
        $statement = $db_connection->prepare($query);
        // delete the option
        $statement->bind_param('i', $option_id);
        $statement->execute();
        $db_connection->close();
    }
}
