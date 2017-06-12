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

    const ERROR_TYPE_FILENAME = 'Le nom du fichier doit être une string.';

    /**
     * Inclu un fichier css grâce au nom du fichier passé en paramètre
     * Il n'est pas nécessaire de spécifier l'extension dans le nom du fichier
     *
     * @param string $file
     * @return string|bool
     * @throws \Exception
     */
    public function loadCSS($file)
    {
        if (!is_string($file)) {
            throw new \Exception(self::ERROR_TYPE_FILENAME);
        }

        if (substr($file, -1, -4) != '.css') {
            $file = $file . '.css';
        }

        $filepath = __DIR__ . '/public/css/' . $file;

        if (!file_exists($filepath)) {
            return false;
        }

        include_once $filepath;

        return true;
    }

    /**
     * Inclu un fichier javascript grâce au nom du fichier passé en paramètre
     * Il n'est pas nécessaire de spécifier l'extension dans le nom du fichier
     *
     * @param string $file
     * @return string|bool
     * @throws \Exception
     */
    public function loadJS($file)
    {
        if (!is_string($file)) {
            throw new \Exception(self::ERROR_TYPE_FILENAME);
        }

        if (substr($file, -1, -3) != '.js') {
            $file = $file . '.js';
        }

        $filepath = __DIR__ . '/public/js/' . $file;

        if (!file_exists($filepath)) {
            return false;
        }

        include_once $filepath;

        return true;
    }
}