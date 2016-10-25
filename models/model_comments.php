<?php

  class Model_Comments extends Model_Base {

    protected static $table = 'fabrix_comments';

    private static function build_order(&$sort) {
      $order = '';
      if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
        $sort = ['a.dt' => 'desc'];
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
      $query = "SELECT COUNT(*) FROM " . static::$table;
      $query .= static::build_where($filter);
      if($result = mysql_query($query)) {
        $response = mysql_fetch_row($result)[0];
      }
      return $response;
    }

    public static function get_list($start, $limit, &$res_count_rows, $filter = null, &$sort = null) {
      $response = null;
      $query = "SELECT a.*, b.aid, b.email ";
      $query .= " FROM " . static::$table . " a";
      $query .= " LEFT JOIN fabrix_accounts b ON b.aid = a.userid";
      $query .= static::build_where($filter);
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
        $query = 'UPDATE ' . static::$table . ' SET `title` = "' . $title . '", `data` = "' . $data . '",`moderated` = "' . $moderated . '" WHERE id =' . $id;
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      } else {
        $query = 'INSERT INTO ' . static::$table . '(title, data, moderated) VALUE ("' . $title . '","' . $data . '","' . $moderated . '")';
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
        $id = mysql_insert_id();
      }
      return $id;
    }

    public static function moderate($id, $action) {
      $query = 'UPDATE ' . static::$table . ' SET `moderated` = "' . $action . '" WHERE id =' . $id;
      return mysql_query($query) ? true : false;
    }

    public static function delete($id) {
      if(isset($id)) {
        $query = "DELETE FROM " . static::$table . " WHERE id = $id";
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      }
    }

  }