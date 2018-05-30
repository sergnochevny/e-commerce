<?php

namespace classes\controllers;

use app\core\App;

/**
 * Class ControllerFormSimple
 * @package controllers\base
 */
abstract class ControllerFormSimple extends ControllerSimple{

  /**
   * @param $url
   * @param $title
   * @throws \Exception
   */
  protected function edit_add_handling($url, $title){
    $this->main->view->setVars('form_title', $title);
    $data = null;
    $this->load($data);
    if(App::$app->RequestIsPost() && $this->form_handling($data)) {
      $this->Save($data);
      exit($this->form($url, $data));
    }
    $this->set_back_url();
    $this->main->view->setVars('form', $this->form($url, null, true));
    $this->render_view_admin('edit');
  }

}