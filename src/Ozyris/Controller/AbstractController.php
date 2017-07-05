<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 30/05/16
 * Time: 14:48
 */

namespace Ozyris\Controller;

use Ozyris\Service\AssetManager;
use Ozyris\Service\SessionManager;
use Ozyris\Stdlib\ControllerInterface;

abstract class AbstractController extends SessionManager implements ControllerInterface
{

    protected $aVariables = [];
    protected $sView;

    const DEFAULT_DIRECTORY = 'index';
    const DEFAULT_VIEW = 'index';


    /**
     * Créée une propriété pour chacunes des valeurs du tableau $aVariables
     * Le nom des propriétés seront égales aux clés du tableau $aVariables
     * Les variables seront accessibles dans les vues avec $this->nom_variable
     *
     * @param array $aVariables
     * @return mixed
     * @throws \Exception
     */
    protected function setVariables(array $aVariables)
    {
        foreach ($aVariables as $sName => $mValue) {
            if (!is_string($sName)) {
                throw new \Exception('La clé doit être une chaîne de caractères.');
            } elseif (property_exists($this, $sName)) {
                throw new \Exception('La propriété ' . $sName . ' existe déjà');
            }

            // Création dynamique de la priopriété
            return $this->{$sName} = $mValue;
        }

        return false;
    }

    /**
     * @param string $sName
     * @param mixed $mValue
     * @return mixed
     * @throws \Exception
     */
    protected function updateVariables($sName, $mValue)
    {
        if (!is_string($sName)) {
            throw new \Exception('Le nom de la variable doit être une chaîne de caractères.');
        } elseif (!property_exists($this, $sName)) {
            return $this->setVariables([$sName => $mValue]);
        }

        return $this->{$sName} = $mValue;
    }

    /**
     * Affichage de la vue en fonction des paramètres
     *
     * @param string $directory
     * @param string $view
     * @return mixed
     * @throws \Exception
     */
    protected function render($directory = '', $view = '')
    {
        if (empty($directory) || !is_string($directory)) {
            $directory = self::DEFAULT_DIRECTORY;
        }

        if (empty($view) || !is_string($view)) {
            $view = self::DEFAULT_VIEW;
        }

        $sFilePath = __DIR__ . '/../View/' . $directory . '/' . $view . '.php';

        // Contrôle de l'existence du fichier
        if (file_exists($sFilePath)) {
            require_once $sFilePath;
        } else {
            throw new \Exception('Le fichier ' . $sFilePath . ' n\'a pas été trouvé.');
        }

        return $this;
    }

    /**
     * Redirige vers /Nom_du_Controller/Action_du_controller.
     *
     * @param string $controller
     * @param string $action
     */
    protected function redirect($controller = '', $action = '')
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
     * Appelle méthode _loadAsset pour récupérer le service AssetManager
     * Il n'est pas nécessaire de spécifier l'extension dans le nom du fichier
     *
     * @param string $file
     * @return bool
     */
    public function loadCSS($file)
    {
        $oAssetManager = $this->_getAssetManager();

        return $oAssetManager->loadCSS($file);
    }

    /**
     * Appelle méthode _loadAsset pour récupérer le service AssetManager
     * Il n'est pas nécessaire de spécifier l'extension dans le nom du fichier
     *
     * @param string $file
     * @return bool
     */
    public function loadJS($file)
    {
        $oAssetManager = $this->_getAssetManager();

        return $oAssetManager->loadJS($file);
    }

    /**
     * Récupère l'objet AssetManager
     *
     * @return object AssetManager
     */
    private function _getAssetManager()
    {
        return new AssetManager();
    }

    /**
     * Appelle la méthode render avec les paramètres de la page 404
     *
     * @return string
     * @throws \Exception
     */
    public function pageNotFound()
    {
        if (!file_exists(__DIR__ . '/../View/error/404.php')) {
            // Alors ça c'est le comble \ö/
            throw new \Exception('La page 404 est introuvable.');
        }

        return $this->render('error', '404');
    }
}
