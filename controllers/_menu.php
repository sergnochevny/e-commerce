<?php

  class Controller_Menu extends Controller_Controller {

    public function show_menu() {
      ob_start();
      $this->template->vars('idx', _A_::$app->get('idx'));
      $this->template->view_layout('shop');
      $shop_menu = ob_get_contents();
      ob_end_clean();
      $this->main->template->vars('shop_menu', $shop_menu);
      $this->main->template->vars('base_url', _A_::$app->router()->UrlTo('/'));
      ob_start();
      $this->template->view_layout('menu');
      $menu = ob_get_contents();
      ob_end_clean();
      $this->main->template->vars('menu', $menu);
    }

  }