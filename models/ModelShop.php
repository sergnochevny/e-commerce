<?php

namespace models;

use app\core\App;
use controllers\ControllerAdmin;
use app\core\model\ModelBase;
use controllers\ControllerMatches;
use controllers\ControllerUser;
use Exception;

/**
 * Class ModelShop
 * @package models
 */
class ModelShop extends ModelBase{

  protected static $list_conditions = ['bestsellers' => 1, 'specials' => 2, 'under' => 3];

  protected static $table = 'shop_products';

  /**
   * @param $filter
   * @param null $prms
   * @return string
   * @throws \Exception
   */
  public static function build_where(&$filter, &$prms = null){
    $result_where = "";
    $prms = [];
    if(ControllerAdmin::is_logged()) {
      if(!empty($filter["a.pname"])) foreach(array_filter(explode(' ', $filter["a.pname"])) as $item) if(!empty($item)) $result[] = "a.pname LIKE '%" . static::prepare_for_sql($item) . "%'";

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
      if(isset($filter['a.piece'])) { $result[] = "a.piece = :apiece";  $prms['apiece'] = $filter["a.piece"]; }
      if(isset($filter['a.pvisible'])) {
        $result[] = "a.pvisible = :apvisible";
        $prms['apvisible'] = $filter["a.pvisible"];
      }
      if(isset($filter["a.pnumber"])) {
        $result[] = "a.pnumber LIKE :apnumber";
        $prms['apnumber'] = '%' . $filter["a.pnumber"] . '%';
      }
      if(isset($filter["b.cid"])) {
        $result[] = "b.cid = :bcid";
        $prms['hbcid'] = $filter["b.cid"];
      }
      if(isset($filter["c.id"])) {
        $result[] = "c.id = :cid";
        $prms['hcid'] = $filter["c.id"];
      }
      if(isset($filter["d.id"])) {
        $result[] = "d.id = :did";
        $prms['hdid'] = $filter["d.id"];
      }
      if(isset($filter["e.id"])) {
        $result[] = "e.id = :eid";
        $prms['heid'] = $filter["e.id"];
      }
      if(isset($filter["a.best"])) {
        $result[] = "a.best = :abest";
        $prms['habest'] = $filter["a.best"];
      }
      if(isset($filter["a.specials"])) {
        $result[] = "a.specials = :aspecials";
        $prms['haspecials'] = $filter["a.specials"];
      }
      if(isset($filter["a.priceyard"]['from']) && !empty((float)$filter["a.priceyard"]['from'])) {
        $result[] = "a.priceyard > :apriceyard_from";
        $prms['hapriceyard_from'] = $filter["a.priceyard"]['from'];
      }
      if(isset($filter["a.priceyard"]['to']) && !empty((float)$filter["a.priceyard"]['to'])) {
        $result[] = "a.priceyard <= :apriceyard_to";
        $prms['hapriceyard_to'] = $filter["a.priceyard"]['to'];
      }

      if(!empty($result) && (count($result) > 0)) {
        if(strlen(trim(implode(" AND ", $result))) > 0) {
          $filter['active'] = true;
        }
      }
    } else {
      if(isset($filter["a.pname"])) {
        $conditions[] = ModelSynonyms::build_synonyms_like_p("a.pname", $filter["a.pname"]);
        $conditions[] = ModelSynonyms::build_synonyms_like_p("b.cname", $filter["a.pname"]);
        $conditions[] = ModelSynonyms::build_synonyms_like_p("c.color", $filter["a.pname"]);
        $conditions[] = ModelSynonyms::build_synonyms_like_p("d.pattern", $filter["a.pname"]);
        $conditions[] = ModelSynonyms::build_synonyms_like_P("e.manufacturer", $filter["a.pname"]);
        $condition = '';
        foreach($conditions as $item) {
          if(!empty($condition)) $condition .= ' OR ';
          $condition .= $item[0];
          $prms = array_merge($prms, $item[1]);
        }
        $result[] = $condition;
      }
      if(!empty($result) && (count($result) > 0)) {
        if(strlen(trim(implode(" AND ", $result))) > 0) {
          $filter['active'] = true;
        }
      }
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
    if(isset($filter['hidden']["b.cid"])) {
      $result[] = "b.cid = :hbcid";
      $prms['hbcid'] = $filter['hidden']["b.cid"];
    }
    if(isset($filter['hidden']["c.id"])) {
      $result[] = "c.id = :hcid";
      $prms['hcid'] = $filter['hidden']["c.id"];
    }
    if(isset($filter['hidden']["d.id"])) {
      $result[] = "d.id = :hdid";
      $prms['hdid'] = $filter['hidden']["d.id"];
    }
    if(isset($filter['hidden']["e.id"])) {
      $result[] = "e.id = :heid";
      $prms['heid'] = $filter['hidden']["e.id"];
    }
    if(isset($filter['hidden']["a.best"])) {
      $result[] = "a.best = :habest";
      $prms['habest'] = $filter['hidden']["a.best"];
    }
    if(isset($filter['hidden']["a.specials"])) {
      $result[] = "a.specials = :haspecials";
      $prms['haspecials'] = $filter['hidden']["a.specials"];
    }
    if(isset($filter['hidden']["a.priceyard"]['from']) && !empty((float)$filter['hidden']["a.priceyard"]['from'])) {
      $result[] = "a.priceyard > :hapriceyard_from";
      $prms['hapriceyard_from'] = $filter['hidden']["a.priceyard"]['from'];
    }
    if(isset($filter['hidden']["a.priceyard"]['to']) && !empty((float)$filter['hidden']["a.priceyard"]['to'])) {
      $result[] = "a.priceyard <= :hapriceyard_to";
      $prms['hapriceyard_to'] = $filter['hidden']["a.priceyard"]['to'];
    }

    if(!empty($result) && (count($result) > 0)) {
      $result_where = implode(" AND ", $result);
      if(!empty($filter['type']) && in_array($filter['type'], array_keys(static::$list_conditions))) {
        $type = static::$list_conditions[$filter['type']];
        $result_where = (!empty($result_where) ? "cc.type = " . $type . ' AND ' . $result_where : "cc.type = " . $type);
      }
      $result_where = (!empty($result_where) ? " WHERE " . $result_where : '');
    }

    return $result_where;
  }

  /**
   * @param $row
   * @param $cart
   * @param $sys_hide_price
   * @param string $image_suffix
   * @return mixed
   * @throws \Exception
   */
  public static function prepare_layout_product($row, $cart, $sys_hide_price, $image_suffix = 'b_'){
    $row['sdesc'] = substr($row['sdesc'], 0, 100);
    $row['ldesc'] = substr($row['ldesc'], 0, 100);
    $filename = 'images/products/' . $image_suffix . $row['image1'];
    if(!(file_exists(APP_PATH . '/web/' . $filename) && is_file(APP_PATH . '/web/' . $filename))) {
      $filename = 'images/products/not_image.jpg';
    }
    $row['filename'] = App::$app->router()->UrlTo($filename);

    $pid = $row['pid'];
    $price = $row['priceyard'];
    $inventory = $row['inventory'];
    $piece = $row['piece'];
    $format_price = '';
    $price = ModelPrice::getPrintPrice($price, $format_price, $inventory, $piece);

    $discountIds = [];
    $saleprice = $row['priceyard'];
    $sDiscount = 0;
    $saleprice = ModelPrice::calculateProductSalePrice($pid, $saleprice, $discountIds);
    $row['bProductDiscount'] = ModelPrice::checkProductDiscount($pid, $sDiscount, $saleprice, $discountIds);
    $format_sale_price = '';
    $row['sDiscount'] = $sDiscount;
    $row['saleprice'] = ModelPrice::getPrintPrice($saleprice, $format_sale_price, $inventory, $piece);
    $row['format_sale_price'] = $format_sale_price;
    $row['format_price'] = $format_price;
    $row['in_cart'] = in_array($row['pid'], $cart);
    $row['sys_hide_price'] = $sys_hide_price;
    $row['price'] = $price;
    $row['Discount'] = (round(($price - $saleprice) * 100) != 0);

    return $row;
  }

  /**
   * @param $data
   * @param $cart
   * @param $sys_hide_price
   * @return mixed
   * @throws \Exception
   */
  public static function prepare_layout_product_detail($data, $cart, $sys_hide_price){
    if(ControllerMatches::product_in($data['pid'])) $data['in_matches'] = true;
    $priceyard = $data['priceyard'];
    $aPrds = [];
    $aPrds[] = $data['pid'];    #add product id
    $aPrds[] = 1;        #add qty

    #get the shipping
    if(isset($cart['ship'])) {
      $shipping = (int)$cart['ship'];
    } else {
      $shipping = DEFAULT_SHIPPING;
      $cart['ship'] = $shipping;
      App::$app->setSession('cart', $cart);
    }

    if(isset($cart['ship_roll'])) {
      $data['bShipRoll'] = (boolean)$cart['ship_roll'];
    } else {
      $data['bShipRoll'] = false;
      $cart['ship_roll'] = 0;
      App::$app->setSession('cart', $cart);
    }

    $shipcost = 0;
    $uid = 0;
    if(ControllerUser::is_logged()) $uid = (int)ControllerUser::get_from_session()['aid'];
    $bTemp = false;

    $bSystemDiscount = false;
    $discountIds = [];
    $sSystemDiscount = false;
    $sPriceDiscount = '';
    $rDiscountPrice = 0;
    $rSystemDiscount = ModelPrice::calculateDiscount(DISCOUNT_CATEGORY_ALL, $uid, $aPrds, $priceyard, $shipcost, '', $bTemp, true, $sPriceDiscount, $sSystemDiscount, $shipping, $discountIds);
    if((strlen($sSystemDiscount) > 0) || ($rSystemDiscount > 0)) {
      $bSystemDiscount = true;
      $rDiscountPrice = $priceyard - $rSystemDiscount;
    }

    #check the price for the discount
    if($bSystemDiscount) {
      $rExDiscountPrice = $rDiscountPrice;
    } else {
      $rExDiscountPrice = $priceyard;
    }

    $inventory = $data['inventory'];
    $piece = $data['piece'];
    $format_price = '';
    $data['price'] = ModelPrice::getPrintPrice($priceyard, $format_price, $inventory, $piece);
    $data['format_price'] = $format_price;

    #check if the product has its own discount
    $sDiscount = '';
    $bDiscount = ModelPrice::checkProductDiscount($data['pid'], $sDiscount, $rExDiscountPrice, $discountIds);
    $data['bDiscount'] = $bDiscount;
    $data['sDiscount'] = $sDiscount;

    $tmp = ModelPrice::getPrintPrice($rDiscountPrice, $sDiscountPrice, $inventory, $piece);
    $data['rDiscountPrice'] = $rDiscountPrice;
    $data['srDiscountPrice'] = $sDiscountPrice;
    $tmp = ModelPrice::getPrintPrice($rExDiscountPrice, $sDiscountPrice, $inventory, $piece);
    $data['rExDiscountPrice'] = $rExDiscountPrice;
    $data['sDiscountPrice'] = $sDiscountPrice;
    $data['rSystemDiscount'] = $rSystemDiscount;
    $data['sys_hide_price'] = $sys_hide_price;
    $data['sPriceDiscount'] = $sPriceDiscount;
    $data['sSystemDiscount'] = $sSystemDiscount;
    $data['bSystemDiscount'] = $bSystemDiscount;

    if(count($discountIds) > 0) {
      $data['next_change'] = (ModelPrice::getNextChangeInDiscoutDate($discountIds) > 0);
      $data['time_rem'] = ModelPrice::displayDiscountTimeRemaining($discountIds);
    }

    if(isset($cart['items'])) {
      $cart_items = $cart['items'];
    } else {
      $cart_items = [];
    }
    if(isset($cart['samples_items'])) {
      $samples_items = $cart['samples_items'];
    } else {
      $samples_items = [];
    }
    $data['in_samples_cart'] = in_array($data['pid'], array_keys($samples_items));
    $data['in_cart'] = in_array($data['pid'], array_keys($cart_items));

    $data['img1_exists'] = true;
    $data['filename'] = 'images/products/' . $data['image1'];
    $data['filename1'] = 'images/products/' . 'v_' . $data['image1'];
    if(!(file_exists(APP_PATH . '/web/' . $data['filename']) &&
      is_file(APP_PATH . '/web/' . $data['filename']) &&
      is_readable(APP_PATH . '/web/' . $data['filename']))) {
      $data['filename'] = "images/products/not_image.jpg";
      $data['filename1'] = null;
      $data['img1_exists'] = false;
    }
    $data['filename'] = App::$app->router()->UrlTo($data['filename']);
    $data['filename1'] = isset($data['filename1']) ? App::$app->router()->UrlTo($data['filename1']) : null;
    for($i = 2; $i < 6; $i++) {
      if(!empty($data['image' . $i])) {
        $data['img' . $i . '_filename'] = 'images/products/b_' . $data['image' . $i];
        $data['img' . $i . '_filename1'] = 'images/products/v_' . $data['image' . $i];
        if(!(file_exists(APP_PATH . '/web/' . $data['img' . $i . '_filename']) &&
          is_file(APP_PATH . '/web/' . $data['img' . $i . '_filename']) &&
          is_readable(APP_PATH . '/web/' . $data['img' . $i . '_filename']))) {
          $data['img' . $i . '_filename'] = "images/products/not_image.jpg";
          $data['img' . $i . '_filename1'] = null;
        }
        $data['img' . $i . '_filename'] = App::$app->router()->UrlTo($data['img' . $i . '_filename']);
        $data['img' . $i . '_filename1'] = isset($data['img' . $i . '_filename1']) ?
          App::$app->router()->UrlTo($data['img' . $i . '_filename1']) : null;
      }
    }

    return $data;
  }

  /**
   * @param $pid
   * @param int $inventory
   * @return mixed
   * @throws \Exception
   */
  public static function set_inventory($pid, $inventory = 0){
    $q = "UPDATE shop_products SET inventory=" . $inventory;
    $q .= ($inventory <= 0) ? ", pvisible = 0" : "";
    $q .= " where pid=" . $pid;

    return static::query($q);
  }

  /**
   * @param $pid
   * @return array
   * @throws \Exception
   */
  public static function get_product_params($pid){

    $data = ModelProduct::get_by_id($pid);
    $quatity = ($data['inventory'] > 1) ? 1 : $data['inventory'];
    if($data['piece'] == 1) $quatity = 1;

    return [
      'pid' => $data['pid'], 'pname' => $data['pname'], 'pnumber' => $data['pnumber'], 'price' => $data['priceyard'],
      'stock_number' => $data['stock_number'], 'quantity' => $quatity, 'inventory' => $data['inventory'],
      'piece' => $data['piece'], 'whole' => $data['whole'], 'image1' => $data['image1']
    ];
  }

  /**
   * @param $pid
   * @return mixed
   * @throws \Exception
   */
  public static function get_product($pid){
    self::inc_popular($pid);
    $row = ModelProduct::get_by_id($pid);
    if(!$row) throw new Exception('The Required Fabric do not exist!!');
    $sys_hide_price = ModelPrice::sysHideAllRegularPrices();
    $cart = App::$app->session('cart');
    $response = self::prepare_layout_product_detail($row, $cart, $sys_hide_price);

    return $response;
  }

  /**
   * @param $pid
   * @throws \Exception
   */
  public static function inc_popular($pid){
    static::query("update shop_products set popular = popular+1 WHERE pid='$pid'");
  }

  /**
   * @param $type
   * @param $start
   * @param $limit
   * @param $res_count_rows
   * @return array|null
   * @throws \Exception
   */
  public static function get_widget_list_by_type($type, $start, $limit, &$res_count_rows){
    $response = null;
    $q = "";
    $image_suffix = '';
    switch($type) {
      case 'new':
        $q = "SELECT * FROM shop_products WHERE priceyard > 0 AND pnumber IS NOT NULL AND pvisible = '1'";
        $q .= " and image1 is not null ORDER BY dt DESC LIMIT " . $start . "," . $limit;
        break;
      case 'carousel':
        $image_suffix = 'b_';
        $q = "SELECT DISTINCT a.* FROM collection c";
        $q .= " left join shop_products a on c.pid = a.pid and c.type = 2";
        $q .= " where c.type = 2 and a.image1 is not null limit " . $start . "," . $limit;
        break;
      case 'best':
        $image_suffix = 'b_';
        $q = "SELECT * FROM shop_products WHERE priceyard > 0 AND pnumber IS NOT NULL AND pvisible = '1'";
        $q .= " and best = '1' and image1 is not null LIMIT " . $start . "," . $limit;
        break;
      case 'bestsellers':
        $image_suffix = 'b_';
        $q = "SELECT DISTINCT a.* FROM collection c";
        $q .= " left join shop_products a on c.pid = a.pid and c.type = 1";
        $q .= " where c.type = 1 and a.image1 is not null limit " . $start . "," . $limit;
        break;
      case 'popular':
        $image_suffix = 'b_';
        $q = "SELECT * FROM shop_products WHERE priceyard > 0 AND pnumber IS NOT NULL AND pvisible = '1'";
        $q .= " and image1 is not null LIMIT " . $start . "," . $limit;
        break;
      case 'under_20':
        $q = "SELECT DISTINCT a.* FROM collection c";
        $q .= " left join shop_products a on c.pid = a.pid and c.type = 3";
        $q .= " where c.type = 3 and c.price > 0 and c.price <= 20 and a.image1 is not null";
        $q .= " limit " . $start . "," . $limit;
        break;
      case 'under_40':
        $q = "SELECT DISTINCT a.* FROM collection c";
        $q .= " left join shop_products a on c.pid = a.pid and c.type = 3";
        $q .= " where c.type = 3 and c.price > 20 and c.price <= 40 and a.image1 is not null";
        $q .= " limit " . $start . "," . $limit;
        break;
      case 'under_60':
        $q = "SELECT DISTINCT a.* FROM collection c";
        $q .= " left join shop_products a on c.pid = a.pid and c.type = 3";
        $q .= " where c.type = 3 and c.price > 40 and c.price <= 60 and a.image1 is not null";
        $q .= " limit " . $start . "," . $limit;
        break;
    }
    if($result = static::query($q)) {
      $res_count_rows = static::num_rows($result);
      $sys_hide_price = ModelPrice::sysHideAllRegularPrices();
      $cart_items = isset(App::$app->session('cart')['items']) ? App::$app->session('cart')['items'] : [];
      $cart = array_keys($cart_items);
      while($row = static::fetch_array($result)) {
        $response[] = self::prepare_layout_product($row, $cart, $sys_hide_price, $image_suffix);
      }
      static::free_result($result);
    }

    return $response;
  }

  /**
   * @param $type
   * @return null
   * @throws \Exception
   */
  public static function get_widget_list_by_type_count($type){
    $response = null;
    $q = "";
    switch($type) {
      case 'new':
        $q = "SELECT COUNT(pid) FROM shop_products WHERE priceyard > 0 AND pnumber IS NOT NULL AND pvisible = '1'";
        $q .= " and image1 is not null";
        break;
      case 'carousel':
        $image_suffix = 'b_';
        $q = "SELECT COUNT(DISTINCT a.pid) FROM collection c";
        $q .= " left join shop_products a on c.pid = a.pid and c.type = 2";
        $q .= " where c.type = 2 and a.image1 is not null";
        break;
      case 'best':
        $image_suffix = 'b_';
        $q = "SELECT COUNT(pid) FROM shop_products WHERE priceyard > 0 AND pnumber IS NOT NULL AND pvisible = '1'";
        $q .= " and best = '1' and image1 is not null";
        break;
      case 'bestsellers':
        $image_suffix = 'b_';
        $q = "SELECT COUNT(DISTINCT a.pid) FROM collection c";
        $q .= " left join shop_products a on c.pid = a.pid and c.type = 1";
        $q .= " where c.type = 1 and a.image1 is not null";
        break;
      case 'popular':
        $image_suffix = 'b_';
        $q = "SELECT COUNT(pid) FROM shop_products WHERE priceyard > 0 AND pnumber IS NOT NULL AND pvisible = '1'";
        $q .= " and image1 is not null";
        break;
      case 'under_20':
        $q = "SELECT COUNT(DISTINCT a.pid) FROM collection c";
        $q .= " left join shop_products a on c.pid = a.pid and c.type = 3";
        $q .= " where c.type = 3 and c.price > 0 and c.price <= 20 and a.image1 is not null";
        break;
      case 'under_40':
        $q = "SELECT COUNT(DISTINCT a.pid) FROM collection c";
        $q .= " left join shop_products a on c.pid = a.pid and c.type = 3";
        $q .= " where c.type = 3 and c.price > 20 and c.price <= 40 and a.image1 is not null";
        break;
      case 'under_60':
        $q = "SELECT COUNT(DISTINCT a.pid) FROM collection c";
        $q .= " left join shop_products a on c.pid = a.pid and c.type = 3";
        $q .= " where c.type = 3 and c.price > 40 and c.price <= 60 and a.image1 is not null";
        break;
    }
    if($result = static::query($q)) {
      $response = static::fetch_value($result);
      static::free_result($result);
    }

    return $response;
  }

  /**
   * @param $type
   * @return array
   * @throws \Exception
   */
  public static function get_items_for_menu($type){
    $res = [];
    $row_new_count = 50;
    switch($type) {
      case 'all':
        $q = "SELECT distinct a.*" .
          " FROM shop_categories a" .
          " LEFT JOIN shop_product_categories c on a.cid = c.cid" .
          " LEFT JOIN shop_products b ON b.pid = c.pid" .
          " WHERE b.priceyard > 0 and b.pvisible = '1' and b.image1 is not null" .
          " ORDER BY a.displayorder, c.displayorder";
        break;
      case 'new':
        $q = "SELECT distinct a.*" .
          " FROM (SELECT pid FROM shop_products WHERE priceyard > 0 and pvisible = '1' and image1 is not null" .
          " ORDER BY dt DESC LIMIT " . $row_new_count . ") b" .
          " LEFT JOIN shop_product_categories c ON b.pid = c.pid" .
          " LEFT JOIN shop_categories a on a.cid = c.cid" . " ORDER BY a.displayorder, c.displayorder";
        break;
      case 'manufacturer':
        $q = "SELECT distinct a.*" .
          " FROM shop_products b " .
          " INNER JOIN shop_manufacturers a ON b.manufacturerId = a.id" .
          " WHERE b.priceyard > 0 and b.pvisible = '1' and b.image1 is not null" .
          " ORDER BY b.dt DESC";
        break;
      case 'patterns':
        $q = "SELECT distinct a.*" .
          " FROM  shop_patterns a" .
          " LEFT JOIN shop_product_patterns c on a.id = c.patternId" .
          " LEFT JOIN shop_products b ON  b.pid = c.prodId" .
          " WHERE b.priceyard > 0 and b.pvisible = '1' and b.image1 is not null";
        break;
      case 'blog_category':
        $q = "SELECT distinct a.*" .
          " FROM blog_groups a" .
          " LEFT JOIN blog_group_posts c on a.id = c.group_id" .
          " LEFT JOIN blog_posts b ON b.ID = c.object_id" .
          " WHERE b.post_status = 'publish'";
        break;
    }
    $result = static::query($q);
    while($row = static::fetch_assoc($result)) {
      $res[] = $row;
    }

    return $res;
  }

  /**
   * @param null $filter
   * @return int|null
   * @throws \Exception
   */
  public static function get_total_count($filter = null){
    $response = 0;
    if(!empty($filter['type']) && in_array($filter['type'], array_keys(static::$list_conditions))) {
      $type = static::$list_conditions[$filter['type']];
      $query = "SELECT COUNT(a.pid) FROM collection cc";
      $query .= " left join shop_products a on cc.pid = a.pid and cc.type = " . $type;
      $query .= " LEFT JOIN shop_product_categories ON a.pid = shop_product_categories.pid";
      $query .= " LEFT JOIN shop_categories b ON shop_product_categories.cid = b.cid";
      $query .= " LEFT JOIN shop_product_colors ON a.pid = shop_product_colors.prodId";
      $query .= " LEFT JOIN shop_color c ON shop_product_colors.colorId = c.id";
      $query .= " LEFT JOIN shop_product_patterns ON a.pid = shop_product_patterns.prodId";
      $query .= " LEFT JOIN shop_patterns d ON d.id = shop_product_patterns.patternId";
      $query .= " LEFT JOIN shop_manufacturers e ON a.manufacturerId = e.id";
    } else {
      $query = "SELECT COUNT(DISTINCT a.pid) FROM " . static::$table . " a";
      $query .= " LEFT JOIN shop_product_categories ON a.pid = shop_product_categories.pid";
      $query .= " LEFT JOIN shop_categories b ON shop_product_categories.cid = b.cid";
      $query .= " LEFT JOIN shop_product_colors ON a.pid = shop_product_colors.prodId";
      $query .= " LEFT JOIN shop_color c ON shop_product_colors.colorId = c.id";
      $query .= " LEFT JOIN shop_product_patterns ON a.pid = shop_product_patterns.prodId";
      $query .= " LEFT JOIN shop_patterns d ON d.id = shop_product_patterns.patternId";
      $query .= " LEFT JOIN shop_manufacturers e ON a.manufacturerId = e.id";
    }
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
    if(!empty($filter['type']) && in_array($filter['type'], array_keys(static::$list_conditions))) {
      $type = static::$list_conditions[$filter['type']];
      $query = "SELECT DISTINCT a.* FROM collection cc";
      $query .= " left join shop_products a on cc.pid = a.pid and cc.type = " . $type;
      $query .= " LEFT JOIN shop_product_categories ON a.pid = shop_product_categories.pid";
      $query .= " LEFT JOIN shop_categories b ON shop_product_categories.cid = b.cid";
      $query .= " LEFT JOIN shop_product_colors ON a.pid = shop_product_colors.prodId";
      $query .= " LEFT JOIN shop_color c ON shop_product_colors.colorId = c.id";
      $query .= " LEFT JOIN shop_product_patterns ON a.pid = shop_product_patterns.prodId";
      $query .= " LEFT JOIN shop_patterns d ON d.id = shop_product_patterns.patternId";
      $query .= " LEFT JOIN shop_manufacturers e ON a.manufacturerId = e.id";
    } else {
      $query = "SELECT DISTINCT a.* FROM " . static::$table . " a";
      $query .= " LEFT JOIN shop_product_categories ON a.pid = shop_product_categories.pid";
      $query .= " LEFT JOIN shop_categories b ON shop_product_categories.cid = b.cid";
      $query .= " LEFT JOIN shop_product_colors ON a.pid = shop_product_colors.prodId";
      $query .= " LEFT JOIN shop_color c ON shop_product_colors.colorId = c.id";
      $query .= " LEFT JOIN shop_product_patterns ON a.pid = shop_product_patterns.prodId";
      $query .= " LEFT JOIN shop_patterns d ON d.id = shop_product_patterns.patternId";
      $query .= " LEFT JOIN shop_manufacturers e ON a.manufacturerId = e.id";
    }
    $query .= static::build_where($filter, $prms);
    $query .= static::build_order($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";
    if($result = static::query($query, $prms)) {
      $res_count_rows = static::num_rows($result);
      $sys_hide_price = ModelPrice::sysHideAllRegularPrices();
      $cart_items = isset(App::$app->session('cart')['items']) ? App::$app->session('cart')['items'] : [];
      $cart = array_keys($cart_items);
      while($row = static::fetch_array($result)) {
        $response[] = self::prepare_layout_product($row, $cart, $sys_hide_price);
      }
      static::free_result($result);
    }

    return $response;
  }

}