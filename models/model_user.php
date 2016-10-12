<?php

  Class Model_User extends Model_Model {

    protected static $table = 'fabrix_accounts';

    public static function get_by_email($email) {
      $user = null;
      $strSQL = "select * from " . static::$table . " where email = '" . mysql_real_escape_string($email) . "'";
      $result = mysql_query($strSQL);
      if($result) {
        $user = mysql_fetch_assoc($result);
      }
      return $user;
    }

    public static function set_remind_for_change_pass($remind, $date, $user_id) {
      $q = "update " . static::$table . " set remind = '" . mysql_real_escape_string($remind) . "', remind_time = '" . $date . "' where aid = " . $user_id;
      $res = mysql_query($q);
      return ($res && mysql_affected_rows());
    }

    public static function clean_remind($user_id) {
      $q = "update " . static::$table . " set remind = NULL, remind_time = NULL where aid = " . $user_id;
      $res = mysql_query($q);
      return ($res && mysql_affected_rows());
    }

    public static function exist($email = null, $id = null) {
      if(is_null($email) && is_null($id)) {
        throw new ErrorException('Both parameters cannot be empty!');
      }
      $q = "select * from " . static::$table . " where";
      if(isset($id)) $q .= " aid <> '$id'";
      if(isset($email)) {
        if(isset($id)) $q .= " and";
        $q .= " email = '" . mysql_real_escape_string($email) . "'";
      }
      $result = mysql_query($q);

      return (!$result || mysql_num_rows($result) > 0);
    }

    public static function remind_exist($remind) {
      $q = "select * from " . static::$table . " where remind = '" . mysql_real_escape_string($remind) . "'";
      $result = mysql_query($q);
      return (!$result || mysql_num_rows($result) > 0);
    }

    public static function get_by_remind($remind) {
      $user = null;
      $strSQL = "select * from " . static::$table . " where remind = '" . mysql_real_escape_string($remind) . "'";
      $result = mysql_query($strSQL);
      if($result) {
        $user = mysql_fetch_assoc($result);
      }
      return $user;
    }

    public static function update_password($password, $user_id) {
      $result = mysql_query("UPDATE " . static::$table . " SET password =  '$password' WHERE  aid =$user_id;");
      if(!$result) throw new Exception(mysql_error());
    }

  }