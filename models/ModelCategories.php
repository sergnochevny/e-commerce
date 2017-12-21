<?php

namespace models;

use app\core\model\ModelBase;
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
   * @return array|string
   * @throws \Exception
   */
  protected static function build_where(&$filter, &$prms = null){
    if(isset($filter['hidden']['view']) && $filter['hidden']['view']) {
      $result = "";
      if(ControllerAdmin::is_logged()) {
        if(!empty($filter["a.cname"])) foreach(array_filter(explode(' ', $filter["a.cname"])) as $item) if(!empty($item)) $result[] = "a.cname LIKE '%" . static::prepare_for_sql($item) . "%'";
      } else {
        if(isset($filter["a.cname"])) $result[] = ModelSynonyms::build_synonyms_like("a.cname", $filter["a.cname"]);
      }
      if(isset($filter["a.cid"])) $result[] = "a.cid = '" . static::prepare_for_sql($filter["a.cid"]) . "'";
      if(!empty($result) && (count($result) > 0)) {
        if(strlen(trim(implode(" AND ", $result))) > 0) {
          $filter['active'] = true;
        }
      }
      if(isset($filter['hidden']['c.pvisible'])) $result[] = "c.pvisible = '" . static::prepare_for_sql($filter['hidden']["c.pvisible"]) . "'";
      if(!empty($result) && (count($result) > 0)) {
        $result = implode(" AND ", $result);
        $result = (!empty($result) ? " WHERE " . $result : '');
      }
    } else {
      $result = parent::build_where($filter);
    }

    return $result;
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
    $query .= static::build_where($filter);
    if($result = static::query($query)) {
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
    $query = "SELECT DISTINCT a.*, count(b.pid) AS amount";
    $query .= " FROM shop_categories a";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER" : " LEFT";
    $query .= " JOIN shop_product_categories b ON b.cid = a.cid";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER JOIN shop_products c ON c.pid = b.pid" : '';
    $query .= static::build_where($filter);
    $query .= " GROUP BY a.cid, a.cname";
    $query .= static::build_order($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";

    if($result = static::query($query)) {
      $res_count_rows = static::num_rows($result);
      while($row = static::fetch_array($result)) {
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
      $result = static::query("SELECT max(displayorder)+1 FROM shop_categories");
      if($result) {
        $row = static::fetch_array($result);
        $data['displayorder'] = $row[0];
      }
    } else {
      $result = static::query("select * from shop_categories WHERE cid='$id'");
      if($result) {
        $data = static::fetch_array($result);
      }
    }

    return $data;
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
      if(!empty($cid)) {
        $res = static::query("select * from shop_categories WHERE cid='$cid'");
        if($res) {
          $row = static::fetch_array($res);
          $_displayorder = $row['displayorder'];
          if($_displayorder != $displayorder) {
            if($res) $res = static::query("update shop_categories set displayorder=displayorder-1 WHERE displayorder > $_displayorder");
            if($res) $res = static::query("update shop_categories set displayorder=displayorder+1 WHERE displayorder >= $displayorder");
          }
          if($res) $res = static::query("update shop_categories set cname='$cname', displayorder='$displayorder' WHERE cid ='$cid'");
        }
      } else {
        $res = static::query("update shop_categories set displayorder=displayorder+1 WHERE displayorder >= $displayorder");
        if($res) $res = static::query("insert shop_categories set cname='$cname', displayorder='$displayorder'");
        if($res) $cid = static::last_id();
      }
      if(!$res) throw new Exception(static::error());
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }

    return $cid;
  }

  /**
   * @param $id
   * @throws \Exception
   */
  public static function delete($id){
    static::transaction();
    try {
      if(isset($id)) {
        $query = "select count(*) from shop_product_categories where cid = $id";
        $res = static::query($query);
        if($res) {
          $amount = static::fetch_array($res)[0];
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
        $query = "delete from shop_product_categories WHERE cid = $id";
        $res = static::query($query);
        if(!$res) throw new Exception(static::error());
        $query = "DELETE FROM shop_categories WHERE cid = $id";
        $res = static::query($query);
        if(!$res) throw new Exception(static::error());
      }
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }
  }

}