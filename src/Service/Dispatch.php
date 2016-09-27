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
    private $_controllerName = 'index';
    private $_actionName = 'index';

    /**
     * Détermine le controller et l'action à appeler selon l'url
     * Le controller appeler par défaut est IndexController
     * L'action des controller si non renseigné, est indexAction
     *
     * @return mixed
     */
    public function dispatch()
    {
        $sControllerName = 'Ozyris\\Controller\\' . $this->getControllerName();
        $sActionName = $this->getActionName();

        if (class_exists($sControllerName)) {
            if (!method_exists($sControllerName, $sActionName . 'Action')) {
                $sActionName = 'indexAction';
            }
        } else {
            $sControllerName = 'Ozyris\\Controller\\IndexController';
            $sActionName = 'indexAction';
        }

        return (new $sControllerName)->$sActionName();
    }

    /**
     * @return string
     */
    protected function getControllerName()
    {
        $sControllerName = (string) strtolower(trim(htmlspecialchars($_GET['controller'])));

        if (!empty($sControllerName)) {
            $this->_controllerName = $sControllerName;
        } else {
            $this->_controllerName = 'index';
        }

        return $this->_controllerName;
    }

    /**
     * @return string
     */
    protected function getActionName()
    {
        $sActionName = (string) strtolower(trim(htmlspecialchars($_GET['action'])));

        if (!empty($sActionName)) {
            $this->_actionName = $sActionName;
        } else {
            $this->_actionName = 'index';
        }

        return $this->_actionName;
    }
}
