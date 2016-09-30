<?php

  class Controller_Categories extends Controller_Controller {

    private function display_order() {
      $this->main->test_access_rights();
      $category_id = Model_Category::validData(_A_::$app->get('category_id'));
      $category = Model_Category::get_category($category_id);
      $this->template->vars('displayorder', $category['displayorder']);
      $rows = Model_Category::get_all(['order' => ' ORDER BY displayorder ASC ']);
      ob_start();
      foreach($rows as $row) {
        $this->template->vars('row', $row);
        $this->template->view_layout('display_order');
      }
      $order_categories = ob_get_contents();
      ob_end_clean();
      $this->template->vars('display_order_categories', $order_categories);
    }

    private function display_order_wo_select() {
      $this->main->test_access_rights();
      $rows = Model_Category::get_all(['order' => ' ORDER BY displayorder ASC ']);
      ob_start();
      foreach($rows as $row) {
        $this->template->vars('row', $row);
        $this->template->view_layout('display_wo_select');
        $curr_order = (int)$row[3] + 1;
      }
      $this->template->vars('curr_order', $curr_order);
      $order_categories = ob_get_contents();
      ob_end_clean();
      $this->template->vars('display_order_categories', $order_categories);
    }

    /**
     * @export
     */
    public function categories() {
      $this->main->test_access_rights();
      $this->get_list();
      $this->main->view_admin('categories');
    }

    /**
     * @export
     */
    public function listof() {
      $this->main->test_access_rights();
      $this->get_list();
      $this->main->view_layout('list');
    }

    public function get_list() {
      $this->main->test_access_rights();
      $categories = '';
      $rows = Model_Category::get_all();
      foreach($rows as $row) {
        ob_start();
        $this->template->vars('row', $row);
        $this->template->view_layout('get_list');
        $categories .= ob_get_contents();
        ob_end_clean();
      }
      $this->template->vars('get_categories_list', $categories);
    }

    /**
     * @export
     */
    public function del() {
      $this->main->test_access_rights();
      $del_category_id = Model_Category::validData(_A_::$app->get('category_id'));
      Model_Category::del($del_category_id);
      $this->listof();
    }

    /**
     * @export
     */
    public function edit() {
      $this->main->test_access_rights();
      $category_id = Model_Category::validData(_A_::$app->get('category_id'));
      $this->display_order();
      $category = Model_Category::get_category($category_id);
      $this->template->vars('data', $category);
      $this->template->vars('back_url', _A_::$app->router()->UrlTo('categories'));
      $this->main->view_admin('edit');
    }

    public function edit_form() {
      $this->main->test_access_rights();
      $category_id = Model_Category::validData(_A_::$app->get('category_id'));
      $this->display_order_categories();
      $data = Model_Category::get_data_categories($category_id);
      $this->template->vars('data', $data);
      $back_url = _A_::$app->router()->UrlTo('categories');
      $this->template->vars('back_url', $back_url);
      $this->main->view_layout('edit_form');
    }

    public function save_data() {
      $this->main->test_access_rights();
      include('include/save_data_categories.php');
      if(!empty($post_category_name{0})) {
        if($post_category_ListStyle == "1") {
          $post_category_ListStyle = "1";
        } else {
          $post_category_ListStyle = "0";
        }
        if($post_category_ListNewItem == "1") {
          $post_category_ListNewItem = "1";
        } else {
          $post_category_ListNewItem = "0";
        }
        If(Model_Category::update($post_category_name, $post_category_seo, $post_display_order, $post_category_ListStyle, $post_category_ListNewItem, $category_id)) {
          $warning = ['Category Data saved successfully!'];
          $this->template->vars('warning', $warning);
          $this->edit_form();
        } else {
          $data = [];

          $data['cname'] = '';
          $data['seo'] = !is_null(_A_::$app->post('seo')) ? _A_::$app->get('seo') : null;
          $data['isStyle'] = !is_null(_A_::$app->post('ListStyle')) ? _A_::$app->post('ListStyle') : null;
          $data['isNew'] = !is_null(_A_::$app->post('ListNewItem')) ? _A_::$app->post('ListNewItem') : null;

          $error = [mysql_error()];
          $this->template->vars('error', $error);

          $this->display_order();
          $back_url = _A_::$app->router()->UrlTo('categories');
          $this->template->vars('back_url', $back_url);
          $this->template->vars('data', $data);

          $this->main->view_layout('edit_form');
        }
      } else {
        $data = [];

        $data['cname'] = '';
        $data['seo'] = !is_null(_A_::$app->post('seo')) ? _A_::$app->get('seo') : null;
        $data['isStyle'] = !is_null(_A_::$app->post('ListStyle')) ? _A_::$app->post('ListStyle') : null;
        $data['isNew'] = !is_null(_A_::$app->post('ListNewItem')) ? _A_::$app->post('ListNewItem') : null;

        $error = ['Identity Category Name Field!'];
        $this->template->vars('error', $error);

        $this->display_order();
        $back_url = _A_::$app->router()->UrlTo('categories');
        $this->template->vars('back_url', $back_url);
        $this->template->vars('data', $data);

        $this->main->view_layout('edit_form');
      }
    }

    public function add() {
      $this->main->test_access_rights();
      $this->display_order_wo_select();
      $back_url = _A_::$app->router()->UrlTo('categories');
      $this->template->vars('back_url', $back_url);
      $this->main->view_admin('new');
    }

    function new_form() {
      $this->main->test_access_rights();
      $this->display_order_wo_select();
      $back_url = _A_::$app->router()->UrlTo('categories');
      $this->template->vars('back_url', $back_url);
      $this->main->view_layout('new_form');
    }

    function save_new() {
      $this->main->test_access_rights();
      $category = Model_Category::validData(_A_::$app->post('category'));
      $post_category_name = mysql_real_escape_string($category);
      $post_display_order = Model_Category::validData(_A_::$app->post('display_order'));
      include('include/save_new_categories.php');

      if(!empty($post_category_name{0})) {
        $category_id = Model_Category::insert($post_category_name, $post_category_seo, $post_display_order, $post_category_ListStyle, $post_category_ListNewItem);
        if(isset($category_id)) {
          _A_::$app->get('category_id', $category_id);
          $warning = ['Category Data saved successfully!'];
          $this->template->vars('warning', $warning);
        } else {
          $this->template->vars('seo', !is_null(_A_::$app->post('seo')) ? _A_::$app->post('seo') : null);
          $this->template->vars('ListStyle', !is_null(_A_::$app->post('ListStyle')) ? _A_::$app->post('ListStyle') : null);
          $this->template->vars('ListNewItem', !is_null(_A_::$app->post('ListNewItem')) ? _A_::$app->post('ListNewItem') : null);
          $this->template->vars('error', [mysql_error()]);
        }
      } else {
        $this->template->vars('seo', !is_null(_A_::$app->post('seo')) ? _A_::$app->post('seo') : null);
        $this->template->vars('ListStyle', !is_null(_A_::$app->post('ListStyle')) ? _A_::$app->post('ListStyle') : null);
        $this->template->vars('ListNewItem', !is_null(_A_::$app->post('ListNewItem')) ? _A_::$app->post('ListNewItem') : null);
        $error = ['Identity Category Name Field!'];
        $this->template->vars('error', $error);
      }
      $this->new_form();
    }
  }