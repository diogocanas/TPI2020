<?php

/**
 * Nom du projet  : ETPI
 * Nom du fichier : register.php
 * Auteur         : Diogo Canas Almeida
 * Date           : 17 mai 2020
 * Description    : Page d'inscription
 * Version        : 1.0
 */

require_once '../php/inc.all.php';

$nameUser = filter_input(INPUT_POST, 'nameUser', FILTER_SANITIZE_STRING);
$firstNameUser = filter_input(INPUT_POST, 'firstNameUser', FILTER_SANITIZE_STRING);
$emailUser = filter_input(INPUT_POST, 'emailUser', FILTER_VALIDATE_EMAIL);
$passwordUser = filter_input(INPUT_POST, 'passwordUser', FILTER_SANITIZE_STRING);
$verifPasswordUser = filter_input(INPUT_POST, 'verifPasswordUser', FILTER_SANITIZE_STRING);
$submitButton = filter_input(INPUT_POST, 'submitButton');
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <title>Page d'inscription</title>
</head>

<body>
  <?php include_once '../html/navbar.php'; ?>
  <form method="POST" action="register.php" class="p-5">
    <div class="form-group">
      <label for="nameUser">Nom</label>
      <input type="text" class="form-control" id="nameUser" name="nameUser" autofocus>
    </div>
    <div class="form-group">
      <label for="firstNameUser">Prénom</label>
      <input type="text" class="form-control" id="firstNameUser" name="firstNameUser">
    </div>
    <div class="form-group">
      <label for="emailUser">Adresse mail</label>
      <input type="email" class="form-control" id="emailUser" name="emailUser" aria-describedby="emailHelp">
    </div>
    <div class="form-group">
      <label for="passwordUser">Mot de passe</label>
      <input type="password" class="form-control" id="passwordUser" name="passwordUser">
    </div>
    <div class="form-group">
      <label for="verifPasswordUser">Vérification du mot de passe</label>
      <input type="password" class="form-control" id="verifPasswordUser" name="verifPasswordUser">
    </div>
    <button type="submit" class="btn btn-primary" name="submitButton">S'inscrire</button>
  </form>
  <?php
  if (isset($submitButton)) {
    if ($nameUser != "" && $firstNameUser != "" && $emailUser != "" && $passwordUser != "" && $verifPasswordUser != "") {
      if ($passwordUser == $verifPasswordUser) {
        $user = new User($nameUser, $firstNameUser, $emailUser, $passwordUser);
        if (CreateUser($user)) {
          header('Location: login.php');
        }
      }
    }
  }
  include_once '../html/footer.php';
  ?>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>