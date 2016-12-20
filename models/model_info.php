<?php

  Class Model_Info extends Model_Base {

    protected static $table = 'info_messages';

    protected static function build_where(&$filter) {
      $result = "";
      if(isset($filter['hidden']['id']) && !is_array($filter['hidden']['priceyard'])) $result[] = "a.id = '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter['hidden']["id"]))) . "'";
      if(isset($filter['hidden']['visible'])) $result[] = "visible = '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter['hidden']["visible"]))) . "'";
      if(isset($filter['hidden']["f1"])) $result[] = "f1 = '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter['hidden']["f1"]))) . "'";
      if(isset($filter['hidden']["f2"])) $result[] = "f2 = '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter['hidden']["f2"]))) . "'";
      if(!empty($result) && (count($result) > 0)) {
        $result = implode(" AND ", $result);
        $result = (!empty($result) ? " WHERE " . $result : '');
      }
      return $result;
    }

    public static function get_by_f1($f1) {
      $data = null;
      if(isset($f1)) {
        $q = "select * from " . static::$table . " where f1 = '" . $f1 . "'";
        $result = mysql_query($q);
        if($result) {
          $data = mysql_fetch_assoc($result);
        }
      }
      return $data;
    }

    public static function get_by_id($id) {
      $data = null;
      if(isset($id)) {
        $q = "select * from " . static::$table . " where id = '" . $id . "'";
        $result = mysql_query($q);
        if($result) {
          $data = mysql_fetch_assoc($result);
        }
      }
      return $data;
    }

    public static function get_total_count($filter = null) {
      $res = 0;
      $q = "SELECT COUNT(a.id) FROM " . static::$table;
      $q .= self::build_where($filter);
      $result = mysql_query($q);
      if($result) {
        $row = mysql_fetch_array($result);
        $res = $row[0];
      }
      return $res;
    }

    public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null) {
      $res = null;
      $q = "SELECT * FROM " . static::$table;
      $q .= self::build_where($filter);
      $q .= static::build_order($sort);
      if($limit != 0) $q .= " LIMIT $start, $limit";
      $result = mysql_query($q);
      if($result) {
        $res_count_rows = mysql_num_rows($result);
        while($row = mysql_fetch_assoc($result)) {
          $res[] = $row;
        }
      }
      return $res;
    }

    public static function save(&$data) {
      extract($data);
      $title = mysql_real_escape_string($title);
      $message = mysql_real_escape_string($message);
      if(isset($f1)) {
        $q = "UPDATE " . static::$table .
          " SET" .
          " title='$title'," .
          " message='$message'," .
          " visible='$visible'," .
          " f2='$f2'" .
          " WHERE f1 ='$f1'";
        $res = mysql_query($q);
      } else {
        $q = "INSERT INTO " . static::$table .
          " SET" .
          " title='$title'," .
          " message='$message'," .
          " visible='$visible'," .
          " f1='$f1'";
          " f2='$f2'";

        $res = mysql_query($q);
      }
      if(!$res) throw new Exception(mysql_error());
      return $f1;
    }

    public static function delete($id) {
      mysql_query("DELETE FROM " . static::$table . " WHERE id = '$id'");
    }

  }