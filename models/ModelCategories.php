<?php

namespace models;

use app\core\model\ModelBase;
use classes\helpers\AdminHelper;
use Exception;

/**
 * Class ModelCategories
 * @package models
 */
class ModelCategories extends ModelBase{

  /**
   * @var string
   */
  protected static $table = 'shop_categories';

  /**
   * @param $filter
   * @param null $prms
   * @return string
   * @throws \Exception
   */
  public static function BuildWhere(&$filter, &$prms = null){
    $return = "";
    if(isset($filter['hidden']['view']) && $filter['hidden']['view']) {
      $prms = [];
      if(!empty($filter["a.cname"])) {
        if(AdminHelper::is_logged()) {
          foreach(array_filter(explode(' ', $filter["a.cname"])) as $idx => $item) {
            if(!empty($item)) {
              $result[] = "a.cname LIKE :a_cname" . $idx . "";
              $prms['a_cname' . $idx] = '%' . $item . '%';
            }
          }
        } else {
          list($result[], $prms) = ModelSynonyms::build_synonyms_like_p("a.cname", $filter["a.cname"]);
        }
      }
      if(isset($filter["a.cid"])) {
        $result[] = "a.cid = :a_cid";
        $prms['a_cid'] = $filter["a.cid"];
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
   * @param null $filter
   * @return int|null
   * @throws \Exception
   */
  public static function get_total_count($filter = null){
    $response = 0;
    $query = "SELECT COUNT(DISTINCT a.cid) FROM " . self::$table . " a";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER" : " LEFT";
    $query .= " JOIN shop_product_categories b ON b.cid = a.cid";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER JOIN shop_products c ON c.pid = b.pid" : '';
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
    $query = "SELECT DISTINCT a.*, count(b.pid) AS amount";
    $query .= " FROM shop_categories a";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER" : " LEFT";
    $query .= " JOIN shop_product_categories b ON b.cid = a.cid";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ?
      " INNER JOIN shop_products c ON c.pid = b.pid" : '';
    $query .= static::BuildWhere($filter, $prms);
    $query .= " GROUP BY a.cid, a.cname";
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
   * @param $id
   * @return array|mixed
   * @throws \Exception
   */
  public static function get_by_id($id){
    $data = [
      'cid' => $id, 'cname' => '', 'displayorder' => ''
    ];
    if(!isset($id)) {
      $result = static::Query("SELECT max(displayorder)+1 FROM shop_categories");
      if($result) {
        $data['displayorder'] = static::FetchValue($result);
      }
    } else {
      $result = static::Query("SELECT * FROM shop_categories WHERE cid= :cid", ['cid' => $id]);
      if($result) {
        $data = static::FetchArray($result);
      }
    }

    if ($data === false){
      throw new Exception('Data set is empty!');
    }

    return $data;
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
       * @var integer $displayorder
       * @var integer $cid
       * @var string $cname
       */
      if(!empty($cid)) {
        $res = static::Query("SELECT * FROM shop_categories WHERE cid=:cid", ['cid' => $cid]);
        if($res) {
          $row = static::FetchArray($res);
          $_displayorder = $row['displayorder'];
          if($_displayorder != $displayorder) {
            if($res) {
              $res = static::Query(
                "UPDATE shop_categories SET displayorder=displayorder-1 WHERE displayorder > :do",
                ['do' => $_displayorder]
              );
            }
            if($res) {
              $res = static::Query(
                "UPDATE shop_categories SET displayorder=displayorder+1 WHERE displayorder >= :do",
                ['do' => $displayorder]
              );
            }
          }
          if($res) {

            $res = static::Query(
              "UPDATE shop_categories SET cname=:cname, displayorder=:displayorder WHERE cid=:cid",
              ['cid' => $cid, 'cname' => $cname, 'displayorder' => $displayorder]
            );
          }
        }
      } else {
        $res = static::Query(
          "UPDATE shop_categories SET displayorder=displayorder+1 WHERE displayorder >= :do",
          ['do' => $displayorder]
        );
        if($res) $res = static::Query(
          "insert shop_categories set cname=:cname, displayorder=:displayorder",
          ['cname' => $cname, 'displayorder' => $displayorder]
        );
        if($res) $cid = static::LastId();
      }
      if(!$res) throw new Exception(static::Error());
      static::Commit();
    } catch(Exception $e) {
      static::RollBack();
      throw $e;
    }

    return $cid;
  }

  /**
   * @param $cid
   * @throws \Exception
   */
  public static function Delete($cid){
    static::BeginTransaction();
    try {
      if(isset($cid)) {
        $query = "SELECT count(*) FROM shop_product_categories WHERE cid = :cid";
        $res = static::Query($query, ['cid' => $cid]);
        if($res) {
          $amount = static::FetchArray($res)[0];
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
        $query = "DELETE FROM shop_product_categories WHERE cid = :cid";
        $res = static::Query($query, ['cid' => $cid]);
        if(!$res) throw new Exception(static::Error());
        $query = "DELETE FROM shop_categories WHERE cid = :cid";
        $res = static::Query($query, ['cid' => $cid]);
        if(!$res) throw new Exception(static::Error());
      }
      static::Commit();
    } catch(Exception $e) {
      static::RollBack();
      throw $e;
    }
  }

}