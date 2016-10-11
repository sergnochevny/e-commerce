<?php

  Class Model_Manufacturers extends Model_Model {

    public static function get_by_id($id) {
      $response = [
        'manufacturer' => ''
      ];
      if(isset($id)) {
        $query = "SELECT * FROM fabrix_manufacturers WHERE id='$id'";
        $result = mysql_query($query);
        if($result) $response = mysql_fetch_assoc($result);
      }
      return $response;
    }

    public static function get_total_count($filter = null) {
      $response = null;
      $query = "SELECT COUNT(*) FROM fabrix_manufacturers";
      $query .= self::build_where($filter);
      if($result = mysql_query($query)) {
        $response = mysql_fetch_row($result)[0];
      }
      return $response;
    }

    public static function save($data) {
      extract($data);
      if(isset($id)) {
        $query = 'UPDATE fabrix_manufacturers SET manufacturer ="' . $manufacturer . '" WHERE id =' . $id;
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      } else {
        $query = 'INSERT INTO fabrix_manufacturers (manufacturer) VALUE ("' . $manufacturer . '")';
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
        $id = mysql_insert_id();
      }
      return $id;
    }

    public static function get_list($start, $limit, &$res_count_rows, $filter = null) {
      $response = null;
      $query = "SELECT a.id, a.manufacturer, count(b.pid) AS amount";
      $query .= " FROM fabrix_manufacturers a";
      $query .= " LEFT JOIN";
      $query .= " fabrix_products b ON b.manufacturerId = a.id";
      $query .= self::build_where($filter);
      $query .= " GROUP BY a.id, a.manufacturer";
      $query .= " ORDER BY a.manufacturer";
      $query .= " LIMIT $start, $limit";

      if($result = mysql_query($query)) {
        $res_count_rows = mysql_num_rows($result);
        while($row = mysql_fetch_array($result)) {
          $response[] = $row;
        }
      }

      return $response;
    }

    public static function delete($id) {
      if(isset($id)) {
        $query = "select count(*) from fabrix_products where manufacturerId = $id";
        $res = mysql_query($query);
        if($res) {
          $amount = mysql_fetch_array($res)[0];
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
        $query = "DELETE FROM fabrix_manufacturers WHERE id = $id";
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      }
    }

  }