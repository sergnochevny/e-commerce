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
    $this->template->merge_vars($this->main->template->get_vars());
    $this->template->vars('idx', !is_null(App::$app->session('sidebar_idx')) ?
      App::$app->session('sidebar_idx') : 0
    );
    $this->main->template->vars('shop_menu', $this->template->render_layout_return('shop', false, $this->controller));
    $this->template->vars('base_url', App::$app->router()->UrlTo('/'));
    $this->main->template->vars('menu', $this->template->render_layout_return('menu', false, $this->controller));
  }

}