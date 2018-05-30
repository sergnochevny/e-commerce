<?php

namespace models;

use app\core\model\ModelBase;
use classes\helpers\AdminHelper;
use Exception;

/**
 * Class ModelColors
 * @package models
 */
class ModelColors extends ModelBase{

  /**
   * @var string
   */
  protected static $table = 'shop_color';

  /**
   * @param $filter
   * @param null $prms
   * @return array|string
   * @throws \Exception
   */
  public static function BuildWhere(&$filter, &$prms = null){
    $return = "";
    if(isset($filter['hidden']['view']) && $filter['hidden']['view']) {
      if(!empty($filter["a.color"])) {
        if(AdminHelper::is_logged()) {
          foreach(array_filter(explode(' ', $filter["a.color"])) as $idx => $item) {
            if(!empty($item)) {
              $result[] = "a.color LIKE :a_color" . $idx . "";
              $prms['a_color' . $idx] = '%' . $item . '%';
            }
          }
        } else {
          list($result[], $prms) = ModelSynonyms::build_synonyms_like_p("a.color", $filter["a.color"]);
        }
      }
      if(isset($filter["a.id"])) {
        $result[] = "a.id = :a_id";
        $prms['a_id'] = $filter["a.id"];
      }
      if(!empty($result) && (count($result) > 0)) {
        if(strlen(trim(implode(" AND ", $result))) > 0) {
          $filter['active'] = true;
        }
      }
      if(isset($filter['hidden']['c.pvisible'])) {
        $result[] = "c.pvisible = :hc_pvisible";
        $prms['hc_pvisible'] = $filter['hidden']["c.pvisible"];
      }
      if(!empty($result) && (count($result) > 0)) {
        $return = implode(" AND ", $result);
        $return = (!empty($return) ? " WHERE " . $return : '');
      }
    } else {
      $return = parent::BuildWhere($filter, $prms);
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
      'id' => $id, 'color' => ''
    ];
    if(isset($id)) {
      $query = "SELECT * FROM " . static::$table . " WHERE id=:id";
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
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER" : " LEFT";
    $query .= " JOIN shop_product_colors b ON b.colorId = a.id";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER JOIN shop_products c ON c.pid = b.prodId" : '';
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
    $query = "SELECT a.id, a.color, count(b.prodId) AS amount";
    $query .= " FROM " . static::$table . " a";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER" : " LEFT";
    $query .= " JOIN shop_product_colors b ON b.colorId = a.id";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER JOIN shop_products c ON c.pid = b.prodId" : '';
    $query .= static::BuildWhere($filter, $prms);
    $query .= " GROUP BY a.id, a.color";
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
       * @var string $color
       */
      if(isset($id)) {
        $query = 'UPDATE ' . static::$table . ' SET color = :color WHERE id = :id';
        $res = static::Query($query, ['id' => $id, 'color' => $color]);
        if(!$res) throw new Exception(static::Error());
      } else {
        $query = 'INSERT INTO ' . static::$table . '(color) VALUE (:color)';
        $res = static::Query($query, ['color' => $color]);
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
   * @throws \Exception
   */
  public static function Delete($id){
    static::BeginTransaction();
    try {
      if(isset($id)) {
        $query = "SELECT COUNT(*) FROM shop_product_colors WHERE colorId = :id";
        $res = static::Query($query, ['id' => $id]);
        if($res) {
          $amount = static::FetchArray($res)[0];
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
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