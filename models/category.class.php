<?php

class Category {

    /**
     * Returns the list of categories from the database
     * @return string[]
     */
    public static function get_all_categories_json(): array {
        $db_connection = get_db_connection();
        $query = "SELECT c.ID_categorie, c.label_categorie
                FROM `categorie` c
                WHERE c.date_suppression IS NULL";
        $result_cursor = $db_connection->query($query);
        $categories_array = [];
        while ($row = $result_cursor->fetch_assoc()) {
            $categories_array[(int) $row['ID_categorie']] = $row['label_categorie'];
        }
        $db_connection->close();
        return $categories_array;
    }

    /**
     * Returns the json containing all the products of the category
     * with the specified ID
     * @param int $id_category
     * @return array
     */
    public static function get_all_category_products_json($id_category): array {
        $db_connection = get_db_connection();
        $query = "SELECT c.label_categorie, p.ID_produit, p.label_produit, p.prix
                FROM `categorie` c
                JOIN `produit` p ON c.ID_categorie = p.ID_categorie
                WHERE c.ID_categorie = {$id_category}
                AND p.date_suppression IS NULL";
        $result_cursor = $db_connection->query($query);
        $category_array = [];
        while ($row = $result_cursor->fetch_assoc()) {
            $category_label = $row['label_categorie'];
            // if the category is in $category_array, add the product to it
            if (array_key_exists($category_label, $category_array)) {
                $category_array[$category_label][] = [
                        'id' => $row['ID_produit'],
                        'label' => $row['label_produit'],
                        'prix' => $row['prix']
                ];
            }
            // otherwise, add the category to the array
            else {
                $category_array[$category_label] = [
                    [
                        'id' => $row['ID_produit'],
                        'label' => $row['label_produit'],
                        'prix' => $row['prix']
                    ]
                ];
            }
        }
        $db_connection->close();
        return $category_array;
    }
}
