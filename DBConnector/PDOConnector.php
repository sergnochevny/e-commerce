<?php

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 30/11/17
 * Time: 11:59 AM
 */
class PDOConnector implements DBConnector {
  public $host;
  public $username;
  public $password;
  private $pdo;

  function __construct($host, $username, $password) {
    $this->host = $host;
    $this->username = $username;
    $this->password = $password;
  }

  public function initConnection($dbname) {
    try {
      $this->pdo = new PDO('mysql:host=' . $this->host . ';dbname=' . $dbname, $this->username, $this->password);

      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function query($query) {
    $this->pdo->query($query);
  }

}