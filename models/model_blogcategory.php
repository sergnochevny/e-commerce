<?php

  Class Model_Blogcategory extends Model_Base {

    protected static $table = 'blog_groups';

    private static function build_order(&$sort) {
      $order = '';
      if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
        $sort = ['a.name' => 'desc'];
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
        'id' => '',
        'name' => '',
      ];
      if(isset($id)) {
        $query = "SELECT * FROM blog_groups WHERE id = '$id'";
        $result = mysql_query($query);
        if($result) $response = mysql_fetch_assoc($result);
      }
      return $response;
    }

    public static function get_total_count($filter = null) {
      $response = 0;
      $query = "SELECT COUNT(DISTINCT a.id) FROM " . self::$table . " a";
      $query .= " LEFT JOIN blog_group_posts b ON a.id = b.group_id";
      $query .= static::build_where($filter);
      if($result = mysql_query($query)) {
        $response = mysql_fetch_row($result)[0];
      }
      return $response;
    }

    public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null) {
      $res = null;
      $q = "SELECT a.id, a.name, COUNT(b.group_id) AS amount ";
      $q .= " FROM " . self::$table . " a";
      $q .= " LEFT JOIN blog_group_posts b ON a.id = b.group_id";
      $q .= static::build_where($filter);
      $q .= " GROUP BY a.id, a.name";
      $q .= static::build_order($sort);
      if($limit != 0) $q .= " LIMIT $start, $limit";
      $result = mysql_query($q);
      if($result) {
        $res_count_rows = mysql_num_rows($result);
        while($row = mysql_fetch_array($result)) {
          $res[] = $row;
        }
      }
      return $res;
    }

    public static function delete($id) {
      if(isset($id)) {
        $query = "SELECT COUNT(*) FROM blog_group_posts WHERE id = $id";
        $res = mysql_query($query);
        if($res) {
          $amount = mysql_fetch_array($res)[0];
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
        $query = "DELETE FROM blog_groups WHERE id = $id";
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      }
    }

    public static function save($data) {
      extract($data);
      $name = mysql_real_escape_string($name);
      if(isset($id)) {
        $query = 'UPDATE blog_groups SET name = "' . $name . '" WHERE id = ' . $id;
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      } else {
        $query = 'INSERT INTO blog_groups (name) VALUE ("' . $name . '")';
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
        $id = mysql_insert_id();
      }
      return $id;
    }

  }