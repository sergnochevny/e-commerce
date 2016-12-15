<?php

  abstract class Model_Base {

    protected static $table;

    protected static function build_where(&$filter) {
      $query = "";
      if(isset($filter)) { $where = "";
        foreach($filter as $key => $val) {
          if($key !== 'scenario'){
            $where1 = "";
            switch($val[0]) {
              case 'like':
                if(is_array($val[1])) {
                  foreach($val[1] as $like) {
                    $where1 .= $key . " " . $val[0] . " '%" . mysql_real_escape_string(static::sanitize($like)) . "%'";
                  }
                } else {
                  $where1 .= $key . " " . $val[0] . " '%" . mysql_real_escape_string(static::sanitize($val[1])) . "%'";
                }
                break;
              case '=':
                if(is_array($val[1])) {
                  foreach($val[1] as $like) {
                    $where1 .= $key . " " . $val[0] . " '" . mysql_real_escape_string(static::sanitize($like)) . "'";
                  }
                } else {
                  $where1 .= $key . " " . $val[0] . " '" . mysql_real_escape_string(static::sanitize($val[1])) . "'";
                }
                break;
              case 'between':
                if(!empty($val[1]['from'])) {
                  $where1 = $key . " >= '" . mysql_real_escape_string(static::sanitize($val[1]['from'])) . "'";
                }
                if(!empty($val[1]['to'])) {
                  if(strlen($where1) > 0) $where1 .= " and ";
                  $where1 .= $key . " <= '" . mysql_real_escape_string(static::sanitize($val[1]['to'])) . "'";
                }
                break;
            }

            $where .= ((strlen($where1) > 0) ? ((strlen($where) > 0) ? " and (" : " (") . $where1 . ")" : '');
          }
        }
        if(strlen($where) > 0) {
          $query = " WHERE " . $where;
          $filter['active'] = true;
        }
      }
      return $query;
    }

    protected static function build_order(&$sort) {
      $order = '';
      if(isset($sort) && (count($sort) > 0)) {
        foreach($sort as $key => $val) {
          if(strlen($order) > 0) $order .= ',';
          $order .= ' ' . $key . ' ' . $val;
        }
        $order = ' ORDER BY ' . $order;
      }
      return $order;
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

    public static function sanitize($data) {
      if (is_string($data)){
        if(function_exists('get_magic_quotes_gpc') == true && get_magic_quotes_gpc() == 1) {
          $data = stripslashes($data);
        }
        $data = htmlspecialchars($data);
        $data = trim($data);
      }
      return $data;
    }
  }