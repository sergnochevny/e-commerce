<?php

class Model_Shop extends Model_Base{

  protected static $list_conditions = ['bestsellers' => 1, 'specials' => 2, 'under' => 3];

  protected static $table = 'fabrix_products';

  protected static function build_where(&$filter){
    $result_where = "";
    if(Controller_Admin::is_logged()) {
      if(!empty($filter["a.pname"])) foreach(array_filter(explode(' ', $filter["a.pname"])) as $item) if(!empty($item)) $result[] = "a.pname LIKE '%" . static::prepare_for_sql($item) . "%'";
    } else {
      if(isset($filter["a.pname"])) $result[] = Model_Synonyms::build_synonyms_like("a.pname", $filter["a.pname"]);
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
    if(isset($filter['hidden']["b.cid"])) $result[] = "b.cid = '" . static::prepare_for_sql($filter['hidden']["b.cid"]) . "'";
    if(isset($filter['hidden']["c.id"])) $result[] = "c.id = '" . static::prepare_for_sql($filter['hidden']["c.id"]) . "'";
    if(isset($filter['hidden']["d.id"])) $result[] = "d.id = '" . static::prepare_for_sql($filter['hidden']["d.id"]) . "'";
    if(isset($filter['hidden']["e.id"])) $result[] = "e.id = '" . static::prepare_for_sql($filter['hidden']["e.id"]) . "'";
    if(isset($filter['hidden']["a.best"])) $result[] = "a.best = '" . static::prepare_for_sql($filter['hidden']["a.best"]) . "'";
    if(isset($filter['hidden']["a.specials"])) $result[] = "a.specials = '" . static::prepare_for_sql($filter['hidden']["a.specials"]) . "'";
    if(isset($filter['hidden']["a.priceyard"]['from']) && !empty((float)$filter['hidden']["a.priceyard"]['from'])) $result[] = "a.priceyard > '" . static::prepare_for_sql($filter['hidden']["a.priceyard"]['from']) . "'";
    if(isset($filter['hidden']["a.priceyard"]['to']) && !empty((float)$filter['hidden']["a.priceyard"]['to'])) $result[] = "a.priceyard <= '" . static::prepare_for_sql($filter['hidden']["a.priceyard"]['to']) . "'";
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

  public static function prepare_layout_product($row, $cart, $sys_hide_price, $image_suffix = 'b_'){
    $row['sdesc'] = substr($row['sdesc'], 0, 100);
    $row['ldesc'] = substr($row['ldesc'], 0, 100);
    $filename = 'images/products/' . $image_suffix . $row['image1'];
    if(!(file_exists(APP_PATH . '/web/' . $filename) && is_file(APP_PATH . '/web/' . $filename))) {
      $filename = 'images/products/not_image.jpg';
    }
    $row['filename'] = _A_::$app->router()->UrlTo($filename);

    $pid = $row['pid'];
    $price = $row['priceyard'];
    $inventory = $row['inventory'];
    $piece = $row['piece'];
    $format_price = '';
    $price = Model_Price::getPrintPrice($price, $format_price, $inventory, $piece);

    $discountIds = [];
    $saleprice = $row['priceyard'];
    $sDiscount = 0;
    $saleprice = Model_Price::calculateProductSalePrice($pid, $saleprice, $discountIds);
    $row['bProductDiscount'] = Model_Price::checkProductDiscount($pid, $sDiscount, $saleprice, $discountIds);
    $format_sale_price = '';
    $row['sDiscount'] = $sDiscount;
    $row['saleprice'] = Model_Price::getPrintPrice($saleprice, $format_sale_price, $inventory, $piece);
    $row['format_sale_price'] = $format_sale_price;
    $row['format_price'] = $format_price;
    $row['in_cart'] = in_array($row['pid'], $cart);
    $row['sys_hide_price'] = $sys_hide_price;
    $row['price'] = $price;
    $row['Discount'] = (round(($price - $saleprice) * 100) != 0);

    return $row;
  }

  public static function prepare_layout_product_detail($data, $cart, $sys_hide_price){
    if(Controller_Matches::product_in($data['pid'])) $data['in_matches'] = true;
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
      _A_::$app->setSession('cart', $cart);
    }

    if(isset($cart['ship_roll'])) {
      $data['bShipRoll'] = (boolean)$cart['ship_roll'];
    } else {
      $data['bShipRoll'] = false;
      $cart['ship_roll'] = 0;
      _A_::$app->setSession('cart', $cart);
    }

    $shipcost = 0;
    $uid = 0;
    if(Controller_User::is_logged()) $uid = (int)Controller_User::get_from_session()['aid'];
    $bTemp = false;

    $bSystemDiscount = false;
    $discountIds = [];
    $sSystemDiscount = false;
    $sPriceDiscount = '';
    $rDiscountPrice = 0;
    $rSystemDiscount = Model_Price::calculateDiscount(DISCOUNT_CATEGORY_ALL, $uid, $aPrds, $priceyard, $shipcost, '', $bTemp, true, $sPriceDiscount, $sSystemDiscount, $shipping, $discountIds);
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
    $data['price'] = Model_Price::getPrintPrice($priceyard, $format_price, $inventory, $piece);
    $data['format_price'] = $format_price;

    #check if the product has its own discount
    $sDiscount = '';
    $bDiscount = Model_Price::checkProductDiscount($data['pid'], $sDiscount, $rExDiscountPrice, $discountIds);
    $data['bDiscount'] = $bDiscount;
    $data['sDiscount'] = $sDiscount;

    $tmp = Model_Price::getPrintPrice($rDiscountPrice, $sDiscountPrice, $inventory, $piece);
    $data['rDiscountPrice'] = $rDiscountPrice;
    $data['srDiscountPrice'] = $sDiscountPrice;
    $tmp = Model_Price::getPrintPrice($rExDiscountPrice, $sDiscountPrice, $inventory, $piece);
    $data['rExDiscountPrice'] = $rExDiscountPrice;
    $data['sDiscountPrice'] = $sDiscountPrice;
    $data['rSystemDiscount'] = $rSystemDiscount;
    $data['sys_hide_price'] = $sys_hide_price;
    $data['sPriceDiscount'] = $sPriceDiscount;
    $data['sSystemDiscount'] = $sSystemDiscount;
    $data['bSystemDiscount'] = $bSystemDiscount;

    if(count($discountIds) > 0) {
      $data['next_change'] = (Model_Price::getNextChangeInDiscoutDate($discountIds) > 0);
      $data['time_rem'] = Model_Price::displayDiscountTimeRemaining($discountIds);
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
    $data['filename'] = _A_::$app->router()->UrlTo($data['filename']);
    $data['filename1'] = isset($data['filename1']) ? _A_::$app->router()->UrlTo($data['filename1']) : null;
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
        $data['img' . $i . '_filename'] = _A_::$app->router()->UrlTo($data['img' . $i . '_filename']);
        $data['img' . $i . '_filename1'] = isset($data['img' . $i . '_filename1']) ?
          _A_::$app->router()->UrlTo($data['img' . $i . '_filename1']) : null;
      }
    }

    return $data;
  }

  public static function set_inventory($pid, $inventory = 0){
    $q = "UPDATE fabrix_products SET inventory=" . $inventory;
    $q .= ($inventory <= 0) ? ", pvisible = 0" : "";
    $q .= " where pid=" . $pid;

    return static::query($q);
  }

  public static function get_product_params($pid){

    $data = Model_Product::get_by_id($pid);
    $quatity = ($data['inventory'] > 1) ? 1 : $data['inventory'];
    if($data['piece'] == 1) $quatity = 1;

    return [
      'pid' => $data['pid'], 'pname' => $data['pname'], 'pnumber' => $data['pnumber'], 'price' => $data['priceyard'],
      'stock_number' => $data['stock_number'], 'quantity' => $quatity, 'inventory' => $data['inventory'],
      'piece' => $data['piece'], 'whole' => $data['whole'], 'image1' => $data['image1']
    ];
  }

  public static function get_product($pid){
    self::inc_popular($pid);
    $row = Model_Product::get_by_id($pid);
    if(!$row) throw new Exception('The Required Fabric do not exist!!');
    $sys_hide_price = Model_Price::sysHideAllRegularPrices();
    $cart = _A_::$app->session('cart');
    $response = self::prepare_layout_product_detail($row, $cart, $sys_hide_price);

    return $response;
  }

  public static function inc_popular($pid){
    static::query("update fabrix_products set popular = popular+1 WHERE pid='$pid'");
  }

  public static function get_widget_list_by_type($type, $start, $limit, &$res_count_rows){
    $response = null;
    $q = "";
    $image_suffix = '';
    switch($type) {
      case 'new':
        $q = "SELECT * FROM fabrix_products WHERE priceyard > 0 AND pnumber IS NOT NULL AND pvisible = '1'";
        $q .= " and image1 is not null ORDER BY dt DESC LIMIT " . $start . "," . $limit;
        break;
      case 'carousel':
        $image_suffix = 'b_';
        $q = "SELECT DISTINCT a.* FROM collection c";
        $q .= " left join fabrix_products a on c.pid = a.pid and c.type = 2";
        $q .= " where c.type = 2 and a.image1 is not null limit " . $start . "," . $limit;
        break;
      case 'best':
        $image_suffix = 'b_';
        $q = "SELECT * FROM fabrix_products WHERE priceyard > 0 AND pnumber IS NOT NULL AND pvisible = '1'";
        $q .= " and best = '1' and image1 is not null LIMIT " . $start . "," . $limit;
        break;
      case 'bestsellers':
        $image_suffix = 'b_';
        $q = "SELECT DISTINCT a.* FROM collection c";
        $q .= " left join fabrix_products a on c.pid = a.pid and c.type = 1";
        $q .= " where c.type = 1 and a.image1 is not null limit " . $start . "," . $limit;
        break;
      case 'popular':
        $image_suffix = 'b_';
        $q = "SELECT * FROM fabrix_products WHERE priceyard > 0 AND pnumber IS NOT NULL AND pvisible = '1'";
        $q .= " and image1 is not null LIMIT " . $start . "," . $limit;
        break;
      case 'under_20':
        $q = "SELECT DISTINCT a.* FROM collection c";
        $q .= " left join fabrix_products a on c.pid = a.pid and c.type = 3";
        $q .= " where c.type = 3 and c.price > 0 and c.price <= 20 and a.image1 is not null";
        $q .= " limit " . $start . "," . $limit;
        break;
      case 'under_40':
        $q = "SELECT DISTINCT a.* FROM collection c";
        $q .= " left join fabrix_products a on c.pid = a.pid and c.type = 3";
        $q .= " where c.type = 3 and c.price > 20 and c.price <= 40 and a.image1 is not null";
        $q .= " limit " . $start . "," . $limit;
        break;
      case 'under_60':
        $q = "SELECT DISTINCT a.* FROM collection c";
        $q .= " left join fabrix_products a on c.pid = a.pid and c.type = 3";
        $q .= " where c.type = 3 and c.price > 40 and c.price <= 60 and a.image1 is not null";
        $q .= " limit " . $start . "," . $limit;
        break;
    }
    if($result = static::query($q)) {
      $res_count_rows = static::num_rows($result);
      $sys_hide_price = Model_Price::sysHideAllRegularPrices();
      $cart_items = isset(_A_::$app->session('cart')['items']) ? _A_::$app->session('cart')['items'] : [];
      $cart = array_keys($cart_items);
      while($row = static::fetch_array($result)) {
        $response[] = self::prepare_layout_product($row, $cart, $sys_hide_price, $image_suffix);
      }
      static::free_result($result);
    }

    return $response;
  }

  public static function get_widget_list_by_type_count($type){
    $response = null;
    $q = "";
    switch($type) {
      case 'new':
        $q = "SELECT COUNT(pid) FROM fabrix_products WHERE priceyard > 0 AND pnumber IS NOT NULL AND pvisible = '1'";
        $q .= " and image1 is not null";
        break;
      case 'carousel':
        $image_suffix = 'b_';
        $q = "SELECT COUNT(DISTINCT a.pid) FROM collection c";
        $q .= " left join fabrix_products a on c.pid = a.pid and c.type = 2";
        $q .= " where c.type = 2 and a.image1 is not null";
        break;
      case 'best':
        $image_suffix = 'b_';
        $q = "SELECT COUNT(pid) FROM fabrix_products WHERE priceyard > 0 AND pnumber IS NOT NULL AND pvisible = '1'";
        $q .= " and best = '1' and image1 is not null";
        break;
      case 'bestsellers':
        $image_suffix = 'b_';
        $q = "SELECT COUNT(DISTINCT a.pid) FROM collection c";
        $q .= " left join fabrix_products a on c.pid = a.pid and c.type = 1";
        $q .= " where c.type = 1 and a.image1 is not null";
        break;
      case 'popular':
        $image_suffix = 'b_';
        $q = "SELECT COUNT(pid) FROM fabrix_products WHERE priceyard > 0 AND pnumber IS NOT NULL AND pvisible = '1'";
        $q .= " and image1 is not null";
        break;
      case 'under_20':
        $q = "SELECT COUNT(DISTINCT a.pid) FROM collection c";
        $q .= " left join fabrix_products a on c.pid = a.pid and c.type = 3";
        $q .= " where c.type = 3 and c.price > 0 and c.price <= 20 and a.image1 is not null";
        break;
      case 'under_40':
        $q = "SELECT COUNT(DISTINCT a.pid) FROM collection c";
        $q .= " left join fabrix_products a on c.pid = a.pid and c.type = 3";
        $q .= " where c.type = 3 and c.price > 20 and c.price <= 40 and a.image1 is not null";
        break;
      case 'under_60':
        $q = "SELECT COUNT(DISTINCT a.pid) FROM collection c";
        $q .= " left join fabrix_products a on c.pid = a.pid and c.type = 3";
        $q .= " where c.type = 3 and c.price > 40 and c.price <= 60 and a.image1 is not null";
        break;
    }
    if($result = static::query($q)) {
      $response = static::fetch_value($result);
      static::free_result($result);
    }

    return $response;
  }

  public static function get_items_for_menu($type){
    $res = [];
    $row_new_count = 50;
    switch($type) {
      case 'all':
        $q = "SELECT distinct a.*" .
          " FROM fabrix_categories a" .
          " LEFT JOIN fabrix_product_categories c on a.cid = c.cid" .
          " LEFT JOIN fabrix_products b ON b.pid = c.pid" .
          " WHERE b.priceyard > 0 and b.pvisible = '1' and b.image1 is not null" .
          " ORDER BY a.displayorder, c.displayorder";
        break;
      case 'new':
        $q = "SELECT distinct a.*" .
          " FROM (SELECT pid FROM fabrix_products WHERE priceyard > 0 and pvisible = '1' and image1 is not null" .
          " ORDER BY dt DESC LIMIT " . $row_new_count . ") b" .
          " LEFT JOIN fabrix_product_categories c ON b.pid = c.pid" .
          " LEFT JOIN fabrix_categories a on a.cid = c.cid" . " ORDER BY a.displayorder, c.displayorder";
        break;
      case 'manufacturer':
        $q = "SELECT distinct a.*" .
          " FROM fabrix_products b " .
          " INNER JOIN fabrix_manufacturers a ON b.manufacturerId = a.id" .
          " WHERE b.priceyard > 0 and b.pvisible = '1' and b.image1 is not null" .
          " ORDER BY b.dt DESC";
        break;
      case 'patterns':
        $q = "SELECT distinct a.*" .
          " FROM  fabrix_patterns a" .
          " LEFT JOIN fabrix_product_patterns c on a.id = c.patternId" .
          " LEFT JOIN fabrix_products b ON  b.pid = c.prodId" .
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

  public static function get_total_count($filter = null){
    $response = 0;
    if(!empty($filter['type']) && in_array($filter['type'], array_keys(static::$list_conditions))) {
      $type = static::$list_conditions[$filter['type']];
      $query = "SELECT COUNT(a.pid) FROM collection cc";
      $query .= " left join fabrix_products a on cc.pid = a.pid and cc.type = " . $type;
      $query .= " LEFT JOIN fabrix_product_categories ON a.pid = fabrix_product_categories.pid";
      $query .= " LEFT JOIN fabrix_categories b ON fabrix_product_categories.cid = b.cid";
      $query .= " LEFT JOIN fabrix_product_colors ON a.pid = fabrix_product_colors.prodId";
      $query .= " LEFT JOIN fabrix_color c ON fabrix_product_colors.colorId = c.id";
      $query .= " LEFT JOIN fabrix_product_patterns ON a.pid = fabrix_product_patterns.prodId";
      $query .= " LEFT JOIN fabrix_patterns d ON d.id = fabrix_product_patterns.patternId";
      $query .= " LEFT JOIN fabrix_manufacturers e ON a.manufacturerId = e.id";
    } else {
      $query = "SELECT COUNT(DISTINCT a.pid) FROM " . static::$table . " a";
      $query .= " LEFT JOIN fabrix_product_categories ON a.pid = fabrix_product_categories.pid";
      $query .= " LEFT JOIN fabrix_categories b ON fabrix_product_categories.cid = b.cid";
      $query .= " LEFT JOIN fabrix_product_colors ON a.pid = fabrix_product_colors.prodId";
      $query .= " LEFT JOIN fabrix_color c ON fabrix_product_colors.colorId = c.id";
      $query .= " LEFT JOIN fabrix_product_patterns ON a.pid = fabrix_product_patterns.prodId";
      $query .= " LEFT JOIN fabrix_patterns d ON d.id = fabrix_product_patterns.patternId";
      $query .= " LEFT JOIN fabrix_manufacturers e ON a.manufacturerId = e.id";
    }
    $query .= static::build_where($filter);
    if($result = static::query($query)) {
      $response = static::fetch_value($result);
      static::free_result($result);
    }

    return $response;
  }

  public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null){
    $response = null;
    if(!empty($filter['type']) && in_array($filter['type'], array_keys(static::$list_conditions))) {
      $type = static::$list_conditions[$filter['type']];
      $query = "SELECT DISTINCT a.* FROM collection cc";
      $query .= " left join fabrix_products a on cc.pid = a.pid and cc.type = " . $type;
      $query .= " LEFT JOIN fabrix_product_categories ON a.pid = fabrix_product_categories.pid";
      $query .= " LEFT JOIN fabrix_categories b ON fabrix_product_categories.cid = b.cid";
      $query .= " LEFT JOIN fabrix_product_colors ON a.pid = fabrix_product_colors.prodId";
      $query .= " LEFT JOIN fabrix_color c ON fabrix_product_colors.colorId = c.id";
      $query .= " LEFT JOIN fabrix_product_patterns ON a.pid = fabrix_product_patterns.prodId";
      $query .= " LEFT JOIN fabrix_patterns d ON d.id = fabrix_product_patterns.patternId";
      $query .= " LEFT JOIN fabrix_manufacturers e ON a.manufacturerId = e.id";
    } else {
      $query = "SELECT DISTINCT a.* FROM " . static::$table . " a";
      $query .= " LEFT JOIN fabrix_product_categories ON a.pid = fabrix_product_categories.pid";
      $query .= " LEFT JOIN fabrix_categories b ON fabrix_product_categories.cid = b.cid";
      $query .= " LEFT JOIN fabrix_product_colors ON a.pid = fabrix_product_colors.prodId";
      $query .= " LEFT JOIN fabrix_color c ON fabrix_product_colors.colorId = c.id";
      $query .= " LEFT JOIN fabrix_product_patterns ON a.pid = fabrix_product_patterns.prodId";
      $query .= " LEFT JOIN fabrix_patterns d ON d.id = fabrix_product_patterns.patternId";
      $query .= " LEFT JOIN fabrix_manufacturers e ON a.manufacturerId = e.id";
    }
    $query .= static::build_where($filter);
    $query .= static::build_order($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";
    if($result = static::query($query)) {
      $res_count_rows = static::num_rows($result);
      $sys_hide_price = Model_Price::sysHideAllRegularPrices();
      $cart_items = isset(_A_::$app->session('cart')['items']) ? _A_::$app->session('cart')['items'] : [];
      $cart = array_keys($cart_items);
      while($row = static::fetch_array($result)) {
        $response[] = self::prepare_layout_product($row, $cart, $sys_hide_price);
      }
      static::free_result($result);
    }

    return $response;
  }

}