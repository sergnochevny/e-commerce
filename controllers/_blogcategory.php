<?php
class Controller_BlogCategory extends Controller_Base{

    protected $main;

    function __construct($main) {

        $this->main = $main;
        $this->registry = $main->registry;
        $this->template = $main->template;

    }


    function blog_categories_list()
    {
        $q = "select a.group_id, a.name, count(b.group_id) as amount from blog_groups a " .
            " left join blog_group_posts b on a.group_id=b.group_id" .
            " group by a.group_id, a.name";
        $results = mysql_query($q);
        $categories = '';
        ob_start();
        $base_url = BASE_URL;
        while ($row = mysql_fetch_assoc($results)) {
            include('views/index/blogcategory/blog_categories_list_row.php');
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
        $model = new Model_Users();
        $group_id = isset($_GET['cat']) ? $_GET['cat'] : null;
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
        $model = new Model_Users();
        $base_url = BASE_URL;
        $userInfo = $model->validData($_GET['cat']);
        $group_id = $userInfo['data'];
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
        $model = new Model_Users();
        $base_url = BASE_URL;
        $userInfo = $model->validData($_GET['cat']);
        $group_id = $userInfo['data'];
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
        $model = new Model_Users();
        $base_url = BASE_URL;
        $userInfo = $model->validData($_GET['cat']);
        $group_id = $userInfo['data'];
        $userInfo = $model->validData($_POST['category']);
        $post_category_name = mysql_real_escape_string($userInfo['data']);
        if (!empty($post_category_name{0})) {
            if (!empty($group_id)) {
                $result = mysql_query("update blog_groups set name='$post_category_name' WHERE group_id ='$group_id'");
            }
            $warning = ['Category Data saved successfully!'];
            $this->template->vars('warning', $warning);
            $this->blog_edit_category_form();
        } else {
            $userInfo = [];

            $action_url = $base_url . '/save_blog_category?cat=' . $group_id;
            $this->template->vars('action_url', $action_url);

            $userInfo['name'] = '';
            $userInfo['slug'] = isset($_POST['slug']) ? $_POST['slug'] : null;
            $userInfo['id'] = isset($_GET['cat']) ? $_GET['cat'] : '';

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
        $model = new Model_Users();
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
        $model = new Model_Users();
        $base_url = BASE_URL;
        $userInfo = $model->validData($_POST['category']);
        $post_category_name = mysql_real_escape_string($userInfo['data']);
        if (!empty($post_category_name{0})) {
            $slug = explode(' ', strtolower($post_category_name));
            $slug = array_filter($slug);
            $slug = implode('-', $slug);
            $result = mysql_query("insert into blog_groups set name='$post_category_name', slug='$slug'");
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
                $userInfo['slug'] = isset($_POST['slug']) ? $_POST['slug'] : '';
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
            $userInfo['slug'] = isset($_POST['slug']) ? $_POST['slug'] : null;
            $userInfo['id'] = isset($_GET['cat']) ? $_GET['cat'] : '';

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