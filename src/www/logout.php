<?php
/**
 * Nom du projet  : ETPI
 * Nom du fichier : logout.php
 * Auteur         : Diogo Canas Almeida
 * Date           : 20 mai 2020
 * Description    : Fichier de déconnexion
 * Version        : 1.0
 */
session_start();
$_SESSION['logged'] = false;
header('Location: index.php');
?>