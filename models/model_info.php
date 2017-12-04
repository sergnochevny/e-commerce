<?php

class Model_Info extends Model_Base{

  protected static $table = 'info_messages';

  protected static function build_where(&$filter){
    $result = "";
    if(isset($filter['hidden']['id']) && !is_array($filter['hidden']['priceyard'])) $result[] = "a.id = '" . static::prepare_for_sql($filter['hidden']["id"]) . "'";
    if(isset($filter['hidden']['visible'])) $result[] = "visible = '" . static::prepare_for_sql($filter['hidden']["visible"]) . "'";
    if(isset($filter['hidden']["f1"])) $result[] = "f1 = '" . static::prepare_for_sql($filter['hidden']["f1"]) . "'";
    if(isset($filter['hidden']["f2"])) $result[] = "f2 = '" . static::prepare_for_sql($filter['hidden']["f2"]) . "'";
    if(!empty($result) && (count($result) > 0)) {
      $result = implode(" AND ", $result);
      $result = (!empty($result) ? " WHERE " . $result : '');
    }

    return $result;
  }

  public static function get_by_f1($filter){
    $data = null;
    $q = "SELECT * FROM " . static::$table;
    $q .= self::build_where($filter);
    $q .= ' LIMIT 1';
    $result = static::query($q);
    if($result) $data = static::fetch_assoc($result);

    return $data;
  }

  public static function get_by_id($id){
    $data = null;
    if(isset($id)) {
      $q = "SELECT * FROM " . static::$table . " WHERE id = '" . $id . "'";
      $result = static::query($q);
      if($result) {
        $data = static::fetch_assoc($result);
      }
    }

    return $data;
  }

  public static function get_total_count($filter = null){
    $res = 0;
    $q = "SELECT COUNT(a.id) FROM " . static::$table;
    $q .= self::build_where($filter);
    $result = static::query($q);
    if($result) {
      $row = static::fetch_array($result);
      $res = $row[0];
    }

    return $res;
  }

  public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null){
    $res = null;
    $q = "SELECT * FROM " . static::$table;
    $q .= self::build_where($filter);
    $q .= static::build_order($sort);
    if($limit != 0) $q .= " LIMIT $start, $limit";
    $result = static::query($q);
    if($result) {
      $res_count_rows = static::num_rows($result);
      while($row = static::fetch_assoc($result)) {
        $res[] = $row;
      }
    }

    return $res;
  }

  public static function save(&$data){
    static::transaction();
    try {
      extract($data);
      $title = static::escape($title);
      $message = static::escape($message);
      if(isset($f1)) {
        $q = "UPDATE " . static::$table . " SET" . " title='$title'," . " message='$message'," . " visible='$visible'," . " f2='$f2'" . " WHERE f1 ='$f1'";
        $res = static::query($q);
      } else {
        $q = "INSERT INTO " . static::$table . " SET" . " title='$title'," . " message='$message'," . " visible='$visible'," . " f1='$f1'";
        " f2='$f2'";

        $res = static::query($q);
      }
      if(!$res) throw new Exception(static::error());
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }

    return $f1;
  }

  public static function delete($id){
    static::transaction();
    try {
      static::query("DELETE FROM " . static::$table . " WHERE id = '$id'");
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }
  }

}