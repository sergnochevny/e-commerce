<?php

class Controller_Menu extends Controller_Base
{

    protected $main;

    function __construct($main)
    {

        $this->main = $main;
        $this->registry = $main->registry;
        $this->template = $main->template;

    }

    function menu_list()
    {
        $results = mysql_query("select * from fabrix_categories");
        while ($row = mysql_fetch_array($results)) {
            echo '<li class="menu-item menu-item-type-post_type menu-item-object-product">
            <a title="' . $row[1] . '" href="shop?cat=' . $row[0] . '">' . $row[1] . '</a></li>';
        }
    }

    function show_shop_menu()
    {
        $model = new Model_Tools();
        $base_url = BASE_URL;

        $items = $model->get_items_for_menu('all');
        ob_start();
        foreach ($items as $item) {
            $href = $base_url . "/shop&cat=" . $item['cid'];
            $name = $item['cname'];
            include('views/index/menu/menu_item.php');
        }
        $menu_all_category = ob_get_contents();
        ob_end_clean();

        $items = $model->get_items_for_menu('new');
        ob_start();
        foreach ($items as $item) {
            $href = $base_url . "/shop&cat=" . $item['cid'];
            $name = $item['cname'];
            include('views/index/menu/menu_item.php');
        }
        $menu_new_category = ob_get_contents();
        ob_end_clean();

        $items = $model->get_items_for_menu('manufacturer');
        ob_start();
        foreach ($items as $item) {
            $href = $base_url . "/shop&mnf=" . $item['id'];
            $name = $item['manufacturer'];
            include('views/index/menu/menu_item.php');
        }
        $menu_manufacturers = ob_get_contents();
        ob_end_clean();

        $items = $model->get_items_for_menu('patterns');
        ob_start();
        foreach ($items as $item) {
            $href = $base_url . "/shop&ptrn=" . $item['id'];
            $name = $item['pattern'];
            include('views/index/menu/menu_item.php');
        }
        $menu_patterns = ob_get_contents();
        ob_end_clean();

        ob_start();
        include('views/index/menu/shop_menu.php');
        $shop_menu = ob_get_contents();
        ob_end_clean();

        $this->template->vars('shop_menu', $shop_menu);

    }

    function show_blog_menu()
    {
        $model = new Model_Tools();
        $base_url = BASE_URL;

        $items = $model->get_items_for_menu('blog_category');
        ob_start();
        foreach ($items as $item) {
            $href = $base_url . "/blog&cat=" . $item['group_id'];
            $name = $item['name'];
            include('views/index/menu/menu_item.php');
        }
        $menu_blog_category = ob_get_contents();
        ob_end_clean();

        ob_start();
        include('views/index/menu/blog_menu.php');
        $shop_menu = ob_get_contents();
        ob_end_clean();

        $this->template->vars('blog_menu', $shop_menu);

    }

    function show_menu()
    {
        $base_url = BASE_URL;
        $this->show_shop_menu();
        $this->show_blog_menu();
        $this->template->vars('base_url', $base_url);
        ob_start();
        $this->template->view_layout('menu/menu');
        $menu = ob_get_contents();
        ob_end_clean();
        $this->template->vars('menu', $menu);
    }

}