<?php

class Model_User extends Model_Base{

  protected static $table = 'fabrix_accounts';

  public static function get_by_email($email){
    $email = static::escape($email);
    $user = null;
    $strSQL = "SELECT * FROM " . static::$table . " WHERE email = '" . $email . "'";
    $result = static::query($strSQL);
    if($result) {
      $user = static::fetch_assoc($result);
    }

    return $user;
  }

  public static function set_remind_for_change_pass($remind, $date, $user_id){
    static::transaction();
    try {
      $remind = static::escape($remind);
      $q = "update " . static::$table . " set remind = '" . $remind . "', remind_time = '" . $date . "' where aid = " . $user_id;
      $res = static::query($q);
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }

    return ($res && static::affected_rows());
  }

  public static function clean_remind($user_id){
    static::transaction();
    try {
      $q = "update " . static::$table . " set remind = NULL, remind_time = NULL where aid = " . $user_id;
      $res = static::query($q);
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }

    return ($res && static::affected_rows());
  }

  public static function exist($email = null, $id = null){
    if(is_null($email) && is_null($id)) {
      throw new ErrorException('Both parameters cannot be empty!');
    }
    $q = "SELECT * FROM " . static::$table . " WHERE";
    if(isset($id)) $q .= " aid <> '$id'";
    if(isset($email)) {
      if(isset($id)) $q .= " and";
      $q .= " email = '" . static::escape($email) . "'";
    }
    $result = static::query($q);

    return (!$result || static::num_rows($result) > 0);
  }

  public static function remind_exist($remind){
    $q = "SELECT * FROM " . static::$table . " WHERE remind = '" . static::escape($remind) . "'";
    $result = static::query($q);

    return (!$result || static::num_rows($result) > 0);
  }

  public static function get_by_remind($remind){
    $user = null;
    $strSQL = "SELECT * FROM " . static::$table . " WHERE remind = '" . static::escape($remind) . "'";
    $result = static::query($strSQL);
    if($result) {
      $user = static::fetch_assoc($result);
    }

    return $user;
  }

  public static function update_password($password, $user_id){
    static::transaction();
    try {
      $result = static::query("UPDATE " . static::$table . " SET password =  '$password' WHERE  aid =$user_id;");
      if(!$result) throw new Exception(static::error());
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }
  }

}