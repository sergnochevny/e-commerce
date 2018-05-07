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

  /**
   * @export
   */
  public function captcha(){
    exit(CaptchaHelper::gen_captcha());
  }

}