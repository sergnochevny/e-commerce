<?php

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 30/11/17
 * Time: 11:59 AM
 */
class PDOConnector implements DBConnector
{
    private $pdo;
    function __construct($host, $dbname, $username, $password)
    {
        try {
            $this->pdo = new PDO('mysql:host='.$host.';dbname='.$dbname, $username, $password);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}