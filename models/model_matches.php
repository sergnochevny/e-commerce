<?php

  Class Model_Matches extends Model_Base {

    public static function get_by_id($id) {
      $response = [
        'id' => $id,
        'colour' => ''
      ];
      if(isset($id)) {
        $query = "SELECT * FROM " . static::$table . " WHERE id='$id'";
        $result = mysql_query($query);
        if($result) $response = mysql_fetch_assoc($result);
      }
      return $response;
    }

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
            $response['product_id'] = $item['pid'];
            $response['img'] = _A_::$app->router()->UrlTo('upload/upload/' . $item['img']);
            $response['top'] = $top;
            $response['left'] = $left;
            $left += 6;
            $top += 4;
          }
        }
      }
      return $response;
    }

    public static function save($data) {
      extract($data);
      if(isset($id)) {
        $query = 'UPDATE ' . static::$table . ' SET colour ="' . $colour . '" WHERE id =' . $id;
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      } else {
        $query = 'INSERT INTO ' . static::$table . '(colour) VALUE ("' . $colour . '")';
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
        $id = mysql_insert_id();
      }
      return $id;
    }

    public static function delete($id) {
      if(isset($id)) {
        $query = "SELECT COUNT(*) FROM fabrix_product_colours WHERE colourId = $id";
        $res = mysql_query($query);
        if($res) {
          $amount = mysql_fetch_array($res)[0];
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
        $query = "DELETE FROM " . static::$table . " WHERE id = $id";
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      }
    }

  }