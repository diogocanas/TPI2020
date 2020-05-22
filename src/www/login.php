<?php

/**
 * Nom du projet  : ETPI
 * Nom du fichier : login.php
 * Auteur         : Diogo Canas Almeida
 * Date           : 13 mai 2020
 * Description    : Page de connexion
 * Version        : 1.0
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/inc/inc.all.php';
session_start();

$emailUser = filter_input(INPUT_POST, 'emailUser', FILTER_SANITIZE_STRING);
$passwordUser = filter_input(INPUT_POST, 'passwordUser', FILTER_SANITIZE_STRING);
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

  <title>Page de connexion</title>
</head>

<body>
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . 'html/navbar.php'; ?>
  <div class="container">
    <?php
    if (isset($submitButton)) {
      if ($emailUser != "" && $passwordUser != "") {
        if (UserManager::login($emailUser, $passwordUser)) {
          SessionManager::setIsLogged(true);
          SessionManager::setLoggedUser(UserManager::getUserByEmail($emailUser));
          header('Location: index.php');
        } else {
          showError("La connexion a échoué.");
        }
      } else {
        showError("Veuillez remplir tous les champs.");
      }
    }
    ?>
    <form method="POST" action="login.php">
      <div class="form-group">
        <label for="emailUser">Adresse mail</label>
        <input type="email" class="form-control" id="emailUser" name="emailUser" aria-describedby="emailHelp" autofocus>
      </div>
      <div class="form-group">
        <label for="passwordUser">Mot de passe</label>
        <input type="password" class="form-control" id="passwordUser" name="passwordUser">
      </div>
      <button type="submit" class="btn btn-primary" name="submitButton">Se connecter</button>
      <small id="emailHelp" class="form-text text-muted"><a href="register.php">Vous n'avez pas de compte? Inscrivez-vous ici!</a></small>
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