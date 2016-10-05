<?php

  class Controller_Categories extends Controller_Controller {

    private function get_list() {
      $categories = '';
      $rows = Model_Category::get_all();
      ob_start();
      foreach($rows as $row) {
        $this->template->vars('row', $row);
        $this->template->view_layout('get_list');
      }
      $categories = ob_get_contents();
      ob_end_clean();
      $this->template->vars('list', $categories);
      $this->main->view_layout('list');
    }

    private function form($url, $back_url) {
      $this->main->test_access_rights();
      $category_id = _A_::$app->get('category_id');
      $action = _A_::$app->router()->UrlTo($url, ['category_id' => $category_id]);
      $data = Model_Category::get_data_category($category_id);
      $this->template->vars('category_id', $category_id);
      $this->template->vars('data', $data);
      $this->template->vars('back_url', $back_url);
      $this->template->vars('action', $action);
      $this->main->view_layout('form');
    }

    private function save() {
      include('include/save_data_categories.php');

      $data = [
        'cname' => $post_category_name,
        'display_order' => $post_display_order
      ];

      if(empty($post_category_name) || empty($post_display_order)) {
        $error = [];
        if(empty($post_category_name)) $error[] = "The Category Name is required.";
        if(empty($post_display_order)) $error[] = "The Display Order is required.";
      } else {
        try {
          Model_Category::save($post_category_name, $post_display_order, $category_id);
          $warning = ["The data saved successfully!"];
          $data = null;
        } catch(Exception $e) {
          $error[] = $e->getMessage();
        }
      }
      $this->template->vars('warning', isset($warning) ? $warning : null);
      $this->template->vars('error', isset($error) ? $error : null);
      return $data;
    }

    /**
     * @export
     */
    public function categories() {
      $this->main->test_access_rights();
      ob_start();
      $this->get_list();
      $list = ob_get_contents();
      ob_end_clean();
      $this->template->vars('list', $list);
      $this->main->view_admin('categories');
    }

    /**
     * @export
     */
    public function del() {
      $this->main->test_access_rights();
      $del_category_id = _A_::$app->get('category_id');
      Model_Category::del($del_category_id);
      $this->get_list();
    }

    public function edit_add_handling($url, $back_url, $title) {
      $this->template->vars('form_title', $title);
      if(_A_::$app->request_is_post()) {
        $data = $this->save();
        $this->form($url, $back_url, $data);
        exit;
      }
      ob_start();
      $this->form($url, $back_url);
      $form = ob_get_contents();
      ob_end_clean();
      $this->template->vars('form', $form);
      $this->main->view_admin('edit');
    }

    /**
     * @export
     */
    public function add() {
      $this->main->test_access_rights();
      $this->edit_add_handling('categories/add', 'categories', 'NEW CATEGORY');
    }

    /**
     * @export
     */
    public function edit() {
      $this->main->test_access_rights();
      $this->edit_add_handling('categories/edit', 'categories', 'MODIFY CATEGORY');
    }

  }