<?php
/**
 * Date: 09.03.2018
 * Time: 12:28
 */

namespace classes\helpers;

use Exception;
use models\ModelFavorites;

class FavoritesHelper{
  /**
   * @param $pid
   * @return bool
   */
  public static function product_in($pid){
    $res = false;
    $aid = !empty(UserHelper::get_from_session()['aid']) ? UserHelper::get_from_session()['aid'] : null;
    if(!empty($aid)) {
      try {
        $res = ModelFavorites::get_by_id($pid, $aid);
        $res = (isset($res) && is_array($res) && (count($res) > 0));
      } catch(Exception $e) {
      };
    }

    return $res;
  }

}