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

 // Containers
 require_once $_SERVER['DOCUMENT_ROOT'] . 'php/containers/User.php';

 // Managers
 require_once $_SERVER['DOCUMENT_ROOT'] . 'php/managers/DatabaseManager.php';
 require_once $_SERVER['DOCUMENT_ROOT'] . 'php/managers/SessionManager.php';
 require_once $_SERVER['DOCUMENT_ROOT'] . 'php/managers/UserManager.php';

 // Fichiers de configuration
 require_once $_SERVER['DOCUMENT_ROOT'] . 'config/conparam.php';
 require_once $_SERVER['DOCUMENT_ROOT'] . 'config/mailparam.php';
?>