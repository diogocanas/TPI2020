<?php

/**
 * Nom du projet  : ETPI
 * Nom du fichier : functions.php
 * Auteur         : Diogo Canas Almeida
 * Date           : 13 mai 2020
 * Description    : Fichier de fonctions
 * Version        : 1.0
 */

require_once $_SERVER['DOCUMENT_ROOT'] . 'php/inc/inc.all.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'swiftmailer5/lib/swift_required.php';

/**
 * @brief Fonction qui affiche une erreur
 *
 * @param string $error Intitulé de l'erreur
 */
function showError($error)
{
?>
    <div class="alert alert-danger mt-2" role="alert">
        <?= $error ?>
    </div>
<?php
}
