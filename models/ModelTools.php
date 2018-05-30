<?php

namespace models;

use app\core\App;
use app\core\model\ModelBase;

/**
 * Class ModelTools
 * @package models
 */
class ModelTools extends ModelBase{

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
          " WHERE b.priceyard > 0 and b.pvisible = '1'" .
          " ORDER BY a.displayorder";
        break;
      case 'new':
        $q = "SELECT distinct a.*" .
          " FROM (SELECT pid FROM shop_products WHERE priceyard > 0 and pvisible = '1' ORDER BY dt DESC LIMIT " . $row_new_count . ") b" .
          " LEFT JOIN shop_product_categories c ON b.pid = c.pid" .
          " LEFT JOIN shop_categories a on a.cid = c.cid" .
          " ORDER BY a.displayorder";
        break;
      case 'manufacturer':
        $q = "SELECT distinct a.*" .
          " FROM shop_products b " .
          " INNER JOIN shop_manufacturers a ON b.manufacturerId = a.id" .
          " WHERE b.priceyard > 0 and b.pvisible = '1'" .
          " ORDER BY b.dt DESC";
        break;
      case 'patterns':
        $q = "SELECT distinct a.*" .
          " FROM  shop_patterns a" .
          " LEFT JOIN shop_product_patterns c on a.id = c.patternId" .
          " LEFT JOIN shop_products b ON  b.pid = c.prodId" .
          " WHERE b.priceyard > 0 and b.pvisible = '1'";
        break;
      case 'blog_category':
        $q = "SELECT distinct a.*, c.group_id" .
          " FROM blog_groups a" .
          " LEFT JOIN blog_group_posts c on a.id = c.group_id" .
          " LEFT JOIN blog_posts b ON b.id = c.post_id" .
          " WHERE b.post_status = 'publish'";
        break;
    }
    $result = static::Query($q);
    while($row = static::FetchAssoc($result)) {
      $res[] = $row;
    }

    return $res;
  }

  /**
   * @return array
   * @throws \Exception
   */
  public static function meta_page(){
    $description = '';
    $keywords = '';
    $title = '';

    if(empty($title) && empty($description) && empty($keywords)) {
      $q = "SELECT * FROM page_meta WHERE controller = '" . App::$app->router()->controller . "'";
      if(!empty(App::$app->router()->action) && (App::$app->router()->controller !== App::$app->router()->action))
        $q .= " AND action = '" . App::$app->router()->action . "'";
      else $q .= " AND action is null";
      $result = static::Query($q);
      $row = static::FetchArray($result);
      if(!empty($row['id'])) {
        $title = $row['title'];
        $description = $row['description'];
        $keywords = $row['keywords'];
      }
    }

    if(empty($title)) $title = App::$app->KeyStorage()->system_site_name;
    if(empty($description)) $description = App::$app->KeyStorage()->system_site_name;
    if(empty($keywords)) {
      $keywords = array_filter(explode(' ', strtolower(App::$app->KeyStorage()->system_site_name)));
      array_unshift($keywords, strtolower(App::$app->KeyStorage()->system_site_name));
      $keywords = implode(',', $keywords);
    }

    return ['keywords' => $keywords, 'description' => $description, 'title' => $title];
  }

}