<?php

class Controller_UserBase extends Controller_Controller{

  public static function get_from_session(){
    return _A_::$app->session('user');
  }

  public function is_authorized(){
    if(self::is_logged())
      return true;
    if(self::is_set_remember()) {
      $remember = _A_::$app->cookie('_r');
      if(Model_Auth::is_user_remember($remember)) {
        $user = Model_Auth::get_user_data();
        _A_::$app->setSession('_', $user['aid']);
        _A_::$app->setSession('user', $user);

        return true;
      }
    }

    return false;
  }

  public static function authorize($email, $password){
    $email = stripslashes(strip_tags(trim($email)));
    $password = stripslashes(strip_tags(trim($password)));
    $res = Model_Auth::user_authorize($email, $password);
    if($res) {
      $user = Model_Auth::get_user_data();
      _A_::$app->setSession('_', $user['aid']);
      _A_::$app->setSession('user', $user);
    }

    return $res;
  }

  public static function is_set_remember(){
    return !is_null(_A_::$app->cookie('_r'));
  }

  public static function is_logged(){
    return !is_null(_A_::$app->session('_'));
  }

}
