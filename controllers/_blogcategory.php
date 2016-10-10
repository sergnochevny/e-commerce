<?php

  class Controller_BlogCategory extends Controller_Controller {

    /**
     * @export
     */
    public function admin() {
      $this->listof();
      $this->main->view_admin('blog_categories');
    }

    /**
     * @export
     */
    public function listof() {
      $rows = Model_Blog::get_blog_categories_list();
      $categories = '';
      ob_start();
      foreach($rows as $row) {
        $this->template->vars('row', $row);
        $this->template->view_layout('list_row');
      }
      $categories .= ob_get_contents();
      ob_end_clean();
      $this->main->template->vars('blog_categories_list', $categories);
    }

    /**
     * @export
     */
    public function del() {
      $group_id = !is_null(_A_::$app->get('cat')) ? _A_::$app->get('cat') : null;
      if(isset($group_id)) {
        if(Model_Blog::blog_category_is_empty($group_id)) {
          Model_Blog::del_blog_category($group_id);
          $warning = ['Category deleted successfully!'];
          $this->main->template->vars('warning', $warning);
        } else {
          $error = ['Category is not empty, delete is not possible!'];
          $this->main->template->vars('error', $error);
        }
      }
      $this->blog_categories_list();
      $this->main->view_layout('list');
    }

    /**
     * @export
     */
    public function edit() {
      $group_id = Model_Blog::validData(_A_::$app->get('cat'));
      $data = Model_Blog::get_blog_category($group_id);
      $this->main->template->vars('data', $data);

      $action_url = _A_::$app->router()->UrlTo('blogcategory/save', ['cat' => $group_id]);
      $this->main->template->vars('action_url', $action_url);

      $back_url = _A_::$app->router()->UrlTo('blogcategory/admin');
      $this->main->template->vars('button_title', 'Update');
      $this->main->template->vars('back_url', $back_url);
      $this->main->view_admin('edit');
    }

    public function save() {
      $group_id = Model_Blog::validData(_A_::$app->get('cat'));
      $category = Model_Blog::validData(_A_::$app->post('category'));
      $post_category_name = mysql_real_escape_string($category);
      if(!empty($post_category_name{0})) {
        if(!empty($group_id)) {
          $result = Model_Blog::update_blog_category($post_category_name, $group_id);
        }
        $warning = ['Category Data saved successfully!'];
        $this->main->template->vars('warning', $warning);
        $this->edit_form();
      } else {
        $data = [];

        $action_url = _A_::$app->router()->UrlTo('blogcategory/save', ['cat' => $group_id]);
        $this->main->template->vars('action_url', $action_url);

        $data['name'] = '';
        $data['slug'] = !is_null(_A_::$app->post('slug')) ? _A_::$app->post('slug') : null;
        $data['id'] = !is_null(_A_::$app->post('cat')) ? _A_::$app->get('cat') : '';

        $error = ['Identity Category Name Field!'];
        $this->main->template->vars('error', $error);

        $back_url = _A_::$app->router()->UrlTo('blogcategory/admin');

        $this->main->template->vars('button_title', 'Update');
        $this->main->template->vars('back_url', $back_url);
        $this->main->template->vars('data', $data);

        $this->main->view_layout('form');
      }
    }

    public function edit_form() {
      $group_id = Model_Blog::validData(_A_::$app->get('cat'));
      $data = Model_Blog::get_blog_category($group_id);
      $this->main->template->vars('data', $data);
      $back_url = _A_::$app->router()->UrlTo('blogcategory/admin');
      $action_url = _A_::$app->router()->UrlTo('blogcategory/save', ['cat' => $group_id]);
      $this->main->template->vars('button_title', 'Update');
      $this->main->template->vars('action_url', $action_url);
      $this->main->template->vars('back_url', $back_url);
      $this->main->view_layout('form');
    }

    /**
     * @export
     */
    public function add() {
      $data = [];

      $action_url = _A_::$app->router()->UrlTo('blogcategory/save_new');
      $this->main->template->vars('action_url', $action_url);

      $data['name'] = '';
      $data['slug'] = '';
      $data['id'] = '';

      $back_url = _A_::$app->router()->UrlTo('blogcategory/admin');
      $this->main->template->vars('button_title', 'Save');
      $this->main->template->vars('back_url', $back_url);
      $this->main->template->vars('data', $data);

      $this->main->view_admin('edit');
    }

    public function save_new() {
      $category = Model_Blog::validData(_A_::$app->post('category'));
      $post_category_name = mysql_real_escape_string($category);
      if(!empty($post_category_name{0})) {
        $slug = explode(' ', strtolower($post_category_name));
        $slug = array_filter($slug);
        $slug = implode('-', $slug);
        $result = Model_Blog::insert_blog_category($post_category_name, $slug);
        if($result) {
          $warning = ['Category Data saved successfully!'];
          $this->main->template->vars('warning', $warning);

          $data = [];
          $data['name'] = '';
          $data['slug'] = '';
          $data['id'] = '';
        } else {
          $warning = [mysql_error()];
          $this->main->template->vars('error', $warning);

          $data = [];
          $data['name'] = $post_category_name;
          $data['slug'] = !is_null(_A_::$app->post('slug')) ? _A_::$app->post('slug') : '';
          $data['id'] = '';
        }

        $action_url = _A_::$app->router()->UrlTo('blogcategory/save_new');
        $this->main->template->vars('action_url', $action_url);

        $back_url = _A_::$app->router()->UrlTo('blogcategory/admin');
        $this->main->template->vars('button_title', 'Save');
        $this->main->template->vars('back_url', $back_url);
        $this->main->template->vars('data', $data);

        $this->main->view_layout('form');
      } else {
        $data = [];

        $action_url = _A_::$app->router()->UrlTo('blogcategory/save_new');
        $this->main->template->vars('action_url', $action_url);

        $data['name'] = '';
        $data['slug'] = !is_null(_A_::$app->post('slug')) ? _A_::$app->post('slug') : null;
        $data['id'] = !is_null(_A_::$app->get('cat')) ? _A_::$app->get('cat') : '';

        $error = ['Identity Category Name Field!'];
        $this->main->template->vars('error', $error);

        $back_url = _A_::$app->router()->UrlTo('blogcategory/admin');

        $this->main->template->vars('button_title', 'Save');
        $this->main->template->vars('back_url', $back_url);
        $this->main->template->vars('data', $data);

        $this->main->view_layout('form');
      }
    }
  }