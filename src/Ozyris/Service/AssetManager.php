<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 23/03/17
 * Time: 14:51
 */

namespace Ozyris\Service;


class AssetManager
{

    /**
     * Inclut un fichier css grâce au nom du fichier passé en paramètre
     * Il n'est pas nécessaire de spécifier l'extension dans le nom du fichier
     *
     * @param string $file
     * @return bool
     * @throws \Exception
     */
    public function loadCSS($file)
    {
        if (!is_string($file)) {
            throw new \Exception('Le nom du fichier doit être une chaîne de caractères.');
        }

        if (substr($file, -1, -4) != '.css') {
            $file = $file . '.css';
        }

        if (!file_exists(__DIR__ . '/public/css/' . $file)) {
            return false;
        }

        include_once $file;

        return true;
    }

    /**
     * Inclut un fichier javascript grâce au nom du fichier passé en paramètre
     * Il n'est pas nécessaire de spécifier l'extension dans le nom du fichier
     *
     * @param string $file
     * @return bool
     * @throws \Exception
     */
    public function loadJS($file)
    {
        if (!is_string($file)) {
            throw new \Exception('Le nom du fichier doit être une chaîne de caractères.');
        }

        if (substr($file, -1, -3) != '.js') {
            $file = $file . '.js';
        }

        if (!file_exists(__DIR__ . '/public/js/' . $file)) {
            return false;
        }

        include_once $file;

        return true;
    }
}