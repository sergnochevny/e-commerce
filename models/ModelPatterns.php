<?php

namespace models;

use app\core\App;
use app\core\model\ModelBase;
use controllers\ControllerAdmin;
use Exception;

/**
 * Class ModelPatterns
 * @package models
 */
class ModelPatterns extends ModelBase{

  /**
   * @var string
   */
  protected static $table = 'shop_patterns';

  /**
   * @param $filter
   * @param null $prms
   * @return array|string
   * @throws \Exception
   */
  public static function build_where(&$filter, &$prms = null){
    if(isset($filter['hidden']['view']) && $filter['hidden']['view']) {
      $result = "";
      $prms = [];
      if(!empty($filter["a.pattern"])) {
        if(ControllerAdmin::is_logged()) {
          foreach(array_filter(explode(' ', $filter["a.pattern"])) as $idx => $item) {
            if(!empty($item)) {
              $result[] = "a.pattern LIKE :a_pattern" . $idx . "";
              $prms['a_pattern' . $idx] = '%' . $item . '%';
            }
          }
        } else {
          list($result[], $prms) = ModelSynonyms::build_synonyms_like_p("a.pattern", $filter["a.pattern"]);
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
        $result = implode(" AND ", $result);
        $result = (!empty($result) ? " WHERE " . $result : '');
      }
    } else {
      $result = parent::build_where($filter, $prms);
    }

    return $result;
  }

  /**
   * @param $id
   * @return array|null
   * @throws \Exception
   */
  public static function get_by_id($id){
    $response = [
      'id' => $id, 'pattern' => ''
    ];
    if(isset($id)) {
      $query = "SELECT * FROM " . static::$table . " WHERE id=:id";
      $result = static::query($query, ['id' => $id]);
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
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER" : " LEFT";
    $query .= " JOIN shop_product_patterns b ON b.patternId = a.id";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ?
      " INNER JOIN shop_products c ON c.pid = b.prodId" : '';
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
    $query = "SELECT a.id, a.pattern, count(b.prodId) AS amount";
    $query .= " FROM " . static::$table . " a";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER" : " LEFT";
    $query .= " JOIN shop_product_patterns b ON b.patternId = a.id";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ?
      " INNER JOIN shop_products c ON c.pid = b.prodId" : '';
    $query .= static::build_where($filter, $prms);
    $query .= " GROUP BY a.id, a.pattern";
    $query .= static::build_order($sort, $prms);
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
    try {
      extract($data);
      /**
       * @var integer $id
       * @var string $pattern
       * @var
       */
      if(isset($id)) {
        $query = "UPDATE " . static::$table . " SET pattern = :pattern WHERE id = :id";
        $res = static::query($query, ['pattern' => $pattern, 'id' => $id]);
        if(!$res) throw new Exception(static::error());
      } else {
        $query = "INSERT INTO " . static::$table . " (pattern) VALUE (:pattern)";
        $res = static::query($query, ['pattern' => $pattern]);
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
   * @throws \Exception
   */
  public static function delete($id){
    static::transaction();
    try {
      if(isset($id)) {
        $query = "SELECT count(*) FROM shop_product_patterns WHERE patternId = :id";
        $res = static::query($query, ['id' => $id]);
        if($res) {
          $amount = static::fetch_array($res)[0];
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
        $query = "DELETE FROM  " . static::$table . " WHERE id = :id";
        $res = static::query($query, ['id' => $id]);
        if(!$res) throw new Exception(static::error());
      }
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }
  }

}