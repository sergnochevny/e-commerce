<?php
/**
 * Date: 09.03.2018
 * Time: 11:48
 */

namespace classes\helpers;

use app\core\App;
use models\ModelAuth;

class UserHelper{

  /**
   * @return array|string
   */
  public static function get_from_session(){
    return App::$app->session('user');
  }

  /**
   * @return bool
   * @throws \Exception
   */
  public static function is_authorized(){
    if(self::is_logged())
      return true;
    if(self::is_set_remember()) {
      $remember = App::$app->cookie('_r');
      if(ModelAuth::is_user_remember($remember)) {
        $user = ModelAuth::get_user_data();
        App::$app->setSession('_', $user['aid']);
        App::$app->setSession('user', $user);

        return true;
      }
    }

    return false;
  }

  /**
   * @param $email
   * @param $password
   * @return bool
   * @throws \Exception
   */
  public static function authorize($email, $password){
    $email = stripslashes(strip_tags(trim($email)));
    $password = stripslashes(strip_tags(trim($password)));
    $res = ModelAuth::user_authorize($email, $password);
    if($res) {
      $user = ModelAuth::get_user_data();
      App::$app->setSession('_', $user['aid']);
      App::$app->setSession('user', $user);
    }

    return $res;
  }

  /**
   * @return bool
   */
  public static function is_set_remember(){
    return !is_null(App::$app->cookie('_r'));
  }

  /**
   * @return bool
   */
  public static function is_logged(){
    return !is_null(App::$app->session('_'));
  }

  /**
   * @param $email
   * @throws \Exception
   */
  public static function sendWelcomeEmail($email){
    $demo = (!is_null(App::$app->keyStorage()->system_demo) ? App::$app->keyStorage()->system_demo : DEMO);

    $subject = "Thank you for registering with iluvfabrix.com";

    $mailer = App::$app->getMailer();
    $emails = [$email];
    if($demo == 1) {
      $emails = array_merge($emails, explode(',', App::$app->keyStorage()->system_emails_admins));
    }
    array_walk($emails, function(&$item){
      $item = trim($item);
    });
    $emails = array_unique($emails);

    foreach($emails as $email) {
      $messages[] = $mailer->compose(['text' => 'welcome-mail-text'], ['site_name' => App::$app->keyStorage()->system_site_name])
        ->setSubject($subject)
        ->setTo([$email])
        ->setReplyTo([App::$app->keyStorage()->system_info_email])
        ->setFrom([App::$app->keyStorage()->system_send_from_email => App::$app->keyStorage()->system_site_name . ' robot']);
    }

    if(!empty($messages)) $mailer->sendMultiple($messages);
  }

}