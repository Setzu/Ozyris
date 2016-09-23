<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 08/06/16
 * Time: 13:01
 */

namespace Ozyris\Controller;

use Ozyris\Service\Users;

class IndexController extends AuthentificationController
{

    public $oUser;

    public function __construct()
    {
        parent::__construct();

        if (array_key_exists('user', $_SESSION) && $_SESSION['user'] instanceof Users) {
            $this->isAuthentified = true;
            $this->oUser = $_SESSION['user'];
        }
    }

    /**
     * Récupère le paramètre de l'url pour charger la vue associée
     *
     * @return mixed
     */
    public function indexAction()
    {
        return $this->render();
    }
}
