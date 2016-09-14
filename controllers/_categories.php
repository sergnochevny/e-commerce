<?php

class Controller_Categories extends Controller_Base
{

    public function categories()
    {

        $this->main->test_access_rights();
        $this->get_list();
        $this->main->view_admin('categories');
    }

    public function list()
    {
        $this->main->test_access_rights();
        $this->get_list();
        $this->main->view_layout('list');
    }

    public function get_list()
    {
        $this->main->test_access_rights();
        $model = new Model_Category();
        $categories = '';
        $rows = $model->get_all();
        foreach($rows as $row) {
            ob_start();
            $this->template->vars('row', $row);
            $this->template->view_layout('get_list');
            $categories .= ob_get_contents();
            ob_end_clean();
        }
        $this->template->vars('get_categories_list', $categories);
    }

    public function del()
    {
        $this->main->test_access_rights();
        $model = new Model_Category();
        $del_category_id = $model->validData(_A_::$app->get('category_id'));
        $model->del($del_category_id);
        $this->category_list();
    }

    public function edit()
    {
        $this->main->test_access_rights();
        $model = new Model_Category();
        $category_id = $model->validData(_A_::$app->get('category_id'));
        $this->display_order();
        $category = $model->get_category($category_id);
        $this->template->vars('userInfo', $category);
        $back_url = _A_::$app->router()->UrlTo('categories');
        $this->template->vars('back_url', $back_url);
        $this->main->view_admin('edit');
    }

    public function edit_form()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();
        $category_id = $model->validData(_A_::$app->get('category_id'));
        $this->display_order_categories();
        $userInfo = $model->get_data_categories($category_id);
        $this->template->vars('userInfo', $userInfo);
        $back_url = _A_::$app->router()->UrlTo('categories');
        $this->template->vars('back_url', $back_url);
        $this->main->view_layout('edit_form');
    }

    private function display_order()
    {
        $this->main->test_access_rights();
        $model = new Model_Category();
        $category_id = $model->validData(_A_::$app->get('category_id'));
        $category = $model->get_category($category_id);
        $this->template->vars('displayorder', $category['displayorder']);
        $rows = $model->get_all(['order' => ' ORDER BY displayorder ASC ']);
        ob_start();
        foreach ($rows as $row) {
            $this->template->vars('row', $row);
            $this->template->view_layout('display_order');
        }
        $order_categories = ob_get_contents();
        ob_end_clean();
        $this->template->vars('display_order_categories', $order_categories);
    }

    private function display_order_wo_select()
    {
        $this->main->test_access_rights();
        $model = new Model_Category();
        $rows = $model->get_all(['order' => ' ORDER BY displayorder ASC ']);
        ob_start();
        foreach ($rows as $row) {
            $this->template->vars('row', $row);
            $this->template->view_layout('display_wo_select');
            $curr_order = (int)$row[3] + 1;
        }
        $this->template->vars('curr_order', $curr_order);
        $order_categories = ob_get_contents();
        ob_end_clean();
        $this->template->vars('display_order_categories', $order_categories);
    }

    public function save_data()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();
        include('include/save_data_categories.php');
        if (!empty($post_category_name{0})) {
            if ($post_category_ListStyle == "1") {
                $post_category_ListStyle = "1";
            } else {
                $post_category_ListStyle = "0";
            }
            if ($post_category_ListNewItem == "1") {
                $post_category_ListNewItem = "1";
            } else {
                $post_category_ListNewItem = "0";
            }
            If($model->update($post_category_name,$post_category_seo,$post_display_order,$post_category_ListStyle,$post_category_ListNewItem,$category_id)){
                $warning = ['Category Data saved successfully!'];
                $this->template->vars('warning', $warning);
                $this->edit_category_form();
            } else {
                $userInfo = [];

                $userInfo['cname'] = '';
                $userInfo['seo'] = !is_null(_A_::$app->post('seo')) ? _A_::$app->get('seo') : null;
                $userInfo['isStyle'] = !is_null(_A_::$app->post('ListStyle')) ? _A_::$app->post('ListStyle') : null;
                $userInfo['isNew'] = !is_null(_A_::$app->post('ListNewItem')) ? _A_::$app->post('ListNewItem') : null;

                $error = [mysql_error()];
                $this->template->vars('error', $error);

                $this->display_order();
                $back_url = _A_::$app->router()->UrlTo('categories');
                $this->template->vars('back_url', $back_url);
                $this->template->vars('userInfo', $userInfo);

                $this->main->view_layout('edit_form');

            }
        } else {
            $userInfo = [];

            $userInfo['cname'] = '';
            $userInfo['seo'] = !is_null(_A_::$app->post('seo')) ? _A_::$app->get('seo') : null;
            $userInfo['isStyle'] = !is_null(_A_::$app->post('ListStyle')) ? _A_::$app->post('ListStyle') : null;
            $userInfo['isNew'] = !is_null(_A_::$app->post('ListNewItem')) ? _A_::$app->post('ListNewItem') : null;

            $error = ['Identity Category Name Field!'];
            $this->template->vars('error', $error);

            $this->display_order();
            $back_url = _A_::$app->router()->UrlTo('categories');
            $this->template->vars('back_url', $back_url);
            $this->template->vars('userInfo', $userInfo);

            $this->main->view_layout('edit_form');
        }
    }

    public function new()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();
        $this->display_order_wo_select();
        $back_url = _A_::$app->router()->UrlTo('categories');
        $this->template->vars('back_url', $back_url);
        $this->main->view_admin('new');
    }

    function new_form()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();
        $this->display_order_wo_select();
        $back_url = _A_::$app->router()->UrlTo('categories');
        $this->template->vars('back_url', $back_url);
        $this->main->view_layout('category/new_category_form');
    }

    function save_new()
    {
        $this->main->test_access_rights();
        $model = new Model_Category();
        $category = $model->validData(_A_::$app->post('category'));
        $post_category_name = mysql_real_escape_string($category);
        $post_display_order = $model->validData(_A_::$app->post('display_order'));
        include('include/save_new_categories.php');

        if (!empty($post_category_name{0})) {
            $category_id = $model->insert($post_category_name,$post_category_seo,$post_display_order,$post_category_ListStyle,$post_category_ListNewItem);
            if (isset($category_id)){
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