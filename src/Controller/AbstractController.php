<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 30/05/16
 * Time: 14:48
 */

namespace Ozyris\Controller;

use Ozyris\Service\ControllerInterface;
use Ozyris\Service\SessionManager;

abstract class AbstractController extends SessionManager implements ControllerInterface
{
    private $controllerName = 'index';
    private $actionName = 'index';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     */
    protected function getControllerName()
    {
        $sControllerName = (string) strtolower(trim(htmlspecialchars($_GET['controller'])));

        if (!empty($sControllerName)) {
            $this->controllerName = $sControllerName;
        }

        return $this->controllerName;
    }

    /**
     * @return string
     */
    protected function getActionName()
    {
        $sActionName = (string) strtolower(trim(htmlspecialchars($_GET['action'])));

        if (!empty($sActionName)) {
            $this->actionName = $sActionName;
        }

        return $this->actionName;
    }

    /**
     * Inclusion des vues dans le layout
     *
     * @return $this
     */
    public function render()
    {
        $sDirectoryPath = __DIR__ . '/../../view/' . $this->getControllerName();

        if (!file_exists($sDirectoryPath) || empty($sDirectoryPath)) {
            include_once __DIR__ . '/../../view/error/404.php';

            return false;
        }

        $sFilePath = $sDirectoryPath . '/' . $this->getActionName() . '.php';

        if (file_exists($sFilePath)) {
            include_once $sFilePath;
        } else {
            include_once __DIR__ . '/../../view/error/404.php';
        }

        return $this;
    }

    /**
     * Redirige vers /Nom_du_Controller/Action_du_controller.
     *
     * @param string $controller
     * @param string $action
     * @return $this
     */
    public function redirect($controller = '', $action = '')
    {
        $sControllerName = (string) strtolower(trim($controller));
        $sActionName = (string) strtolower(trim($action));

        if (!empty($sActionName)) {
            header('Location: /' . $sControllerName . '/' . $sActionName);
            exit;
        } else {
            header('Location: /' . $sControllerName);
            exit;
        }
    }
}
