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

    const DEFAULT_DIRECTORY = 'index';
    const DEFAULT_VIEW = 'index';

    /**
     * AbstractController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Crée une propriété pour chacunes des valeurs du tableau $aVariables
     * Le nom des propriétés seront égales aux clés du tableau $aVariables
     * Les variables seront accessibles dans les vues avec $this->nom_variable
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
     * Récupère les paramètres pour afficher la vue associée
     *
     * @param string $directory
     * @param string $view
     * @return mixed
     */
    public function render($directory = '', $view = '')
    {
        if (empty($directory) || !is_string($directory)) {
            $directory = self::DEFAULT_DIRECTORY;
        }

        if (empty($view) || !is_string($view)) {
            $view = self::DEFAULT_VIEW;
        }

        $sDirectoryPath = __DIR__ . '/../View/' . $directory;

        // Contrôle de l'existence du repertoire
        if (!file_exists($sDirectoryPath) || empty($sDirectoryPath)) {
            return $this->getErrorPage();
        }

        $sFilePath = $sDirectoryPath . '/' . $view . '.php';

        // Contrôle de l'existence du fichier
        if (file_exists($sFilePath)) {
            include_once $sFilePath;
        } else {
            return $this->getErrorPage();
        }

        return $this;
    }

    /**
     * Redirige vers /Nom_du_Controller/Action_du_controller.
     *
     * @param string $controller
     * @param string $action
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

    /**
     * @return string
     * @throws \Exception
     */
    public function getErrorPage()
    {
        if (!file_exists(__DIR__ . '/../View/error/404.php')) {
            // Alors ça c'est le comble \ö/
            throw new \Exception('La page 404 est introuvable.');
        }

        return __DIR__ . '/../View/error/404.php';
    }
}
