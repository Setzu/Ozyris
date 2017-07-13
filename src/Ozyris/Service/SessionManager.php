<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 02/06/16
 * Time: 10:14
 */

namespace Ozyris\Service;

abstract class SessionManager
{

    public $aFlashMessages = [];

    const DEFAULT_EXPIRATION_TIME = 60;
    const FLASH_MESSAGE = 'flashmessage';
    const DANGER = 'danger';
    const SUCCESS = 'success';

    public function __construct()
    {
        $this->startSession();
    }

    /**
     * Démarre la session
     *
     * @param int $expiration
     * @return $this
     */
    public function startSession($expiration = self::DEFAULT_EXPIRATION_TIME)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
            $exp = (int) $expiration;
            session_cache_expire($exp > 0 ? $exp : self::DEFAULT_EXPIRATION_TIME);
        }

        return $this;
    }

    /**
     * Enregistre $value en session
     *
     * @param mixed $values
     * @return array|mixed
     * @throws \Exception
     */
    public function setSessionValues($values)
    {
        if (!is_array($values)) {
            $_SESSION[] = $values;
        } else {
            foreach ($values as $k => $v) {
                if (!is_string($k) && !is_int($k)) {
                    throw new \Exception('La clé doit être un entier ou une chaine de caractères.');
                }
                $_SESSION[$k] = $v;
            }
        }

        return $_SESSION;
    }

    /**
     * Retourne le user stocké en session
     *
     * @return Users | null
     */
    public function getUser()
    {
        if (key_exists('user', $_SESSION) && $_SESSION['user'] instanceof Users) {
            return $_SESSION['user'];
        } else {
            return null;
        }
    }

    /**
     * Récupère toute la session
     *
     * @return array
     */
    public function getSession()
    {
        $this->startSession();

        return $_SESSION;
    }

    /**
     * Récupère une valeur de la session en passant la clé en paramètre
     *
     * @param mixed $key
     * @return null
     * @throws \Exception
     */
    public function getSessionValue($key)
    {
        if (!is_string($key) || !is_int($key)) {
            throw new \Exception('La clé doit être un entier ou une chaine de caractères.');
        }

        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        } else {
            return null;
        }
    }

    /**
     * Détruit toute la session
     */
    public function destroySession()
    {
        session_destroy();
    }

    /**
     * Détruit la clé $key en session
     *
     * @param $key
     * @return $this
     */
    public function destroySessionValue($key)
    {
        if (is_string($key) || is_int($key)) {
            if (array_key_exists($key, $_SESSION)) {
                unset($_SESSION[$key]);
            }
        }

        return $this;
    }

    /**
     * Stocke les flashmessages en session
     *
     * @param $message
     * @param bool|true $error
     * @return $this
     */
    public function setFlashMessage($message, $error = true)
    {
        if ($error) {
            $type = self::DANGER;
        } else {
            $type = self::SUCCESS;
        }

        $_SESSION[self::FLASH_MESSAGE][$type] = $message;

        return $this;
    }

    /**
     * Affiche le message selon le type, et appelle la méthode destroySession
     *
     * @return SessionManager
     */
    public function flashMessages()
    {
        if (array_key_exists(self::FLASH_MESSAGE, $_SESSION)) {
            echo '<ul>';
            foreach ($_SESSION[self::FLASH_MESSAGE] as $type => $message) {
                echo "<div class='flashmessage alert alert-$type'><li>$message</li></div>";
            }
            echo '</ul>';
        }

        return $this->destroySessionValue(self::FLASH_MESSAGE);
    }
}
