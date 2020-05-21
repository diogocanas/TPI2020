<?php

/**
 * Nom du projet  : ETPI
 * Nom du fichier : Session.php
 * Auteur         : Diogo Canas Almeida
 * Date           : 21 mai 2020
 * Description    : Classe des sessions
 * Version        : 1.0
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/php/inc/inc.all.php';

class Session
{

    /**
     * @brief Le constructeur de la classe (privé afin que l'on ne puisse pas créer d'instances)
     */
    private function __construct()
    {
    }
    private function __clone()
    {
    }

    /**
     * @brief Fonction qui modifie la valeur de la variable de session 'isLogged'
     *
     * @param bool $value Vrai si l'utilisateur est connecté, faux sinon
     */
    public static function setIsLogged($value)
    {
        $_SESSION['isLogged'] = $value;
    }

    /**
     * @brief Fonction qui retourne la valeur de la variable de session 'isLogged'
     *
     * @return bool $_SESSION['isLogged'] La variable de session
     */
    public static function getIsLogged()
    {
        if (!isset($_SESSION['isLogged'])) {
            $_SESSION['isLogged'] = false;
        }
        return $_SESSION['isLogged'];
    }

    /**
     * @brief Fonction qui modifie la valeur de la variable de session 'loggedUser' 
     *
     * @param User $value Instance de la classe User
     */
    public static function setLoggedUser($value)
    {
        $_SESSION['loggedUser'] = $value;
    }

    /**
     * @brief Fonction qui retourne la valeur de la variable de session 'loggedUser'
     *
     * @return User $_SESSION['loggedUser'] La variable de session
     */
    public static function getLoggedUser()
    {
        if (!isset($_SESSION['loggedUser'])) {
            $_SESSION['loggedUser'] = "";
        }
        return $_SESSION['loggedUser'];
    }
}
