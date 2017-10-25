<?php

class Model_Base{

  protected static $intransaction = false;

  protected static $table;
  public static $filter_exclude_keys = ['scenario', 'reset'];

  protected static function build_where(&$filter){
    $query = "";
    if(isset($filter)) {
      $where = "";
      foreach($filter as $key => $val) {
        if(!in_array($key, static::$filter_exclude_keys)) {
          $where1 = "";
          switch($val[0]) {
            case 'like':
              if(is_array($val[1])) {
                foreach($val[1] as $like) {
                  if(strlen($where1) > 0) $where1 .= ' or ';
                  $where1 .= $key . " " . $val[0] . " '%" . static::prepare_for_sql($like) . "%'";
                }
              } else {
                $where1 .= $key . " " . $val[0] . " '%" . static::prepare_for_sql($val[1]) . "%'";
              }
              break;
            case '=':
              if(is_array($val[1])) {
                foreach($val[1] as $like) {
                  if(strlen($where1) > 0) $where1 .= ' or ';
                  $where1 .= $key . " " . $val[0] . " '" . static::prepare_for_sql($like) . "'";
                }
              } else {
                $where1 .= $key . " " . $val[0] . " '" . static::prepare_for_sql($val[1]) . "'";
              }
              break;
            case 'between':
              if(!empty($val[1]['from'])) {
                $where1 = $key . " >= '" . static::prepare_for_sql($val[1]['from']) . "'";
              }
              if(!empty($val[1]['to'])) {
                if(strlen($where1) > 0) $where1 .= " and ";
                $where1 .= $key . " <= '" . static::prepare_for_sql($val[1]['to']) . "'";
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

  protected static function build_order(&$sort){
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

  public static function get_fields(){
    $response = null;
    $query = "DESCRIBE " . static::$table;
    $result = static::query($query);
    if($result) {
      while($row = static::fetch_assoc($result)) {
        $response[$row['Field']] = $row;
      }
    }

    return $response;
  }

  public static function strip_data($text){
    $quotes = ["\x27", "\x22", "\x60", "\t", "\n", "\r", "*", "%", "<", ">", "?", "!"];
    $goodquotes = ["-", "+", "#"];
    $repquotes = ["\-", "\+", "\#"];
    $text = trim(strip_tags($text));
    $text = str_replace($quotes, '', $text);
    $text = str_replace($goodquotes, $repquotes, $text);
    $text = preg_replace("/ +/i", " ", $text);

    return $text;
  }

  public static function sanitize($data){
    if(is_string($data)) {
      if(function_exists('get_magic_quotes_gpc') == true && get_magic_quotes_gpc() == 1) {
        $data = stripslashes($data);
      }
      $data = nl2br(htmlspecialchars($data));
      $data = trim($data);
    }

    return $data;
  }

  public static function transaction(){
    if(!static::$intransaction) {
      static::$intransaction = mysqli_begin_transaction(_A_::$app->getDBConnection('default'));
      if(!static::$intransaction) {
        throw new Exception(self::error());
      }
    }

    return static::$intransaction;
  }

  public static function commit(){
    $res = !static::$intransaction;
    if(static::$intransaction) {
      $res = mysqli_commit(_A_::$app->getDBConnection('default'));
      if(!$res) {
        throw new Exception(self::error());
      }
      static::$intransaction = false;
    }

    return $res;
  }

  public static function rollback(){
    $res = !static::$intransaction;
    if(static::$intransaction) {
      $res = mysqli_rollback(_A_::$app->getDBConnection('default'));
      if(!$res) {
        throw new Exception(self::error());
      }
      static::$intransaction = false;
    }

    return $res;
  }

  public static function query($query){
    $res = mysqli_query(_A_::$app->getDBConnection('default'), $query);
    if(!$res) {
      throw new Exception(self::error());
    }

    return $res;
  }

  public static function escape($str){
    return mysqli_real_escape_string(_A_::$app->getDBConnection('default'), $str);
  }

  public static function prepare_for_sql($str){
    return static::escape(static::strip_data(static::sanitize($str)));
  }

  public static function error(){
    return mysqli_error(_A_::$app->getDBConnection('default'));
  }

  public static function last_id(){
    return mysqli_insert_id(_A_::$app->getDBConnection('default'));
  }

  public static function fetch_assoc($from){
    if($from) return mysqli_fetch_assoc($from);

    return null;
  }

  public static function fetch_array($from, $resulttype = MYSQLI_BOTH){
    return mysqli_fetch_array($from, $resulttype);
  }

  public static function fetch_row($from){
    if($from) return mysqli_fetch_row($from);

    return null;
  }

  public static function num_rows($from){
    if($from) return mysqli_num_rows($from);

    return 0;
  }

  public static function affected_rows(){
    return mysqli_affected_rows(_A_::$app->getDBConnection('default'));
  }

  public static function free_result($result){
    if($result) mysqli_free_result($result);
  }
}