<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 24/06/16
 * Time: 11:50
 */

namespace Ozyris\Controller;

use Ozyris\Model\UserModel;
use Ozyris\Service\Mailer;
use Ozyris\Validator\EmailValidator;
use Ozyris\Validator\PasswordValidator;

class PasswordController extends AbstractController
{
    /**
     * @return $this
     */
    public function indexAction()
    {
        if ($_POST) {
            $sUserEmail = (string) htmlspecialchars(trim($_POST['email']));
            $oEmailValidator = new EmailValidator();
            $bEmailIsValid = $oEmailValidator->isValid($sUserEmail);

            if (!$bEmailIsValid) {
                $this->setFlashMessage($oEmailValidator->errorMessage);

                return $this->redirect('authentification', 'forgotpassword');
            }

            $oModelUser = new UserModel();
            $aDonneesUser = $oModelUser->getUserByUsernameOrEmail($sUserEmail);

            if (!$aDonneesUser) {
                $this->setFlashMessage('Aucun compte n\'existe avec cette adresse email.');

                return $this->redirect('authentification', 'forgotpassword');
            }

            $token = base64_encode($aDonneesUser['email'] . $aDonneesUser['id'] . date('Y-m-d H:i:s'));
            $oModelUser->resetPasswordByToken($aDonneesUser['id'], $aDonneesUser['email'], $token);
            $sUrl = "http://" . $_SERVER['HTTP_HOST'] . "/resetpassword/" . $token;

            $sMessage = "Content-Type: text/html; charset=\"UTF-8\"";
            $sMessage .= "Content-Transfer-Encoding: 8bit";
            $sMessage .= "
            <html>
                <head>
                    <title>Mot de passe perdu</title>
                </head>
                <body>
                    <p>Pour réinitialiser votre mot de passe, veuillez cliquer sur le lien suivant :</p>
                    <a href='" . $sUrl . "'>Réinitialiser mon mot de passe.</a>
                    <p>Ce lien est valide jusqu'au </p>
                </body>
            </html>
            ";

            $sSujet = 'Demande de réinitialisation du mot de passe.';

            $headers  = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
            $headers .= "To: " . $aDonneesUser['username'] . ' ' . $sUserEmail  . "\r\n";
            $headers .= "From: no reply no-reply@noreply.com\r\n";

            $oMailer = new Mailer();
            $oMailer->sendMail($sUserEmail, $sSujet, $sMessage, $headers);

            $this->setFlashMessage(
                "Un lien de réinitialisation de mot de passe vous a été envoyé par mail à l'adresse $sUserEmail",
                false
            );

            return $this->redirect();
        }

        return $this->render();
    }

    public function resetpasswordAction()
    {
        // On verifie qu'un paramètre est présent dans l'url
        if (!empty($_GET['param'])) {

            $oModelUser = new UserModel();

            $token = htmlspecialchars(trim($_GET['param']));
            $aResetPassword = $oModelUser->getResetPasswordByToken($token);

            // On verifie qu'il s'agit d'un token valide
            if (empty($aResetPassword)) {
                $this->setFlashMessage("Le lien saisi n'est pas valide.");

                return $this->redirect();
            }

            // S'il s'agit bien d'un token valide, on enregistre en session l'id et l'email de l'utilisateur
            $_SESSION['reset-password'] = array(
                'email' => $aResetPassword['user_email'],
                'id' => $aResetPassword['id']
            );
        }

        // Puis on le redirige sur la page changement du mot de passe
        return $this->redirect('password', 'changepassword');
    }

    /**
     * @return $this|bool
     */
    public function changepasswordAction()
    {
        if ($_POST) {
            // On vérifie que l'utilisateur à bien la clé reset-password en session
            if (!array_key_exists('reset-password', $_SESSION)) {
                return $this->redirect();
            }

            // Appel au validateur du mot de passe
            $sPassword = (string) htmlspecialchars(trim($_POST['change-password']));
            $sConfirmPassword = (string) htmlspecialchars(trim($_POST['confirm-password']));
            $oPasswordValidator = new PasswordValidator();
            $bPasswordIsValid = $oPasswordValidator->isValid($sPassword, $sConfirmPassword);

            // Si le mot de passe n'est pas valide on redirige
            if (!$bPasswordIsValid) {
                $this->setFlashMessage($oPasswordValidator->errorMessage);

                return $this->redirect('password', 'changepassword');
            }

            // Hashage du mdp, plus modification en BDD du mdp
            $sHashPassword = password_hash($sPassword, PASSWORD_BCRYPT);
            $oModelUser = new UserModel();

            $oModelUser->updatePasswordByEmail(
                $sHashPassword,
                $_SESSION['reset-password']['email'],
                $_SESSION['reset-password']['id']
            );

            // Redirection avec message de confirmation sur l'accueil
            $this->setFlashMessage('Votre mot de passe a été modifié avec succès', false);
            $this->destroySession('reset-password');

            return $this->redirect();
        }

        return $this->render();
    }
}
