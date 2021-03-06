<?php

namespace models;

use app\core\App;
use app\core\model\ModelBase;
use Exception;

/**
 * Class ModelOrders
 * @package models
 */
class ModelOrders extends ModelBase{

  /**
   * @var string
   */
  protected static $table = 'shop_orders';

  /**
   * @param $filter
   * @param null $prms
   * @return array|string
   */
  public static function BuildWhere(&$filter, &$prms = null){
    $return = "";
    if(isset($filter["a.aid"])) $result[] = "a.aid = '" . static::PrepareForSql($filter['a.aid']) . "'";
    if(!empty($filter['username'])) foreach(array_filter(explode(' ', $filter['username'])) as $item) if(!empty($item)) $result[] = "CONCAT(b.bill_firstname,' ',b.bill_lastname) LIKE '%" . static::PrepareForSql($item) . "%'";
    if(isset($filter["a.status"])) $result[] = "a.status = '" . static::PrepareForSql($filter["a.status"]) . "'";
    if(isset($filter["a.order_date"])) {
      $where = (!empty($filter["a.order_date"]['from']) ? "a.order_date >= '" . strtotime(static::PrepareForSql($filter["a.order_date"]["from"])) . "'" : "") . (!empty($filter["a.order_date"]['to']) ? " AND a.order_date <= '" . strtotime(static::PrepareForSql($filter["a.order_date"]["to"])) . "'" : "");
      if(strlen(trim($where)) > 0) $result[] = "(" . $where . ")";
    }
    if(isset($filter["a.trid"])) $result[] = "a.trid LIKE '%" . implode('%', array_filter(explode(' ', static::PrepareForSql($filter["a.trid"])))) . "%'";
    if(isset($filter["c.sid"])) $result[] = "c.sid = '" . static::PrepareForSql($filter["c.sid"]) . "'";

    if(!empty($result) && (count($result) > 0)) {
      if(strlen(trim(implode(" AND ", $result))) > 0) {
        $filter['active'] = true;
      }
    }
    if(isset($filter['hidden']["a.aid"])) $result[] = "a.aid = '" . static::PrepareForSql($filter['hidden']['a.aid']) . "'";
    if(isset($filter['hidden']["c.sid"])) $result[] = "c.sid = '" . static::PrepareForSql($filter['hidden']["c.sid"]) . "'";

    if(!empty($result) && (count($result) > 0)) {
      $return = implode(" AND ", $result);
      if(strlen(trim($return)) > 0) {
        $return = " WHERE " . $return;
      }
    }

    return $return;
  }

  /**
   * @param $arr
   * @return array|bool|null
   * @throws \Exception
   */
  public static function getOrderDetailInfo($arr){
    if(isset($arr) && count($arr) === 1) {
      $result = null;

      $query = '
               SELECT
                fod.*,
                fo.*
                  
                FROM
                    shop_order_details fod
                LEFT JOIN
                    shop_orders fo
                ON
                    fod.order_id = fo.oid
                WHERE
                    fo.oid = ' . $arr['oid'] . '
            ';

      $res = static::Query($query);
      if($res) {
        while($row = static::FetchAssoc($res)) {
          $result[] = $row;
        }
      }

      return $result;
    }

    return false;
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
      if(isset($oid)) {
        $query = "UPDATE " . static::$table . " SET status = '" . $status . "'," . " track_code = '" . $track_code . "'," . " end_date = STR_TO_DATE('" . $end_date . "', '%m/%d/%Y')" . " WHERE oid = '" . $oid . "'";
        $res = static::Query($query);
        if(!$res) throw new Exception(static::Error());
      }
      static::Commit();
    } catch(Exception $e) {
      static::RollBack();
      throw $e;
    }

    return $oid;
  }

  /**
   * @param $id
   * @return array|null
   * @throws \Exception
   */
  public static function get_by_id($id){
    $response = [
      'oid' => $id, 'track_code' => '', 'status' => '', 'order_date' => '', 'end_date' => '',
    ];
    if(isset($id)) {
      $query = "SELECT * FROM " . static::$table . " WHERE oid='$id'";
      $result = static::Query($query);
      if($result) $response = static::FetchAssoc($result);
    }

    if ($response === false){
      throw new Exception('Data set is empty!');
    }
    return $response;
  }

  /**
   * @param $id
   * @return array|null
   * @throws \Exception
   */
  public static function get_list_by_discount_id($id){
    if(isset($id)) {
      $query = "SELECT orders.*, CONCAT(users.bill_firstname,' ',users.bill_lastname) AS username FROM shop_specials_usage spec_usage ";
      $query .= "LEFT JOIN shop_orders orders ON spec_usage.oid = orders.oid ";
      $query .= "LEFT JOIN accounts users ON orders.aid = users.aid ";
      $query .= "WHERE spec_usage.sid = '$id'";
      if($result = static::Query($query)) {
        $rows = [];
        while($row = static::FetchArray($result)) {
          $rows[] = $row;
        }

        return $rows;
      }
    }

    return null;
  }

  /**
   * @param null $filter
   * @return int|null
   * @throws \Exception
   */
  public static function get_total_count($filter = null){
    $response = 0;
    $query = "SELECT COUNT(DISTINCT a.oid)";
    $query .= " from shop_orders a";
    $query .= " left join accounts b on a.aid = b.aid";
    $query .= " left join shop_specials_usage c on a.oid = c.oid";
    $query .= static::BuildWhere($filter, $prms);
    if($result = static::Query($query)) {
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
    $query = "select";
    $query .= " DISTINCT a.*, CONCAT(b.bill_firstname,' ',b.bill_lastname) as username";
    $query .= " from shop_orders a";
    $query .= " left join accounts b on a.aid = b.aid";
    $query .= " left join shop_specials_usage c on a.oid = c.oid";
    $query .= static::BuildWhere($filter, $prms);
    $query .= static::BuildOrder($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";

    if($result = static::Query($query)) {
      $res_count_rows = static::getNumRows($result);
      while($row = static::FetchArray($result)) {
        $response[] = $row;
      }
    }

    return $response;
  }

  /**
   * @param $aid
   * @param $trid
   * @param $shipping_type
   * @param $shipping_cost
   * @param $on_roll
   * @param $express_samples
   * @param $handling
   * @param $shipping_discount
   * @param $coupon_discount
   * @param $total_discount
   * @param $taxes
   * @param $total
   * @return mixed|null
   * @throws \Exception
   */
  public static function register_order($aid, $trid, $shipping_type, $shipping_cost, $on_roll, $express_samples, $handling, $shipping_discount, $coupon_discount, $total_discount, $taxes, $total){

    $rate_handling = (!is_null(App::$app->KeyStorage()->shop_rate_handling) ? App::$app->KeyStorage()->shop_rate_handling : RATE_HANDLING);

    $q = "INSERT INTO shop_orders (" . "aid, trid, shipping_type, shipping_cost, on_roll," . " roll_cost, express_samples, on_handling, handling, shipping_discount," . " coupon_discount, total_discount, taxes, total, order_date," . " samples_express_cost, samples_single_cost, samples_multiple_cost," . " samples_additional_cost, samples_products_cost, samples_min_qty," . " samples_max_qty)" . " VALUES (%u, '%s', %u, %01.2f, %u," . " %01.2f, %u, %u, %01.2f, %01.2f," . " %01.2f, %01.2f, %01.2f, %01.2f, %u," . " %01.2f, %01.2f, %01.2f," . " %01.2f, %01.2f, %01.2f," . " %01.2f)";

    $sSQL = sprintf($q, $aid, $trid, $shipping_type, str_replace(",", "", $shipping_cost), $on_roll, str_replace(",", "", RATE_ROLL), str_replace(",", "", $express_samples), $handling, str_replace(",", "", $rate_handling), str_replace(",", "", $shipping_discount), str_replace(",", "", $coupon_discount), str_replace(",", "", $total_discount), str_replace(",", "", $taxes), str_replace(",", "", $total), time(), (!is_null(App::$app->KeyStorage()->shop_samples_price_express_shipping) ? App::$app->KeyStorage()->shop_samples_price_express_shipping : SAMPLES_PRICE_EXPRESS_SHIPPING), (!is_null(App::$app->KeyStorage()->shop_samples_price_single) ? App::$app->KeyStorage()->shop_samples_price_single : SAMPLES_PRICE_SINGLE), (!is_null(App::$app->KeyStorage()->shop_samples_price_multiple) ? App::$app->KeyStorage()->shop_samples_price_multiple : SAMPLES_PRICE_MULTIPLE), (!empty($data['shop_samples_price_additional']) ? $data['shop_samples_price_additional'] : SAMPLES_PRICE_ADDITIONAL), (!empty($data['shop_samples_price_with_products']) ? $data['shop_samples_price_with_products'] : SAMPLES_PRICE_WITH_PRODUCTS), (!empty($data['shop_samples_qty_multiple_min']) ? $data['shop_samples_qty_multiple_min'] : SAMPLES_QTY_MULTIPLE_MIN), (!empty($data['shop_samples_qty_multiple_max']) ? $data['shop_samples_qty_multiple_max'] : SAMPLES_QTY_MULTIPLE_MAX));

    $res = static::Query($sSQL);
    if($res) return static::LastId();

    return null;
  }

  /**
   * @param $order_id
   * @param $product_id
   * @param $product_number
   * @param $product_name
   * @param $quantity
   * @param $price
   * @param $discount
   * @param $sale_price
   * @param int $is_sample
   * @return mixed
   * @throws \Exception
   */
  public static function insert_order_detail($order_id, $product_id, $product_number, $product_name, $quantity, $price, $discount, $sale_price, $is_sample = 0){
    $q = "INSERT INTO  shop_order_details " . "(order_id, product_id, product_number, product_name, quantity, price, discount, sale_price, is_sample)" . " VALUES (%u, %u,'%s', '%s', '%s','%s', '%s', '%s', %u);";
    $sql = sprintf($q, $order_id, $product_id, $product_number, $product_name, $quantity, $price, $discount, $sale_price, $is_sample);
    $res = static::Query($sql);

    return $res;
  }

  /**
   * @param $discountIds
   * @param $oid
   * @throws \Exception
   */
  public static function save_discount_usage($discountIds, $oid){
    if(isset($discountIds) && is_array($discountIds) && (count($discountIds) > 0)) {
      $discounts = array_unique($discountIds, SORT_NUMERIC);
      $delete = sprintf("DELETE FROM shop_specials_usage WHERE oid = %u", $oid);
      $res = static::Query($delete);
      foreach($discounts as $sid) {
        $sSQL = sprintf("INSERT INTO shop_specials_usage (sid, oid) VALUES (%u, %u)", $sid, $oid);
        static::Query($sSQL);
      }
    }
  }

  /**
   * @param $oid
   * @return array|bool
   * @throws \Exception
   */
  public static function get_order_details($oid){
    $results = static::Query("select * from shop_order_details WHERE order_id='$oid'");
    if($results) {
      $rows = [];
      while($row = static::FetchArray($results)) {
        $rows[] = $row;
      }

      return $rows;
    }

    return false;
  }

}