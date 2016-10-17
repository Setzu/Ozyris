<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 02/06/16
 * Time: 10:14
 */

namespace Ozyris\Service;

abstract class SessionManager extends Dispatch
{

    public $aFlashMessages = array();
    protected $mSession;

    const FLASH_MESSAGE = 'flashmessage';
    const DANGER = 'danger';
    const SUCCESS = 'success';

    /**
     * SessionManager constructor.
     */
    public function __construct()
    {
        $this->startSession();
    }

    /**
     * Démarre la session
     *
     * @return $this
     */
    public function startSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
            session_cache_expire(60);
        }

        return $this;
    }

    /**
     * @param $key
     * @param $value
     */
    protected function setSessionValue($key, $value)
    {
        $_SESSION[(string) $key] = $value;
        $this->mSession = $_SESSION[$key];
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->mSession;
    }

    /**
     * @param $key
     * @return null
     */
    public function getSessionValue($key)
    {
        if (array_key_exists($key, $this->mSession)) {
            return $this->mSession[$key];
        } else {
            return null;
        }
    }

    /**
     * Détruit la clé $key en session.
     * Si $key vaut null, détruit toute la session
     *
     * @param null $key
     * @return $this
     */
    public function destroySession($key = null)
    {
        if (array_key_exists($key, $_SESSION)) {
            unset($_SESSION[$key]);
        } else {
            session_destroy();
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
    protected function setFlashMessage($message, $error = true)
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
     * Affiche le message selon le type. Et détruit la session flashmessage
     *
     * @return SessionManager
     */
    public function flashMessages()
    {
        if (array_key_exists(self::FLASH_MESSAGE, $_SESSION)) {
            foreach ($_SESSION[self::FLASH_MESSAGE] as $type => $message) {
                echo "<div class='alert alert-$type'>$message</div>";
            }
        }

        return $this->destroySession(self::FLASH_MESSAGE);
    }
}
