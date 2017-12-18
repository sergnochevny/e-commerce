<?php

class Model_Shop extends Model_Console{

  protected static $table = 'shop_products';

  public static function prepare_layout_product($row){
    $pid = $row['pid'];
    $price = $row['priceyard'];
    $inventory = $row['inventory'];
    $piece = $row['piece'];
    $price = Model_Price::getPrice($price, $inventory, $piece);

    $discountIds = [];
    $saleprice = $row['priceyard'];
    $saleprice = Model_Price::calculateProductSalePrice($saleprice, $discountIds);
    $row['bProductDiscount'] = Model_Price::checkProductDiscount($pid, $saleprice, $discountIds);
    $row['saleprice'] = Model_Price::getPrice($saleprice, $inventory, $piece);
    $row['price'] = $price;
    $row['discount'] = (round(($price - $saleprice) * 100) > 0);

    return $row;
  }

  public static function get_widget_list_by_type($type, $start, $limit, &$res_count_rows){
    $response = null;
    $q = "";
    switch($type) {
      case 'new':
        $q = "SELECT pid, priceyard, inventory, piece FROM shop_products ";
        $q .= "WHERE priceyard > 0 and pnumber is not null and ";
        $q .= "pvisible = '1' and image1 is not null ";
        $q .= "ORDER BY dt DESC, pid DESC LIMIT " . $start . "," . $limit;
        break;
      case 'best':
        $q = "SELECT pid, priceyard, inventory, piece FROM shop_products ";
        $q .= "WHERE priceyard > 0 and pnumber is not null and ";
        $q .= "pvisible = '1' and best = '1' and image1 is not null ";
        $q .= "ORDER BY pid DESC LIMIT " . $start . "," . $limit;
        break;
      case 'bestsellers':
        $q = "select n.pid, n.priceyard, n.inventory, n.piece" .
          " from (SELECT a.pid, SUM(b.quantity) as s" .
          " FROM shop_products a" .
          " LEFT JOIN shop_order_details b ON a . pid = b . product_id" .
          " WHERE a.priceyard > 0 and a.pnumber is not null and a.pvisible = '1' and a.image1 is not null" .
          " GROUP BY a . pid" .
          " ORDER BY s DESC" .
          " LIMIT " . $start . "," . $limit . ") m" .
          " LEFT JOIN shop_products n ON m.pid = n.pid";
        break;
      case 'popular':
        $q = "SELECT pid, priceyard, inventory, piece FROM shop_products ";
        $q .= "WHERE priceyard > 0 and pnumber is not null and ";
        $q .= "pvisible = '1' and image1 is not null ";
        $q .= "ORDER BY popular DESC LIMIT " . $start . "," . $limit;
        break;
      case 'under':
        $q = "SELECT pid, priceyard, inventory, piece FROM shop_products ";
        $q .= "WHERE priceyard > 0 and pnumber is not null and ";
        $q .= "pvisible = '1' and image1 is not null ";
        $q .= "ORDER BY priceyard ASC, pid DESC LIMIT " . $start . "," . $limit;
        break;
      case 'bestsellers_1':
        $q = "SELECT pid, priceyard, inventory, piece FROM shop_products ";
        $q .= "WHERE priceyard > 0 and pnumber is not null and ";
        $q .= "pvisible = '1' and specials != '1' and best = '1' and image1 is not null ";
        $q .= "ORDER BY pid DESC LIMIT " . $start . "," . $limit;
        break;
      case 'bestsellers_2':
        $q = "SELECT DISTINCT a.pid, a.priceyard, a.inventory, a.piece FROM shop_products a ";
        $q .= "LEFT JOIN shop_product_categories pc on a.pid = pc.pid ";
        $q .= "WHERE a.priceyard > 0 and a.pnumber is not null ";
        $q .= "and a.pvisible = '1' and a.specials != '1' and best != '1' and a.image1 is not null ";
        $q .= "and pc.cid != 13 ";
        $q .= "ORDER BY a.pid DESC LIMIT " . $start . "," . $limit;
        break;
      case 'specials_1':
        $q = "SELECT pid, priceyard, inventory, piece FROM shop_products ";
        $q .= "WHERE priceyard > 0 and pnumber is not null and ";
        $q .= "pvisible = '1' and specials = '1' and best != '1' and image1 is not null ";
        $q .= "ORDER BY pid DESC LIMIT " . $start . "," . $limit;
        break;
      case 'specials_2':
        $q = "SELECT DISTINCT a.pid, a.priceyard, a.inventory, a.piece FROM shop_products a ";
        $q .= "LEFT JOIN shop_product_categories pc on a.pid = pc.pid ";
        $q .= "WHERE a.priceyard > 0 and a.pnumber is not null ";
        $q .= "and a.pvisible = '1' and a.specials != '1' and best != '1' and a.image1 is not null ";
        $q .= "and pc.cid != 13 ";
        $q .= "ORDER BY a.pid DESC LIMIT " . $start . "," . $limit;
        break;
    }
    if($result = static::query($q)) {
      $res_count_rows = static::num_rows($result);
      while($row = static::fetch_assoc($result)) {
        $response[] = self::prepare_layout_product($row);
      }
    } else {
      throw new Exception(static::error());
    }

    return $response;
  }

  public static function get_total_count($filter = null){
    $response = 0;
    if(isset($filter['type']) && ($filter['type'] == 'bestsellers')) {
      $query = "SELECT COUNT(n.pid) FROM (";
      $query .= "SELECT a.pid, SUM(k.quantity) AS s FROM " . static::$table . " a";
      $query .= " LEFT JOIN shop_order_details k ON a.pid = k.product_id";
    } else {
      $query = "SELECT COUNT(DISTINCT a.pid) FROM " . static::$table . " a";
    }
    $query .= " LEFT JOIN shop_product_categories ON a.pid = shop_product_categories.pid";
    $query .= " LEFT JOIN shop_categories b ON shop_product_categories.cid = b.cid";
    $query .= " LEFT JOIN shop_product_colors ON a.pid = shop_product_colors.prodId";
    $query .= " LEFT JOIN shop_color c ON shop_product_colors.colorId = c.id";
    $query .= " LEFT JOIN shop_product_patterns ON a.pid = shop_product_patterns.prodId";
    $query .= " LEFT JOIN shop_patterns d ON d.id = shop_product_patterns.patternId";
    $query .= " LEFT JOIN shop_manufacturers e ON a.manufacturerId = e.id";
    $query .= static::build_where($filter);
    if(isset($filter['type']) && ($filter['type'] == 'bestsellers')) {
      $query .= " GROUP BY a.pid";
      $query .= " ORDER BY s DESC) m";
      $query .= " LEFT JOIN shop_products n ON m.pid = n.pid";
    }
    if($result = static::query($query)) {
      $response = static::fetch_value($result);
      static::free_result($result);
    } else {
      throw new Exception(static::error());
    }

    return $response;
  }

  public static function get_list($prepare, $start, $limit, &$res_count_rows, &$filter = null, &$sort = null){
    $response = null;
    if(isset($filter['type']) && ($filter['type'] == 'bestsellers')) {
      $query = "SELECT n.pid, n.priceyard, n.inventory, n.piece FROM (";
      $query .= "SELECT a.pid, SUM(k.quantity) AS s FROM " . static::$table . " a";
      $query .= " LEFT JOIN shop_order_details k ON a.pid = k.product_id";
    } else {
      $query = "SELECT DISTINCT a.pid, a.priceyard, a.inventory, a.piece FROM " . static::$table . " a";
    }
    $query .= " LEFT JOIN shop_product_categories ON a.pid = shop_product_categories.pid";
    $query .= " LEFT JOIN shop_categories b ON shop_product_categories.cid = b.cid";
    $query .= " LEFT JOIN shop_product_colors ON a.pid = shop_product_colors.prodId";
    $query .= " LEFT JOIN shop_color c ON shop_product_colors.colorId = c.id";
    $query .= " LEFT JOIN shop_product_patterns ON a.pid = shop_product_patterns.prodId";
    $query .= " LEFT JOIN shop_patterns d ON d.id = shop_product_patterns.patternId";
    $query .= " LEFT JOIN shop_manufacturers e ON a.manufacturerId = e.id";
    $query .= static::build_where($filter);
    if(isset($filter['type']) && ($filter['type'] == 'bestsellers')) {
      $query .= " GROUP BY a.pid";
    }
    $query .= static::build_order($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";
    if(isset($filter['type']) && ($filter['type'] == 'bestsellers')) {
      $query .= ") m";
      $query .= " LEFT JOIN shop_products n ON m.pid = n.pid";
    }
    if($result = static::query($query)) {
      $res_count_rows = static::num_rows($result);
      while($row = static::fetch_assoc($result)) {
        if($prepare) {
          $response[$row['pid']] = self::prepare_layout_product($row);
        } else {
          $response[$row['pid']] = $row['pid'];
        }
      }
    } else {
      throw new Exception(static::error());
    }

    return $response;
  }

}