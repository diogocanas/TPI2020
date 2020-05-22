<?php

/**
 * Nom du projet  : ETPI
 * Nom du fichier : profile.php
 * Auteur         : Diogo Canas Almeida
 * Date           : 21 mai 2020
 * Description    : Page de profil de l'utilisateur connecté
 * Version        : 1.0
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/inc/inc.all.php';
session_start();

$updateButton = filter_input(INPUT_POST, 'updateButton');
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Page de profil</title>
</head>

<body>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . 'html/navbar.php'; ?>
    <div class="container">
        <?php
        if (isset($updateButton)) {
            if (!isset($_FILES['profilePictureUser']) || !is_uploaded_file($_FILES['profilePictureUser']['tmp_name'])) {
                echo ('Problème de transfert');
                exit;
            } else {
                changeProfilePicture(Session::getLoggedUser(), $_FILES['profilePictureUser']);
                Session::setLoggedUser(getUserByEmail('diogoalmeida1709@gmail.com'));
            }
        }
        ?>
        <form method="POST" action="profile.php" enctype="multipart/form-data">
            <div class="form-group">
                <input type="hidden" name="MAX_FILE_SIZE" value="300000"/>
                <label for="profilePictureUser">Photo de profil</label>
                <input type="file" class="form-control-file" id="profilePictureUser" name="profilePictureUser">
            </div>
            <button type="submit" class="btn btn-primary" name="updateButton">Modifier</button>
        </form>
    </div>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . 'html/footer.php'; ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>