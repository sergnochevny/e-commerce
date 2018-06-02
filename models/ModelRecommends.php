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
  public static function BuildWhere(&$filter, &$prms = null){
    $return = "";
    if(isset($filter["a.pname"])) {
      list($result[], $prms) = ModelSynonyms::build_synonyms_like_p("a.pname", $filter["a.pname"]);
    }
    if(isset($filter['a.piece'])) {
      $result[] = "a.piece = :apiece";
      $prms['apiece'] = $filter["a.piece"];
    }
    if(isset($filter["a.dt"])) {
      $where = '';
      if(!empty($filter["a.dt"]['from'])) {
        $where = "a.dt >= :adt_from";
        $prms['adt_from'] = $filter["a.dt"]["from"];
      }
      if(!empty($filter["a.dt"]['to'])) {
        $where .= " AND a.dt <= :adt_to";
        $prms['adt_to'] = $filter["a.dt"]["to"];
      }
      if(strlen(trim($where)) > 0) $result[] = "(" . $where . ")";
    }
    if(isset($filter["a.pnumber"])) {
      $result[] = "a.pnumber LIKE :apnumber";
      $prms['apnumber'] = '%' . $filter["a.pnumber"] . '%';
    }
    if(isset($filter["a.best"])) {
      $result[] = "a.best = :abest";
      $prms['abest'] = $filter["a.best"];
    }
    if(isset($filter["a.specials"])) {
      $result[] = "a.specials = :aspecials";
      $prms['aspecials'] = $filter["a.specials"];
    }
    if(isset($filter["b.cid"])) {
      $result[] = "b.cid = :bcid";
      $prms['bcid'] = $filter["b.cid"];
    }
    if(!empty($filter["c.id"])) {
      if(is_array($filter["c.id"])) {
        $result[] = "c.id in (" . implode(',', $filter["c.id"]) . ")";
      } else {
        $result[] = "c.id = :cid";
        $prms['cid'] = $filter["c.id"];
      }
    }
    if(!empty($filter["d.id"])) {
      if(is_array($filter["d.id"])) {
        $result[] = "d.id in (" . implode(',', $filter["d.id"]) . ")";
      } else {
        $result[] = "d.id = '" . static::PrepareForSql($filter["d.id"]) . "'";
      }
    }
    if(isset($filter["e.id"])) {
      $result[] = "e.id = :eid";
      $prms['heid'] = $filter["e.id"];
    }

    if(isset($filter["a.priceyard"]['from']) && !empty((float)$filter["a.priceyard"]['from'])) {
      $result[] = "a.priceyard > :apriceyard_from";
      $prms['apriceyard_from'] = $filter["a.priceyard"]['from'];
    }
    if(isset($filter["a.priceyard"]['to']) && !empty((float)$filter["a.priceyard"]['to'])) {
      $result[] = "a.priceyard <= :apriceyard_to";
      $prms['apriceyard_to'] = $filter["a.priceyard"]['to'];
    }

    if(!empty($result) && (count($result) > 0)) {
      if(strlen(trim(implode(" AND ", $result))) > 0) {
        $filter['active'] = true;
      }
    }

    if(isset($filter['hidden']["shop_orders.aid"])) {
      $result[] = "shop_orders.aid = :hshop_orders_aid";
      $prms['hshop_orders_aid'] = $filter['hidden']["shop_orders.aid"];
    }

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

    if(!empty($result) && (count($result) > 0)) {
      $return = implode(" AND ", $result);
      $return = (!empty($return) ? " WHERE " . $return : '');
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
      $query .= static::BuildWhere($filter, $prms);
      if($result = static::Query($query, $prms)) {
        $response = static::FetchValue($result);
        static::FreeResult($result);
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
    $response = [];
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
    }

    return $response;
  }

}