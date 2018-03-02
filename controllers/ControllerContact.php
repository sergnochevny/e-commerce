<?php

namespace controllers;

use app\core\App;
use classes\controllers\ControllerSimple;
use Exception;

/**
 * Class ControllerContact
 * @package controllers
 */
class ControllerContact extends ControllerSimple{

  /**
   * @param null $data
   * @return bool
   * @throws \Exception
   */
  private function sendMessage($data = null){
    if(isset($data) && is_array($data)) {
      $demo = (!is_null(App::$app->keyStorage()->system_demo) ? App::$app->keyStorage()->system_demo : DEMO);

      $subject = $data['subject'];
      $body = $data['comments'];
      $email = App::$app->keyStorage()->system_info_email;

      $mailer = App::$app->getMailer();
      $emails = [$email];
      if($demo == 1) {
        $emails[] = "sergnochevny@studionovi.co";
      }
      foreach($emails as $email) {
        $messages[] = $mailer->compose(['text' => 'mail-text'], ['body' => $body])
          ->setSubject($subject)
          ->setTo([$email])
          ->setFrom([App::$app->keyStorage()->system_send_from_email => App::$app->keyStorage()->system_site_name . ' robot']);
      }

      return !empty($messages) && $mailer->sendMultiple($messages);
    }
  }

  /**
   * @param $data
   * @param $error
   * @return bool|mixed
   */
  protected function validate(&$data, &$error){
    $verify = ControllerCaptcha::check_captcha(isset($data['captcha']) ? $data['captcha'] : '', $error2);
    if(empty($data['name']) || empty($data['email']) || empty($data['captcha']) || !$verify) {
      $error = ['Please fill in all required fields:'];
      $error1 = [];

      if(empty($data['name'])) $error1[] = '&#9;Identify <b>Your Name</b> field!';
      if(empty($data['email'])) $error1[] = '&#9;Identify <b>Your Email</b> field!';
      if(empty($data['captcha'])) $error1[] = '&#9;Identify <b>Captcha</b> field!';
      if(!$verify) $error1[] = '&#9;' . $error2[0];
      if(count($error1) > 0) {
        if(count($error) > 0) $error[] = '';
        $error = array_merge($error, $error1);
      }
    } else return true;

    return false;
  }

  /**
   * @param null $data
   * @return bool
   */
  protected function form_handling(&$data = null){
    $error = null;
    if($this->validate($data, $error)) {
      try {
        $this->sendMessage($data);
        $warning = ['Your Message sent successfully!'];
        $data = [];
      } catch(Exception $e) {
        $error[] = $e->getMessage();
      }
    }
    if(isset($warning)) $this->template->vars('warning', $warning);
    if(isset($error)) $this->template->vars('error', $error);

    return parent::form_handling($data);
  }

  /**
   * @param bool $required_access
   */
  public function edit($required_access = true){
  }

  /**
   * @param bool $required_access
   */
  public function add($required_access = true){
  }

  /**
   * @param bool $required_access
   */
  public function delete($required_access = true){
  }

  /**
   * @export
   * @param bool $required_access
   * @throws \Exception
   */
  public function index($required_access = true){
    $data = null;
    $url = App::$app->router()->UrlTo($this->controller);
    $this->load($data);
    if(App::$app->request_is_post() && $this->form_handling($data)) {
      exit($this->form($url, $data));
    }
    $this->template->vars('form', $this->form($url, [], true));
    $this->main->view($this->controller);
  }

  /**
   * @param bool $partial
   * @param bool $required_access
   */
  public function view($partial = false, $required_access = false){
  }

}