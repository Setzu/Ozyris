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

    /**
     * Dertemine le controller et l'action à appeler selon l'url
     * Le controller appeler par défaut est IndexController
     * L'action des controller si non renseigné, est indexAction
     *
     * @return mixed
     */
    public function dispatch()
    {
        $sControllerName = (string) ucfirst(strtolower(trim(htmlspecialchars($_GET['controller']))));

        if (empty($sControllerName)) {
            $sControllerName = 'IndexController';
        } else {
            $sControllerName .= 'Controller';
        }

        $sActionName = (string) strtolower(trim(htmlspecialchars($_GET['action'])));

        if (empty($sActionName)) {
            $sActionName = 'indexAction';
        } else {
            $sActionName .= 'Action';
        }

        if (class_exists('Ozyris\\Controller\\' . $sControllerName)) {
            if (!method_exists('Ozyris\\Controller\\' . $sControllerName, $sActionName)) {
                $sActionName = 'indexAction';
            }
        } else {
            $sControllerName = 'IndexController';
            $sActionName = 'indexAction';
        }

        $sController = 'Ozyris\\Controller\\' . $sControllerName;

        return (new $sController)->$sActionName();
    }
}
