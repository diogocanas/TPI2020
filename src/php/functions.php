<?php
/**
 * Nom du projet  : ETPI
 * Nom du fichier : functions.php
 * Auteur         : Diogo Canas Almeida
 * Date           : 13 mai 2020
 * Description    : Fichier de fonctions
 * Version        : 1.0
 */

 /**
  * @brief Fonction qui insère un utilisateur dans la base de données
  *
  * @param User $user Utilisateur du site
  * @return bool Vrai si l'insertion à été faite, une erreur est affichée sinon
  */
 function CreateUser($user)
 {
     try {
        $user->Password = hash('sha256', $user->Password);
        $db = Database::getInstance();
        $sql = 'INSERT INTO users(name, firstName, email, password, verified) VALUES(:name, :firstName, :email, :password, :verified)';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':name', $user->Name);
        $stmt->bindParam(':firstName', $user->FirstName);
        $stmt->bindParam(':email', $user->Email);
        $stmt->bindParam(':password', $user->Password);
        $stmt->bindParam(':verified', $user->Verified);
        $stmt->execute();
        return true;
     } catch (PDOException $e) {
         die('Erreur : ' . $e->getMessage());
     }
 }