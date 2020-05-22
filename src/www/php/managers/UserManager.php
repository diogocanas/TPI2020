<?php

/**
 * Nom du projet  : ETPI
 * Nom du fichier : Database.php
 * Auteur         : Diogo Canas Almeida
 * Date           : 13 mai 2020
 * Description    : Classe de la base de données
 * Version        : 1.0
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/php/inc/inc.all.php';

class UserManager
{
    /**
     * @brief Fonction qui insère un utilisateur dans la base de données
     *
     * @param User $user Utilisateur du site
     * @return bool Vrai si l'insertion à été faite, une erreur est affichée sinon
     */
    public static function createUser($user)
    {
        try {
            $user->Password = hash('sha256', $user->Password);
            $db = DatabaseManager::getInstance();
            $sql = 'INSERT INTO users(email, name, firstName, password, verified, roles_id) VALUES(:email, :name, :firstName, :password, :verified, :roles_id)';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':email', $user->Email, PDO::PARAM_STR);
            $stmt->bindParam(':name', $user->Name, PDO::PARAM_STR);
            $stmt->bindParam(':firstName', $user->FirstName, PDO::PARAM_STR);
            $stmt->bindParam(':password', $user->Password, PDO::PARAM_STR);
            $stmt->bindParam(':verified', $user->Verified, PDO::PARAM_INT);
            $stmt->bindParam(':roles_id', $user->Roles_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            return false;
        }
    }

    /**
     * @brief Fonction qui vérifie les données d'un utilisateur avant son login
     *
     * @param string $userMail Adresse mail de l'utilisateur
     * @param string $userPwd Mot de passe de l'utilisateur
     * @return bool Vrai si l'utilisateur est authentifié, faux sinon
     */
    public static function login($userMail, $userPwd)
    {
        try {
            $db = DatabaseManager::getInstance();
            $sql = 'SELECT password, verified FROM users WHERE email LIKE :email';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':email', $userMail, PDO::PARAM_STR);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                if ($row['password'] == hash('sha256', $userPwd)) {
                    if ($row['verified'] == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            return false;
        }
    }

    /**
     * @brief Fonction qui indique si l'email est déjà utilisé par un autre compte
     *
     * @param string $userMail L'adresse mail de l'utilisateur
     * @return bool Faux si l'email est libre, vrai sinon
     */
    public static function exist($userMail)
    {
        try {
            $db = DatabaseManager::getInstance();
            $sql = 'SELECT COUNT(email) as nbUsers FROM users WHERE email LIKE :email';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':email', $userMail, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();
            if ($row['nbUsers'] == 0) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            return true;
        }
    }

    /**
     * @brief Fonction qui crée un token pour un utilisateur
     *
     * @param User $user L'utilisateur
     * @return bool Vrai si le token a été créé, faux sinon
     */
    public static function createToken($user) {
        try {
            $token = hash('sha256', $user->Email . date('Y-m-d H:i:s'));
            $db = DatabaseManager::getInstance();
            $sql = 'UPDATE users SET token = :token WHERE email LIKE :email';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->bindParam(':email', $user->Email, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            return false;
        }
    }

    /**
     * @brief Fonction qui modifie la photo de profil d'un utilisateur dans la base de données
     *
     * @param User $user L'utilisateur connecté
     * @param $_FILES[] $userfile L'image récupéré
     * @return bool Vrai si la modification a fonctionné, faux sinon
     */
    public static function changeProfilePicture($user, $userfile)
    {
        try {
            $data = file_get_contents($userfile['tmp_name']);
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($userfile['tmp_name']);
            $src = 'data:' . $mime . ';base64,' . base64_encode($data);

            $db = DatabaseManager::getInstance();
            $sql = 'UPDATE users SET profile_picture = :profile_picture WHERE email LIKE :email';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':profile_picture', $src);
            $stmt->bindParam(':email', $user->Email, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            return false;
        }
    }

    /**
     * @brief Fonction qui retourne un utilisateur par rapport à son adresse mail
     *
     * @param string $userMail Adresse mail d'un utilisateur
     * @return User L'utilisateur
     */
    public static function getUserByEmail($userMail)
    {
        try {
            $db = DatabaseManager::getInstance();
            $sql = 'SELECT email, name, firstName, password, token, profile_picture, verified, roles_id FROM users WHERE email LIKE :email';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':email', $userMail, PDO::PARAM_STR);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                return new User($row['email'], $row['name'], $row['firstName'], $row['password'], $row['token'], $row['profile_picture'], $row['verified'], $row['roles_id']);
            }
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            return null;
        }
    }

    /**
     * @brief Fonction qui confirme l'adresse mail de l'utilisateur
     *
     * @param string $userToken Le token de l'utilisateur recherché
     * @return bool Vrai si la modification à été faite, une erreur est affichée sinon
     */
    public static function confirmMail($userToken)
    {
        try {
            $db = DatabaseManager::getInstance();
            $sql = 'UPDATE users SET verified = 1 WHERE token LIKE :token';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':token', $userToken, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            return false;
        }
    }

    /**
     * @brief Fonction qui envoie un mail
     *
     * @param string $subject Sujet du message
     * @param string $setTo Adresse mail du destinataire
     * @param string $message Message du mail
     * @return bool Vrai si le mail est envoyé, faux sinon
     */
    static function sendMail($subject, $setTo, $body)
    {
        // On doit créer une instance de transport smtp avec les constantes
        // définies dans le fichier mailparam.php
        $transport = Swift_SmtpTransport::newInstance(EMAIL_SERVER, EMAIL_PORT, EMAIL_TRANS)
            ->setUsername(EMAIL_USERNAME)
            ->setPassword(EMAIL_PASSWORD);

        try {
            // On crée un nouvelle instance de mail en utilisant le transport créé précédemment
            $mailer = Swift_Mailer::newInstance($transport);
            // On crée un nouveau message
            $message = Swift_Message::newInstance();
            // Le sujet du message
            $message->setSubject($subject);
            // Qui envoie le message 
            $message->setFrom(array(EMAIL_USERNAME => 'Contact TPI'));
            // A qui on envoie le message
            $message->setTo(array($setTo));


            // On assigne le message et on dit de quel type. Dans notre exemple c'est du html
            $message->setBody($body, 'text/html');
            // Maintenant il suffit d'envoyer le message
            $result = $mailer->send($message);
            return true;
        } catch (Swift_TransportException $e) {
            echo "Problème d'envoi de message: " . $e->getMessage();
            return false;
        }
    }

    /**
     * @brief Fonction qui envoie un mail pour confirmer un utilisateur
     *
     * @param User $user L'utilisateur à confirmer
     * @return bool Vrai si le mail est envoyé, faux sinon
     */
    public static function sendConfirmationMail($userMail)
    {
        $user = self::getUserByEmail($userMail);
        $subject = "Confirmation de votre adresse mail";
        $message =
            '<html>' .
            ' <head></head>' .
            ' <body>' .
            '  <a href="localhost/confirmationMail.php?token=' . $user->Token . '">Pour confirmer votre compte, cliquez-ici.</a>';
            ' </body>' .
            '</html>';

        return self::sendMail($subject, $user->Email, $message);
    }
}
