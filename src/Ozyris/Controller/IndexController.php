<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 08/06/16
 * Time: 13:01
 */

namespace Ozyris\Controller;

use Ozyris\Service\AssetManager;
use Ozyris\Service\Users;

class IndexController extends AuthentificationController
{

    public $oUser;

    /**
     * IndexController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        if (array_key_exists('user', $_SESSION) && $_SESSION['user'] instanceof Users) {
            $this->isAuthentified = true;
            $this->oUser = $_SESSION['user'];
        }
    }

    /**
     * @return mixed
     */
    public function indexAction()
    {
        return $this->render();
    }
}
