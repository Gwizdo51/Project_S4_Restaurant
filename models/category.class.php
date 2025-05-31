<?php

class Category {
    /**
     * @param array $get_array
     * @return array
     */
    public static function get($get_array): array {
        if (array_key_exists('categoryId', $get_array)) {
            $result = self::get_all_category_products_json((int) $get_array['categoryId']);
        }
        else {
            $result = self::get_all_categories_json();
        }
        return $result;
    }

    /**
     * Returns the json containing all the categories
     * in the database
     * @return array
     */
    public static function get_all_categories_json(): array {
        $db_connection = get_db_connection();
        $query = "SELECT c.ID_categorie, c.label_categorie
                FROM `categorie` c
                WHERE c.date_suppression IS NULL
                ORDER BY c.ID_categorie";
        $result_cursor = $db_connection->query($query);
        $categories_array = [];
        while ($row = $result_cursor->fetch_assoc()) {
            $categories_array[(int) $row['ID_categorie']] = $row['label_categorie'];
        }
        $db_connection->close();
        return $categories_array;
    }

    /**
     * Returns the list of categories from the database
     * which contain products
     * @return string[]
     */
    public static function get_all_categories_with_products_json(): array {
        $db_connection = get_db_connection();
        $query = "SELECT c.ID_categorie, c.label_categorie
                FROM `categorie` c
                JOIN `produit` p ON c.ID_categorie = p.ID_categorie
                WHERE c.date_suppression IS NULL
                GROUP BY c.ID_categorie
                ORDER BY c.ID_categorie";
        $result_cursor = $db_connection->query($query);
        $categories_array = [];
        while ($row = $result_cursor->fetch_assoc()) {
            $categories_array[(int) $row['ID_categorie']] = $row['label_categorie'];
        }
        $db_connection->close();
        return $categories_array;
    }

    /**
     * Returns the json containing all the products of the category with the specified ID
     * @param int $id_category
     * @return array
     */
    public static function get_all_category_products_json($id_category): array {
        $db_connection = get_db_connection();
        // prepare and run statement
        $query = 'SELECT c.label_categorie, p.ID_produit, p.label_produit, p.prix, p.ID_lieu_preparation
                FROM `categorie` c
                LEFT JOIN `produit` p ON c.ID_categorie = p.ID_categorie
                WHERE c.ID_categorie = ?
                AND p.date_suppression IS NULL
                ORDER BY p.ID_produit';
        $statement = $db_connection->prepare($query);
        $statement->bind_param('i', $id_category);
        $statement->execute();
        $result_cursor = $statement->get_result();
        $category_array = [
            'produits' => []
        ];
        while ($row = $result_cursor->fetch_assoc()) {
            // add the category label if it isn't already added
            if (!array_key_exists('label', $category_array)) {
                $category_array['label'] = $row['label_categorie'];
            }
            // if the product is not null, add it to the products array
            if ($row['ID_produit'] !== null) {
                $category_array['produits'][] = [
                    'id' => $row['ID_produit'],
                    'label' => $row['label_produit'],
                    'prix' => format_price((float) $row['prix']),
                    'id_lieu_preparation' => $row['ID_lieu_preparation']
                ];
            }
        }
        $db_connection->close();
        return $category_array;
    }

    /**
     * @param array $json_content
     * @return array
     */
    public static function create($json_content): array {
        // sanitize the json
        $json_content['newCategoryLabel'] = sanitize_input($json_content['newCategoryLabel']);
        $db_connection = get_db_connection();
        // prepare statement
        $query = 'INSERT INTO `categorie` (label_categorie) VALUES
                (?)';
        $statement = $db_connection->prepare($query);
        // insert the new category
        $statement->bind_param('s', $json_content['newCategoryLabel']);
        $statement->execute();
        // get the last inserted row id
        $id_query = 'SELECT LAST_INSERT_ID() id';
        $result_cursor = $db_connection->query($id_query);
        $row = $result_cursor->fetch_assoc();
        $category_id = (int) $row['id'];
        $db_connection->close();
        return [
            'success' => true,
            'newCategoryId' => $category_id
        ];
    }

    /**
     * @param array $json_content
     * @return array
     */
    public static function update($json_content): array {
        // sanitize the json
        $json_content['newCategoryLabel'] = sanitize_input($json_content['newCategoryLabel']);
        $db_connection = get_db_connection();
        // prepare and run statement
        $query = 'UPDATE `categorie`
                SET label_categorie = ?
                WHERE ID_categorie = ?';
        $statement = $db_connection->prepare($query);
        $statement->bind_param('si', $json_content['newCategoryLabel'], $json_content['categoryId']);
        $statement->execute();
        $db_connection->close();
        return ['success' => true];
    }

    /**
     * @param array $json_content
     * @return array
     */
    public static function delete($json_content): array {
        $db_connection = get_db_connection();
        // prepare statements
        $query = 'UPDATE `categorie`
                SET date_suppression = NOW()
                WHERE ID_categorie = ?';
        $delete_category_statement = $db_connection->prepare($query);
        $query = 'UPDATE `produit`
                SET date_suppression = NOW()
                WHERE ID_categorie = ?';
        $delete_products_statement = $db_connection->prepare($query);
        // delete the specified category
        $delete_category_statement->bind_param('i', $json_content['CategoryToDeleteId']);
        $delete_category_statement->execute();
        // delete the contained products
        $delete_products_statement->bind_param('i', $json_content['CategoryToDeleteId']);
        $delete_products_statement->execute();
        $db_connection->close();
        return ['success' => true];
    }
}
