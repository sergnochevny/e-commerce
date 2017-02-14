<?php

  Class Model_User extends Model_Base {

    protected static $table = 'fabrix_accounts';

    public static function get_by_email($email) {
      $email = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $email);
      $user = null;
      $strSQL = "select * from " . static::$table . " where email = '" . $email . "'";
      $result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $strSQL);
      if($result) {
        $user = mysqli_fetch_assoc($result);
      }
      return $user;
    }

    public static function set_remind_for_change_pass($remind, $date, $user_id) {
      $remind = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $remind);
      $q = "update " . static::$table . " set remind = '" . $remind . "', remind_time = '" . $date . "' where aid = " . $user_id;
      $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q);
      return ($res && mysqli_affected_rows());
    }

    public static function clean_remind($user_id) {
      $q = "update " . static::$table . " set remind = NULL, remind_time = NULL where aid = " . $user_id;
      $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q);
      return ($res && mysqli_affected_rows());
    }

    public static function exist($email = null, $id = null) {
      if(is_null($email) && is_null($id)) {
        throw new ErrorException('Both parameters cannot be empty!');
      }
      $q = "select * from " . static::$table . " where";
      if(isset($id)) $q .= " aid <> '$id'";
      if(isset($email)) {
        if(isset($id)) $q .= " and";
        $q .= " email = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $email) . "'";
      }
      $result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q);

      return (!$result || mysqli_num_rows($result) > 0);
    }

    public static function remind_exist($remind) {
      $q = "select * from " . static::$table . " where remind = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $remind) . "'";
      $result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q);
      return (!$result || mysqli_num_rows($result) > 0);
    }

    public static function get_by_remind($remind) {
      $user = null;
      $strSQL = "select * from " . static::$table . " where remind = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $remind) . "'";
      $result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $strSQL);
      if($result) {
        $user = mysqli_fetch_assoc($result);
      }
      return $user;
    }

    public static function update_password($password, $user_id) {
      $result = mysqli_query("UPDATE " . static::$table . " SET password =  '$password' WHERE  aid =$user_id;");
      if(!$result) throw new Exception(mysqli_error(_A_::$app->getDBConnection('iluvfabrix')));
    }

  }