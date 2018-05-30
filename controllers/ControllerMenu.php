<?php

namespace controllers;

use app\core\App;
use classes\controllers\ControllerController;

/**
 * Class ControllerMenu
 */
class ControllerMenu extends ControllerController{

  /**
   *
   * @throws \Exception
   */
  public function show_menu(){
    $this->view->merge_vars($this->main->view->get_vars());
    $this->view->setVars('idx', !is_null(App::$app->session('sidebar_idx')) ?
      App::$app->session('sidebar_idx') : 0
    );
    $this->main->view->setVars('shop_menu', $this->view->RenderLayoutReturn('shop', false, $this->controller));
    $this->view->setVars('base_url', App::$app->router()->UrlTo('/'));
    $this->main->view->setVars('menu', $this->view->RenderLayoutReturn('menu', false, $this->controller));
  }

}