<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 26/05/16
 * Time: 14:52
 */

namespace Ozyris\Controller;

use Ozyris\Model\UserModel;
use Ozyris\Validator\EmailValidator;
use Ozyris\Service\Users;
use Ozyris\Validator\PasswordValidator;
use Ozyris\Validator\StandardValidator;

class AuthentificationController extends AbstractController
{

    public $isAuthentified = false;

    /**
     * Connecte l'utilisateur, stocke l'objet Users en session, puis redirige sur l'accueil
     *
     * @return $this|bool
     */
    public function indexAction()
    {
        if ($_POST) {
            $sUsername = (string) htmlspecialchars(trim($_POST['username']));

            $oModelUser = new UserModel();
            $aDonneesUser = $oModelUser->getUserByUsernameOrEmail($sUsername);

            $sPassword = (string) htmlspecialchars(trim($_POST['password']));

            if (count($aDonneesUser) == 0 || !password_verify($sPassword, $aDonneesUser['password'])) {
                $this->setFlashMessage('Identifiant ou mot de passe incorrect.');

                return $this->redirect('authentification');
            }

            $oUser = new Users($aDonneesUser);

            $this->setSessionValue('user', $oUser);
            $this->isAuthentified = true;

            return $this->redirect();
        }

        return $this->render('authentification', 'index');
    }

    /**
     * Créée un nouvel utilisateur, stocke l'objet Users en session puis redirige sur l'accueil
     *
     * @return $this
     */
    public function registrationAction()
    {
        if ($_POST) {
            $aDonneesUser = array();
            $sUserEmail = (string) htmlspecialchars(trim($_POST['email']));
            $oEmailValidator = new EmailValidator();
            $bEmailIsValid = $oEmailValidator->isValid($sUserEmail);

            if (!$bEmailIsValid) {
                $this->setFlashMessage($oEmailValidator->errorMessage);

                return $this->redirect('authentification', 'registration');
            }

            $oModelUser = new UserModel();

            if ($oModelUser->ifUserAlreadyExist($sUserEmail)) {
                $this->setFlashMessage("Un compte a déjà été crée avec cette adresse email.");

                return $this->redirect('authentification', 'registration');
            }

            $this->startSession();
            $this->setSessionValue('email', $sUserEmail);

            $sUsername = (string) htmlspecialchars(trim($_POST['username']));
            $oStandarValidator = new StandardValidator();
            $bUsernameIsValid = $oStandarValidator->stringLenght($sUsername, 3, 50);

            if (!$bUsernameIsValid) {
                $this->setFlashMessage($oStandarValidator->errorMessage);

                return $this->redirect('authentification', 'registration');
            }

            if ($oModelUser->getUserByUsernameOrEmail($sUsername)) {
                $this->setFlashMessage("Ce nom d'utilisateur est déjà utilisé, veuillez en choisir un autre.");

                return $this->redirect('authentification', 'registration');
            }

            $_SESSION['username'] = $sUsername;

            $sPassword = (string) htmlspecialchars(trim($_POST['password']));
            $sConfirmPassword = (string) htmlspecialchars(trim($_POST['confirm-password']));
            $oPasswordValidator = new PasswordValidator();
            $bPasswordIsValid = $oPasswordValidator->isValid($sPassword, $sConfirmPassword);

            if (!$bPasswordIsValid) {
                $this->setFlashMessage($oPasswordValidator->errorMessage);

                return $this->redirect('authentification', 'registration');
            }

            $sHashPassword = password_hash($sPassword, PASSWORD_BCRYPT);

            $aDonneesUser['email'] = $sUserEmail;
            $aDonneesUser['username'] = $sUsername;
            $aDonneesUser['password'] = $sHashPassword;

            $oUser = new Users($aDonneesUser);
            $oModelUser->insertUserByInfosUser($oUser);

            $_SESSION['user'] = $oUser;
            $this->isAuthentified = true;
            $this->setFlashMessage('Votre compte a été crée avec succès.', false);

            return $this->redirect();
        }

        return $this->render('authentification', 'registration');
    }

    /**
     * Détruit la session puis redirige sur l'accueil
     *
     * @return $this
     */
    public function disconnectAction()
    {
        $this->destroySession();
        $this->isAuthentified = false;

        return $this->redirect();
    }

}
