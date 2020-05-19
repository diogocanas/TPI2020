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
        $stmt->bindParam(':email', $user->Email);
        $stmt->bindParam(':name', $user->Name);
        $stmt->bindParam(':firstName', $user->FirstName);
        $stmt->bindParam(':password', $user->Password);
        $stmt->bindParam(':verified', $user->Verified);
        $stmt->bindParam(':roles_id', $user->Roles_id);
        return $stmt->execute();
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

/**
 * @brief Fonction qui confirme l'adresse mail de l'utilisateur
 *
 * @param string $userMail Le mail de l'utilisateur recherché
 * @return bool Vrai si la modification à été faite, une erreur est affichée sinon
 */
function confirmMail($userMail) {
    try {
        $db = Database::getInstance();
        $sql = 'UPDATE users SET verified = 1 WHERE email LIKE :email';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $userMail);
        return $stmt->execute();
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

/**
 * @brief Fonction qui envoie un mail pour confirmer un utilisateur
 *
 * @param string $setTo Adresse mail du destinataire
 * @param string $link Le lien vers la page qui confirmera le compte de l'utilisateur
 */
function sendConfirmationMail($setTo, $link)
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
        $message->setSubject('Confirmation de l\'adresse mail');
        // Qui envoie le message 
        $message->setFrom(array(EMAIL_USERNAME => 'Contact TPI'));
        // A qui on envoie le message
        $message->setTo(array($setTo));

        // Un petit message html
        // On peut bien évidemment avoir un message texte
        $body =
            '<html>' .
            ' <head></head>' .
            ' <body>' .
            '  <a href="' . $link . '">Pour confirmer votre compte, cliquez-ici.</a>' .
            ' </body>' .
            '</html>';
        // On assigne le message et on dit de quel type. Dans notre exemple c'est du html
        $message->setBody($body, 'text/html');
        // Maintenant il suffit d'envoyer le message
        $result = $mailer->send($message);
    } catch (Swift_TransportException $e) {
        echo "Problème d'envoi de message: " . $e->getMessage();
        exit();
    }
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
