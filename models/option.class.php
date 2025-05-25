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
