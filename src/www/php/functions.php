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
 * @brief Fonction qui insère un utilisateur dans la base de données
 *
 * @param User $user Utilisateur du site
 * @return bool Vrai si l'insertion à été faite, une erreur est affichée sinon
 */
function createUser($user)
{
    try {
        $user->Password = hash('sha256', $user->Password);
        $db = Database::getInstance();
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
function login($userMail, $userPwd)
{
    try {
        $db = Database::getInstance();
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
 * @brief Fonction qui modifie la photo de profil d'un utilisateur dans la base de données
 *
 * @param User $user L'utilisateur connecté
 * @param $_FILES[] $userfile L'image récupéré
 * @return bool Vrai si la modification a fonctionné, faux sinon
 */
function changeProfilePicture($user, $userfile)
{
    try {
        $data = file_get_contents($userfile['tmp_name']);
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($userfile['tmp_name']);
        $src = 'data:' . $mime . ';base64,' . base64_encode($data);

        $db = Database::getInstance();
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
function getUserByEmail($userMail)
{
    try {
        $db = Database::getInstance();
        $sql = 'SELECT email, name, firstName, password, profile_picture, verified, roles_id FROM users WHERE email LIKE :email';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $userMail, PDO::PARAM_STR);
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            return new User($row['email'], $row['name'], $row['firstName'], $row['password'], $row['profile_picture'], $row['verified'], $row['roles_id']);
        }
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
        return null;
    }
}

/**
 * @brief Fonction qui confirme l'adresse mail de l'utilisateur
 *
 * @param string $userMail Le mail de l'utilisateur recherché
 * @return bool Vrai si la modification à été faite, une erreur est affichée sinon
 */
function confirmMail($userMail)
{
    try {
        $db = Database::getInstance();
        $sql = 'UPDATE users SET verified = 1 WHERE email LIKE :email';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $userMail, PDO::PARAM_STR);
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
function sendMail($subject, $setTo, $body)
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
 * @param string $setTo Adresse mail du destinataire
 * @param string $link Le lien vers la page qui confirmera le compte de l'utilisateur
 * @return bool Vrai si le mail est envoyé, faux sinon
 */
function sendConfirmationMail($setTo, $link)
{
    $subject = "Confirmation de votre adresse mail";
    $message =
        '<html>' .
        ' <head></head>' .
        ' <body>' .
        '  <a href="' . $link . '">Pour confirmer votre compte, cliquez-ici.</a>' .
        ' </body>' .
        '</html>';

    return sendMail($subject, $setTo, $message);
}

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
