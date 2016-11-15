<?php

  Class Model_Manufacturers extends Model_Base {

    protected static $table = 'fabrix_manufacturers';

    protected static function build_where(&$filter) {
      if (isset($filter['hidden']['view']) && $filter['hidden']['view']){
        $result = "";
        if(isset($filter["manufacturer"])) $result[] = "a.manufacturer LIKE '%" . mysql_real_escape_string(static::sanitize($filter["a.manufacturer"])) . "%'";
        if(isset($filter["id"])) $result[] = "a.id = '" . mysql_real_escape_string(static::sanitize($filter["a.id"])) . "'";
        if(!empty($result) && (count($result) > 0)) {
          if(strlen(trim(implode(" AND ", $result))) > 0) {
            $filter['active'] = true;
          }
        }
        if(isset($filter['hidden']['b.pvisible'])) $result[] = "b.pvisible = '" . mysql_real_escape_string(static::sanitize($filter['hidden']["b.pvisible"])) . "'";
        if(!empty($result) && (count($result) > 0)) {
          $result = implode(" AND ", $result);
          $result = (!empty($result) ? " WHERE " . $result : '');
        }
      } else {
        $result = parent::build_where($filter);
      }
      return $result;
    }

    public static function get_by_id($id) {
      $response = [
        'id' => $id,
        'manufacturer' => ''
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
      $query = "SELECT COUNT(DISTINCT a.id) FROM " . static::$table . " a";
      $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view'])? " INNER" : " LEFT";
      $query .= " JOIN fabrix_products b ON b.manufacturerId = a.id";
      $query .= static::build_where($filter);
      if($result = mysql_query($query)) {
        $response = mysql_fetch_row($result)[0];
      }
      return $response;
    }

    public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null) {
      $response = null;
      $query = "SELECT a.id, a.manufacturer, count(b.pid) AS amount";
      $query .= " FROM " . static::$table . " a";
      $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view'])? " INNER" : " LEFT";
      $query .= " JOIN fabrix_products b ON b.manufacturerId = a.id";
      $query .= static::build_where($filter);
      $query .= " GROUP BY a.id, a.manufacturer";
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

    public static function save(&$data) {
      extract($data);
      if(isset($id)) {
        $query = "UPDATE " . static::$table . " SET manufacturer ='" . $manufacturer . "' WHERE id =" . $id;
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      } else {
        $query = "INSERT INTO " . static::$table . " (manufacturer) VALUE ('" . $manufacturer . "')";
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
        $id = mysql_insert_id();
      }
      return $id;
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
        $query = "DELETE FROM " . static::$table . " WHERE id = $id";
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      }
    }

  }