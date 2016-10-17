<?php

  Class Model_Blogcategory extends Model_Model {

    public static function get_by_id($id) {
      $response = [

        'name' => '',
        'slug' => ''
      ];
      if(isset($id)) {
        $query = "SELECT * FROM blog_groups WHERE group_id = '$id'";
        $result = mysql_query($query);
        if($result) $response = mysql_fetch_assoc($result);
      }
      return $response;
    }


    public static function get_all(){
      $res = null;
      $q = "SELECT a.group_id, a.name, COUNT(b.group_id) AS amount FROM blog_groups a";
      $q .= " LEFT JOIN blog_group_posts b ON a.group_id = b.group_id";
      $q .= " GROUP BY a.group_id, a.name";
      $q .= " ORDER BY a.name";
      $result = mysql_query($q);
      if($result) {
        while($row = mysql_fetch_array($result)) {
          $res[] = $row;
        }
      }
      return $res;
    }

    public static function get_total_count($filter = null) {
      $response = 0;
      $query = "SELECT COUNT(*) FROM blog_groups";
      $query .= static::build_where($filter);
      if($result = mysql_query($query)) {
        $response = mysql_fetch_row($result)[0];
      }
      return $response;
    }

    public static function delete($id) {
      if(isset($id)) {
        $query = "SELECT COUNT(*) FROM blog_group_posts WHERE group_id = $id";
        $res = mysql_query($query);
        if($res) {
          $amount = mysql_fetch_array($res)[0];
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
        $query = "DELETE FROM blog_groups WHERE group_id = $id";
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      }
    }

    public static function get_list($start, $limit, &$res_count_rows, $filter = null) {
      $res = null;
      $q = "SELECT a.group_id, a.name, COUNT(b.group_id) AS amount FROM blog_groups a";
      $q .= " LEFT JOIN blog_group_posts b ON a.group_id = b.group_id";
      $q .= static::build_where($filter);
      $q .= " GROUP BY a.group_id, a.name";
      $q .= " ORDER BY a.name";
      $q .= " LIMIT $start, $limit";
      $result = mysql_query($q);
      if($result) {
        $res_count_rows = mysql_num_rows($result);
        while($row = mysql_fetch_array($result)) {
          $res[] = $row;
        }
      }
      return $res;
    }

    public static function save($data) {
      extract($data);
      if(isset($id)) {
        $query = 'UPDATE blog_groups SET name = "' . $name . '", slug = "' . $slug . '" WHERE group_id = ' . $id;
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      } else {
        $query = 'INSERT INTO blog_groups (name, slug) VALUE ("' . $name . '", "' . $slug . '")';
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
        $id = mysql_insert_id();
      }
      return $id;
    }

  }