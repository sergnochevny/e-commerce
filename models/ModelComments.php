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
  public static function BuildWhere(&$filter, &$prms = null){
    $return = '';
    if(isset($filter['a.title'])) {
      $result[] = "a.post_title LIKE :a_post_title";
      $prms['a_post_title'] = "%" . implode('%', array_filter(explode(' ', $filter['a.post_title']))) . "%";
    }
    if(isset($filter["a.dt"])) {
      $where = '';
      if(!empty($filter["a.dt"]['from'])) {
        $where = "a.dt >= :adt_from";
        $prms['adt_from'] = $filter["a.dt"]["from"];
      }
      if(!empty($filter["a.dt"]['to'])) {
        $where .= " AND a.dt <= :adt_to";
        $prms['adt_to'] = $filter["a.dt"]["to"];
      }
      if(strlen(trim($where)) > 0) $result[] = "(" . $where . ")";
    }
    if(isset($filter['b.email'])) {
      $result[] = "b.email LIKE :b_email";
      $prms['b_email'] = "%" . implode('%', array_filter(explode(' ', $filter['b.email']))) . "%'";
    }
    if(isset($filter['a.moderated'])) {
      $result[] = "a.moderated = :a_moderated";
      $prms['a_moderated'] = $filter['a.moderated'];
    }
    if(!empty($result) && (count($result) > 0)) {
      $return = implode(" AND ", $result);
      if(strlen(trim($result)) > 0) {
        $return = " WHERE " . $return;
        $filter['active'] = true;
      }
    }

    return $return;
  }

  /**
   * @param $id
   * @return array|null
   * @throws \Exception
   */
  public static function get_by_id($id){
    $response = [
      'id' => $id, 'title' => '', 'dt' => time(), 'user_id' => '', 'moderated' => '0'
    ];
    if(isset($id)) {
      $query = "SELECT * FROM " . static::$table . " WHERE id= :id";
      $result = static::Query($query, ['id' => $id]);
      if($result) $response = static::FetchAssoc($result);
    }

    if ($response === false){
      throw new Exception('Data set is empty!');
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
   * @return array|null
   * @throws \Exception
   */
  public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null){
    $response = [];
    $query = "SELECT a.*, b.email ";
    $query .= " FROM " . static::$table . " a";
    $query .= " LEFT JOIN accounts b ON b.aid = a.userid";
    $query .= static::BuildWhere($filter, $prms);
    $query .= static::BuildOrder($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";

    if($result = static::Query($query, $prms)) {
      $res_count_rows = static::getNumRows($result);
      while($row = static::FetchArray($result)) {
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
  public static function Save(&$data){
    static::BeginTransaction();
    try {
      extract($data);
      /**
       * @var integer $id
       * @var string $data
       * @var string $moderated
       * @var string $title
       */
      if(!empty($data['id'])) {
        $query = 'UPDATE ' . static::$table . ' SET `title` = :title, `data` = :data, `moderated` = :moderated WHERE id = :id';
        $res = static::Query($query, ['id' => $id, 'title' => $title, 'data' => $data, 'moderated' => $moderated]);
        if(!$res) throw new Exception(static::Error());
      } else {
        $query = 'INSERT INTO ' . static::$table . '(`title`, `data`, `moderated`) VALUE (:title, :data, :moderated)';
        $res = static::Query($query, ['title' => $title, 'data' => $data, 'moderated' => $moderated]);
        if(!$res) throw new Exception(static::Error());
        $id = static::LastId();
      }
      static::Commit();
    } catch(Exception $e) {
      static::RollBack();
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
    static::BeginTransaction();
    try {
      $query = 'UPDATE ' . static::$table . ' SET moderated = :action WHERE id = :id';
      $prms = ['action' => $action, 'id' => $id];

      return static::Query($query, $prms) ? true : false;
      static::Commit();
    } catch(Exception $e) {
      static::RollBack();
      throw $e;
    }
  }

  /**
   * @param $id
   * @throws \Exception
   */
  public static function Delete($id){
    static::BeginTransaction();
    try {
      if(isset($id)) {
        $query = "DELETE FROM " . static::$table . " WHERE id = :id";
        $res = static::Query($query, ['id' => $id]);
        if(!$res) throw new Exception(static::Error());
      }
      static::Commit();
    } catch(Exception $e) {
      static::RollBack();
      throw $e;
    }
  }

}