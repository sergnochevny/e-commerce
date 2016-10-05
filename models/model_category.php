<?php

  Class Model_Category extends Model_Model {

    public static function get_all($prms = null) {
      $q = "select * from fabrix_categories";
      if(isset($prms)) {
        $where = isset($prms['where']) ? $prms['where'] : '';
        $order = isset($prms['order']) ? $prms['order'] : '';
        $q .= ' ' . $where . ' ' . $order;
        $q = trim($q);
      }

      $results = mysql_query($q);
      $rows = null;
      if($results) {
        while($row = mysql_fetch_array($results)) {
          $rows[] = $row;
        }
      }
      return $rows;
    }

    public static function del($id) {
      if(!empty($id)) {
        $strSQL = "delete from fabrix_product_categories WHERE cid = $id";
        mysql_query($strSQL);

        $strSQL = "DELETE FROM fabrix_categories WHERE cid = $id";
        mysql_query($strSQL);
      }
    }

    public static function get_category($id) {
      $row = null;
      $result = mysql_query("select * from fabrix_categories WHERE cid='$id'");
      if($result) $row = mysql_fetch_array($result);
      return $row;
    }

    public static function get_data_category($id) {
      $data = [
        'cname' => '',
        'display_order' => ''
      ];
      if(!isset($id)){
        $result = mysql_query("select max(displayorder)+1 from fabrix_categories");
        if($result) {
          $row = mysql_fetch_array($result);
          $data['display_order'] = $row[0];
        }
      } else {
        $result = mysql_query("select * from fabrix_categories WHERE cid='$id'");
        if($result) {
          $row = mysql_fetch_array($result);
          $data = [
            'cname' => $row['cname'],
            'display_order' => $row['displayorder']
          ];
        }

      }
      return $data;
    }

    public static function save($post_category_name, $post_display_order, $category_id) {
      if(!empty($category_id)) {
        $res = mysql_query("select * from fabrix_categories WHERE cid='$category_id'");
        if($res) {
          $row = mysql_fetch_array($res);
          $displayorder = $row['displayorder'];
          if($displayorder != $post_display_order) {
            if($res) $res = mysql_query("update fabrix_categories set displayorder=displayorder-1 WHERE displayorder > $displayorder");
            if($res) $res = mysql_query("update fabrix_categories set displayorder=displayorder+1 WHERE displayorder >= $post_display_order");
          }
          if($res) $res = mysql_query("update fabrix_categories set cname='$post_category_name', displayorder='$post_display_order' WHERE cid ='$category_id'");
        }
      } else {
        $res = mysql_query("update fabrix_categories set displayorder=displayorder+1 WHERE displayorder >= $post_display_order");
        if($res) $res = mysql_query("insert fabrix_categories set cname='$post_category_name', displayorder='$post_display_order'");
        if($res) $category_id = mysql_insert_id();
      }
      if(!$res) throw new Exception(mysql_error());

      return $category_id;
    }

  }