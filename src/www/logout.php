<?php
/**
 * Nom du projet  : ETPI
 * Nom du fichier : logout.php
 * Auteur         : Diogo Canas Almeida
 * Date           : 20 mai 2020
 * Description    : Fichier de déconnexion
 * Version        : 1.0
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/inc/inc.all.php';
session_start();
Session::setIsLogged(false);
header('Location: index.php');
?>