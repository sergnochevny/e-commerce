<?php

namespace controllers;

use app\core\App;
use classes\controllers\ControllerController;
use classes\helpers\CaptchaHelper;

/**
 * Class ControllerCaptcha
 * @package controllers
 */
class ControllerCaptcha extends ControllerController{

  public $key = '';

  /**
   * @export
   */
  public function captcha(){
    CaptchaHelper::gen_captcha($this->key);
    App::$app->setSession('captcha', $this->key);
    App::$app->setSession('captcha_time', time());
  }

}