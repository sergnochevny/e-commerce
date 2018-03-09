<?php
/**
 * Date: 09.03.2018
 * Time: 12:28
 */

namespace classes\helpers;

use app\core\App;

class MatchesHelper{

  /**
   * @param $pid
   * @return bool
   */
  public static function product_in($pid){
    if(isset(App::$app->session('matches')['items'])) {
      $matches_items = App::$app->session('matches')['items'];
    } else {
      return false;
    }

    $item_added = false;
    foreach($matches_items as $key => $item) {
      if($item['pid'] == $pid) {
        $item_added = true;
        break;
      }
    }

    return $item_added;
  }

}