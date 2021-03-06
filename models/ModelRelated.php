<?php

namespace models;

use app\core\App;
use app\core\model\ModelBase;
use Exception;

/**
 * Class ModelRelated
 * @package models
 */
class ModelRelated extends ModelBase{

  /**
   * @var string
   */
  protected static $table = 'shop_product_related';

  /**
   * @param $filter
   * @param null $prms
   * @return string
   */
  public static function BuildWhere(&$filter, &$prms = null){
    $return = "";
    if(isset($filter['hidden']['a.priceyard']) && !is_array($filter['hidden']['a.priceyard'])) {
      $result[] = "a.priceyard > :hapriceyard";
      $prms['hapriceyard'] = $filter['hidden']["a.priceyard"];
    }
    if(isset($filter['hidden']['a.pvisible'])) {
      $result[] = "a.pvisible = :hapvisible";
      $prms['hapvisible'] = $filter['hidden']["a.pvisible"];
    }
    if(isset($filter['hidden']["a.pnumber"])) $result[] = "a.pnumber is not null";
    if(isset($filter['hidden']["a.image1"])) $result[] = "a.image1 is not null";

    if(isset($filter['hidden']['b.priceyard']) && !is_array($filter['hidden']['b.priceyard'])) {
      $result[] = "b.priceyard > :hbpriceyard";
      $prms['hbpriceyard'] = $filter['hidden']["b.priceyard"];
    }
    if(isset($filter['hidden']['b.pvisible'])) {
      $result[] = "b.pvisible = :hbpvisible";
      $prms['hbpvisible'] = $filter['hidden']["b.pvisible"];
    }
    if(isset($filter['hidden']["b.pnumber"])) $result[] = "b.pnumber is not null";
    if(isset($filter['hidden']["b.image1"])) $result[] = "b.image1 is not null";

    if(isset($filter['hidden']["a.pid"])) {
      $result[] = "a.pid = :ha_pid";
      $prms['ha_pid'] = $filter['hidden']["a.pid"];
    }
    if(!empty($result) && (count($result) > 0)) {
      $return = implode(" AND ", $result);
    }
    $return = !empty($return) ? " WHERE " . $return : '';

    return $return;
  }

  /**
   * @param $id
   * @return array|null
   * @throws \Exception
   */
  public static function get_by_id($id){
    $response = [
      'id' => $id, 'pid' => '', 'r_pid' => ''
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
    $query .= " LEFT JOIN shop_products b ON b.pid = a.r_pid";
    $query .= " LEFT JOIN shop_products c ON c.pid = a.pid";
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
    $query = "SELECT DISTINCT c.pid AS cpid, c.pname AS cpname, b.* FROM " . static::$table . " a";
    $query .= " LEFT JOIN shop_products b ON b.pid = a.r_pid";
    $query .= " LEFT JOIN shop_products c ON c.pid = a.pid";
    $query .= static::BuildWhere($filter, $prms);
    $query .= static::BuildOrder($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";

    if($result = static::Query($query, $prms)) {
      $res_count_rows = static::getNumRows($result);
      $sys_hide_price = ModelPrice::sysHideAllRegularPrices();
      $cart_items = isset(App::$app->session('cart')['items']) ? App::$app->session('cart')['items'] : [];
      $cart = array_keys($cart_items);
      while($row = static::FetchArray($result)) {
        $response[] = ModelShop::prepare_layout_product($row, $cart, $sys_hide_price);
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
       * @var integer $pid
       * @var integer $r_id
       */
      $query = "REPLACE INTO " . static::$table . "(pid, r_pid) VALUE (:pid, :r_pid)";
      $res = static::Query($query, ['pid' => $pid, 'r_id' => $r_id]);
      if(!$res) throw new Exception(static::Error());
      $id = static::LastId();
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