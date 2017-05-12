<?php

Class Model_Shop extends Model_Base
{

  protected static $table = 'fabrix_products';

  protected static function build_where(&$filter)
  {
    $result_where = "";
    if (Controller_Admin::is_logged()) {
      if (!empty($filter["a.pname"]))
        foreach (array_filter(explode(' ', $filter["a.pname"])) as $item)
          if (!empty($item)) $result[] = "a.pname LIKE '%" . static::escape( static::strip_data(static::sanitize($item))) . "%'";
    } else {
      if (isset($filter["a.pname"])) $result[] = Model_Synonyms::build_synonyms_like("a.pname", $filter["a.pname"]);
    }
    if (isset($filter["a.pvisible"])) $result[] = "a.pvisible = '" . static::escape( static::strip_data(static::sanitize($filter["a.pvisible"]))) . "'";
    if (isset($filter["a.piece"])) $result[] = "a.piece = '" . static::escape( static::strip_data(static::sanitize($filter["a.piece"]))) . "'";
    if (isset($filter["a.dt"])) {
      $where = (!empty($filter["a.dt"]['from']) ? "a.dt >= '" . static::escape( static::strip_data(static::sanitize($filter["a.dt"]["from"]))) . "'" : "") .
        (!empty($filter["a.dt"]['to']) ? " AND a.dt <= '" . static::escape( static::strip_data(static::sanitize($filter["a.dt"]["to"]))) . "'" : "");
      if (strlen(trim($where)) > 0) $result[] = "(" . $where . ")";
    }
    if (isset($filter["a.pnumber"])) $result[] = "a.pnumber LIKE '%" . static::escape( static::strip_data(static::sanitize($filter["a.pnumber"]))) . "%'";
    if (isset($filter["a.best"])) $result[] = "a.best = '" . static::escape( static::strip_data(static::sanitize($filter["a.best"]))) . "'";
    if (isset($filter["a.specials"])) $result[] = "a.specials = '" . static::escape( static::strip_data(static::sanitize($filter["a.specials"]))) . "'";
    if (isset($filter["b.cid"])) $result[] = "b.cid = '" . static::escape( static::strip_data(static::sanitize($filter["b.cid"]))) . "'";
    if (isset($filter["c.id"])) $result[] = "c.id = '" . static::escape( static::strip_data(static::sanitize($filter["c.id"]))) . "'";
    if (isset($filter["d.id"])) $result[] = "d.id = '" . static::escape( static::strip_data(static::sanitize($filter["d.id"]))) . "'";
    if (isset($filter["e.id"])) $result[] = "e.id = '" . static::escape( static::strip_data(static::sanitize($filter["e.id"]))) . "'";
    if (isset($filter["a.priceyard"]['from']) && !empty((float)$filter["a.priceyard"]['from'])) $result[] = "a.priceyard > '" . static::escape( static::strip_data(static::sanitize($filter["a.priceyard"]['from']))) . "'";
    if (isset($filter["a.priceyard"]['to']) && !empty((float)$filter["a.priceyard"]['to'])) $result[] = "a.priceyard <= '" . static::escape( static::strip_data(static::sanitize($filter["a.priceyard"]['to']))) . "'";
    if (!empty($result) && (count($result) > 0)) {
      if (strlen(trim(implode(" AND ", $result))) > 0) {
        $filter['active'] = true;
      }
    }
    if (isset($filter['hidden']['a.priceyard']) && !is_array($filter['hidden']['a.priceyard'])) $result[] = "a.priceyard > '" . static::escape( static::strip_data(static::sanitize($filter['hidden']["a.priceyard"]))) . "'";
    if (isset($filter['hidden']['a.pvisible'])) $result[] = "a.pvisible = '" . static::escape( static::strip_data(static::sanitize($filter['hidden']["a.pvisible"]))) . "'";
    if (isset($filter['hidden']["a.pnumber"])) $result[] = "a.pnumber is not null";
    if (isset($filter['hidden']["a.image1"])) $result[] = "a.image1 is not null";
    if (isset($filter['hidden']["b.cid"])) $result[] = "b.cid = '" . static::escape( static::strip_data(static::sanitize($filter['hidden']["b.cid"]))) . "'";
    if (isset($filter['hidden']["c.id"])) $result[] = "c.id = '" . static::escape( static::strip_data(static::sanitize($filter['hidden']["c.id"]))) . "'";
    if (isset($filter['hidden']["d.id"])) $result[] = "d.id = '" . static::escape( static::strip_data(static::sanitize($filter['hidden']["d.id"]))) . "'";
    if (isset($filter['hidden']["e.id"])) $result[] = "e.id = '" . static::escape( static::strip_data(static::sanitize($filter['hidden']["e.id"]))) . "'";
    if (isset($filter['hidden']["a.best"])) $result[] = "a.best = '" . static::escape( static::strip_data(static::sanitize($filter['hidden']["a.best"]))) . "'";
    if (isset($filter['hidden']["a.specials"])) $result[] = "a.specials = '" . static::escape( static::strip_data(static::sanitize($filter['hidden']["a.specials"]))) . "'";
    if (isset($filter['hidden']["a.priceyard"]['from']) && !empty((float)$filter['hidden']["a.priceyard"]['from'])) $result[] = "a.priceyard > '" . static::escape( static::strip_data(static::sanitize($filter['hidden']["a.priceyard"]['from']))) . "'";
    if (isset($filter['hidden']["a.priceyard"]['to']) && !empty((float)$filter['hidden']["a.priceyard"]['to'])) $result[] = "a.priceyard <= '" . static::escape( static::strip_data(static::sanitize($filter['hidden']["a.priceyard"]['to']))) . "'";
    if (!empty($result) && (count($result) > 0)) {
      $result_where = implode(" AND ", $result);
      $result_where = (!empty($result_where) ? " WHERE " . $result_where : '');
    }
    return $result_where;
  }

  public static function prepare_layout_product($row, $cart, $sys_hide_price, $image_suffix = 'b_')
  {
    $row['sdesc'] = substr($row['sdesc'], 0, 100);
    $row['ldesc'] = substr($row['ldesc'], 0, 100);
    $filename = 'upload/upload/' . $image_suffix . $row['image1'];
    if (!(file_exists($filename) && is_file($filename))) {
      $filename = 'upload/upload/not_image.jpg';
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
    return $row;
  }

  public static function prepare_layout_product_detail($data, $cart, $sys_hide_price)
  {
    if (Controller_Matches::product_in($data['pid'])) $data['in_matches'] = true;
    $priceyard = $data['priceyard'];
    $aPrds = [];
    $aPrds[] = $data['pid'];    #add product id
    $aPrds[] = 1;        #add qty

    #get the shipping
    if (isset($cart['ship'])) {
      $shipping = (int)$cart['ship'];
    } else {
      $shipping = DEFAULT_SHIPPING;
      $cart['ship'] = $shipping;
      _A_::$app->setSession('cart', $cart);
    }

    if (isset($cart['ship_roll'])) {
      $data['bShipRoll'] = (boolean)$cart['ship_roll'];
    } else {
      $data['bShipRoll'] = false;
      $cart['ship_roll'] = 0;
      _A_::$app->setSession('cart', $cart);
    }

    $shipcost = 0;
    $uid = 0;
    if (Controller_User::is_logged()) $uid = (int)Controller_User::get_from_session()['aid'];
    $bTemp = false;

    $bSystemDiscount = false;
    $discountIds = [];
    $sSystemDiscount = false;
    $sPriceDiscount = '';
    $rDiscountPrice = 0;
    $rSystemDiscount = Model_Price::calculateDiscount(DISCOUNT_CATEGORY_ALL, $uid, $aPrds, $priceyard, $shipcost, '', $bTemp, true, $sPriceDiscount, $sSystemDiscount, $shipping, $discountIds);
    if ((strlen($sSystemDiscount) > 0) || ($rSystemDiscount > 0)) {
      $bSystemDiscount = true;
      $rDiscountPrice = $priceyard - $rSystemDiscount;
    }

    #check the price for the discount
    if ($bSystemDiscount) {
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

    if (count($discountIds) > 0) {
      $data['next_change'] = (Model_Price::getNextChangeInDiscoutDate($discountIds) > 0);
      $data['time_rem'] = Model_Price::displayDiscountTimeRemaining($discountIds);
    }

    if (isset($cart['items'])) {
      $cart_items = $cart['items'];
    } else {
      $cart_items = [];
    }
    if (isset($cart['samples_items'])) {
      $samples_items = $cart['samples_items'];
    } else {
      $samples_items = [];
    }
    $data['in_samples_cart'] = in_array($data['pid'], array_keys($samples_items));
    $data['in_cart'] = in_array($data['pid'], array_keys($cart_items));

    $data['img1_exists'] = true;
    $data['filename'] = 'upload/upload/' . $data['image1'];
    $data['filename1'] = 'upload/upload/' . 'v_' . $data['image1'];
    if (!(file_exists($data['filename']) && is_file($data['filename']) && is_readable($data['filename']))) {
      $data['filename'] = "upload/upload/not_image.jpg";
      $data['filename1'] = null;
      $data['img1_exists'] = false;
    }
    $data['filename'] = _A_::$app->router()->UrlTo($data['filename']);
    $data['filename1'] = isset($data['filename1']) ? _A_::$app->router()->UrlTo($data['filename1']) : null;
    for ($i = 2; $i < 6; $i++) {
      if (!empty($data['image' . $i])) {
        $data['img' . $i . '_filename'] = 'upload/upload/b_' . $data['image' . $i];
        $data['img' . $i . '_filename1'] = 'upload/upload/v_' . $data['image' . $i];
        if (!(file_exists($data['img' . $i . '_filename']) && is_file($data['img' . $i . '_filename']) && is_readable($data['img' . $i . '_filename']))) {
          $data['img' . $i . '_filename'] = "upload/upload/not_image.jpg";
          $data['img' . $i . '_filename1'] = null;
        }
        $data['img' . $i . '_filename'] = _A_::$app->router()->UrlTo($data['img' . $i . '_filename']);
        $data['img' . $i . '_filename1'] = isset($data['img' . $i . '_filename1']) ? _A_::$app->router()->UrlTo($data['img' . $i . '_filename1']) : null;
      }
    }

    return $data;
  }

  public static function set_inventory($pid, $inventory = 0)
  {
    $q = "update fabrix_products set inventory=" . $inventory;
    $q .= ($inventory <= 0) ? ", pvisible = 0" : "";
    $q .= " where pid=" . $pid;
    $res = static::query( $q);
  }

  public static function get_product_params($pid)
  {

    $data = Model_Product::get_by_id($pid);
    $quatity = ($data['inventory'] > 1) ? 1 : $data['inventory'];
    if ($data['piece'] == 1) $quatity = 1;

    return [
      'pid' => $data['pid'],
      'pname' => $data['pname'],
      'pnumber' => $data['pnumber'],
      'price' => $data['priceyard'],
      'stock_number' => $data['stock_number'],
      'quantity' => $quatity,
      'inventory' => $data['inventory'],
      'piece' => $data['piece'],
      'whole' => $data['whole'],
      'image1' => $data['image1']
    ];
  }

  public static function get_product($pid)
  {
    self::inc_popular($pid);
    $row = Model_Product::get_by_id($pid);
    if (!$row) throw new Exception('The Required Fabric do not exist!!');
    $sys_hide_price = Model_Price::sysHideAllRegularPrices();
    $cart = _A_::$app->session('cart');
    $response = self::prepare_layout_product_detail($row, $cart, $sys_hide_price);

    return $response;
  }

  public static function inc_popular($pid)
  {
    static::query( "update fabrix_products set popular = popular+1 WHERE pid='$pid'");
  }

  public static function get_widget_list_by_type($type, $start, $limit, &$res_count_rows)
  {
    $response = null;
    $q = "";
    $image_suffix = '';
    switch ($type) {
      case 'new':
        $q = "SELECT * FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' and image1 is not null ORDER BY  dt DESC, pid DESC LIMIT " . $start . "," . $limit;
        break;
      case 'carousel':
        $image_suffix = 'b_';
        $q = "SELECT * FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' and image1 is not null ORDER BY  dt DESC, pid DESC LIMIT " . $start . "," . $limit;
        break;
      case 'best':
        $q = "SELECT * FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' and best = '1' and image1 is not null ORDER BY pid DESC LIMIT " . $start . "," . $limit;
        break;
      case 'bestsellers':
        $q = "select n.*" .
          " from (SELECT a.pid, SUM(b.quantity) as s" .
          " FROM fabrix_products a" .
          " LEFT JOIN fabrix_order_details b ON a . pid = b . product_id" .
          " WHERE a . pnumber is not null and a . pvisible = '1' and a.image1 is not null" .
          " GROUP BY a . pid" .
          " ORDER BY s DESC" .
          " LIMIT " . $start . "," . $limit . ") m" .
          " LEFT JOIN fabrix_products n ON m.pid = n.pid";
        break;
      case 'popular':
        $q = "SELECT * FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' and image1 is not null ORDER BY popular DESC LIMIT " . $start . "," . $limit;
        break;
    }
    if ($result = static::query( $q)) {
      $res_count_rows = static::num_rows($result);
      $sys_hide_price = Model_Price::sysHideAllRegularPrices();
      $cart_items = isset(_A_::$app->session('cart')['items']) ? _A_::$app->session('cart')['items'] : [];
      $cart = array_keys($cart_items);
      while ($row = static::fetch_array($result)) {
        $response[] = self::prepare_layout_product($row, $cart, $sys_hide_price, $image_suffix);
      }
    }
    return $response;
  }

  public static function get_items_for_menu($type)
  {
    $res = [];
    $row_new_count = 50;
    switch ($type) {
      case 'all':
        $q = "SELECT distinct a.*" .
          " FROM fabrix_categories a" .
          " LEFT JOIN fabrix_product_categories c on a.cid = c.cid" .
          " LEFT JOIN fabrix_products b ON b.pid = c.pid" .
          " WHERE b.pvisible = '1' and b.image1 is not null" .
          " ORDER BY a.displayorder, c.displayorder";
        break;
      case 'new':
        $q = "SELECT distinct a.*" .
          " FROM (SELECT pid FROM fabrix_products WHERE pvisible = '1' and image1 is not null ORDER BY dt DESC LIMIT " . $row_new_count . ") b" .
          " LEFT JOIN fabrix_product_categories c ON b.pid = c.pid" .
          " LEFT JOIN fabrix_categories a on a.cid = c.cid" .
          " ORDER BY a.displayorder, c.displayorder";
        break;
      case 'manufacturer':
        $q = "SELECT distinct a.*" .
          " FROM fabrix_products b " .
          " INNER JOIN fabrix_manufacturers a ON b.manufacturerId = a.id" .
          " WHERE b.pvisible = '1' and b.image1 is not null" .
          " ORDER BY b.dt DESC";
        break;
      case 'patterns':
        $q = "SELECT distinct a.*" .
          " FROM  fabrix_patterns a" .
          " LEFT JOIN fabrix_product_patterns c on a.id = c.patternId" .
          " LEFT JOIN fabrix_products b ON  b.pid = c.prodId" .
          " WHERE b.pvisible = '1' and b.image1 is not null";
        break;
      case 'blog_category':
        $q = "SELECT distinct a.*" .
          " FROM blog_groups a" .
          " LEFT JOIN blog_group_posts c on a.id = c.group_id" .
          " LEFT JOIN blog_posts b ON b.ID = c.object_id" .
          " WHERE b.post_status = 'publish'";
        break;
    }
    $result = static::query( $q);
    while ($row = static::fetch_assoc($result)) {
      $res[] = $row;
    }
    return $res;
  }

  public static function get_total_count($filter = null)
  {
    $response = 0;
    if (isset($filter['type']) && ($filter['type'] == 'bestsellers')) {
      $query = "select COUNT(n.pid) from (";
      $query .= "SELECT a.pid, SUM(k.quantity) as s FROM " . static::$table . " a";
      $query .= " LEFT JOIN fabrix_order_details k ON a.pid = k.product_id";
    } else {
      $query = "SELECT COUNT(DISTINCT a.pid) FROM " . static::$table . " a";
    }
    $query .= " LEFT JOIN fabrix_product_categories ON a.pid = fabrix_product_categories.pid";
    $query .= " LEFT JOIN fabrix_categories b ON fabrix_product_categories.cid = b.cid";
    $query .= " LEFT JOIN fabrix_product_colors ON a.pid = fabrix_product_colors.prodId";
    $query .= " LEFT JOIN fabrix_color c ON fabrix_product_colors.colorId = c.id";
    $query .= " LEFT JOIN fabrix_product_patterns ON a.pid = fabrix_product_patterns.prodId";
    $query .= " LEFT JOIN fabrix_patterns d ON d.id = fabrix_product_patterns.patternId";
    $query .= " LEFT JOIN fabrix_manufacturers e ON a.manufacturerId = e.id";
    $query .= static::build_where($filter);
    if (isset($filter['type']) && ($filter['type'] == 'bestsellers')) {
      $query .= " GROUP BY a.pid";
      $query .= " ORDER BY s DESC) m";
      $query .= " LEFT JOIN fabrix_products n ON m.pid = n.pid";
    }
    if ($result = static::query( $query)) {
      $response = static::fetch_row($result)[0];
    }
    return $response;
  }

  public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null)
  {
    $response = null;
    if (isset($filter['type']) && ($filter['type'] == 'bestsellers')) {
      $query = "select n.* from (";
      $query .= "SELECT a.pid, SUM(k.quantity) as s FROM " . static::$table . " a";
      $query .= " LEFT JOIN fabrix_order_details k ON a.pid = k.product_id";
    } else {
      $query = "SELECT DISTINCT a.* FROM " . static::$table . " a";
    }
    $query .= " LEFT JOIN fabrix_product_categories ON a.pid = fabrix_product_categories.pid";
    $query .= " LEFT JOIN fabrix_categories b ON fabrix_product_categories.cid = b.cid";
    $query .= " LEFT JOIN fabrix_product_colors ON a.pid = fabrix_product_colors.prodId";
    $query .= " LEFT JOIN fabrix_color c ON fabrix_product_colors.colorId = c.id";
    $query .= " LEFT JOIN fabrix_product_patterns ON a.pid = fabrix_product_patterns.prodId";
    $query .= " LEFT JOIN fabrix_patterns d ON d.id = fabrix_product_patterns.patternId";
    $query .= " LEFT JOIN fabrix_manufacturers e ON a.manufacturerId = e.id";
    $query .= static::build_where($filter);
    if (isset($filter['type']) && ($filter['type'] == 'bestsellers')) {
      $query .= " GROUP BY a.pid";
    }
    $query .= static::build_order($sort);
    if ($limit != 0) $query .= " LIMIT $start, $limit";
    if (isset($filter['type']) && ($filter['type'] == 'bestsellers')) {
      $query .= ") m";
      $query .= " LEFT JOIN fabrix_products n ON m.pid = n.pid";
    }
    if ($result = static::query( $query)) {
      $res_count_rows = static::num_rows($result);
      $sys_hide_price = Model_Price::sysHideAllRegularPrices();
      $cart_items = isset(_A_::$app->session('cart')['items']) ? _A_::$app->session('cart')['items'] : [];
      $cart = array_keys($cart_items);
      while ($row = static::fetch_array($result)) {
        $response[] = self::prepare_layout_product($row, $cart, $sys_hide_price);
      }
    }
    return $response;
  }

}