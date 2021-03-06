<?php

/**
 * Nom du projet  : ETPI
 * Nom du fichier : User.php
 * Auteur         : Diogo Canas Almeida
 * Date           : 13 mai 2020
 * Description    : Classe de l'utilisateur
 * Version        : 1.0
 */

class User
{
    /**
     * @brief Le constructeur de la classe
     * @param string $name Le nom de l'utilisateur
     * @param string $firstName Le prénom de l'utilisateur
     * @param string $email L'adresse mail de l'utilisateur
     * @param string $password Le mot de passe de l'utilisateur (hashé)
     */
    function __construct($email, $name, $firstName, $password, $token = null, $profilePicture = null, $verified = 0, $roles_id = 0)
    {
        $this->Email = $email;
        $this->Name = $name;
        $this->FirstName = $firstName;
        $this->ProfilePicture = $profilePicture;
        $this->Password = $password;
        $this->Token = $token;
        $this->Verified = $verified;
        $this->Roles_id = $roles_id;
    }
    function __clone()
    {
    }

    /**
     * @var string L'adresse mail de l'utilisateur
     */
    public $Email;

    /**
     * @var string Le nom de l'utilisateur
     */
    public $Name;

    /**
     * @var string Le prénom de l'utilisateur
     */
    public $FirstName;

    /**
     * @var string Le mot de passe de l'utilisateur (hashé)
     */
    public $Password;

    /**
     * @var string Le token de l'utilisateur
     */
    public $Token;

    /**
     * @var string La photo de profil de l'utilisateur (en base64)
     */
    public $ProfilePicture;

    /**
     * @var int 1 si l'adresse mail de l'utilisateur est vérifiée, 0 sinon
     */
    public $Verified;

    /**
     * @var int 1 si administrateur, 0 si utilisateur
     */
    public $Roles_id;
}
