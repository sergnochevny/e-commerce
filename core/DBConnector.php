<?php

class DBConnector{
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
    }

    return false;
  }

  public function query($query) {
    $this->pdo->query($query);
  }

}