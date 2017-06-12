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

    /**
     * Affichage de la vue index
     *
     * @return mixed
     */
    public function indexAction()
    {
        $aSession = $this->getSession();

        if (array_key_exists('user', $aSession) && $aSession['user'] instanceof Users) {
            $this->isAuthentified = true;
            $this->oUser = $aSession['user'];
        }

        return $this->render();
    }
}
