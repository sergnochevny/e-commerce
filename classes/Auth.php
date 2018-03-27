<?php
/**
 * Date: 27.03.2018
 * Time: 11:14
 */

namespace classes;

use app\core\App;
use classes\helpers\AdminHelper;
use classes\helpers\UserHelper;

final class Auth{

  /**
   * @param null $redirect
   * @return null|string
   * @throws \Exception
   */
  public static function check_any_authorized($redirect = null){
    if(!AdminHelper::is_logged() && !UserHelper::is_logged()) {
      $prms = isset($redirect) ? ['url' => urlencode(base64_encode(App::$app->router()->UrlTo($redirect)))] : null;
      App::$app->router()->redirect(App::$app->router()->UrlTo('authorization', $prms));
    } else {
      if(AdminHelper::is_logged()) return 'admin';
      if(UserHelper::is_logged()) return 'user';
    }

    return null;
  }

  /**
   * @param bool $redirect_to_url
   * @throws \Exception
   */
  public static function check_admin_authorized($redirect_to_url = true){
    if(!AdminHelper::is_authorized()) {
      if($redirect_to_url) {
        $redirect = strtolower(explode('/', App::$app->server('SERVER_PROTOCOL'))[0]) . "://";
        $redirect .= App::$app->server('SERVER_NAME');
        $redirect .= (App::$app->server('SERVER_PORT') == '80' ? '' : ':' . App::$app->server('SERVER_PORT'));
        $redirect .= App::$app->server('REQUEST_URI');
        if(empty(App::$app->server('REQUEST_URI'))) {
          $redirect = App::$app->router()->UrlTo('product');
        }
      } else
        $redirect = App::$app->server('HTTP_REFERER');
      $url = App::$app->router()->UrlTo('admin', ['url' => urlencode(base64_encode($redirect))]);
      App::$app->router()->redirect($url);
    }
  }

  /**
   * @param bool $redirect_to_url
   * @throws \Exception
   */
  public static function check_user_authorized($redirect_to_url = false){
    if(!UserHelper::is_authorized()) {
      if($redirect_to_url) {
        $redirect = strtolower(explode('/', App::$app->server('SERVER_PROTOCOL'))[0]) . "://";
        $redirect .= App::$app->server('SERVER_NAME');
        $redirect .= (App::$app->server('SERVER_PORT') == '80' ? '' : ':' . App::$app->server('SERVER_PORT'));
        $redirect .= App::$app->server('REQUEST_URI');
        if(empty(App::$app->server('REQUEST_URI'))) {
          $redirect = App::$app->router()->UrlTo('shop');
        }
      } else
        $redirect = App::$app->server('HTTP_REFERER');
      $url = App::$app->router()->UrlTo('user', ['url' => urlencode(base64_encode($redirect))]);
      App::$app->router()->redirect($url);
    }
  }

}