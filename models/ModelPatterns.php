<?php

namespace models;

use app\core\model\ModelBase;
use classes\helpers\AdminHelper;
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
  public static function BuildWhere(&$filter, &$prms = null){
    $return = "";
    if(isset($filter['hidden']['view']) && $filter['hidden']['view']) {
      $prms = [];
      if(!empty($filter["a.pattern"])) {
        if(AdminHelper::is_logged()) {
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
      'id' => $id, 'pattern' => ''
    ];
    if(isset($id)) {
      $query = "SELECT * FROM " . static::$table . " WHERE id=:id";
      $result = static::Query($query, ['id' => $id]);
      if($result) $response = static::FetchAssoc($result);
    }

    if($response === false) {
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
    $query .= " JOIN shop_product_patterns b ON b.patternId = a.id";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ?
      " INNER JOIN shop_products c ON c.pid = b.prodId" : '';
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
    $query = "SELECT a.id, a.pattern, count(b.prodId) AS amount";
    $query .= " FROM " . static::$table . " a";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER" : " LEFT";
    $query .= " JOIN shop_product_patterns b ON b.patternId = a.id";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ?
      " INNER JOIN shop_products c ON c.pid = b.prodId" : '';
    $query .= static::BuildWhere($filter, $prms);
    $query .= " GROUP BY a.id, a.pattern";
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
       * @var string $pattern
       * @var
       */
      if(isset($id)) {
        $query = "UPDATE " . static::$table . " SET pattern = :pattern WHERE id = :id";
        $res = static::Query($query, ['pattern' => $pattern, 'id' => $id]);
        if(!$res) throw new Exception(static::Error());
      } else {
        $query = "INSERT INTO " . static::$table . " (pattern) VALUE (:pattern)";
        $res = static::Query($query, ['pattern' => $pattern]);
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
        $query = "SELECT count(*) FROM shop_product_patterns WHERE patternId = :id";
        $res = static::Query($query, ['id' => $id]);
        if($res) {
          $amount = static::FetchArray($res)[0];
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
        $query = "DELETE FROM  " . static::$table . " WHERE id = :id";
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