<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 30/11/17
 * Time: 11:59 AM
 */


class PDOConnector implements DBConnector {
  public function DBConnections($host, $dbname, $username, $password) {
    try {
      $pdo = new PDO($host, $dbname, $username, $password);
    }
    catch(PDOException $e)
    {
      echo $e->getMessage();
    }
  }

}