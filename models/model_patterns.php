<?php

  Class Model_Patterns extends Model_Base {

    protected static $table = 'fabrix_patterns';

    private static function build_order(&$sort) {
      $order = '';
      if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
        $sort = ['a.pattern' => 'asc'];
      }
      foreach($sort as $key => $val) {
        if(strlen($order) > 0) $order .= ',';
        $order .= ' ' . $key . ' ' . $val;
      }
      $order = ' ORDER BY ' . $order;
      return $order;
    }

    public static function get_by_id($id) {
      $response = [
        'id' => $id,
        'pattern' => ''
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
      $query = "SELECT COUNT(*) FROM " . static::$table;
      $query .= static::build_where($filter);
      if($result = mysql_query($query)) {
        $response = mysql_fetch_row($result)[0];
      }
      return $response;
    }

    public static function get_list($start, $limit, &$res_count_rows, $filter = null, &$sort = null) {
      $response = null;
      $query = "SELECT a.id, a.pattern, count(b.prodId) AS amount";
      $query .= " FROM " . static::$table . " a";
      $query .= " LEFT JOIN fabrix_product_patterns b ON b.patternId = a.id";
      $query .= static::build_where($filter);
      $query .= " GROUP BY a.id, a.pattern";
      $query .= static::build_order($sort);
      if ( $limit != 0 ) $query .= " LIMIT $start, $limit";

      if($result = mysql_query($query)) {
        $res_count_rows = mysql_num_rows($result);
        while($row = mysql_fetch_array($result)) {
          $response[] = $row;
        }
      }

      return $response;
    }

    public static function save($data) {
      extract($data);
      if(isset($id)) {
        $query = "UPDATE " . static::$table . " SET pattern ='" . $pattern . "' WHERE id =" . $id;
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      } else {
        $query = "INSERT INTO " . static::$table . " (pattern) VALUE ('" . $pattern . "')";
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
        $id = mysql_insert_id();
      }
      return $id;
    }

    public static function delete($id) {
      if(isset($id)) {
        $query = "select count(*) from fabrix_product_patterns where patternId = $id";
        $res = mysql_query($query);
        if($res) {
          $amount = mysql_fetch_array($res)[0];
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
        $query = "DELETE FROM  " . static::$table . " WHERE id = $id";
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      }
    }

  }