<?php

class Model_User extends Model_Base{

  /**
   * @var string
   */
  protected static $table = 'fabrix_accounts';

  /**
   * @param $email
   * @return null
   * @throws \Exception
   */
  public static function get_by_email($email){
    $user = null;
    $strSQL = "SELECT * FROM " . static::$table . " WHERE email = :email";
    $result = static::query($strSQL, ['email' => $email]);
    if($result) {
      $user = static::fetch_assoc($result);
    }

    return $user;
  }

  /**
   * @param $remind
   * @param $date
   * @param $user_id
   * @return bool
   * @throws \Exception
   */
  public static function set_remind_for_change_pass($remind, $date, $user_id){
    static::transaction();
    try {
      $q = "update " . static::$table . " set remind = :remind, remind_time = :date where aid = :user_id";
      $res = static::query($q, compact($remind, $date, $user_id));
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }

    return ($res && static::affected_rows($res));
  }

  /**
   * @param $user_id
   * @return bool
   * @throws \Exception
   */
  public static function clean_remind($user_id){
    static::transaction();
    try {
      $q = "update " . static::$table . " set remind = NULL, remind_time = NULL where aid = :user_id";
      $res = static::query($q, compact($user_id));
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }

    return ($res && static::affected_rows($res));
  }

  /**
   * @param null $email
   * @param null $id
   * @return bool
   * @throws \ErrorException
   * @throws \Exception
   */
  public static function exist($email = null, $id = null){
    if(is_null($email) && is_null($id)) {
      throw new ErrorException('Both parameters cannot be empty!');
    }
    $prms = [];
    $q = "SELECT * ";
    $q .= "FROM " . static::$table . " WHERE";
    if(isset($id)) {
      $q .= " aid <> :id";
      $prms['id'] = $id;
    }
    if(isset($email)) {
      if(isset($id)) $q .= " and";
      $q .= " email = :email";
      $prms['email'] = $email;
    }
    $result = static::query($q, $prms);

    return (!$result || static::num_rows($result) > 0);
  }

  /**
   * @param $remind
   * @return bool
   * @throws \Exception
   */
  public static function remind_exist($remind){
    $q = "SELECT * FROM " . static::$table . " WHERE remind = :remind";
    $result = static::query($q, compact($remind));

    return (!$result || static::num_rows($result) > 0);
  }

  /**
   * @param $remind
   * @return null
   * @throws \Exception
   */
  public static function get_by_remind($remind){
    $user = null;
    $strSQL = "SELECT * FROM " . static::$table . " WHERE remind = :remind";
    $result = static::query($strSQL, compact($remind));
    if($result) {
      $user = static::fetch_assoc($result);
    }

    return $user;
  }

  /**
   * @param $password
   * @param $user_id
   * @throws \Exception
   */
  public static function update_password($password, $user_id){
    static::transaction();
    try {
      $q = "UPDATE " . static::$table . " SET password = :password WHERE aid = :user_id";
      $result = static::query($q, compact($password, $user_id));
      if(!$result) throw new Exception(static::error());
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }
  }

}