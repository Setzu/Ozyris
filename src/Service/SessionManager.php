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

    const FLASH_MESSAGE = 'flashmessage';
    const DANGER = 'danger';
    const SUCCESS = 'success';

    /**
     * Démarre la session
     */
    public function __construct()
    {
        $this->startSession();
    }


    /**
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
     * @param null $param
     * @return $this
     */
    public function destroySession($param = null)
    {
        if ($param) {
            unset($_SESSION[$param]);
        } else {
            session_destroy();
        }

        return $this;
    }

    /**
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
