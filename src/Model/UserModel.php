<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 26/05/16
 * Time: 14:52
 */

namespace Ozyris\Model;

use Ozyris\Service\Users;

class UserModel extends AbstractModel
{

    const SQL_ERROR = "Une erreur s'est produite, veuillez réessayer ultérieurement.";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Users $aInfosUser
     * @return bool
     * @throws \Exception
     */
    public function insertUserByInfosUser(Users $aInfosUser)
    {
        $sql = "INSERT INTO users (username, email, password, admin) VALUES (:username, :email, :password, :admin)";
        $stmt = $this->bdd->prepare($sql);

        $sUsername = $aInfosUser->getUsername();
        $sEmail = $aInfosUser->getEmail();
        $sPassword = $aInfosUser->getPassword();
        $bAdmin = $aInfosUser->isAdmin();

        try {
            $stmt->bindParam(':username', $sUsername);
            $stmt->bindParam(':email', $sEmail);
            $stmt->bindParam(':password', $sPassword);
            $stmt->bindParam(':admin', $bAdmin);

            if (!$stmt->execute()) {
//                $aSqlError = $stmt->errorInfo();
                throw new \Exception(self::SQL_ERROR);
            }
        } catch(\Exception $e) {
            die($e->getMessage());
        }

        return $stmt->closeCursor();
    }

    /**
     * @param string $value
     * @return array
     */
    public function getUserByUsernameOrEmail($value)
    {
        $sql = "SELECT id, username, email, password FROM users
                WHERE username = :username OR email = :username";

        $stmt = $this->bdd->prepare($sql);
        $sValue = (string) $value;

        try {
            $stmt->bindParam(':username', $sValue);
            
            if ($stmt->execute()) {
//                $aSqlErrors = $stmt->errorInfo();
                throw new \Exception(self::SQL_ERROR);
            }

        } catch (\Exception $e) {
            die($e->getMessage());
        }

        return $stmt->fetch(\PDO::FETCH_ASSOC);// Permet de récupérer uniquement les tableaux associatifs
    }

    /**
     * @param string $value
     * @return bool
     * @throws \Exception
     */
    public function ifUserAlreadyExist($value)
    {

        $sql = "SELECT COUNT (username) FROM users WHERE username = :username OR email = :email";
        $stmt = $this->bdd->prepare($sql);

        $sValue = (string) $value;

        try {
            $stmt->bindParam(':username', $sValue);
            $stmt->bindParam(':email', $sValue);

            if (!$stmt->execute()) {
//                $aSqlError = $stmt->errorInfo();
                throw new \Exception(self::SQL_ERROR);
            }
            
            $iResult = $stmt->fetch();
            $stmt->closeCursor();
        } catch(\Exception $e) {
            die($e->getMessage());
        }

        return (!empty($iResult)) ? true : false;
    }

    /**
     * @param integer $id
     * @param string $useremail
     * @param string $token
     * @return bool
     */
    public function resetPasswordByToken($id, $useremail, $token)
    {
        $sql = "INSERT INTO reset_password (user_id, user_email, token)
                VALUES (:user_id, :user_email, :token)";
        $stmt = $this->bdd->prepare($sql);

        try {
            $stmt->bindParam(':user_id', $id);
            $stmt->bindParam(':user_email', $useremail);
            $stmt->bindParam(':token', $token);

            if (!$stmt->execute()) {
//                $aSqlErrors = $stmt->errorInfo();
                throw new \Exception(self::SQL_ERROR);
            }
            
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        return $stmt->closeCursor();
    }

    /**
     * @param string $token
     * @return array
     */
    public function getResetPasswordByToken($token)
    {
        $sql = "SELECT id, user_email FROM reset_password WHERE token = :token AND validated != 1";
        $stmt = $this->bdd->prepare($sql);

        $token = (string) $token;

        try {
            $stmt->bindParam(':token', $token);
            
            if (!$stmt->execute()) {
//                $aSqlErrors = $stmt->errorInfo();
                throw new \Exception(self::SQL_ERROR);
            }
            
            $stmt->closeCursor();
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param string $password
     * @param string $email
     * @param integer|null $id
     * @return bool
     */
    public function updatePasswordByEmail($password, $email, $id = null)
    {
        $sql = "UPDATE users SET password = :password WHERE email = :email";
        $stmt = $this->bdd->prepare($sql);

        try {
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':email', $email);

            if (!$stmt->execute()) {
//                $aSqlErrors = $stmt->errorInfo();
                throw new \Exception(self::SQL_ERROR);
            }
            
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        if (!is_null($id)) {
            return $this->updateResetPasswordById($id);
        }

        return $stmt->closeCursor();
    }

    /**
     * @param integer $id
     * @return bool
     */
    public function updateResetPasswordById($id)
    {
        $sql = "UPDATE reset_password SET date_modification = NOW(), validated = 1 WHERE id = :id AND validated != 1";
        $stmt = $this->bdd->prepare($sql);

        try {
            $stmt->bindParam(':id', $id);
            
            if (!$stmt->execute()) {
//                $aSqlErrors = $stmt->errorInfo();
                throw new \Exception(self::SQL_ERROR);
            }
            
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        return $stmt->closeCursor();
    }
}
