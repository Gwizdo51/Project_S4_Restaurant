<?php

class Server {
    public static function get_all_active_servers_json(): array {
        $db_connection = get_db_connection();
        $query = "SELECT ser.ID_serveur, ser.nom 'nom_serveur', sec.nom 'nom_secteur'
                  FROM `serveur` ser
                  JOIN `secteur` sec ON ser.ID_secteur = sec.ID_secteur
                  WHERE ser.date_suppression IS NULL
                  ORDER BY ser.ID_serveur";
        $result_cursor = $db_connection->query($query);
        $servers_array = [];
        while ($row = $result_cursor->fetch_assoc()) {
            $servers_array[(int) $row['ID_serveur']] = [
                'nom' => $row['nom_serveur'],
                'secteur' => $row['nom_secteur']
            ];
        }
        $db_connection->close();
        return $servers_array;
        // return [];
    }
}
