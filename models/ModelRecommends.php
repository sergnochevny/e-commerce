<?php

namespace models;

use app\core\App;
use app\core\model\ModelBase;

/**
 * Class ModelRecommends
 * @package models
 */
class ModelRecommends extends ModelBase{

  /**
   * @var string
   */
  protected static $table = 'shop_products';

  /**
   * @param $filter
   * @param null $prms
   * @return array|string
   * @throws \Exception
   */
  public static function build_where(&$filter, &$prms = null){
    $result = "";
    if(isset($filter["a.pname"])) $result[] = ModelSynonyms::build_synonyms_like("a.pname", $filter["a.pname"]);
    if(isset($filter["a.piece"])) $result[] = "a.piece = '" . static::prepare_for_sql($filter["a.piece"]) . "'";
    if(isset($filter["a.dt"])) {
      $where = (!empty($filter["a.dt"]['from']) ? "a.dt >= '" . static::prepare_for_sql($filter["a.dt"]["from"]) . "'" : "") . (!empty($filter["a.dt"]['to']) ? " AND a.dt <= '" . static::prepare_for_sql($filter["a.dt"]["to"]) . "'" : "");
      if(strlen(trim($where)) > 0) $result[] = "(" . $where . ")";
    }
    if(isset($filter["a.pnumber"])) $result[] = "a.pnumber LIKE '%" . static::prepare_for_sql($filter["a.pnumber"]) . "%'";
    if(isset($filter["a.best"])) $result[] = "a.best = '" . static::prepare_for_sql($filter["a.best"]) . "'";
    if(isset($filter["a.specials"])) $result[] = "a.specials = '" . static::prepare_for_sql($filter["a.specials"]) . "'";
    if(isset($filter["b.cid"])) $result[] = "b.cid = '" . static::prepare_for_sql($filter["b.cid"]) . "'";
    if(!empty($filter["c.id"])) {
      if(is_array($filter["c.id"])) {
        $result[] = "c.id in (" . implode(',', $filter["c.id"]) . ")";
      } else {
        $result[] = "c.id = '" . static::prepare_for_sql($filter["c.id"]) . "'";
      }
    }
    if(!empty($filter["d.id"])) {
      if(is_array($filter["d.id"])) {
        $result[] = "d.id in (" . implode(',', $filter["d.id"]) . ")";
      } else {
        $result[] = "d.id = '" . static::prepare_for_sql($filter["d.id"]) . "'";
      }
    }
    if(isset($filter["e.id"])) $result[] = "e.id = '" . static::prepare_for_sql($filter["e.id"]) . "'";
    if(isset($filter["a.priceyard"]['from']) && !empty((float)$filter["a.priceyard"]['from'])) $result[] = "a.priceyard > '" . static::prepare_for_sql($filter["a.priceyard"]['from']) . "'";
    if(isset($filter["a.priceyard"]['to']) && !empty((float)$filter["a.priceyard"]['to'])) $result[] = "a.priceyard <= '" . static::prepare_for_sql($filter["a.priceyard"]['to']) . "'";
    if(!empty($result) && (count($result) > 0)) {
      if(strlen(trim(implode(" AND ", $result))) > 0) {
        $filter['active'] = true;
      }
    }

    if(isset($filter['hidden']["shop_orders.aid"])) $result[] = "shop_orders.aid = '" . static::prepare_for_sql($filter['hidden']["shop_orders.aid"]) . "'";
    if(isset($filter['hidden']['a.priceyard']) && !is_array($filter['hidden']['a.priceyard'])) $result[] = "a.priceyard > '" . static::prepare_for_sql($filter['hidden']["a.priceyard"]) . "'";
    if(isset($filter['hidden']['a.pvisible'])) $result[] = "a.pvisible = '" . static::prepare_for_sql($filter['hidden']["a.pvisible"]) . "'";
    if(isset($filter['hidden']["a.pnumber"])) $result[] = "a.pnumber is not null";
    if(isset($filter['hidden']["a.image1"])) $result[] = "a.image1 is not null";
    if(!empty($result)) {
      if(!empty($result) && (count($result) > 0)) {
        $result = implode(" AND ", $result);
        $result = (!empty($result) ? " WHERE " . $result : '');
      }
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
    if(!isset($filter['totalrows']) || (!empty($filter['totalrows']))) {
      $query = "SELECT COUNT(DISTINCT a.pid) ";
      $query .= " FROM shop_product_related ";
      $query .= " LEFT JOIN shop_order_details ON shop_product_related.pid = shop_order_details.product_id";
      $query .= " LEFT JOIN shop_orders ON shop_order_details.order_id = shop_orders.oid";
      $query .= " LEFT JOIN " . static::$table . " a ON shop_product_related.r_pid = a.pid";
      $query .= " LEFT JOIN shop_product_categories ON a.pid = shop_product_categories.pid";
      $query .= " LEFT JOIN shop_categories b ON shop_product_categories.cid = b.cid";
      $query .= " LEFT JOIN shop_product_colors ON a.pid = shop_product_colors.prodId";
      $query .= " LEFT JOIN shop_color c ON shop_product_colors.colorId = c.id";
      $query .= " LEFT JOIN shop_product_patterns ON a.pid = shop_product_patterns.prodId";
      $query .= " LEFT JOIN shop_patterns d ON d.id = shop_product_patterns.patternId";
      $query .= " LEFT JOIN shop_manufacturers e ON a.manufacturerId = e.id";
    } elseif(empty($filter['totalrows']) && empty($filter['firstpage'])) {
      $query = "SELECT COUNT(DISTINCT a.pid) FROM " . static::$table . " a";
      $query .= " LEFT JOIN shop_product_categories ON a.pid = shop_product_categories.pid";
      $query .= " LEFT JOIN shop_categories b ON shop_product_categories.cid = b.cid";
      $query .= " LEFT JOIN shop_product_colors ON a.pid = shop_product_colors.prodId";
      $query .= " LEFT JOIN shop_color c ON shop_product_colors.colorId = c.id";
      $query .= " LEFT JOIN shop_product_patterns ON a.pid = shop_product_patterns.prodId";
      $query .= " LEFT JOIN shop_patterns d ON d.id = shop_product_patterns.patternId";
      $query .= " LEFT JOIN shop_manufacturers e ON a.manufacturerId = e.id";
    }
    if(!empty($query)) {
      $query .= static::build_where($filter, $prms);
      if($result = static::query($query, $prms)) {
        $response = static::fetch_value($result);
        static::free_result($result);
      }
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
    if(!isset($filter['totalrows']) || (!empty($filter['totalrows']))) {
      $query = "SELECT DISTINCT a.* ";
      $query .= " FROM shop_product_related ";
      $query .= " LEFT JOIN shop_order_details ON shop_product_related.pid = shop_order_details.product_id";
      $query .= " LEFT JOIN shop_orders ON shop_order_details.order_id = shop_orders.oid";
      $query .= " LEFT JOIN " . static::$table . " a ON shop_product_related.r_pid = a.pid";
      $query .= " LEFT JOIN shop_product_categories ON a.pid = shop_product_categories.pid";
      $query .= " LEFT JOIN shop_categories b ON shop_product_categories.cid = b.cid";
      $query .= " LEFT JOIN shop_product_colors ON a.pid = shop_product_colors.prodId";
      $query .= " LEFT JOIN shop_color c ON shop_product_colors.colorId = c.id";
      $query .= " LEFT JOIN shop_product_patterns ON a.pid = shop_product_patterns.prodId";
      $query .= " LEFT JOIN shop_patterns d ON d.id = shop_product_patterns.patternId";
      $query .= " LEFT JOIN shop_manufacturers e ON a.manufacturerId = e.id";
    } elseif(empty($filter['totalrows']) && empty($filter['firstpage'])) {
      $query = "SELECT DISTINCT a.* FROM " . static::$table . " a";
      $query .= " LEFT JOIN shop_product_categories ON a.pid = shop_product_categories.pid";
      $query .= " LEFT JOIN shop_categories b ON shop_product_categories.cid = b.cid";
      $query .= " LEFT JOIN shop_product_colors ON a.pid = shop_product_colors.prodId";
      $query .= " LEFT JOIN shop_color c ON shop_product_colors.colorId = c.id";
      $query .= " LEFT JOIN shop_product_patterns ON a.pid = shop_product_patterns.prodId";
      $query .= " LEFT JOIN shop_patterns d ON d.id = shop_product_patterns.patternId";
      $query .= " LEFT JOIN shop_manufacturers e ON a.manufacturerId = e.id";
    }
    if(!empty($query)) {
      $query .= static::build_where($filter, $prms);
      $query .= static::build_order($sort);
      if($limit != 0) $query .= " LIMIT $start, $limit";
      if($result = static::query($query, $prms)) {
        $res_count_rows = static::num_rows($result);
        $sys_hide_price = ModelPrice::sysHideAllRegularPrices();
        $cart_items = isset(App::$app->session('cart')['items']) ? App::$app->session('cart')['items'] : [];
        $cart = array_keys($cart_items);
        while($row = static::fetch_array($result)) {
          $response[] = ModelShop::prepare_layout_product($row, $cart, $sys_hide_price);
        }
      }
    }

    return $response;
  }

}