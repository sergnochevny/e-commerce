<?php

namespace models;

use app\core\App;
use app\core\model\ModelBase;
use controllers\ControllerAdmin;
use Exception;

/**
 * Class ModelFavorites
 * @package models
 */
class ModelFavorites extends ModelBase{

  /**
   * @var string
   */
  protected static $table = 'shop_product_favorites';

  /**
   * @param $filter
   * @param null $prms
   * @return array|string
   * @throws \Exception
   */
  public static function build_where(&$filter, &$prms = null){
    $result = "";
    if(isset($filter["a.pname"])) {
      if(ControllerAdmin::is_logged()) {
        foreach(array_filter(explode(' ', $filter["a.pname"])) as $idx => $item) {
          if(!empty($item)) {
            $result[] = "a.pname LIKE :a_pname" . $idx . "";
            $prms['a_pname' . $idx] = '%' . $item . '%';
          }
        }
      } else {
        $result[] = ModelSynonyms::build_synonyms_like("a.pname", $filter["a.pname"]);
      }
    }
    if(isset($filter['a.pvisible'])) {
      $result[] = "a.pvisible = :apvisible";
      $prms['apvisible'] = $filter["a.pvisible"];
    }
    if(isset($filter["a.pnumber"])) {
      $result[] = "a.pnumber LIKE :apnumber";
      $prms['apnumber'] = '%' . $filter["a.pnumber"] . '%';
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

    if(isset($filter["b.cid"])) {
      $result[] = "b.cid = :bcid";
      $prms['bcid'] = $filter["b.cid"];
    }
    if(isset($filter["c.id"])) {
      $result[] = "c.id = :cid";
      $prms['cid'] = $filter["c.id"];
    }
    if(isset($filter["d.id"])) {
      $result[] = "d.id = :did";
      $prms['did'] = $filter["d.id"];
    }
    if(isset($filter["e.id"])) {
      $result[] = "e.id = :eid";
      $prms['eid'] = $filter["e.id"];
    }
    if(isset($filter["a.best"])) {
      $result[] = "a.best = :abest";
      $prms['abest'] = $filter["a.best"];
    }
    if(isset($filter["a.specials"])) {
      $result[] = "a.specials = :aspecials";
      $prms['aspecials'] = $filter["a.specials"];
    }
    if(isset($filter["a.priceyard"]['from']) && !empty((float)$filter["a.priceyard"]['from'])) {
      $result[] = "a.priceyard > :apriceyard_from";
      $prms['apriceyard_from'] = $filter["a.priceyard"]['from'];
    }
    if(isset($filter["a.priceyard"]['to']) && !empty((float)$filter["a.priceyard"]['to'])) {
      $result[] = "a.priceyard <= :apriceyard_to";
      $prms['apriceyard_to'] = $filter["a.priceyard"]['to'];
    }

    if(isset($filter['a.piece'])) { $result[] = "a.piece = :apiece";  $prms['apiece'] = $filter["a.piece"]; }

    if(!empty($result) && (count($result) > 0)) {
      if(strlen(trim(implode(" AND ", $result))) > 0) {
        $filter['active'] = true;
      }
    }
    if(isset($filter['hidden']["z.aid"])) {
      $result[] = "z.aid = :hz_id";
      $prms['hz_id'] = $filter['hidden']["z.aid"];
    }

    if(!empty($result) && (count($result) > 0)) {
      $result = implode(" AND ", $result);
    }
    $result = " WHERE a.pnumber is not null " . (!empty($result) ? ' AND ' . $result : '');

    return $result;
  }

  /**
   * @param $pid
   * @param $aid
   * @return null
   * @throws \Exception
   */
  public static function get_by_id($pid, $aid){
    $data = null;
    $q = "SELECT * FROM " . self::$table;
    $q .= " where pid = :pid and aid = :aid";
    $res = static::query($q, ['aid' => $aid, 'pid' => $pid]);
    if($res) {
      $data = static::fetch_assoc($res);
    } else {
      throw new Exception(static::error());
    }

    return $data;
  }

  /**
   * @param null $filter
   * @return int|null
   * @throws \Exception
   */
  public static function get_total_count($filter = null){
    $response = 0;
    $query = "SELECT COUNT(DISTINCT a.pid) FROM " . static::$table . " z";
    $query .= " LEFT JOIN shop_products a ON a.pid = z.pid";
    $query .= " LEFT JOIN shop_product_categories ON a.pid = shop_product_categories.pid";
    $query .= " LEFT JOIN shop_categories b ON shop_product_categories.cid = b.cid";
    $query .= " LEFT JOIN shop_product_colors ON a.pid = shop_product_colors.prodId";
    $query .= " LEFT JOIN shop_color c ON shop_product_colors.colorId = c.id";
    $query .= " LEFT JOIN shop_product_patterns ON a.pid = shop_product_patterns.prodId";
    $query .= " LEFT JOIN shop_patterns d ON d.id = shop_product_patterns.patternId";
    $query .= " LEFT JOIN shop_manufacturers e ON a.manufacturerId = e.id";
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
    $query = "SELECT DISTINCT z.id, a.* FROM " . static::$table . " z";
    $query .= " LEFT JOIN shop_products a ON a.pid = z.pid";
    $query .= " LEFT JOIN shop_product_categories ON a.pid = shop_product_categories.pid";
    $query .= " LEFT JOIN shop_categories b ON shop_product_categories.cid = b.cid";
    $query .= " LEFT JOIN shop_product_colors ON a.pid = shop_product_colors.prodId";
    $query .= " LEFT JOIN shop_color c ON shop_product_colors.colorId = c.id";
    $query .= " LEFT JOIN shop_product_patterns ON a.pid = shop_product_patterns.prodId";
    $query .= " LEFT JOIN shop_patterns d ON d.id = shop_product_patterns.patternId";
    $query .= " LEFT JOIN shop_manufacturers e ON a.manufacturerId = e.id";
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
       * @var integer $aid
       * @var integer $pid
       */
      $query = "REPLACE INTO " . static::$table . " (aid, pid) VALUE (:aid, :pid)";
      $res = static::query($query, ['aid' => $aid, 'pid' => $pid]);
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