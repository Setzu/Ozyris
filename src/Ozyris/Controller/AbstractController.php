<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 30/05/16
 * Time: 14:48
 */

namespace Ozyris\Controller;

use Ozyris\Service\SessionManager;
use Ozyris\Stdlib\ControllerInterface;

abstract class AbstractController extends SessionManager implements ControllerInterface
{

    protected $aVariables = array();
    protected $sView;

    /**
     * AbstractController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Crée une propriété pour chaques valeurs du tableau $aVariables
     *
     * @param array $aVariables
     * @throws \Exception
     */
    public function setVariables(array $aVariables)
    {
        foreach ($aVariables as $sName => $mValue) {
            if (!is_string($sName)) {
                throw new \Exception('La clé doit être une chaîne de caractères.');
            }

            $this->{$sName} = $mValue;
        }
    }

    /**
     * Récupère les paramètres Controller et Action de l'url pour afficher les vues associées
     *
     * @return mixed
     */
    public function render()
    {
        $sDirectoryPath = __DIR__ . '/../View/' . strtolower(str_replace('Controller', '', $this->getControllerName()));

        // Contrôle de l'existence du repertoire
        if (!file_exists($sDirectoryPath) || empty($sDirectoryPath)) {
            include_once __DIR__ . '/../View/error/404.php';

            return false;
        }

        $sFilePath = $sDirectoryPath . '/' . str_replace('Action', '', $this->getActionName() . '.php');

        // Contrôle de l'existence du fichier
        if (file_exists($sFilePath)) {
            include_once $sFilePath;
        } else {
            include_once __DIR__ . '/../View/error/404.php';
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
