<?php

namespace controllers;

use app\core\App;
use controllers\base\ControllerController;

/**
 * Class ControllerMenu
 */
class ControllerMenu extends ControllerController{

  /**
   *
   * @throws \Exception
   */
  public function show_menu(){
    $this->template->vars('idx', !is_null(App::$app->session('sidebar_idx')) ?
      App::$app->session('sidebar_idx') : 0
    );
    $this->main->template->vars('shop_menu', $this->template->view_layout_return('shop'));
    $this->main->template->vars('base_url', App::$app->router()->UrlTo('/'));
    $this->main->template->vars('menu', $this->template->view_layout_return('menu'));
  }

}