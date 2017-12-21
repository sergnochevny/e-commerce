<?php

namespace models;

use app\core\App;
use app\core\model\ModelBase;
use Exception;

/**
 * Class ModelClearance
 * @package models
 */
class ModelClearance extends ModelBase{

  /**
   * @var string
   */
  protected static $table = 'shop_clearance';

  /**
   * @param $filter
   * @param null $prms
   * @return array|string
   * @throws \Exception
   */
  protected static function build_where(&$filter, &$prms = null){
    $result = "";
    if(ControllerAdmin::is_logged()) {
      if(!empty($filter["a.pname"])) foreach(array_filter(explode(' ', $filter["a.pname"])) as $item) if(!empty($item)) $result[] = "a.pname LIKE '%" . static::prepare_for_sql($item) . "%'";
    } else {
      if(isset($filter["a.pname"])) $result[] = ModelSynonyms::build_synonyms_like("a.pname", $filter["a.pname"]);
    }
    if(isset($filter["a.pvisible"])) $result[] = "a.pvisible = '" . static::prepare_for_sql($filter["a.pvisible"]) . "'";
    if(isset($filter["a.piece"])) $result[] = "a.piece = '" . static::prepare_for_sql($filter["a.piece"]) . "'";
    if(isset($filter["a.dt"])) {
      $where = (!empty($filter["a.dt"]['from']) ? "a.dt >= '" . static::prepare_for_sql($filter["a.dt"]["from"]) . "'" : "") . (!empty($filter["a.dt"]['to']) ? " AND a.dt <= '" . static::prepare_for_sql($filter["a.dt"]["to"]) . "'" : "");
      if(strlen(trim($where)) > 0) $result[] = "(" . $where . ")";
    }
    if(isset($filter["a.pnumber"])) $result[] = "a.pnumber LIKE '%" . static::prepare_for_sql($filter["a.pnumber"]) . "%'";
    if(isset($filter["a.best"])) $result[] = "a.best = '" . static::prepare_for_sql($filter["a.best"]) . "'";
    if(isset($filter["a.specials"])) $result[] = "a.specials = '" . static::prepare_for_sql($filter["a.specials"]) . "'";
    if(isset($filter["b.cid"])) $result[] = "b.cid = '" . static::prepare_for_sql($filter["b.cid"]) . "'";
    if(isset($filter["c.id"])) $result[] = "c.id = '" . static::prepare_for_sql($filter["c.id"]) . "'";
    if(isset($filter["d.id"])) $result[] = "d.id = '" . static::prepare_for_sql($filter["d.id"]) . "'";
    if(isset($filter["e.id"])) $result[] = "e.id = '" . static::prepare_for_sql($filter["e.id"]) . "'";
    if(isset($filter["a.priceyard"]['from']) && !empty((float)$filter["a.priceyard"]['from'])) $result[] = "a.priceyard > '" . static::prepare_for_sql($filter["a.priceyard"]['from']) . "'";
    if(isset($filter["a.priceyard"]['to']) && !empty((float)$filter["a.priceyard"]['to'])) $result[] = "a.priceyard <= '" . static::prepare_for_sql($filter["a.priceyard"]['to']) . "'";
    if(!empty($result) && (count($result) > 0)) {
      if(strlen(trim(implode(" AND ", $result))) > 0) {
        $filter['active'] = true;
      }
    }
    if(isset($filter['hidden']['a.priceyard']) && !is_array($filter['hidden']['a.priceyard'])) $result[] = "a.priceyard > '" . static::prepare_for_sql($filter['hidden']["a.priceyard"]) . "'";
    if(isset($filter['hidden']['a.pvisible'])) $result[] = "a.pvisible = '" . static::prepare_for_sql($filter['hidden']["a.pvisible"]) . "'";
    if(isset($filter['hidden']["a.pnumber"])) $result[] = "a.pnumber is not null";
    if(isset($filter['hidden']["a.image1"])) $result[] = "a.image1 is not null";
    if(!empty($result) && (count($result) > 0)) {
      $result = implode(" AND ", $result);
      $result = (!empty($result) ? " WHERE " . $result : '');
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
    $query = "SELECT COUNT(DISTINCT a.pid) ";
    if(isset($filter['scenario']) && ($filter['scenario'] == 'add')) {
      $query .= " FROM shop_products a";
      $query .= " LEFT JOIN " . static::$table . " z ON a.pid = z.pid";
    } else {
      $query .= " FROM " . static::$table . " z";
      $query .= " LEFT JOIN shop_products a ON a.pid = z.pid";
    }
    $query .= " LEFT JOIN shop_product_categories ON a.pid = shop_product_categories.pid";
    $query .= " LEFT JOIN shop_categories b ON shop_product_categories.cid = b.cid";
    $query .= " LEFT JOIN shop_product_colors ON a.pid = shop_product_colors.prodId";
    $query .= " LEFT JOIN shop_color c ON shop_product_colors.colorId = c.id";
    $query .= " LEFT JOIN shop_product_patterns ON a.pid = shop_product_patterns.prodId";
    $query .= " LEFT JOIN shop_patterns d ON d.id = shop_product_patterns.patternId";
    $query .= " LEFT JOIN shop_manufacturers e ON a.manufacturerId = e.id";
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
    $query = "SELECT DISTINCT z.id, a.* ";
    if(isset($filter['scenario']) && ($filter['scenario'] == 'add')) {
      $query .= " FROM shop_products a";
      $query .= " LEFT JOIN " . static::$table . " z ON a.pid = z.pid";
    } else {
      $query .= " FROM " . static::$table . " z";
      $query .= " LEFT JOIN shop_products a ON a.pid = z.pid";
    }
    $query .= " LEFT JOIN shop_product_categories ON a.pid = shop_product_categories.pid";
    $query .= " LEFT JOIN shop_categories b ON shop_product_categories.cid = b.cid";
    $query .= " LEFT JOIN shop_product_colors ON a.pid = shop_product_colors.prodId";
    $query .= " LEFT JOIN shop_color c ON shop_product_colors.colorId = c.id";
    $query .= " LEFT JOIN shop_product_patterns ON a.pid = shop_product_patterns.prodId";
    $query .= " LEFT JOIN shop_patterns d ON d.id = shop_product_patterns.patternId";
    $query .= " LEFT JOIN shop_manufacturers e ON a.manufacturerId = e.id";
    $query .= static::build_where($filter);
    $query .= static::build_order($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";

    if($result = static::query($query)) {
      $res_count_rows = static::num_rows($result);

      if(isset($filter['hidden']['view']) && $filter['hidden']['view']) {
        $sys_hide_price = ModelPrice::sysHideAllRegularPrices();
        $cart_items = isset(App::$app->session('cart')['items']) ? App::$app->session('cart')['items'] : [];
        $cart = array_keys($cart_items);
        while($row = static::fetch_array($result)) {
          $response[] = ModelShop::prepare_layout_product($row, $cart, $sys_hide_price);
        }
      } else {
        while($row = static::fetch_array($result)) {
          $filename = 'images/products/b_' . $row['image1'];
          if(!(file_exists($filename) && is_file($filename))) {
            $filename = 'images/products/not_image.jpg';
          }
          $row['filename'] = App::$app->router()->UrlTo($filename);

          $price = $row['priceyard'];
          $inventory = $row['inventory'];
          $piece = $row['piece'];
          if($piece == 1 && $inventory > 0) {
            $price = $price * $inventory;
            $row['price'] = "$" . number_format($price, 2);
            $row['format_price'] = sprintf('%s <sup>per piece</sup>', $price);
          } else {
            $row['price'] = "$" . number_format($price, 2);
            $row['format_price'] = sprintf('%s <sup>per yard</sup>', $price);
          }
          $response[] = $row;
        }
      }
    }

    return $response;
  }

  /**
   * @param $id
   * @return array|null
   * @throws \Exception
   */
  public static function get_by_id($id){
    $data = [
      'id' => $id, 'pid' => null, 'metadescription' => '', 'metakeywords' => '', 'metatitle' => '', 'pname' => '',
      'pnumber' => '', 'width' => '', 'inventory' => '0.00', 'priceyard' => '0.00', 'hideprice' => 0,
      'dimensions' => '', 'weight' => 0, 'manufacturerId' => '', 'sdesc' => '', 'ldesc' => '', 'weight_id' => '',
      'specials' => 0, 'pvisible' => 0, 'best' => 0, 'piece' => 0, 'whole' => 0, 'stock_number' => '', 'image1' => '',
      'image2' => '', 'image3' => '', 'image4' => '', 'image5' => ''
    ];
    if(isset($id)) {
      $q = "SELECT z.id, a.* FROM " . static::$table . " z";
      $q .= " left join shop_products a on z.pid = a.pid";
      $q .= " where z.id = '" . $id . "'";
      $result = static::query($q);
      if($result) {
        $data = static::fetch_assoc($result);
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
      if(isset($pid) & isset($id)) {
        $sql = "update " . static::$table . " set";
        $sql .= " pid='$pid'";
        $sql .= " where id ='$id'";
        $result = static::query($sql);
      } else {
        $sql = "INSERT INTO " . static::$table . " SET";
        $sql .= " pid='$pid'";
        $result = static::query($sql);
        if($result) $id = static::last_id();
      }
      if(!$result) throw new Exception(static::error());
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
        $query = "DELETE FROM " . static::$table . " WHERE id = $id";
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