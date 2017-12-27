<?php

namespace models;

use app\core\App;
use app\core\model\ModelBase;

/**
 * Class ModelMatches
 * @package models
 */
class ModelMatches extends ModelBase{

  /**
   * @return null
   */
  public static function get_fields(){
    return null;
  }

  /**
   * @param null $filter
   * @return int|void
   */
  public static function get_total_count($filter = null){
    $response = 0;
    if(isset(App::$app->session('matches')['items'])) {
      $matches_items = App::$app->session('matches')['items'];
      $response = count($matches_items);
    }

    return $response;
  }

  /**
   * @param $start
   * @param $limit
   * @param $res_count_rows
   * @param null $filter
   * @param null $sort
   * @return null
   * @throws \Exception
   */
  public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null){
    $response = null;
    if(isset(App::$app->session('matches')['items'])) {
      $matches_items = App::$app->session('matches')['items'];
      if($res_count_rows = count($matches_items) > 0) {
        $left = 2;
        $top = 2;
        foreach($matches_items as $key => $item) {
          $response[$key]['pid'] = $item['pid'];
          $response[$key]['pname'] = $item['pname'];
          $response[$key]['img'] = App::$app->router()->UrlTo('images/products/' . $item['img']);
          $response[$key]['top'] = $top;
          $response[$key]['left'] = $left;
          $left += 6;
          $top += 4;
        }
      }
    }

    return $response;
  }

  /**
   * @param $data
   * @return bool
   * @throws \Exception
   */
  public static function save(&$data){
    extract($data);
    $added = false;
    if(!empty($pid)) {
      $matches_items = isset(App::$app->session('matches')['items']) ?
        App::$app->session('matches')['items'] : [];
      $item_added = false;
      if(count($matches_items) > 0) {
        foreach($matches_items as $key => $item) {
          if($item['pid'] == $pid) {
            $item_added = true;
          }
        }
      }

      if(!$item_added) {
        $suffix_img = 'b_';
        $product = ModelProduct::get_by_id($pid);

        if(isset($product['image1'])) {
          $file_img = 'images/products/' . $product['image1'];
          if(file_exists($file_img) && is_file($file_img)) {
            $product['image1'] = $suffix_img . $product['image1'];
            $matches_items[] = ['pid' => $pid, 'pname' => $product['pname'], 'img' => $product['image1']];
          }
          $added = true;
        }
      }
      $_matches = App::$app->session('matches');
      $_matches['items'] = $matches_items;
      App::$app->setSession('matches', $_matches);
    }

    return $added;
  }

  /**
   * @param $id
   */
  public static function delete($id){
    if(!empty($id)) {
      $matches_items = isset(App::$app->session('matches')['items']) ?
        App::$app->session('matches')['items'] : [];
      if(count($matches_items) > 0) {
        foreach($matches_items as $key => $item) {
          if($item['pid'] == $id) {
            unset($matches_items[$key]);
          }
        }
      }
      $_matches = App::$app->session('matches');
      $_matches['items'] = $matches_items;
      App::$app->setSession('matches', $_matches);
    }
  }

  /**
   *
   */
  public static function clear(){
    if(isset(App::$app->session('matches')['items'])) {
      App::$app->setSession('matches', null);
    }
  }

}