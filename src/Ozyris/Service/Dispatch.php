<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 14/06/16
 * Time: 10:06
 */

namespace Ozyris\Service;

use Ozyris\Controller;
use Ozyris\Stdlib\DispatchInterface;

class Dispatch implements DispatchInterface
{
    private $_sControllerName = 'IndexController';
    private $_sActionName = 'indexAction';

    /**
     * Détermine le controller et l'action à appeler selon l'url
     * Le controller appeler par défaut est IndexController
     * L'action des controller si non renseigné, est indexAction
     *
     * @return mixed
     */
    public function dispatch()
    {
        if (!empty($_GET['controller'])) {
            $this->setControllerName(ucfirst(strtolower(trim(htmlspecialchars($_GET['controller'])))));
        }

        $sControllerName = 'Ozyris\\Controller\\' . $this->getControllerName();

        if (!empty($_GET['action'])) {
            $this->setActionName(ucfirst(strtolower(trim(htmlspecialchars($_GET['action'])))));
        }

        $sActionName = $this->getActionName();

        return (new $sControllerName)->$sActionName();
    }

    /**
     * Récupère le nom du controller
     *
     * @return string
     */
    public function getControllerName()
    {
        return $this->_sControllerName;
    }

    /**
     * Set le nom du controller
     *
     * @param string $sControllerName
     * @return $this
     */
    public function setControllerName($sControllerName)
    {
        $this->_sControllerName = $sControllerName . 'Controller';

        return $this;
    }

    /**
     * Récupère le nom de l'action
     *
     * @return string
     */
    public function getActionName()
    {
        return $this->_sActionName;
    }

    /**
     * Set le nom de l'action
     *
     * @param string $sActionName
     * @return $this
     */
    public function setActionName($sActionName)
    {
        $sActionName = strtolower(trim(htmlspecialchars($sActionName)));
        $this->_sActionName = $sActionName . 'Action';

        return $this;
    }
}
