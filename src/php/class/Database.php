<?php
/**
 * Nom du projet  : ETPI
 * Nom du fichier : Database.php
 * Auteur         : Diogo Canas Almeida
 * Date           : 13 mai 2020
 * Description    : Classe de la base de données
 * Version        : 1.0
 */

 include_once '../php/inc.all.php';

 class Database {
     private static $objInstance;

     /**
      * @brief Le constructeur de la classe (privé afin que l'on ne puisse pas créer d'instances)
      */
     private function __construct() {}
     private function __clone() {}

     /**
      * @brief Méthode qui retourne une instance PDO
      *
      * @return PDO $objInstance L'instance de l'objet PDO pour la connexion à la base de données
      */
     public static function getInstance() {
         if (!self::$objInstance) {
             try {
                 $dsn = DB_TYPE . ':host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME;
                 self::$objInstance = new PDO($dsn, DB_USER, DB_PWD, array('charset'=>'utf8'));
                 self::$objInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             } catch (PDOException $e) {
                 die('Erreur : ' . $e->getMessage());
             }
         }
         return self::$objInstance;
     }
 }
?>