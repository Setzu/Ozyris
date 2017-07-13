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

    /**
     * Affichage de la vue index
     *
     * @return mixed
     */
    public function indexAction()
    {
        if ($this->getUser() instanceof Users) {
            $this->isAuthentified = true;
        }

        $this->setVariables([
            'user' => $this->getUser(),
            'isAuth' => $this->isAuthentified
        ]);

        return $this->render();
    }
}
