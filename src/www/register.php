<?php

/**
 * Nom du projet  : ETPI
 * Nom du fichier : register.php
 * Auteur         : Diogo Canas Almeida
 * Date           : 17 mai 2020
 * Description    : Page d'inscription
 * Version        : 1.0
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/inc/inc.all.php';
session_start();

$nameUser = filter_input(INPUT_POST, 'nameUser', FILTER_SANITIZE_STRING);
$firstNameUser = filter_input(INPUT_POST, 'firstNameUser', FILTER_SANITIZE_STRING);
$emailUser = filter_input(INPUT_POST, 'emailUser', FILTER_SANITIZE_STRING);
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
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . 'html/navbar.php'; ?>
  <div class="container">
    <?php
    if (isset($submitButton)) {
      if ($nameUser != "" && $firstNameUser != "" && $emailUser != "" && $passwordUser != "" && $verifPasswordUser != "") {
        if ($passwordUser == $verifPasswordUser) {
          if (filter_var($emailUser, FILTER_VALIDATE_EMAIL)) {
            $user = new User($emailUser, $nameUser, $firstNameUser, $passwordUser);
            if (sendConfirmationMail($emailUser, "localhost/confirmationMail.php?mail=" . $emailUser)) {
              if (createUser($user)) {
    ?>
                <div class="alert alert-success mt-2" role="alert">
                  L'inscription a fonctionné! Merci de confirmer votre adresse mail avant de vous connecter.
                </div>
    <?php
              } else {
                showError("L'inscription a échoué.")
              }
            } else {
              showError("L'envoi du mail a échoué.");
            }
          } else {
            showError("Votre adresse mail n'est pas valide.");
          }
        } else {
          showError("Les mots de passes ne correspondent pas.");
        }
      } else {
        showError("Veuillez remplir tous les champs.");
      }
    }
    ?>
    <form method="POST" action="register.php" enctype="multipart/form-data">
      <div class="form-group">
        <label for="nameUser">Nom</label>
        <input type="text" class="form-control" id="nameUser" name="nameUser" autofocus required>
      </div>
      <div class="form-group">
        <label for="firstNameUser">Prénom</label>
        <input type="text" class="form-control" id="firstNameUser" name="firstNameUser" required>
      </div>
      <div class="form-group">
        <label for="emailUser">Adresse mail</label>
        <input type="email" class="form-control" id="emailUser" name="emailUser" aria-describedby="emailHelp" required>
      </div>
      <div class="form-group">
        <label for="passwordUser">Mot de passe</label>
        <input type="password" class="form-control" id="passwordUser" name="passwordUser" required>
      </div>
      <div class="form-group">
        <label for="verifPasswordUser">Vérification du mot de passe</label>
        <input type="password" class="form-control" id="verifPasswordUser" name="verifPasswordUser" required>
      </div>
      <button type="submit" class="btn btn-primary" name="submitButton">S'inscrire</button>
    </form>

  </div>
  <?php
  include_once $_SERVER['DOCUMENT_ROOT'] . 'html/footer.php';
  ?>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>