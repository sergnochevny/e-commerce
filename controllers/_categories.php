<?php

class Controller_Categories extends Controller_Base
{

    protected $main;

    function __construct($main)
    {

        $this->main = $main;
        $this->registry = $main->registry;
        $this->template = $main->template;

    }

    function categories()
    {

        $this->main->test_access_rights();
        $this->get_categories_list();
        $this->main->view_admin('category/categories');
    }

    function category_list()
    {

        $this->main->test_access_rights();
        $this->get_categories_list();
        $this->main->view_layout('category/category_list');
    }

    function get_categories_list()
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
            include('./views/index/category/get_categories_list.php');
            $categories .= ob_get_contents();
            ob_end_clean();
        }
        $this->template->vars('get_categories_list', $categories);
    }

    function del_categories()
    {
        $this->main->test_access_rights();
        $model = new Model_Users();
        $userInfo = $model->validData($_GET['category_id']);
        $del_category_id = $userInfo['data'];
        if (!empty($del_category_id)) {
            $strSQL = "update fabrix_products set cid = NULL WHERE cid = $del_category_id";
            mysql_query($strSQL);

            $strSQL = "DELETE FROM fabrix_categories WHERE cid = $del_category_id";
            mysql_query($strSQL);
        }
        $this->category_list();
    }

    function edit_categories()
    {
        $this->main->test_access_rights();
        $model = new Model_Users();
        $userInfo = $model->validData($_GET['category_id']);
        $category_id = $userInfo['data'];
        $this->display_order_categories();
        $userInfo = $model->get_data_categories($category_id);
        $this->template->vars('userInfo', $userInfo);
//        if(isset($_SESSION['last_url'])) {
//            $back_url = $_SESSION['last_url'];
//        } else {
        $back_url = BASE_URL . '/categories';
//        }
        $this->template->vars('back_url', $back_url);
        $this->main->view_admin('category/edit_categories');
    }

    function edit_category_form()
    {
        $this->main->test_access_rights();
        $model = new Model_Users();
        $userInfo = $model->validData($_GET['category_id']);
        $category_id = $userInfo['data'];
        $this->display_order_categories();
        $userInfo = $model->get_data_categories($category_id);
        $this->template->vars('userInfo', $userInfo);
//        if(isset($_SESSION['last_url'])) {
//            $back_url = $_SESSION['last_url'];
//        } else {
        $back_url = BASE_URL . '/categories';
//        }
        $this->template->vars('back_url', $back_url);
        $this->main->view_layout('category/edit_category_form');
    }

    function display_order_categories()
    {
        $this->main->test_access_rights();
        $model = new Model_Users();
        $userInfo = $model->validData($_GET['category_id']);
        $category_id = $userInfo['data'];
        $results = mysql_query("select * from fabrix_categories ORDER BY  `fabrix_categories`.`displayorder` ASC ");
        ob_start();
        while ($row = mysql_fetch_array($results)) {
            $resulthatistim = mysql_query("select * from fabrix_categories WHERE cid='$category_id'");
            $rowsni = mysql_fetch_array($resulthatistim);
            include('./views/index/category/display_order_categories.php');
        }
        $order_categories = ob_get_contents();
        ob_end_clean();
        $this->template->vars('display_order_categories', $order_categories);
    }

    function display_order_categories_wo_select()
    {
        $this->main->test_access_rights();
        $model = new Model_Users();
        $results = mysql_query("select * from fabrix_categories ORDER BY  `displayorder` ASC ");
        ob_start();
        while ($row = mysql_fetch_array($results)) {
            include('./views/index/category/display_order_categories_wo_select.php');
            $curr_order = (int)$row[3] + 1;
        }
        $this->template->vars('curr_order', $curr_order);
        $order_categories = ob_get_contents();
        ob_end_clean();
        $this->template->vars('display_order_categories', $order_categories);
    }

    function save_data_categories()
    {
        $this->main->test_access_rights();
        $model = new Model_Users();
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
            $userInfo['seo'] = isset($_POST['seo']) ? $_POST['seo'] : null;
            $userInfo['isStyle'] = isset($_POST['ListStyle']) ? $_POST['ListStyle'] : null;
            $userInfo['isNew'] = isset($_POST['ListNewItem']) ? $_POST['ListNewItem'] : null;

            $error = ['Identity Category Name Field!'];
            $this->template->vars('error', $error);

            $this->display_order_categories();

//            if(isset($_SESSION['last_url'])) {
//                $back_url = $_SESSION['last_url'];
//            } else {
            $back_url = BASE_URL . '/categories';
//            }

            $this->template->vars('back_url', $back_url);
            $this->template->vars('userInfo', $userInfo);

            $this->main->view_layout('category/edit_category_form');
        }
    }

    function new_categories()
    {
        $this->main->test_access_rights();
        $model = new Model_Users();
        $this->display_order_categories_wo_select();
//        if(isset($_SESSION['last_url'])) {
//            $back_url = $_SESSION['last_url'];
//        } else {
        $back_url = BASE_URL . '/categories';
//        }
        $this->template->vars('back_url', $back_url);
        $this->main->view_admin('category/new_categories');
    }

    function new_category_form()
    {
        $this->main->test_access_rights();
        $model = new Model_Users();
        $this->display_order_categories_wo_select();
//        if(isset($_SESSION['last_url'])) {
//            $back_url = $_SESSION['last_url'];
//        } else {
        $back_url = BASE_URL . '/categories';
//        }
        $this->template->vars('back_url', $back_url);
        $this->main->view_layout('category/new_category_form');
    }

    function save_new_categories()
    {
        $this->main->test_access_rights();
        $model = new Model_Users();
        $userInfo = $model->validData($_POST['category']);
        $post_category_name = mysql_real_escape_string($userInfo['data']);
        $userInfo = $model->validData($_POST['display_order']);
        $post_display_order = $userInfo['data'];
        include('include/save_new_categories.php');

        if (!empty($post_category_name{0})) {

            $strSQL = "INSERT INTO fabrix_categories(cname,seo,displayorder,isStyle,isNew) VALUES ('$post_category_name','$post_category_seo','$post_display_order','$post_category_ListStyle','$post_category_ListNewItem')";
            mysql_query($strSQL) or die(mysql_error());
            $category_id = mysql_insert_id();
            $_GET['category_id'] = $category_id;

            $warning = ['Category Data saved successfully!'];
            $this->template->vars('warning', $warning);
        } else {

            $this->template->vars('seo', isset($_POST['seo']) ? $_POST['seo'] : null);
            $this->template->vars('ListStyle', isset($_POST['ListStyle']) ? $_POST['ListStyle'] : null);
            $this->template->vars('ListNewItem', isset($_POST['ListNewItem']) ? $_POST['ListNewItem'] : null);

            $error = ['Identity Category Name Field!'];
            $this->template->vars('error', $error);
        }

        $this->new_category_form();

    }


}