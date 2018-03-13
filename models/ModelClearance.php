<?php

namespace models;

use app\core\App;
use app\core\model\ModelBase;
use controllers\ControllerAdmin;
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
  public static function build_where(&$filter, &$prms = null){
    return ModelShop::build_where($filter, $prms);
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
    $query .= static::build_where($filter, $prms);
    $query .= static::build_order($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";

    if($result = static::query($query, $prms)) {
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
            $filename = 'images/not_image.jpg';
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
      $q .= " where z.id = :id";
      $result = static::query($q, ['id' => $id]);
      if($result) {
        $data = static::fetch_assoc($result);
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
  public static function save(&$data){
    static::transaction();
    try {
      extract($data);
      if(isset($pid) && isset($id)) {
        $sql = "update " . static::$table . " set";
        $sql .= " pid= :pid";
        $sql .= " where id = :id";
        $result = static::query($sql, ['id' => $id, 'pid' => $pid]);
      } elseif(isset($pid)) {
        $sql = "INSERT INTO " . static::$table . " SET pid= :pid";
        $result = static::query($sql, ['pid' => $pid]);
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
        $query = "DELETE FROM " . static::$table . " WHERE id = :id";
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