<?php

  class Controller_Menu extends Controller_Controller {

    public function show_menu() {
      $this->template->vars('idx', !is_null(_A_::$app->session('sidebar_idx')) ? _A_::$app->session('sidebar_idx') : 0);
      $this->main->template->vars('shop_menu', $this->template->view_layout_return('shop'));
      $this->main->template->vars('base_url', _A_::$app->router()->UrlTo('/'));
      $this->main->template->vars('menu', $this->template->view_layout_return('menu'));
    }

  }