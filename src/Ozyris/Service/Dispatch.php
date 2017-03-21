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
    const DEFAULT_CONTROLLER = 'IndexController';
    const DEFAULT_ACTION = 'indexAction';

    /**
     * Détermine le controller et l'action à appeler selon l'url
     *
     * @return mixed
     */
    public static function dispatch()
    {
        // Récupère le nom du contrôleur dans l'url
        if (!empty($_GET['controller'])) {
            $sController = ucfirst(strtolower(trim(htmlspecialchars($_GET['controller'])))) . 'Controller';
        } else {
            $sController = self::DEFAULT_CONTROLLER;
        }

        $sControllerName = 'Ozyris\\Controller\\' . $sController;

        // Si la classe n'existe pas on appel la méthode errorAction de l'indexController pour afficher une 404
        if (!class_exists($sControllerName)) {
            return (new Controller\IndexController())->errorAction();
        }

        // Récupère le nom de l'action dans l'url
        if (!empty($_GET['action'])) {
            $sActionName = ucfirst(strtolower(trim(htmlspecialchars($_GET['action'])))) . 'Action';
        } else {
            $sActionName = self::DEFAULT_ACTION;
        }

        // Si la méthode n'existe pas on appel la méthode errorAction de l'indexController pour afficher une 404
        if (!method_exists($sControllerName, $sActionName)) {
            return (new Controller\IndexController())->errorAction();
        }

        return (new $sControllerName)->$sActionName();
    }
}
