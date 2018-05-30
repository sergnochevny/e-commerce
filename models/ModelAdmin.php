<?php

namespace models;

use app\core\model\ModelBase;
use ErrorException;
use Exception;

/**
 * Class ModelAdmin
 * @package models
 */
class ModelAdmin extends ModelBase{

  protected static $table = 'admins';

  /**
   * @param null $filter
   * @return int|null
   * @throws \Exception
   */
  public static function get_total_count($filter = null){
    $response = 0;
    $prms = [];
    $query = "SELECT COUNT(*) FROM " . static::$table;
    $query .= static::BuildWhere($filter, $prms);
    if($result = static::Query($query, $prms)) {
      $response = static::FetchValue($result);
      static::FreeResult($result);
    }

    return $response;
  }

  /**
   * @param $start
   * @param $limit
   * @param $res_count_rows
   * @param null $filter
   * @param null $sort
   * @return mixed|null
   * @throws \Exception
   */
  public static function getList($start, $limit, &$res_count_rows, &$filter = null, &$sort = null){
    $response = [];
    $prms = [];
    $query = "SELECT * ";
    $query .= " FROM " . static::$table;
    $query .= static::BuildWhere($filter, $prms);
    $query .= static::BuildOrder($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";

    if($result = static::Query($query, $prms)) {
      $res_count_rows = static::getNumRows($result);
      $response = static::FetchArrayAll($result);
      static::FreeResult($result);
    }

    return $response;
  }

  /**
   * @param $id
   * @throws \Exception
   */
  public static function Delete($id){
    static::BeginTransaction();
    try {
      $strSQL = "DELETE FROM " . static::$table . " WHERE id = :id";
      static::Exec($strSQL, ['id' => $id]);
      static::Commit();
    } catch(Exception $e) {
      static::RollBack();
      throw $e;
    }
  }

  /**
   * @param null $login
   * @param null $id
   * @return bool
   * @throws \ErrorException
   * @throws \Exception
   */
  public static function exist($login = null, $id = null){
    if(is_null($login) && is_null($id)) {
      throw new ErrorException('Both parameters cannot be empty!');
    }
    $q = "SELECT * ";
    $q .= "FROM " . static::$table . " WHERE";
    if(isset($id)) {
      $q .= " id <> :id";
      $prms['id'] = $id;
    }
    if(isset($login)) {
      if(isset($id)) $q .= " and";
      $q .= " login = :login";
      $prms['login'] = $login;
    }
    $result = static::Query($q, $prms);

    return (!$result || static::getNumRows($result) > 0);
  }

  /**
   * @param $id
   * @return array|null
   * @throws \Exception
   */
  public static function get_by_id($id){
    $data = [
      'id' => $id, 'login' => ''
    ];
    if(isset($id)) {
      $strSQL = "SELECT * FROM " . static::$table . " WHERE id = :id";
      $result = static::Query($strSQL, ['id' => $id]);
      if($result) {
        $data = static::FetchAssoc($result);
        static::FreeResult($result);
      }
    }

    if ($data === false){
      throw new Exception('Data set is empty!');
    }

    return $data;
  }

  /**
   * @param $password
   * @param $id
   * @throws \Exception
   */
  public static function update_password($password, $id){
    static::BeginTransaction();
    try {
      $q = "UPDATE " . static::$table . " SET password = :password WHERE  id = :id";
      $result = static::Query($q, ['password' => $password, 'id' => $id]);
      if(!$result) throw new Exception(static::Error());
      static::Commit();
    } catch(Exception $e) {
      static::RollBack();
      throw $e;
    }
  }

  /**
   * @param $data
   * @return mixed
   * @throws \Exception
   */
  public static function Save(&$data){
    /**
     * @var string $login
     * @var string $password
     * @var integer $id
     */
    static::BeginTransaction();
    try {
      extract($data);
      if(!isset($id)) {
        $q = "INSERT INTO  " . static::$table . "(id ,login ,password)" . "VALUES (NULL , :login, :password);";
      } else {
        $q = "UPDATE " . static::$table . " SET" . " login = :login";
        if(isset($password) && (strlen($password) > 0)) {
          $q .= "',password = :password";
        }
        $q .= "' WHERE  id = :id";
      }
      $result = static::Query($q, $data);
      if(!$result) throw new Exception(static::Error());
      if(!isset($admin_id)) {
        $id = static::LastId();
      }
      static::Commit();
    } catch(Exception $e) {
      static::RollBack();
      throw $e;
    }

    return $id;
  }

}