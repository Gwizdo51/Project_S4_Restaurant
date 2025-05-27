<?php

class Category {

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
        $query = 'SELECT c.label_categorie, p.ID_produit, p.label_produit, p.prix
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
                    'prix' => $row['prix']
                ];
            }
        }
        $db_connection->close();
        return $category_array;
    }
}
