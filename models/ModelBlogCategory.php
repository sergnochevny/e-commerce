<?php

namespace models;

use app\core\model\ModelBase;
use Exception;

/**
 * Class ModelBlogCategory
 * @package models
 */
class ModelBlogCategory extends ModelBase{

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
      $query = "SELECT * FROM blog_groups WHERE id = :id";
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
    $query = "SELECT COUNT(DISTINCT a.id) FROM " . self::$table . " a";
    $query .= " LEFT JOIN blog_group_posts b ON a.id = b.group_id";
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
    $res = null;
    $q = "SELECT a.id, a.name, COUNT(b.group_id) AS amount ";
    $q .= " FROM " . self::$table . " a";
    $q .= " LEFT JOIN blog_group_posts b ON a.id = b.group_id";
    $q .= static::BuildWhere($filter, $prms);
    $q .= " GROUP BY a.id, a.name";
    $q .= static::BuildOrder($sort);
    if($limit != 0) $q .= " LIMIT $start, $limit";
    $result = static::Query($q, $prms);
    if($result) {
      $res_count_rows = static::getNumRows($result);
      while($row = static::FetchArray($result)) {
        $res[] = $row;
      }
    }

    return $res;
  }

  /**
   * @param $id
   * @throws \Exception
   */
  public static function Delete($id){
    static::BeginTransaction();
    try {
      if(isset($id)) {
        $query = "SELECT COUNT(*) FROM blog_group_posts WHERE group_id = :id";
        $res = static::Query($query, ['id' => $id]);
        if($res) {
          $amount = static::FetchArray($res)[0];
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
        $query = "DELETE FROM blog_groups WHERE id = :id";
        $res = static::Query($query, ['id' => $id]);
        if(!$res) throw new Exception(static::Error());
      }
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
    extract($data);
    /**
     * @var $id
     * @var string $name
     */
    static::BeginTransaction();
    try {
      if(isset($id)) {
        $query = 'UPDATE blog_groups SET name = :name WHERE id = :id';
        $res = static::Query($query, ['id' => $id, 'name' => $name]);
        if(!$res) throw new Exception(static::Error());
      } else {
        $query = 'INSERT INTO blog_groups (name) VALUE (:name)';
        $res = static::Query($query, ['name' => $name]);
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

}