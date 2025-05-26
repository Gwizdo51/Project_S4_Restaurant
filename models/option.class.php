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
        $query = "SELECT o.label_option, o.ID_type_choix, c.label_choix
                FROM `option_commande` o
                LEFT JOIN `choix` c ON o.ID_option = c.ID_option
                WHERE c.date_suppression IS NULL
                AND o.ID_option = {$option_id}
                ORDER BY c.ID_choix";
        $result_cursor = $db_connection->query($query);
        $option_array = [
            'choix' => []
        ];
        while ($row = $result_cursor->fetch_assoc()) {
            // add the option label and choice type if there are not there yet
            if (!array_key_exists('label', $option_array)) {
                $option_array['label'] = $row['label_option'];
                $option_array['id_type_choix'] = (int) $row['ID_type_choix'];
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
     * @param array $json_content
     * @return array
     */
    public static function create_option($json_content): array {
        $db_connection = get_db_connection();
        // create the order option
        $insert_query = "INSERT INTO `option_commande` (label_option, ID_type_choix) VALUES
                        ('{$json_content['label']}', {$json_content['choiceTypeId']})";
        $db_connection->query($insert_query);
        // get the ID of the last inserted option
        $id_query = 'SELECT LAST_INSERT_ID() id';
        $result_cursor = $db_connection->query($id_query);
        $row = $result_cursor->fetch_assoc();
        $option_id = (int) $row['id'];
        // create all the related choices
        foreach ($json_content['choices'] as $choice_label) {
            $insert_query = "INSERT INTO `choix` (label_choix, ID_option) VALUES
                            ('{$choice_label}', {$option_id})";
            $db_connection->query($insert_query);
        }
        $db_connection->close();
        return ['success' => true];
    }

    /**
     * @param array $json_content
     * @return array
     */
    public static function update_option($json_content): array {
        $db_connection = get_db_connection();
        // update the option basic info
        $update_basic_info_query = "UPDATE `option_commande`
                                    SET label_option = '{$json_content['label']}', ID_type_choix = {$json_content['choiceTypeId']}
                                    WHERE ID_option = {$json_content['id']}";
        $db_connection->query($update_basic_info_query);
        // get the list of current choices for this option
        $query = "SELECT c.ID_choix
                FROM `choix` c
                WHERE c.date_suppression IS NULL
                AND c.ID_option = {$json_content['id']}";
        $result_cursor = $db_connection->query($query);
        $current_choices_ids = [];
        while ($row = $result_cursor->fetch_assoc()) {
            $current_choices_ids[] = (int) $row['ID_choix'];
        }
        // for each choice in $json_content, update a choice in the database, until either list empties
        while (count($current_choices_ids) > 0 and count($json_content['choices']) > 0) {
            $update_label_query = "UPDATE `choix`
                            SET label_choix = '{$json_content['choices'][0]}'
                            WHERE ID_choix = {$current_choices_ids[0]}";
            $db_connection->query($update_label_query);
            // remove the first element from both lists
            unset($current_choices_ids[0]);
            $current_choices_ids = array_values($current_choices_ids);
            unset($json_content['choices'][0]);
            $json_content['choices'] = array_values($json_content['choices']);
        }
        // delete each remaining choice in the database
        foreach ($current_choices_ids as $choice_id_to_delete) {
            $update_delete_query = "UPDATE `choix`
                            SET date_suppression = NOW()
                            WHERE ID_choix = {$choice_id_to_delete}";
            $db_connection->query($update_delete_query);
        }
        // create each remaining choice in $json_content
        foreach ($json_content['choices'] as $choice_label_to_create) {
            $insert_query = "INSERT INTO `choix` (label_choix, ID_option) VALUES
                            ('{$choice_label_to_create}', {$json_content['id']})";
            $db_connection->query($insert_query);
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
        // delete the option
        $update_query = "UPDATE `option_commande`
                        SET date_suppression = NOW()
                        WHERE ID_option = {$option_id}";
        $db_connection->query($update_query);
        $db_connection->close();
    }
}
