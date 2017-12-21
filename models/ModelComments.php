<?php

namespace models;

use app\core\model\ModelBase;
use Exception;

/**
 * Class ModelComments
 * @package models
 */
class ModelComments extends ModelBase{

  /**
   * @var string
   */
  protected static $table = 'comments';

  /**
   * @param $filter
   * @param null $prms
   * @return array|string
   */
  protected static function build_where(&$filter, &$prms = null){
    $result = '';
    if(isset($filter['a.title'])) $result[] = "a.post_title LIKE '%" . implode('%', array_filter(explode(' ', static::prepare_for_sql($filter['a.post_title'])))) . "%'";
    if(isset($filter['a.dt'])) {
      $where = (!empty($filter['a.dt']['from']) ? "a.dt >= '" . static::prepare_for_sql($filter['a.dt']['from']) . "'" : "") . (!empty($filter['a.dt']['to']) ? " AND a.dt <= '" . static::prepare_for_sql($filter['a.dt']['to']) . "'" : "");
      if(strlen(trim($where)) > 0) $result[] = "(" . $where . ")";
    }
    if(isset($filter['b.email'])) $result[] = "b.email LIKE '%" . implode('%', array_filter(explode(' ', static::prepare_for_sql($filter['b.email'])))) . "%'";
    if(isset($filter['a.moderated'])) $result[] = "a.moderated = '" . static::prepare_for_sql($filter['a.moderated']) . "'";
    if(!empty($result) && (count($result) > 0)) {
      $result = implode(" AND ", $result);
      if(strlen(trim($result)) > 0) {
        $result = " WHERE " . $result;
        $filter['active'] = true;
      }
    }

    return $result;
  }

  /**
   * @param $id
   * @return array|null
   * @throws \Exception
   */
  public static function get_by_id($id){
    $prms = [];
    $response = [
      'id' => $id, 'title' => '', 'dt' => time(), 'user_id' => '', 'moderated' => '0'
    ];
    if(isset($id)) {
      $query = "SELECT * FROM " . static::$table . " WHERE id='$id'";
      $result = static::query($query, $prms);
      if($result) $response = static::fetch_assoc($result);
    }

    return $response;
  }

  /**
   * @param null $filter
   * @return int|null
   * @throws \Exception
   */
  public static function get_total_count($filter = null){
    $response = 0;
    $query = "SELECT COUNT(DISTINCT a.id) FROM " . static::$table . " a";
    $query .= " LEFT JOIN accounts b ON b.aid = a.userid";
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
   * @return array|null
   * @throws \Exception
   */
  public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null){
    $response = null;
    $query = "SELECT a.*, b.email ";
    $query .= " FROM " . static::$table . " a";
    $query .= " LEFT JOIN accounts b ON b.aid = a.userid";
    $query .= static::build_where($filter, $prms);
    $query .= static::build_order($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";

    if($result = static::query($query, $prms)) {
      $res_count_rows = static::num_rows($result);
      while($row = static::fetch_array($result)) {
        $response[] = $row;
      }
    }

    return $response;
  }

  /**
   * @param $data
   * @return mixed
   * @throws \Exception
   */
  public static function save(&$data){
    static::transaction();
    $prms = [];
    try {
      extract($data);
      if(isset($id)) {
        $query = 'UPDATE ' . static::$table . ' SET `title` = "' . $title . '", `data` = "' . $data . '",`moderated` = "' . $moderated . '" WHERE id =' . $id;
        $res = static::query($query, $prms);
        if(!$res) throw new Exception(static::error());
      } else {
        $query = 'INSERT INTO ' . static::$table . '(title, data, moderated) VALUE ("' . $title . '","' . $data . '","' . $moderated . '")';
        $res = static::query($query, $prms);
        if(!$res) throw new Exception(static::error());
        $id = static::last_id();
      }
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }

    return $id;
  }

  /**
   * @param $id
   * @param $action
   * @return bool
   * @throws \Exception
   */
  public static function moderate($id, $action){
    static::transaction();
    $prms = [];
    try {
      $query = 'UPDATE ' . static::$table . ' SET `moderated` = "' . $action . '" WHERE id =' . $id;

      return static::query($query, $prms) ? true : false;
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }
  }

  /**
   * @param $id
   * @throws \Exception
   */
  public static function delete($id){
    static::transaction();
    $prms = [];
    try {
      if(isset($id)) {
        $query = "DELETE FROM " . static::$table . " WHERE id = $id";
        $res = static::query($query, $prms);
        if(!$res) throw new Exception(static::error());
      }
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }
  }

}