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
    private $_controllerName = 'index';
    private $_actionName = 'index';
    protected $aVariables = array();

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
            $this->_controllerName = $sControllerName;
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
        }

        return $this->_actionName;
    }

    /**
     * @param array $aVariables
     * @throws \Exception
     */
    public function setVariables(array $aVariables)
    {
        if (!is_array($aVariables)) {
            throw new \Exception('Le paramètre doit être un array.');
        }

        foreach ($aVariables as $sName => $mValue) {
            if (!is_string($sName)) {
                throw new \Exception('Le paramètre doit être une chaîne de caractères.');
            }

            $this->{$sName} = $mValue;
        }
    }

    /**
     * Inclusion des vues dans le layout
     *
     * @return mixed
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
