<?php

  Class Model_Blogcategory extends Model_Model {

    public static function get_by_id($id) {
      $response = [
        'name' => '',
        'slug' => ''
      ];
      if(isset($id)) {
        $query = "SELECT * FROM blog_group WHERE group_id='$id'";
        $result = mysql_query($query);
        if($result) $response = mysql_fetch_assoc($result);
      }
      return $response;
    }

    public static function get_total_count($filter = null) {
      $response = null;
      $query = "SELECT COUNT(*) FROM blog_group";
      if(isset($filter)) {
        $query .= " WHERE";
      }
      if($result = mysql_query($query)) {
        $response = mysql_fetch_row($result)[0];
      }
      return $response;
    }

    public static function delete($id) {
      if(isset($id)) {
        $query = "SELECT COUNT(*) FROM blog_group WHERE group_id = $id";
        $res = mysql_query($query);
        if($res) {
          $amount = mysql_fetch_array($res)[0];
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
        $query = "DELETE FROM blog_group WHERE group_id = $id";
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      }
    }

    public static function get_list() {
      $res = null;
      $q = "SELECT a.group_id, a.name, COUNT(b.group_id) AS amount FROM blog_groups a " .
        " LEFT JOIN blog_group_posts b ON a.group_id=b.group_id" .
        " GROUP BY a.group_id, a.name";
      $result = mysql_query($q);
      if($result) {
        while($row = mysql_fetch_array($result)) {
          $res[] = $row;
        }
      }
      return $res;
    }

    public static function save($data) {
      extract($data);
      if(isset($id)) {
        $query = 'UPDATE blog_groups SET `name` ="' . $name . '", `slug` = "' . $slug . '" WHERE `group_id` =' . $group_id;
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      } else {
        $query = 'INSERT INTO blog_groups (`name`, `slug`) VALUE ("' . $name . '","' . $slug . '")';
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
        $id = mysql_insert_id();
      }
      return $id;
    }

  }