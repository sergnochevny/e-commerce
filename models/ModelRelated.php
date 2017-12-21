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
   * @return array|string
   */
  protected static function build_where(&$filter, &$prms = null){
    $result = "";
    if(isset($filter['hidden']['b.pvisible'])) $result[] = "b.pvisible = '" . static::prepare_for_sql($filter['hidden']["b.pvisible"]) . "'";
    if(isset($filter['hidden']["b.pnumber"])) $result[] = "b.pnumber is not null";
    if(isset($filter['hidden']["b.image1"])) $result[] = "b.image1 is not null";
    if(isset($filter['hidden']["a.pid"])) $result[] = "a.pid = '" . static::prepare_for_sql($filter['hidden']["a.pid"]) . "'";
    if(!empty($result) && (count($result) > 0)) {
      $result = implode(" AND ", $result);
    }
    $result = " WHERE b.priceyard > 0 and b.pnumber is not null and b.pvisible = '1'  and b.image1 is not null" . (!empty($result) ? ' AND ' . $result : '');

    return $result;
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
      $query = "SELECT * FROM " . static::$table . " WHERE id='$id'";
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
    $query = "SELECT COUNT(DISTINCT a.id) FROM " . static::$table . " a";
    $query .= " LEFT JOIN shop_products b ON b.pid = a.r_pid";
    $query .= " LEFT JOIN shop_products c ON c.pid = a.pid";
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
    $query = "SELECT DISTINCT c.pid AS cpid, c.pname AS cpname, b.* FROM " . static::$table . " a";
    $query .= " LEFT JOIN shop_products b ON b.pid = a.r_pid";
    $query .= " LEFT JOIN shop_products c ON c.pid = a.pid";
    $query .= static::build_where($filter);
    $query .= static::build_order($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";

    if($result = static::query($query)) {
      $res_count_rows = static::num_rows($result);
      $sys_hide_price = ModelPrice::sysHideAllRegularPrices();
      $cart_items = isset(App::$app->session('cart')['items']) ? App::$app->session('cart')['items'] : [];
      $cart = array_keys($cart_items);
      while($row = static::fetch_array($result)) {
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
  public static function save(&$data){
    static::transaction();
    try {
      extract($data);
      /**
       * @var integer $pid
       * @var integer $r_pid
       */
      $query = "REPLACE INTO " . static::$table . " (pid, r_pid) VALUE ('" . $pid . "', '" . $r_pid . "')";
      $res = static::query($query);
      if(!$res) throw new Exception(static::error());
      $id = static::last_id();
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
        $query = "DELETE FROM  " . static::$table . " WHERE id = $id";
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