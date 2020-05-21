<?php
/**
 * Nom du projet  : ETPI
 * Nom du fichier : inc.all.php
 * Auteur         : Diogo Canas Almeida
 * Date           : 13 mai 2020
 * Description    : Fichier où se trouvent tout les include de fichiers
 * Version        : 1.0
 */

 // Fichier de fonctions
 require_once $_SERVER['DOCUMENT_ROOT'] . 'php/functions.php';

 // Classes
 require_once $_SERVER['DOCUMENT_ROOT'] . 'php/class/Database.php';
 require_once $_SERVER['DOCUMENT_ROOT'] . 'php/class/User.php';
 require_once $_SERVER['DOCUMENT_ROOT'] . 'php/class/Session.php';

 // Fichiers de configuration
 require_once $_SERVER['DOCUMENT_ROOT'] . 'config/conparam.php';
 require_once $_SERVER['DOCUMENT_ROOT'] . 'config/mailparam.php';
?>