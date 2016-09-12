<?php

class Controller_BlogCategory extends Controller_Base
{

    function blog_categories_list()
    {
        $model = new Model_Blog();
        $rows = $model->get_blog_categories_list();
        $categories = '';
        ob_start();
        $base_url = BASE_URL;
        foreach ($rows as $row) {
            include('views/blogcategory/blog_categories_list_row.php');
        }
        $categories .= ob_get_contents();
        ob_end_clean();
        $this->template->vars('blog_categories_list', $categories);
    }

    function admin_blog_categories()
    {

        $this->blog_categories_list();
        $this->main->view_admin('blogcategory/blog_categories');
    }

    function del_blog_category()
    {
        $model = new Model_Blog();
        $group_id = !is_null(_A_::$app->get('cat')) ? _A_::$app->get('cat') : null;
        if (isset($group_id)) {
            if ($model->blog_category_is_empty($group_id)) {
                $model->del_blog_category($group_id);
                $warning = ['Category deleted successfully!'];
                $this->template->vars('warning', $warning);
            } else {
                $error = ['Category is not empty, delete is not possible!'];
                $this->template->vars('error', $error);
            }
        }
        $this->blog_categories_list();
        $this->main->view_layout('blogcategory/blog_categories_list');
    }

    function edit_blog_category()
    {
        $model = new Model_Blog();
        $base_url = BASE_URL;
        $group_id = $model->validData(_A_::$app->get('cat'));
        $userInfo = $model->get_blog_category($group_id);
        $this->template->vars('userInfo', $userInfo);

        $action_url = $base_url . '/save_blog_category?cat=' . $group_id;
        $this->template->vars('action_url', $action_url);

        $back_url = BASE_URL . '/admin_blog_categories';
        $this->template->vars('button_title', 'Update');
        $this->template->vars('back_url', $back_url);
        $this->main->view_admin('blogcategory/blog_edit_categories');
    }

    function blog_edit_category_form()
    {
        $model = new Model_Blog();
        $base_url = BASE_URL;
        $group_id = $model->validData(_A_::$app->get('cat'));
        $userInfo = $model->get_blog_category($group_id);
        $this->template->vars('userInfo', $userInfo);
        $back_url = BASE_URL . '/admin_blog_categories';
        $action_url = $base_url . '/save_blog_category?cat=' . $group_id;
        $this->template->vars('button_title', 'Update');
        $this->template->vars('action_url', $action_url);
        $this->template->vars('back_url', $back_url);
        $this->main->view_layout('blogcategory/blog_category_form');
    }

    function save_blog_category()
    {
        $model = new Model_Blog();
        $base_url = BASE_URL;
        $group_id = $model->validData(_A_::$app->get('cat'));
        $userInfo = $model->validData(_A_::$app->post('category'));
        $post_category_name = mysql_real_escape_string($userInfo['data']);
        if (!empty($post_category_name{0})) {
            if (!empty($group_id)) {
                $result = $model->update_blog_category($post_category_name, $group_id);
            }
            $warning = ['Category Data saved successfully!'];
            $this->template->vars('warning', $warning);
            $this->blog_edit_category_form();
        } else {
            $userInfo = [];

            $action_url = $base_url . '/save_blog_category?cat=' . $group_id;
            $this->template->vars('action_url', $action_url);

            $userInfo['name'] = '';
            $userInfo['slug'] = !is_null(_A_::$app->post('slug')) ? _A_::$app->post('slug') : null;
            $userInfo['id'] = !is_null(_A_::$app->post('cat')) ? _A_::$app->get('cat') : '';

            $error = ['Identity Category Name Field!'];
            $this->template->vars('error', $error);

            $back_url = $base_url . '/admin_blog_categories';

            $this->template->vars('button_title', 'Update');
            $this->template->vars('back_url', $back_url);
            $this->template->vars('userInfo', $userInfo);

            $this->main->view_layout('blogcategory/blog_category_form');
        }
    }

    function new_blog_category()
    {
        $userInfo = [];
        $base_url = BASE_URL;

        $action_url = $base_url . '/save_new_blog_category';
        $this->template->vars('action_url', $action_url);

        $userInfo['name'] = '';
        $userInfo['slug'] = '';
        $userInfo['id'] = '';

        $back_url = $base_url . '/admin_blog_categories';
        $this->template->vars('button_title', 'Save');
        $this->template->vars('back_url', $back_url);
        $this->template->vars('userInfo', $userInfo);

        $this->main->view_admin('blogcategory/blog_edit_categories');
    }

    function save_new_blog_category()
    {
        $model = new Model_Blog();
        $base_url = BASE_URL;
        $userInfo = $model->validData(_A_::$app->post('category'));
        $post_category_name = mysql_real_escape_string($userInfo['data']);
        if (!empty($post_category_name{0})) {
            $slug = explode(' ', strtolower($post_category_name));
            $slug = array_filter($slug);
            $slug = implode('-', $slug);
            $result = $model->insert_blog_category($post_category_name, $slug);
            if ($result) {
                $warning = ['Category Data saved successfully!'];
                $this->template->vars('warning', $warning);

                $userInfo = [];

                $userInfo['name'] = '';
                $userInfo['slug'] = '';
                $userInfo['id'] = '';

            } else {
                $warning = [mysql_error()];
                $this->template->vars('error', $warning);

                $userInfo = [];
                $userInfo['name'] = $post_category_name;
                $userInfo['slug'] = !is_null( _A_::$app->post('slug')) ?  _A_::$app->post('slug') : '';
                $userInfo['id'] = '';
            }

            $action_url = $base_url . '/save_new_blog_category';
            $this->template->vars('action_url', $action_url);

            $back_url = BASE_URL . '/admin_blog_categories';
            $this->template->vars('button_title', 'Save');
            $this->template->vars('back_url', $back_url);
            $this->template->vars('userInfo', $userInfo);

            $this->main->view_layout('blogcategory/blog_category_form');
        } else {
            $userInfo = [];

            $action_url = $base_url . '/save_new_blog_category';
            $this->template->vars('action_url', $action_url);

            $userInfo['name'] = '';
            $userInfo['slug'] = !is_null(_A_::$app->post('slug')) ? _A_::$app->post('slug') : null;
            $userInfo['id'] = !is_null(_A_::$app->get('cat')) ? _A_::$app->get('cat') : '';

            $error = ['Identity Category Name Field!'];
            $this->template->vars('error', $error);

            $back_url = $base_url . '/admin_blog_categories';

            $this->template->vars('button_title', 'Save');
            $this->template->vars('back_url', $back_url);
            $this->template->vars('userInfo', $userInfo);

            $this->main->view_layout('blogcategory/blog_category_form');
        }
    }

}