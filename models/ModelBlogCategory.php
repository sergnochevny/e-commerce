<?php

namespace models;

use app\core\model\ModelBase;
use Exception;

/**
 * Class ModelBlogcategory
 * @package models
 */
class ModelBlogcategory extends ModelBase{

  /**
   * @var string
   */
  protected static $table = 'blog_groups';

  /**
   * @param $id
   * @return array|null
   * @throws \Exception
   */
  public static function get_by_id($id){
    $response = [
      'id' => '', 'name' => '',
    ];
    if(isset($id)) {
      $query = "SELECT * FROM blog_groups WHERE id = '$id'";
      $result = static::query($query);
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
    $query = "SELECT COUNT(DISTINCT a.id) FROM " . self::$table . " a";
    $query .= " LEFT JOIN blog_group_posts b ON a.id = b.group_id";
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
    $res = null;
    $q = "SELECT a.id, a.name, COUNT(b.group_id) AS amount ";
    $q .= " FROM " . self::$table . " a";
    $q .= " LEFT JOIN blog_group_posts b ON a.id = b.group_id";
    $q .= static::build_where($filter, $prms);
    $q .= " GROUP BY a.id, a.name";
    $q .= static::build_order($sort);
    if($limit != 0) $q .= " LIMIT $start, $limit";
    $result = static::query($q, $prms);
    if($result) {
      $res_count_rows = static::num_rows($result);
      while($row = static::fetch_array($result)) {
        $res[] = $row;
      }
    }

    return $res;
  }

  /**
   * @param $id
   * @throws \Exception
   */
  public static function delete($id){
    static::transaction();
    try {
      if(isset($id)) {
        $query = "SELECT COUNT(*) FROM blog_group_posts WHERE id = $id";
        $res = static::query($query);
        if($res) {
          $amount = static::fetch_array($res)[0];
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
        $query = "DELETE FROM blog_groups WHERE id = $id";
        $res = static::query($query);
        if(!$res) throw new Exception(static::error());
      }
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
    extract($data);
    static::transaction();
    try {
      if(isset($id)) {
        $query = 'UPDATE blog_groups SET name = "' . $name . '" WHERE id = ' . $id;
        $res = static::query($query);
        if(!$res) throw new Exception(static::error());
      } else {
        $query = 'INSERT INTO blog_groups (name) VALUE ("' . $name . '")';
        $res = static::query($query);
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

}