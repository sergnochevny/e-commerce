<?php

namespace console\models;

use app\core\console\model\ModelConsole;
use Exception;

/**
 * Class ModelShop
 * @package console\models
 */
class ModelShop extends ModelConsole{

  /**
   * @var string
   */
  protected static $table = 'shop_products';

  /**
   * @param $row
   * @return mixed
   * @throws \Exception
   */
  public static function PrepareLayoutProduct($row){
    $pid = $row['pid'];
    $price = $row['priceyard'];
    $inventory = $row['inventory'];
    $piece = $row['piece'];
    $price = ModelPrice::getPrice($price, $inventory, $piece);

    $discountIds = [];
    $saleprice = $row['priceyard'];
    $saleprice = ModelPrice::calculateProductSalePrice($saleprice, $discountIds);
    $row['bProductDiscount'] = ModelPrice::checkProductDiscount($pid, $saleprice, $discountIds);
    $row['saleprice'] = ModelPrice::getPrice($saleprice, $inventory, $piece);
    $row['price'] = $price;
    $row['discount'] = (round(($price - $saleprice) * 100) > 0);

    return $row;
  }

  /**
   * @param $type
   * @param $start
   * @param $limit
   * @param $res_count_rows
   * @return array|null
   * @throws \Exception
   */
  public static function getWidgetListByType($type, $start, $limit, &$res_count_rows){
    $response = [];
    $prms = [];
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
    if($result = static::Query($q, $prms)) {
      $res_count_rows = static::getNumRows($result);
      while($row = static::FetchAssoc($result)) {
        $response[] = static::PrepareLayoutProduct($row);
      }
    } else {
      throw new Exception(static::Error());
    }

    return $response;
  }

}