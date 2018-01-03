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
    $query .= static::build_where($filter, $prms);
    if($result = static::query($query, $prms)) {
      $response = static::fetch_value($result);
      static::free_result($result);
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
  public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null){
    $response = null;
    $prms = [];
    $query = "SELECT * ";
    $query .= " FROM " . static::$table;
    $query .= static::build_where($filter, $prms);
    $query .= static::build_order($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";

    if($result = static::query($query, $prms)) {
      $res_count_rows = static::num_rows($result);
      $response = static::fetch_array_all($result);
      static::free_result($result);
    }

    return $response;
  }

  /**
   * @param $id
   * @throws \Exception
   */
  public static function delete($id){
    static::transaction();
    try {
      $strSQL = "DELETE FROM " . static::$table . " WHERE id = :id";
      static::exec($strSQL, ['id' => $id]);
      static::commit();
    } catch(Exception $e) {
      static::rollback();
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
    $result = static::query($q, $prms);

    return (!$result || static::num_rows($result) > 0);
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
      $result = static::query($strSQL, ['id' => $id]);
      if($result) {
        $data = static::fetch_assoc($result);
        static::free_result($result);
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
    static::transaction();
    try {
      $q = "UPDATE " . static::$table . " SET password = :password WHERE  id = :id";
      $result = static::query($q, ['password' => $password, 'id' => $id]);
      if(!$result) throw new Exception(static::error());
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }
  }

  /**
   * @param $data
   * @return mixed
   * @throws \Exception
   */
  public static function save(&$data){
    /**
     * @var string $login
     * @var string $password
     * @var integer $id
     */
    static::transaction();
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
      $result = static::query($q, $data);
      if(!$result) throw new Exception(static::error());
      if(!isset($admin_id)) {
        $id = static::last_id();
      }
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }

    return $id;
  }

}