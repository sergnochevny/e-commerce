<?php

  abstract class Model_Base {

    protected static $table;

    protected static function build_where($filter) {
      $query = "";
      if(isset($filter)) {
        $where = "";
        foreach($filter as $key => $val) {
          $where .= ((strlen($where) > 0) ? " and (" : " (");
          switch($val[0]) {
            case 'like':
              if(is_array($val[1])) {
                foreach($val[1] as $like) {
                  $where .= $key . " " . $val[0] . " '%" . mysql_real_escape_string(static::validData($like)) . "%'";
                }
              } else {
                $where .= $key . " " . $val[0] . " '%" . mysql_real_escape_string(static::validData($val[1])) . "%'";
              }
              break;
            case '=':
              if(is_array($val[1])) {
                foreach($val[1] as $like) {
                  $where .= $key . " " . $val[0] . " '" . mysql_real_escape_string(static::validData($like)) . "'";
                }
              } else {
                $where .= $key . " " . $val[0] . " '" . mysql_real_escape_string(static::validData($val[1])) . "'";
              }
              break;
            case 'between':
              $where .= "(". $key . " >= '" . mysql_real_escape_string(static::validData($val[1]['from'])) . "'";
              $where .= " and ". $key ." <= '" . mysql_real_escape_string(static::validData($val[1]['to'])) . "')";
              break;
          }
          $where .= ")";
        }
        $query = " WHERE " . $where;
      }
      return $query;
    }

    public static function get_fields() {
      $response = null;
      $query = "DESCRIBE " . static::$table;
      $result = mysql_query($query);
      if($result) {
        while($row = mysql_fetch_assoc($result)) {
          $response[$row['Field']] = $row;
        }
      }
      return $response;
    }

    public static function validData($data) {
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      $data = trim($data);
      return $data;
    }
  }
?>