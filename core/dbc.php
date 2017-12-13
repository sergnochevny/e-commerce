<?php

class DBC{

  private $pdo;
  public $host;
  public $username;
  public $password;
  public $error;
  public $errno;

  function __construct($host, $username, $password){
    $this->host = $host;
    $this->username = $username;
    $this->password = $password;
  }

  public function initConnection($dbname){
    try {
      $this->pdo = new PDO('mysql:host=' . $this->host . ';dbname=' . $dbname, $this->username, $this->password);

      return true;
    } catch(Exception $e) {
      $this->errno = $e->getCode();
      $this->error = $e->getMessage();
    }

    return false;
  }

  public function query($query, $prms = null){
    $statement = $this->pdo->prepare($query);
    if(!empty($prms) && is_array($prms)) {
      foreach($prms as $key => $value) {
        $statement->bindValue(':' . $key, $value);
      }
    }

    return $statement->execute() ? $statement : false;
  }

  public function exec($query){
    return $this->pdo->exec($query);
  }

  public function begin_transaction(){
    return $this->pdo->beginTransaction();
  }

  public function commint(){
    return $this->pdo->commit();
  }

  public function in_transaction(){
    return $this->pdo->inTransaction();
  }

  public function roll_back(){
    return $this->pdo->rollBack();
  }

  public function error(){
    $this->error = $this->pdo->errorInfo();
    if(!empty($this->error)) {
      $this->errno = $this->error[0];
      $this->error = $this->error[2];
    }

    return $this->error;
  }

  public function last_id(){
    return $this->pdo->lastInsertId();
  }

  public function quote($value){
    return $this->pdo->quote($value);
  }

}