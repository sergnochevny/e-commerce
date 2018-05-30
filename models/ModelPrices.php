<?php

namespace models;

use app\core\model\ModelBase;

/**
 * Class ModelPrices
 * @package models
 */
class ModelPrices extends ModelBase{

  /**
   * @var string
   */
  protected static $table = 'shop_products';

  /**
   * @var array
   */
  public static $price_parceling = [
    1 => ['max_price' => 15, 'title' => '$15.00 and under'],
    2 => ['min_price' => 15, 'max_price' => 30, 'title' => '$15.01 to $30.00'],
    3 => ['min_price' => 30, 'max_price' => 55, 'title' => '$30.01 to $55.00'],
    4 => ['min_price' => 55, 'max_price' => 75, 'title' => '$55.01 to $75.00'],
    5 => ['min_price' => 75, 'title' => '$75.01 and above'],
  ];
//      [
//        ['max_price' => 15, 'title' => '$15.00 and under'],
//        ['min_price' => 15, 'max_price' => 30, 'title' => '$15.01 to $30.00'],
//        ['min_price' => 30, 'max_price' => 55, 'title' => '$30.01 to $55.00'],
//        ['min_price' => 55, 'max_price' => 75, 'title' => '$55.01 to $75.00'],
//        ['min_price' => 75, 'max_price' => 100, 'title' => '$75.01 to $100.00'],
//        ['min_price' => 100, 'max_price' => 150, 'title' => '$100.01 to $150.00'],
//        ['min_price' => 150, 'max_price' => 200, 'title' => '$150.01 to $200.00'],
//        ['min_price' => 200, 'title' => '$200.01 and above'],
//      ];

  /**
   * @param $filter
   * @param null $prms
   * @return array|string
   */
  public static function BuildWhere(&$filter, &$prms = null){
    $return = "";
    if(isset($filter['hidden']['view']) && $filter['hidden']['view']) {
      $prms = [];
      if(isset($filter['hidden']['a.priceyard'])) {
        $result[] = "a.priceyard > :ha_priceyard";
        $prms['ha_priceyard'] = $filter['hidden']["a.priceyard"];
      }
      if(isset($filter['hidden']['a.pvisible'])) {
        $result[] = "a.pvisible = :hc_pvisible";
        $prms['hc_pvisible'] = $filter['hidden']["a.pvisible"];
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
   * @return int|void
   */
  public static function get_total_count($filter = null){
    $response = count(static::$price_parceling); //PRICE_GROUPS_COUNT;

    return $response;
  }

  /**
   * @param $id
   * @return array|null
   */
  public static function get_by_id($id){
    $response = [];
    if(isset(static::$price_parceling[$id])) {
      $response = array_filter(static::$price_parceling[$id]);
      $response['id'] = $id;
    }

    if ($response === false){
      throw new Exception('Data set is empty!');
    }
    return $response;
  }

  /**
   * @param $start
   * @param $limit
   * @param $res_count_rows
   * @param null $filter
   * @param null $sort
   * @return array
   */
  public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null){
    $res_count_rows = count(static::$price_parceling);
    if(empty($start) && empty($limit)) {
      $start = 0;
      $limit = count(static::$price_parceling);
    }
    $response = array_slice(static::$price_parceling, $start, $limit, true);
    foreach($response as $key => $row) $response[$key]['id'] = $key;

    return $response;
  }

//    public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null) {
//      $response = [];
//      $query = "SELECT COUNT(a.pid) as count";
//      $query .= " FROM " . static::$table . " a";
//      $query .= static::BuildWhere($filter, $prms);
//      $query .= static::BuildOrder($sort);
//
//      $res_count_rows = PRICE_GROUPS_COUNT;
//
//      if($result = static::Query( $query)) {
//        $row = static::FetchArray($result);
//        $count = $row['count'];
//        $step = ceil($count / $res_count_rows);
//        $limit = $limit + $start;
//        if($limit > $res_count_rows) $limit = $res_count_rows;
////      true - Over UNION SELECT;
//        if(true) {
//          $query = '';
//          while($start < $limit) {
//            $from = $start++ * $step;
//            if(!empty($query)) $query .= " UNION ";
//            $query .= "SELECT MIN(s.priceyard) as min_price, MAX(s.priceyard) as max_price";
//            $query .= " FROM (";
//            $query .= "SELECT * FROM " . static::$table . " a";
//            $query .= static::BuildWhere($filter, $prms);
//            $query .= " ORDER BY a.priceyard";
//            $query .= " LIMIT " . $from . "," . $step;
//            $query .= ") s";
//          }
//          if($result = static::Query( $query)) {
//            while($row = static::FetchArray($result)) {
//              $min_price = round($row['min_price']);
//              $max_price = round($row['max_price']);
//              $response[] = ['min_price' => $min_price, 'max_price' => $max_price];
//            }
//          }
//        } else {
//          while($start < $limit) {
//            $from = (int)$start++ * $step;
//            $query = "SELECT MIN(s.priceyard) as min_price, MAX(s.priceyard) as max_price";
//            $query .= " FROM (";
//            $query .= "SELECT * FROM " . static::$table . " a";
//            $query .= static::BuildWhere($filter, $prms);
//            $query .= " ORDER BY a.priceyard";
//            $query .= " LIMIT " . $from . "," . $step;
//            $query .= ") s";
//            if($result = static::Query( $query)) {
//              $row = static::FetchArray($result);
//              $response[] = ['min_price' => $row['min_price'], 'max_price' => $row['max_price']];
//            }
//          }
//        }
//      }
//      return $response;
//    }

}