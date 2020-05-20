<?php
/**
 * Nom du projet  : ETPI
 * Nom du fichier : confirmationMail.php
 * Auteur         : Diogo Canas Almeida
 * Date           : 20 mai 2020
 * Description    : Fichier de confirmation de mail
 * Version        : 1.0
 */

require_once $_SERVER['DOCUMENT_ROOT'] . 'php/inc/inc.all.php';

if (isset($_GET['mail'])) {
    $userMail = $_GET['mail'];
}
if (confirmMail($userMail)) {
    header('Location: login.php');
}
?>