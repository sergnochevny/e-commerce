<?php

class Controller_BlogCategory extends Controller_Controller
{

    function admin()
    {

        $this->blog_categories_list();
        $this->main->view_admin('blog_categories');
    }

    function blog_categories_list()
    {
        $model = new Model_Blog();
        $rows = $model->get_blog_categories_list();
        $categories = '';
        ob_start();
        $base_url = _A_::$app->router()->UrlTo('/');
        foreach ($rows as $row) {
            $this->template->vars('base_url', $base_url);
            $this->template->vars('row', $row);
            $this->template->view_layout('blog_categories_list_row');
        }
        $categories .= ob_get_contents();
        ob_end_clean();
        $this->main->template->vars('blog_categories_list', $categories);
    }

    function del()
    {
        $model = new Model_Blog();
        $group_id = !is_null(_A_::$app->get('cat')) ? _A_::$app->get('cat') : null;
        if (isset($group_id)) {
            if ($model->blog_category_is_empty($group_id)) {
                $model->del_blog_category($group_id);
                $warning = ['Category deleted successfully!'];
                $this->main->template->vars('warning', $warning);
            } else {
                $error = ['Category is not empty, delete is not possible!'];
                $this->main->template->vars('error', $error);
            }
        }
        $this->blog_categories_list();
        $this->main->view_layout('blog_categories_list');
    }

    function edit()
    {
        $model = new Model_Blog();
        $base_url = _A_::$app->router()->UrlTo('/');
        $group_id = $model->validData(_A_::$app->get('cat'));
        $userInfo = $model->get_blog_category($group_id);
        $this->main->template->vars('userInfo', $userInfo);

        $action_url = _A_::$app->router()->UrlTo('blogcategory/save',['cat' => $group_id]);
        $this->main->template->vars('action_url', $action_url);

        $back_url = _A_::$app->router()->UrlTo('blogcategory/admin');
        $this->main->template->vars('button_title', 'Update');
        $this->main->template->vars('back_url', $back_url);
        $this->main->view_admin('blogcategory/blog_edit_categories');
    }

    function save()
    {
        $model = new Model_Blog();
        $base_url = _A_::$app->router()->UrlTo('/');
        $group_id = $model->validData(_A_::$app->get('cat'));
        $category = $model->validData(_A_::$app->post('category'));
        $post_category_name = mysql_real_escape_string($category);
        if (!empty($post_category_name{0})) {
            if (!empty($group_id)) {
                $result = $model->update_blog_category($post_category_name, $group_id);
            }
            $warning = ['Category Data saved successfully!'];
            $this->main->template->vars('warning', $warning);
            $this->edit_form();
        } else {
            $userInfo = [];

            $action_url = _A_::$app->router()->UrlTo('blogcategory/save', ['cat' => $group_id]);
            $this->main->template->vars('action_url', $action_url);

            $userInfo['name'] = '';
            $userInfo['slug'] = !is_null(_A_::$app->post('slug')) ? _A_::$app->post('slug') : null;
            $userInfo['id'] = !is_null(_A_::$app->post('cat')) ? _A_::$app->get('cat') : '';

            $error = ['Identity Category Name Field!'];
            $this->main->template->vars('error', $error);

            $back_url = _A_::$app->router()->UrlTo('blogcategory/admin');

            $this->main->template->vars('button_title', 'Update');
            $this->main->template->vars('back_url', $back_url);
            $this->main->template->vars('userInfo', $userInfo);

            $this->main->view_layout('blog_category_form');
        }
    }

    function edit_form()
    {
        $model = new Model_Blog();
        $base_url = _A_::$app->router()->UrlTo('/');
        $group_id = $model->validData(_A_::$app->get('cat'));
        $userInfo = $model->get_blog_category($group_id);
        $this->main->template->vars('userInfo', $userInfo);
        $back_url = _A_::$app->router()->UrlTo('blogcategory/admin');
        $action_url = _A_::$app->router()->UrlTo('blogcategory/save', ['cat' => $group_id]);
        $this->main->template->vars('button_title', 'Update');
        $this->main->template->vars('action_url', $action_url);
        $this->main->template->vars('back_url', $back_url);
        $this->main->view_layout('blogcategory/blog_category_form');
    }

    function new()
    {
        $userInfo = [];
        $base_url = _A_::$app->router()->UrlTo('/');

        $action_url = _A_::$app->router()->UrlTo('blogcategory/save_new');
        $this->main->template->vars('action_url', $action_url);

        $userInfo['name'] = '';
        $userInfo['slug'] = '';
        $userInfo['id'] = '';

        $back_url = _A_::$app->router()->UrlTo('blogcategory/admin');
        $this->main->template->vars('button_title', 'Save');
        $this->main->template->vars('back_url', $back_url);
        $this->main->template->vars('userInfo', $userInfo);

        $this->main->view_admin('blog_edit_categories');
    }

    function save_new()
    {
        $model = new Model_Blog();
        $base_url = _A_::$app->router()->UrlTo('/');
        $category = $model->validData(_A_::$app->post('category'));
        $post_category_name = mysql_real_escape_string($category);
        if (!empty($post_category_name{0})) {
            $slug = explode(' ', strtolower($post_category_name));
            $slug = array_filter($slug);
            $slug = implode('-', $slug);
            $result = $model->insert_blog_category($post_category_name, $slug);
            if ($result) {
                $warning = ['Category Data saved successfully!'];
                $this->main->template->vars('warning', $warning);

                $userInfo = [];
                $userInfo['name'] = '';
                $userInfo['slug'] = '';
                $userInfo['id'] = '';
            } else {
                $warning = [mysql_error()];
                $this->main->template->vars('error', $warning);

                $userInfo = [];
                $userInfo['name'] = $post_category_name;
                $userInfo['slug'] = !is_null(_A_::$app->post('slug')) ? _A_::$app->post('slug') : '';
                $userInfo['id'] = '';
            }

            $action_url = _A_::$app->router()->UrlTo('blogcategory/save_new');
            $this->main->template->vars('action_url', $action_url);

            $back_url = _A_::$app->router()->UrlTo('blogcategory/admin');
            $this->main->template->vars('button_title', 'Save');
            $this->main->template->vars('back_url', $back_url);
            $this->main->template->vars('userInfo', $userInfo);

            $this->main->view_layout('blog_category_form');
        } else {
            $userInfo = [];

            $action_url = _A_::$app->router()->UrlTo('blogcategory/save_new');
            $this->main->template->vars('action_url', $action_url);

            $userInfo['name'] = '';
            $userInfo['slug'] = !is_null(_A_::$app->post('slug')) ? _A_::$app->post('slug') : null;
            $userInfo['id'] = !is_null(_A_::$app->get('cat')) ? _A_::$app->get('cat') : '';

            $error = ['Identity Category Name Field!'];
            $this->main->template->vars('error', $error);

            $back_url = _A_::$app->router()->UrlTo('blogcategory/admin');

            $this->main->template->vars('button_title', 'Save');
            $this->main->template->vars('back_url', $back_url);
            $this->main->template->vars('userInfo', $userInfo);

            $this->main->view_layout('blog_category_form');
        }
    }

}