<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 14/06/16
 * Time: 10:06
 */

namespace Ozyris\Service;

use Ozyris\Controller;

class Dispatch
{
    private $_sControllerName = 'indexController';
    private $_sActionName = 'indexAction';
    private $_sNamespace = 'Ozyris\\Controller\\';

    /**
     * Détermine le controller et l'action à appeler selon l'url
     * Le controller appeler par défaut est IndexController
     * L'action des controller si non renseigné, est indexAction
     *
     * @return mixed
     */
    public function dispatch()
    {
        if (isset($_GET['controller'])) {
            $this->setControllerName($_GET['controller']);
        }

        $sControllerName = $this->_sNamespace . $this->getControllerName();

        if (isset($_GET['action'])) {
            $this->setActionName($_GET['action']);
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
    protected function setControllerName($sControllerName)
    {
        $sControllerName = strtolower(trim(htmlspecialchars($sControllerName)));
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
    protected function setActionName($sActionName)
    {
        $sActionName = strtolower(trim(htmlspecialchars($sActionName)));
        $this->_sActionName = $sActionName . 'Action';

        return $this;
    }
}
