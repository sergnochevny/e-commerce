<?php

class Model_Base{

  protected static $intransaction = false;

  protected static $table;
  public static $filter_exclude_keys = ['scenario', 'reset'];

  /**
   * @param $filter
   * @param null $prms
   * @return string
   */
  protected static function build_where(&$filter, &$prms = null){
    $query = "";
    if(isset($filter)) {
      $where = "";
      foreach($filter as $key => $val) {
        if(!in_array($key, static::$filter_exclude_keys)) {
          $where1 = "";
          switch($val[0]) {
            case 'like':
              if(is_array($val[1])) {
                foreach($val[1] as $idx => $like) {
                  if(strlen($where1) > 0) $where1 .= ' or ';
                  $where1 .= $key . " " . $val[0] . " '%:" . $key . $idx . "%'";
                  $prms[$key . $idx] = static::prepare_for_sql($like);
                }
              } else {
                $where1 .= $key . " " . $val[0] . " '%:" . $key . "%'";
                $prms[$key] = static::prepare_for_sql($val[1]);
              }
              break;
            case '=':
              if(is_array($val[1])) {
                foreach($val[1] as $idx => $eq) {
                  if(strlen($where1) > 0) $where1 .= ' or ';
                  $where1 .= $key . " " . $val[0] . " ':" . $key . $idx . "'";
                  $prms[$key . $idx] = static::prepare_for_sql($eq);
                }
              } else {
                $where1 .= $key . " " . $val[0] . " ':" . $key . "'";
                $prms[$key] = static::prepare_for_sql($val[1]);
              }
              break;
            case 'between':
              if(!empty($val[1]['from'])) {
                $where1 = $key . " >= ':" . $key . "_from'";
                $prms[$key . '_from'] = static::prepare_for_sql($val[1]['from']);
              }
              if(!empty($val[1]['to'])) {
                if(strlen($where1) > 0) $where1 .= " and ";
                $where1 .= $key . " <= ':" . $key . "_to'";
                $prms[$key . '_to'] = static::prepare_for_sql($val[1]['to']);
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

  /**
   * @param $sort
   * @return string
   */
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

  /**
   * @return null
   * @throws \Exception
   */
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

  /**
   * @param $text
   * @return mixed|null|string|string[]
   */
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

  /**
   * @param $data
   * @return string
   */
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

  /**
   * @return bool
   * @throws \Exception
   */
  public static function transaction(){
    if(!static::$intransaction) {
      static::$intransaction = _A_::$app->getDBConnection('default')->begin_tarnsaction();
      if(!static::$intransaction) {
        throw new Exception(self::error());
      }
    }

    return static::$intransaction;
  }

  /**
   * @return bool
   * @throws \Exception
   */
  public static function commit(){
    $res = !static::$intransaction;
    if(static::$intransaction) {
      $res = _A_::$app->getDBConnection('default')->commit();
      if(!$res) {
        throw new Exception(self::error());
      }
      static::$intransaction = false;
    }

    return $res;
  }

  /**
   * @return bool
   * @throws \Exception
   */
  public static function rollback(){
    $res = !static::$intransaction;
    if(static::$intransaction) {
      $res = _A_::$app->getDBConnection('default')->roll_back();
      if(!$res) {
        throw new Exception(self::error());
      }
      static::$intransaction = false;
    }

    return $res;
  }

  /**
   * @param $query
   * @param null $prms
   * @return mixed
   * @throws \Exception
   */
  public static function query($query, $prms = null){
    $res = _A_::$app->getDBConnection('default')->query($query, $prms);

    if(!$res) {
      throw new Exception(self::error());
    }

    return $res;
  }

  /**
   * @param $query
   * @return mixed
   * @throws \Exception
   */
  public static function exec($query){
    $res = _A_::$app->getDBConnection('default')->exec($query);

    if(!$res) {
      throw new Exception(self::error());
    }

    return $res;
  }

  /**
   * @param $str
   * @return mixed|null|string|string[]
   */
  public static function prepare_for_sql($str){
    return static::strip_data(static::sanitize($str));
  }

  /**
   * @return mixed
   */
  public static function error(){
    return _A_::$app->getDBConnection('default')->error();
  }

  /**
   * @return mixed
   */
  public static function last_id(){
    return _A_::$app->getDBConnection('default')->last_id();
  }

  /**
   * @param $from
   * @return null
   */
  public static function fetch_assoc($from){
    if($from) return $from->fetch(PDO::FETCH_ASSOC);

    return null;
  }

  /**
   * @param $from
   * @return null
   */
  public static function fetch_assoc_all($from){
    if($from) return $from->fetchAll(PDO::FETCH_ASSOC);

    return null;
  }

  /**
   * @param $from
   * @param int $resulttype
   * @return mixed
   */
  public static function fetch_array($from, $resulttype = PDO::FETCH_BOTH){
    return $from->fetch($resulttype);
  }

  /**
   * @param $from
   * @param int $resulttype
   * @return mixed
   */
  public static function fetch_array_all($from, $resulttype = PDO::FETCH_BOTH){
    return $from->fetchAll($resulttype);
  }

  /**
   * @param $from
   * @return null
   */
  public static function fetch_value($from){
    if($from) return $from->fetch(PDO::FETCH_COLUMN);

    return null;
  }

  /**
   * @param $from
   * @return int
   */
  public static function num_rows($from){
    if($from) return $from->rowCount();

    return 0;
  }

  /**
   * @param $from
   * @return int
   */
  public static function affected_rows($from){
    if($from) return $from->rowCount();

    return 0;
  }

  /**
   * @param $result
   */
  public static function free_result($result){
    if($result) $result->closeCursor();
  }
}