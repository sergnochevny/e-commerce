<?php

  Class Model_Matches extends Model_Base {

    public static function get_total_count($filter = null) {
      $response = 0;
      if(isset(_A_::$app->session('matches')['items'])) {
        $matches_items = _A_::$app->session('matches')['items'];
        $response = count($matches_items);
      }
      return $response;
    }

    public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null) {
      $response = null;
      if(isset(_A_::$app->session('matches')['items'])) {
        $matches_items = _A_::$app->session('matches')['items'];
        if($res_count_rows = count($matches_items) > 0) {
          $left = 2;
          $top = 2;
          foreach($matches_items as $key => $item) {
            $response[$key]['pid'] = $item['pid'];
            $response[$key]['pname'] = $item['pname'];
            $response[$key]['img'] = _A_::$app->router()->UrlTo('upload/upload/' . $item['img']);
            $response[$key]['top'] = $top;
            $response[$key]['left'] = $left;
            $left += 6;
            $top += 4;
          }
        }
      }
      return $response;
    }

    public static function save(&$data) {
      extract($data);
      $added = false;
      if(!empty($pid)) {
        $matches_items = isset(_A_::$app->session('matches')['items']) ? _A_::$app->session('matches')['items'] : [];
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
          $product = Model_Product::get_by_id($pid);

          if(isset($product['image1'])) {
            $file_img = 'upload/upload/' . $product['image1'];
            if(file_exists($file_img) && is_file($file_img)) {
              $product['image1'] = $suffix_img . $product['image1'];
              $matches_items[] = ['pid' => $pid, 'pname'=> $product['pname'], 'img' => $product['image1']];
            }
            $added = true;
          }
        }
        $_matches = _A_::$app->session('matches');
        $_matches['items'] = $matches_items;
        _A_::$app->setSession('matches', $_matches);
      }
      return $added;
    }

    public static function delete($id) {
      if(!empty($id)) {
        $matches_items = isset(_A_::$app->session('matches')['items']) ? _A_::$app->session('matches')['items'] : [];
        if(count($matches_items) > 0) {
          foreach($matches_items as $key => $item) {
            if($item['pid'] == $id) {
              unset($matches_items[$key]);
            }
          }
        }
        $_matches = _A_::$app->session('matches');
        $_matches['items'] = $matches_items;
        _A_::$app->setSession('matches', $_matches);
      }
    }

    public static function clear(){
      if(isset(_A_::$app->session('matches')['items'])) {
        _A_::$app->setSession('matches', null);
      }
    }

  }