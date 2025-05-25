<?php

class Product {

    /**
     * @return array
     */
    public static function get_all_products_by_category_json(): array {
        $db_connection = get_db_connection();
        $query = "SELECT p.ID_produit, p.label_produit, c.label_categorie FROM `produit` p
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
                    'id' => $row['ID_produit'],
                    'label' => $row['label_produit']
                ];
            }
            // otherwise, add the category to the array
            else {
                $products_array[$category_label] = [
                    [
                        'id' => $row['ID_produit'],
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
        $query = "SELECT o.ID_option, o.label_option, o.ID_type_choix, c.ID_choix, c.label_choix
                  FROM `produit` pro
                  JOIN `preciser` pre ON pro.ID_produit = pre.ID_produit
                  JOIN `option_commande` o ON pre.ID_option = o.ID_option
                  JOIN `choix` c ON o.ID_option = c.ID_option
                  WHERE pro.ID_produit = {$id_product}
                  AND o.date_suppression IS NULL
                  AND c.date_suppression IS NULL
                  ORDER BY o.ID_option, c.ID_choix";
        $result_cursor = $db_connection->query($query);
        $product_options_array = [];
        while ($row = $result_cursor->fetch_assoc()) {
            $option_id = (int) $row['ID_option'];
            // the order option is in $product_options_array, add the choice to it
            if (array_key_exists($option_id, $product_options_array)) {
                $product_options_array[$option_id]['choix'][(int) $row['ID_choix']] = $row['label_choix'];
            }
            // otherwise, add the order option to the array
            else {
                $product_options_array[$option_id] = [
                    'label' => $row['label_option'],
                    'id_type_choix' => (int) $row['ID_type_choix'],
                    'choix' => [
                        (int) $row['ID_choix'] => $row['label_choix']
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
        $query = "SELECT p.ID_produit, p.label_produit, p.ID_lieu_preparation
                  FROM `produit` p
                  WHERE p.ID_produit = {$id_product}";
        $result_cursor = $db_connection->query($query);
        $product_array = [];
        $row = $result_cursor->fetch_assoc();
        $product_array['id_produit'] = $row['ID_produit'];
        $product_array['label'] = $row['label_produit'];
        $product_array['id_lieu_preparation'] = $row['ID_lieu_preparation'];
        $db_connection->close();
        return $product_array;
    }
}
