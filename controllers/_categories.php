<?php

class Controller_Categories extends Controller_Base
{

    function categories()
    {

        $this->main->test_access_rights();
        $this->get_list();
        $this->main->view_admin('categories');
    }

    function list()
    {

        $this->main->test_access_rights();
        $this->get_list();
        $this->main->view_layout('list');
    }

    function get_list()
    {
        $this->main->test_access_rights();
        $results = mysql_query("select * from fabrix_categories");
        $categories = '';
        while ($row = mysql_fetch_array($results)) {
            if ($row[4] == 1) {
                $row[4] = "Yes";
            } else {
                $row[4] = "No";
            }
            if ($row[5] == 1) {
                $row[5] = "Yes";
            } else {
                $row[5] = "No";
            }
            ob_start();
            include('./views/category/get_list.php');
            $categories .= ob_get_contents();
            ob_end_clean();
        }
        $this->template->vars('get_categories_list', $categories);
    }

    function del()
    {
        $this->main->test_access_rights();
        $model = new Model_Tools();
        $del_category_id = $model->validData(_A_::$app->get('category_id'));
        if (!empty($del_category_id)) {
            $strSQL = "update fabrix_products set cid = NULL WHERE cid = $del_category_id";
            mysql_query($strSQL);

            $strSQL = "DELETE FROM fabrix_categories WHERE cid = $del_category_id";
            mysql_query($strSQL);
        }
        $this->category_list();
    }

    function edit()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();
        $category_id = $model->validData(_A_::$app->get('category_id'));
        $this->display_order_categories();
        $userInfo = $model->get_data_categories($category_id);
        $this->template->vars('userInfo', $userInfo);
        $back_url = _A_::$app->router()->UrlTo('categories');
        $this->template->vars('back_url', $back_url);
        $this->main->view_admin('edit');
    }

    function edit_form()
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

    function display_order()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();
        $category_id = $model->validData(_A_::$app->get('category_id'));
        $results = mysql_query("select * from fabrix_categories ORDER BY  `fabrix_categories`.`displayorder` ASC ");
        ob_start();
        while ($row = mysql_fetch_array($results)) {
            $resulthatistim = mysql_query("select * from fabrix_categories WHERE cid='$category_id'");
            $rowsni = mysql_fetch_array($resulthatistim);
            include('./views/category/display_order.php');
        }
        $order_categories = ob_get_contents();
        ob_end_clean();
        $this->template->vars('display_order_categories', $order_categories);
    }

    function display_order_wo_select()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();
        $results = mysql_query("select * from fabrix_categories ORDER BY  `displayorder` ASC ");
        ob_start();
        while ($row = mysql_fetch_array($results)) {
            include('./views/category/display_order_categories_wo_select.php');
            $curr_order = (int)$row[3] + 1;
        }
        $this->template->vars('curr_order', $curr_order);
        $order_categories = ob_get_contents();
        ob_end_clean();
        $this->template->vars('display_order_categories', $order_categories);
    }

    function save_data()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();
        include('include/save_data_categories.php');
        if (!empty($post_category_name{0})) {
            $resulthatistim = mysql_query("select * from fabrix_categories WHERE cid='$category_id'");
            $rowsni = mysql_fetch_array($resulthatistim);
            $temp = $rowsni['displayorder'];
            $resulthatistim = mysql_query("select * from fabrix_categories WHERE displayorder='$post_display_order'");
            $rows = mysql_fetch_array($resulthatistim);
            $temp_id = $rows['cid'];
            $result = mysql_query("update fabrix_categories set displayorder='$temp' WHERE cid ='$temp_id'");
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
            if (!empty($category_id)) {
                $result = mysql_query("update fabrix_categories set cname='$post_category_name', seo='$post_category_seo', displayorder='$post_display_order', isStyle='$post_category_ListStyle',  isNew='$post_category_ListNewItem' WHERE cid ='$category_id'");
            }
            $warning = ['Category Data saved successfully!'];
            $this->template->vars('warning', $warning);
            $this->edit_category_form();
        } else {
            $userInfo = [];

            $userInfo['cname'] = '';
            $userInfo['seo'] = !is_null(_A_::$app->post('seo')) ? _A_::$app->get('seo') : null;
            $userInfo['isStyle'] = !is_null(_A_::$app->post('ListStyle')) ? _A_::$app->post('ListStyle') : null;
            $userInfo['isNew'] = !is_null(_A_::$app->post('ListNewItem')) ? _A_::$app->post('ListNewItem') : null;

            $error = ['Identity Category Name Field!'];
            $this->template->vars('error', $error);

            $this->display_order_categories();
            $back_url = _A_::$app->router()->UrlTo('categories');
            $this->template->vars('back_url', $back_url);
            $this->template->vars('userInfo', $userInfo);

            $this->main->view_layout('edit_form');
        }
    }

    function new()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();
        $this->display_order_categories_wo_select();
        $back_url = _A_::$app->router()->UrlTo('categories');
        $this->template->vars('back_url', $back_url);
        $this->main->view_admin('new');
    }

    function new_category_form()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();
        $this->display_order_categories_wo_select();
//        if(isset($_SESSION['last_url'])) {
//            $back_url = $_SESSION['last_url'];
//        } else {
        $back_url = _A_::$app->router()->UrlTo('categories');
//        }
        $this->template->vars('back_url', $back_url);
        $this->main->view_layout('category/new_category_form');
    }

    function save_new_categories()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();
        $category = $model->validData(_A_::$app->post('category'));
        $post_category_name = mysql_real_escape_string($category);
        $post_display_order = $model->validData(_A_::$app->post('display_order'));
        include('include/save_new_categories.php');

        if (!empty($post_category_name{0})) {

            $strSQL = "INSERT INTO fabrix_categories(cname,seo,displayorder,isStyle,isNew) VALUES ('$post_category_name','$post_category_seo','$post_display_order','$post_category_ListStyle','$post_category_ListNewItem')";
            mysql_query($strSQL) or die(mysql_error());
            $category_id = mysql_insert_id();
            _A_::$app->get('category_id', $category_id);

            $warning = ['Category Data saved successfully!'];
            $this->template->vars('warning', $warning);
        } else {

            $this->template->vars('seo', !is_null(_A_::$app->post('seo')) ? _A_::$app->post('seo') : null);
            $this->template->vars('ListStyle', !is_null(_A_::$app->post('ListStyle')) ? _A_::$app->post('ListStyle') : null);
            $this->template->vars('ListNewItem', !is_null(_A_::$app->post('ListNewItem')) ? _A_::$app->post('ListNewItem') : null);

            $error = ['Identity Category Name Field!'];
            $this->template->vars('error', $error);
        }

        $this->new_category_form();

    }


}