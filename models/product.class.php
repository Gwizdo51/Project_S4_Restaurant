<?php

class Product {
    /**
     * @param array $get_array
     * @return array
     */
    public static function get($get_array): array {
        if (!array_key_exists('productId', $get_array)) {
            return [
                'success' => false,
                'message' => 'No "productId" in request parameters'
            ];
        }
        if (!is_numeric($get_array['productId'])) {
            return [
                'success' => false,
                'message' => '"productId" is not a integer'
            ];
        }
        $product_id = (int) $get_array['productId'];
        if (!array_key_exists('categoryId', $get_array)) {
            return [
                'success' => false,
                'message' => 'No "categoryId" in request parameters'
            ];
        }
        if (!is_numeric($get_array['categoryId'])) {
            return [
                'success' => false,
                'message' => '"categoryId" is not a integer'
            ];
        }
        $category_id = (int) $get_array['categoryId'];
        $db_connection = get_db_connection();
        // prepare statements
        $query = 'SELECT o.ID_option, o.label_option
                FROM `option_commande` o
                WHERE o.date_suppression IS NULL';
        $order_options_statement = $db_connection->prepare($query);
        $query = 'SELECT pro.label_produit, pro.prix, pro.ID_lieu_preparation, o.ID_option
                FROM `produit` pro
                LEFT JOIN `preciser` pre ON pro.ID_produit = pre.ID_produit
                LEFT JOIN `option_commande` o ON pre.ID_option = o.ID_option
                WHERE pro.ID_produit = ?
                AND o.date_suppression IS NULL';
        $product_data_statement = $db_connection->prepare($query);
        $query = 'SELECT c.label_categorie
                FROM `categorie` c
                WHERE c.ID_categorie = ?';
        $category_label_statement = $db_connection->prepare($query);
        $result_array = [
            'success' => true,
            'orderOptions' => [],
            'productData' => []
        ];
        // add the order options
        $order_options_statement->execute();
        $result_cursor = $order_options_statement->get_result();
        while ($row = $result_cursor->fetch_assoc()) {
            $result_array['orderOptions'][$row['ID_option']] = $row['label_option'];
        }
        // add the product data
        $product_data_statement->bind_param('i', $product_id);
        $product_data_statement->execute();
        $result_cursor = $product_data_statement->get_result();
        while ($row = $result_cursor->fetch_assoc()) {
            // add the product info if they're not there already
            if (!array_key_exists('label', $result_array['productData'])) {
                $result_array['productData'] = [
                    'label' => $row['label_produit'],
                    'price' => $row['prix'],
                    'preparationPlaceId' => $row['ID_lieu_preparation'],
                    'orderOptions' => []
                ];
            }
            // add the order option ID if it is not NULL
            if ($row['ID_option'] !== null) {
                $result_array['productData']['orderOptions'][] = $row['ID_option'];
            }
        }
        // add the category label
        $category_label_statement->bind_param('i', $category_id);
        $category_label_statement->execute();
        $result_cursor = $category_label_statement->get_result();
        $row = $result_cursor->fetch_assoc();
        $result_array['categoryLabel'] = $row['label_categorie'];
        $db_connection->close();
        return $result_array;
    }

    /**
     * @return array
     */
    public static function get_all_products_by_category_json(): array {
        $db_connection = get_db_connection();
        $query = "SELECT p.ID_produit, p.label_produit, c.label_categorie
                FROM `produit` p
                JOIN `categorie` c ON p.ID_categorie = c.ID_categorie
                WHERE p.date_suppression IS NULL
                ORDER BY c.date_creation, p.date_creation";
        $result_cursor = $db_connection->query($query);
        $products_array = [];
        while ($row = $result_cursor->fetch_assoc()) {
            $category_label = $row['label_categorie'];
            // if the category is in $products_array, add the product to it
            if (array_key_exists($category_label, $products_array)) {
                $products_array[$category_label][] = [
                    'id' => (int) $row['ID_produit'],
                    'label' => $row['label_produit']
                ];
            }
            // otherwise, add the category to the array
            else {
                $products_array[$category_label] = [
                    [
                        'id' => (int) $row['ID_produit'],
                        'label' => $row['label_produit']
                    ]
                ];
            }
        }
        $db_connection->close();
        return $products_array;
    }

    /**
     * @param int $id_product
     * @return array
     */
    public static function get_product_order_options_json($id_product): array {
        $db_connection = get_db_connection();
        // prepare and run statement
        $query = 'SELECT o.ID_option, o.label_option, o.ID_type_choix, c.ID_choix, c.label_choix
                FROM `produit` pro
                JOIN `preciser` pre ON pro.ID_produit = pre.ID_produit
                JOIN `option_commande` o ON pre.ID_option = o.ID_option
                JOIN `choix` c ON o.ID_option = c.ID_option
                WHERE pro.ID_produit = ?
                AND o.date_suppression IS NULL
                AND c.date_suppression IS NULL
                ORDER BY o.ID_option, c.ID_choix';
        $statement = $db_connection->prepare($query);
        $statement->bind_param('i', $id_product);
        $statement->execute();
        $result_cursor = $statement->get_result();
        $product_options_array = [];
        while ($row = $result_cursor->fetch_assoc()) {
            $option_id = $row['ID_option'];
            // the order option is in $product_options_array, add the choice to it
            if (array_key_exists($option_id, $product_options_array)) {
                $product_options_array[$option_id]['choix'][$row['ID_choix']] = $row['label_choix'];
            }
            // otherwise, add the order option to the array
            else {
                $product_options_array[$option_id] = [
                    'label' => $row['label_option'],
                    'id_type_choix' => $row['ID_type_choix'],
                    'choix' => [
                        $row['ID_choix'] => $row['label_choix']
                    ]
                ];
            }
        }
        $db_connection->close();
        return $product_options_array;
    }

    /**
     * @param int $id_product
     * @return array
     */
    public static function get_product_json($id_product): array {
        $db_connection = get_db_connection();
        // prepare and run statement
        $query = 'SELECT p.ID_produit, p.label_produit, p.ID_lieu_preparation
                FROM `produit` p
                WHERE p.ID_produit = ?';
        $statement = $db_connection->prepare($query);
        $statement->bind_param('i', $id_product);
        $statement->execute();
        $result_cursor = $statement->get_result();
        $product_array = [];
        $row = $result_cursor->fetch_assoc();
        $product_array['id_produit'] = $row['ID_produit'];
        $product_array['label'] = $row['label_produit'];
        $product_array['id_lieu_preparation'] = $row['ID_lieu_preparation'];
        $db_connection->close();
        return $product_array;
    }

    /**
     * @param array $json_content
     * @return array
     */
    public static function create($json_content): array {
        // sanitize the json
        $json_content['label'] = sanitize_input($json_content['label']);
        $db_connection = get_db_connection();
        // prepare statements
        $query = 'INSERT INTO `produit` (label_produit, prix, ID_categorie, ID_lieu_preparation) VALUES
                (?, ?, ?, ?)';
        $create_product_statement = $db_connection->prepare($query);
        $query = 'INSERT INTO `preciser` (ID_produit, ID_option) VALUES
                (?, ?)';
        $link_option_statement = $db_connection->prepare($query);
        // create a new product
        $create_product_statement->bind_param('sdii', $json_content['label'], $json_content['price'], $json_content['categoryId'], $json_content['preparationPlaceId']);
        $create_product_statement->execute();
        // get the last inserted product ID
        $id_query = 'SELECT LAST_INSERT_ID() id';
        $result_cursor = $db_connection->query($id_query);
        $row = $result_cursor->fetch_assoc();
        $product_id = (int) $row['id'];
        // add the order options selected
        foreach ($json_content['orderOptionsIds'] as $option_id) {
            $link_option_statement->bind_param('ii', $product_id, $option_id);
            $link_option_statement->execute();
        }
        $db_connection->close();
        return ['success' => true];
    }

    /**
     * @param array $json_content
     * @return array
     */
    public static function update($json_content): array {
        // sanitize the json
        $json_content['label'] = sanitize_input($json_content['label']);
        $db_connection = get_db_connection();
        // prepare statements
        $query = 'UPDATE `produit`
                SET label_produit = ?, prix = ?, ID_categorie = ?, ID_lieu_preparation = ?
                WHERE ID_produit = ?';
        $update_product_statement = $db_connection->prepare($query);
        $query = 'DELETE FROM `preciser`
                WHERE ID_produit = ?';
        $remove_option_link_statement = $db_connection->prepare($query);
        $query = 'INSERT INTO `preciser` (ID_produit, ID_option) VALUES
                (?, ?)';
        $add_option_link_statement = $db_connection->prepare($query);
        // update the product base info
        $update_product_statement->bind_param('sdiii', $json_content['label'], $json_content['price'], $json_content['categoryId'], $json_content['preparationPlaceId'], $json_content['productId']);
        $update_product_statement->execute();
        // remove all previous order options
        $remove_option_link_statement->bind_param('i', $json_content['productId']);
        $remove_option_link_statement->execute();
        //add the order options selected
        foreach ($json_content['orderOptionsIds'] as $option_id) {
            $add_option_link_statement->bind_param('ii', $json_content['productId'], $option_id);
            $add_option_link_statement->execute();
        }
        $db_connection->close();
        return ['success' => true];
    }

    /**
     * @param array $json_content
     * @return array
     */
    public static function delete($json_content): array {
        $db_connection = get_db_connection();
        // prepare and run statement
        $query = 'UPDATE `produit`
                SET date_suppression = NOW()
                WHERE ID_produit = ?';
        $statement = $db_connection->prepare($query);
        $statement->bind_param('i', $json_content['productToDeleteId']);
        $statement->execute();
        $db_connection->close();
        return ['success' => true];
    }
}
