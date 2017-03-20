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
     * @param string $dbname
     * @param string $host
     * @param string $user
     * @param string $password
     * @throws \Exception
     */
    public function __construct($dbname = '', $host = '' , $user = '', $password = '')
    {
        // Connexion à une base ODBC
        if (empty($user) || !is_string($user)) {
            $dbname = 'demo';
        }
        if (empty($password) || !is_string($password)) {
            $host = 'localhost';
        }
        if (empty($user) || !is_string($user)) {
            $user = 'root';
        }
        if (empty($password) || !is_string($password)) {
            $password = 'gfp';
        }

        $dsn = 'mysql:dbname=' . $dbname . ';host=' . $host;

        $this->bdd = new \PDO($dsn, $user, $password);

        if (!$this->bdd) {
            throw new \Exception('Connexion à la base de donnée impossible.');
        }
    }
}
