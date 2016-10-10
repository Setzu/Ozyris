<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 26/05/16
 * Time: 16:16
 */

namespace Ozyris\Model;

abstract class AbstractModel
{

    public $bdd;

    /**
     * ConnectionPDO constructor.
     * @param string $dsn
     * @param string $user
     * @param string $password
     */
    public function __construct($dsn = '', $user = '', $password = '')
    {
        /* Connexion à une base ODBC avec l'invocation de pilote */

        if (empty($dsn) || !is_string($dsn)) {
            $dsn = 'mysql:dbname=test;host=localhost';
        }
        if (empty($user) || !is_string($user)) {
            $user = 'root';
        }
        if (empty($password) || !is_string($password)) {
            $password = 'gfp';
        }

        try {
            $this->bdd = new \PDO($dsn, $user, $password);
        } catch (\PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
    }
}
