<?php
/**
 * Created by PhpStorm.
 * User: maxkamov48
 * Date: 5/19/21
 * Time: 10:25 PM
 */

namespace app\core;


class Database
{
    public $pdo;

    public function __construct($dbConfig = [])
    {
        $dbDsn = $dbConfig['dsn'] ?? '';
        $username = $dbConfig['user'] ?? '';
        $password = $dbConfig['password'] ?? '';

        $this->pdo = new \PDO($dbDsn, $username, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }

}