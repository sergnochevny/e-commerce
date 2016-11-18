<?php

  class Controller_Menu extends Controller_Controller {

    public function show_menu() {
      $base_url = _A_::$app->router()->UrlTo('/');
      $this->show_shop_menu();
      $this->show_blog_menu();
      $this->main->template->vars('base_url', $base_url);
      ob_start();
      $this->template->view_layout('menu');
      $menu = ob_get_contents();
      ob_end_clean();
      $this->main->template->vars('menu', $menu);
    }

    public function show_shop_menu() {
      ob_start();
      $this->template->vars('idx', _A_::$app->get('idx'));
      $this->template->view_layout('shop_menu');
      $shop_menu = ob_get_contents();
      ob_end_clean();

      $this->main->template->vars('shop_menu', $shop_menu);
    }

    public function show_blog_menu() {
      $base_url = _A_::$app->router()->UrlTo('/');

      $this->template->vars('base_url', $base_url);
      $items = Model_Tools::get_items_for_menu('blog_category');
      ob_start();
      foreach($items as $item) {
        $name = $item['name'];
        $href = _A_::$app->router()->UrlTo('blog/view', ['cat' => $item['group_id']], $name);
        $this->template->vars('href', $href, true);
        $this->template->vars('name', $name, true);
        $this->template->view_layout('menu_item');
      }
      $menu_blog_category = ob_get_contents();
      ob_end_clean();

      ob_start();
      $this->template->vars('menu_blog_category', $menu_blog_category);
      $this->template->view_layout('blog_menu');
      $blog_menu = ob_get_contents();
      ob_end_clean();

      $this->template->vars('blog_menu', $blog_menu);
    }

  }