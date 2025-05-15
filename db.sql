-- script de création de database (mysql)
DROP DATABASE IF EXISTS esaip_s4_restaurant;
CREATE DATABASE esaip_s4_restaurant COLLATE utf8_general_ci;
USE esaip_s4_restaurant;

-- on utilise le fuseau horaire français
-- -> maintenant géré avec docker

-- tables et contraintes

CREATE TABLE `bon` (
    PRIMARY KEY (ID_bon),
    ID_bon           INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    date_creation    DATETIME NOT NULL DEFAULT NOW(),
    date_suppression DATETIME,
    remise           DECIMAL(8,2) NOT NULL DEFAULT 0,
    ID_table         INTEGER UNSIGNED NOT NULL,
    ID_serveur       INTEGER UNSIGNED NOT NULL
);

CREATE TABLE `categorie` (
    PRIMARY KEY (ID_categorie),
    ID_categorie     INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    label_categorie  VARCHAR(256),
    date_creation    DATETIME NOT NULL DEFAULT NOW(),
    date_suppression DATETIME
);

CREATE TABLE `choix` (
    PRIMARY KEY (ID_choix),
    ID_choix         INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    label_choix      VARCHAR(256) NOT NULL,
    date_creation    DATETIME NOT NULL DEFAULT NOW(),
    -- date de suppression indiquée <=> le choix est supprimé
    date_suppression DATETIME,
    ID_option        INTEGER UNSIGNED NOT NULL
);

CREATE TABLE `commande` (
    PRIMARY KEY (ID_commande),
    ID_commande         INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    date_creation       DATETIME NOT NULL DEFAULT NOW(),
    ID_bon              INTEGER UNSIGNED NOT NULL,
    ID_etat_commande    INTEGER UNSIGNED NOT NULL,
    -- le lieu de préparation est laissé à "NULL" pour les ajouts de produits sans commande
    ID_lieu_preparation INTEGER UNSIGNED NULL
);

CREATE TABLE `etat_commande` (
    PRIMARY KEY (ID_etat_commande),
    ID_etat_commande    INTEGER UNSIGNED NOT NULL,
    label_etat_commande VARCHAR(256) NOT NULL,
    -- deux états ne peuvent pas avoir le même label
    UNIQUE (label_etat_commande)
);

CREATE TABLE `etat_table` (
    PRIMARY KEY (ID_etat_table),
    ID_etat_table    INTEGER UNSIGNED NOT NULL,
    label_etat_table VARCHAR(256) NOT NULL,
    -- deux états ne peuvent pas avoir le même label
    UNIQUE (label_etat_table)
);

CREATE TABLE `horaire` (
    PRIMARY KEY (ID_horaire),
    ID_horaire    INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    date_creation DATETIME NOT NULL DEFAULT NOW()
);

CREATE TABLE `item` (
    PRIMARY KEY (ID_item),
    ID_item     INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    details     VARCHAR(1024) NOT NULL DEFAULT '',
    ID_commande INTEGER UNSIGNED NOT NULL,
    ID_produit  INTEGER UNSIGNED NOT NULL
);

CREATE TABLE `lieu_preparation` (
    PRIMARY KEY (ID_lieu_preparation),
    ID_lieu_preparation INTEGER UNSIGNED NOT NULL,
    label_lieu          VARCHAR(256) NOT NULL,
    -- deux lieux ne peuvent pas avoir le même label
    UNIQUE (label_lieu)
);

CREATE TABLE `option_commande` (
    PRIMARY KEY (ID_option),
    ID_option        INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    label_option     VARCHAR(256) NOT NULL,
    date_creation    DATETIME NOT NULL DEFAULT NOW(),
    date_suppression DATETIME,
    ID_type_choix    INTEGER UNSIGNED NOT NULL
);

CREATE TABLE `plage` (
    PRIMARY KEY (ID_plage),
    ID_plage      INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    heure_debut   TIME NOT NULL,
    heure_fin     TIME NOT NULL,
    ID_horaire    INTEGER UNSIGNED NOT NULL
);

CREATE TABLE `preciser` (
    PRIMARY KEY (ID_option, ID_produit),
    ID_option  INTEGER UNSIGNED NOT NULL,
    ID_produit INTEGER UNSIGNED NOT NULL
);

CREATE TABLE `produit` (
    PRIMARY KEY (ID_produit),
    ID_produit          INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    label_produit       VARCHAR(256) NOT NULL,
    prix                DECIMAL(8,2) NOT NULL,
    date_creation       DATETIME NOT NULL DEFAULT NOW(),
    date_suppression    DATETIME,
    ID_categorie        INTEGER UNSIGNED NOT NULL,
    ID_lieu_preparation INTEGER UNSIGNED NOT NULL
);

CREATE TABLE `reservation` (
    PRIMARY KEY (ID_reservation),
    ID_reservation   INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    nom_client       VARCHAR(256) NOT NULL,
    date             DATETIME NOT NULL,
    nombre_personnes SMALLINT UNSIGNED NOT NULL,
    notes            VARCHAR(1024) NOT NULL DEFAULT '',
    date_creation    DATETIME NOT NULL DEFAULT NOW(),
    date_suppression DATETIME
);

CREATE TABLE `reserver` (
    PRIMARY KEY (ID_reservation, ID_table),
    ID_reservation INTEGER UNSIGNED NOT NULL,
    ID_table       INTEGER UNSIGNED NOT NULL
);

CREATE TABLE `secteur` (
    PRIMARY KEY (ID_secteur),
    ID_secteur       INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    nom              VARCHAR(256) NOT NULL,
    date_creation    DATETIME NOT NULL DEFAULT NOW(),
    date_suppression DATETIME
);

CREATE TABLE `serveur` (
    PRIMARY KEY (ID_serveur),
    ID_serveur       INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    nom              VARCHAR(256),
    date_creation    DATETIME NOT NULL DEFAULT NOW(),
    date_suppression DATETIME,
    -- si le serveur n'est pas assigné à un secteur, ID_secteur = NULL
    ID_secteur       INTEGER UNSIGNED NULL
);

CREATE TABLE `table` (
    PRIMARY KEY (ID_table),
    ID_table         INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    numero           SMALLINT UNSIGNED NOT NULL,
    date_creation    DATETIME NOT NULL DEFAULT NOW(),
    date_suppression DATETIME,
    -- si la table n'est pas affectée à un secteur, ID_secteur = NULL
    ID_secteur       INTEGER UNSIGNED NULL,
    ID_etat_table    INTEGER UNSIGNED NOT NULL
);

CREATE TABLE `type_choix` (
    PRIMARY KEY (ID_type_choix),
    ID_type_choix    INTEGER UNSIGNED NOT NULL,
    label_type_choix VARCHAR(256) NOT NULL,
    -- deux types de choix ne peuvent pas avoir le même label
    UNIQUE (label_type_choix)
);

ALTER TABLE `bon` ADD FOREIGN KEY (ID_serveur) REFERENCES `serveur` (ID_serveur) ON DELETE CASCADE;
ALTER TABLE `bon` ADD FOREIGN KEY (ID_table) REFERENCES `table` (ID_table) ON DELETE CASCADE;

ALTER TABLE `choix` ADD FOREIGN KEY (ID_option) REFERENCES `option_commande` (ID_option) ON DELETE CASCADE;

ALTER TABLE `commande` ADD FOREIGN KEY (ID_lieu_preparation) REFERENCES `lieu_preparation` (ID_lieu_preparation) ON DELETE CASCADE;
ALTER TABLE `commande` ADD FOREIGN KEY (ID_etat_commande) REFERENCES `etat_commande` (ID_etat_commande) ON DELETE CASCADE;
ALTER TABLE `commande` ADD FOREIGN KEY (ID_bon) REFERENCES `bon` (ID_bon) ON DELETE CASCADE;

ALTER TABLE `item` ADD FOREIGN KEY (ID_produit) REFERENCES `produit` (ID_produit) ON DELETE CASCADE;
ALTER TABLE `item` ADD FOREIGN KEY (ID_commande) REFERENCES `commande` (ID_commande) ON DELETE CASCADE;

ALTER TABLE `option_commande` ADD FOREIGN KEY (ID_type_choix) REFERENCES `type_choix` (ID_type_choix) ON DELETE CASCADE;

ALTER TABLE `plage` ADD FOREIGN KEY (ID_horaire) REFERENCES `horaire` (ID_horaire) ON DELETE CASCADE;

ALTER TABLE `preciser` ADD FOREIGN KEY (ID_produit) REFERENCES `produit` (ID_produit) ON DELETE CASCADE;
ALTER TABLE `preciser` ADD FOREIGN KEY (ID_option) REFERENCES `option_commande` (ID_option) ON DELETE CASCADE;

ALTER TABLE `produit` ADD FOREIGN KEY (ID_lieu_preparation) REFERENCES `lieu_preparation` (ID_lieu_preparation) ON DELETE CASCADE;
ALTER TABLE `produit` ADD FOREIGN KEY (ID_categorie) REFERENCES `categorie` (ID_categorie) ON DELETE CASCADE;

ALTER TABLE `reserver` ADD FOREIGN KEY (ID_table) REFERENCES `table` (ID_table) ON DELETE CASCADE;
ALTER TABLE `reserver` ADD FOREIGN KEY (ID_reservation) REFERENCES `reservation` (ID_reservation) ON DELETE CASCADE;

ALTER TABLE `serveur` ADD FOREIGN KEY (ID_secteur) REFERENCES `secteur` (ID_secteur) ON DELETE CASCADE;

ALTER TABLE `table` ADD FOREIGN KEY (ID_etat_table) REFERENCES `etat_table` (ID_etat_table) ON DELETE CASCADE;
ALTER TABLE `table` ADD FOREIGN KEY (ID_secteur) REFERENCES `secteur` (ID_secteur) ON DELETE CASCADE;

-- insertion des données de test

-- ordre d'insertion des données :
-- horaire
-- plage
-- secteur
-- serveur
-- etat_table
-- table
-- reservation
-- reserver
-- bon
-- etat_commande
-- lieu_preparation
-- commande
-- categorie
-- produit
-- item
-- type_choix
-- option_commande
-- preciser
-- choix

INSERT INTO `horaire` (date_creation) VALUES
(DEFAULT);

INSERT INTO `plage` (heure_debut, heure_fin, ID_horaire) VALUES
("12:00:00", "15:00:00", 1),
("19:00:00", "22:30:00", 1);

INSERT INTO `secteur` (nom) VALUES
("Salle 1"),
("Salle 2"),
("Etage"),
("Terrasse");

INSERT INTO `serveur` (nom, ID_secteur) VALUES
("Johnathan", 3),
("Monique", 4),
("Ines", 1),
("Marc", 2);

INSERT INTO `etat_table` (ID_etat_table, label_etat_table) VALUES
(1, "disponible"),
(2, "occupée"),
(3, "à nettoyer");

INSERT INTO `table` (numero, ID_secteur, ID_etat_table) VALUES
(1, 1, 1),
(2, 1, 1),
(3, 1, 1),
(4, 1, 2),
(5, 1, 1),
(6, 2, 1),
(7, 2, 1),
(8, 2, 1),
(9, 2, 1),
(10, 2, 1),
(11, 3, 1),
(12, 3, 1),
(13, 3, 1),
(14, 3, 1),
(15, 3, 1),
(16, 4, 1),
(17, 4, 1),
(18, 4, 1),
(19, 4, 1),
(20, 4, 1);

INSERT INTO `reservation` (nom_client, date, nombre_personnes, notes) VALUES
("Anderson", "2025-05-11 20:15:00", 2, DEFAULT),
("Smith", "2025-05-10 08:30:00", 8, "un bébé");

INSERT INTO `reserver` (ID_reservation, ID_table) VALUES
(1, 10),
(2, 15),
(2, 16);

INSERT INTO `bon` (ID_table, ID_serveur, remise) VALUES
(4, 3, DEFAULT);

INSERT INTO `etat_commande` (ID_etat_commande, label_etat_commande) VALUES
(1, "à préparer"),
(2, "prête"),
(3, "délivrée");

INSERT INTO `lieu_preparation` (ID_lieu_preparation, label_lieu) VALUES
(1, "cuisine"),
(2, "bar");

INSERT INTO `commande` (ID_bon, ID_etat_commande, ID_lieu_preparation) VALUES
(1, 1, 1),
(1, 1, 1),
(1, 1, 1),
(1, 1, 2);

INSERT INTO `categorie` (label_categorie) VALUES
("Softs"),
("Vins"),
("Entrées"),
("Plats"),
("Desserts");

INSERT INTO `produit` (label_produit, prix, ID_categorie, ID_lieu_preparation) VALUES
("Evian", 1.50, 1, 2),
("Grenadine", 1.50, 1, 2),
("Pichet vin rouge", 7, 2, 2),
("Pichet vin blanc", 7, 2, 2),
("Salade verte", 5, 3, 1),
("Entrecôte", 9.50, 4, 1),
("Flan", 3, 5, 1);

INSERT INTO `item` (ID_commande, ID_produit, details) VALUES
(1, 7, DEFAULT),
(1, 5, DEFAULT),
(2, 6, "Cuisson : Saignant - Sauces : Mayonnaise, Ketchup"),
(2, 6, "Cuisson : A point"),
(3, 6, "Cuisson : Cuit"),
(3, 5, "Sans tomates"),
(4, 2, "Glaçons : Avec");

INSERT INTO `type_choix` (ID_type_choix, label_type_choix) VALUES
(1, "unique"),
(2, "multiple");

INSERT INTO `option_commande` (label_option, ID_type_choix) VALUES
("Cuisson", 1),
("Glaçons", 1),
("Sauces", 2);

INSERT INTO `preciser` (ID_option, ID_produit) VALUES
(1, 6),
(2, 2),
(3, 6);

INSERT INTO `choix` (label_choix, ID_option) VALUES
("Bleu", 1),
("Saignant", 1),
("A point", 1),
("Cuit", 1),
("Bien cuit", 1),
("Avec", 2),
("Sans", 2),
("Moutarde", 3),
("Blanche", 3),
("Ketchup", 3),
("Mayonnaise", 3);
