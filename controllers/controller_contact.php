<?php

class Controller_Contact extends Controller_Simple{

  private function sendMessage($data = null){
    if(isset($data) && is_array($data)) {
      $headers = "From: " . $data['name'] . "<" . $data['email'] . ">\n";
      $subject = $data['subject'];
      $body = $data['comments'];
      $email = _A_::$app->keyStorage()->system_info_email;
      mail($email, $subject, $body, $headers);
    }
  }

  protected function validate(&$data, &$error){
    $verify = Controller_Captcha::check_captcha(isset($data['captcha']) ? $data['captcha'] : '', $error2);
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

  public function edit($required_access = true){
  }

  public function add($required_access = true){
  }

  public function delete($required_access = true){
  }

  /**
   * @export
   */
  public function index($required_access = true){
    $data = null;
    $url = _A_::$app->router()->UrlTo($this->controller);
    $this->load($data);
    if(_A_::$app->request_is_post() && $this->form_handling($data)) {
      exit($this->form($url, $data));
    }
    $this->template->vars('form', $this->form($url, [], true));
    $this->main->view($this->controller);
  }

  public function view($partial = false, $required_access = false){
  }

}