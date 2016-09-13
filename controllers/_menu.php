<?php

class Controller_Menu extends Controller_Controller
{

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

        $this->template->vars('base_url',$base_url);
        $items = $model->get_items_for_menu('all');
        ob_start();
        foreach ($items as $item) {
            $href = _A_::$app->router()->UrlTo('shop',['cat'=>$item['cid']]);
            $name = $item['cname'];
            $this->template->vars('href',$href, true);
            $this->template->vars('name',$name, true);
            $this->template->view_layout('menu_item');
        }
        $menu_all_category = ob_get_contents();
        ob_end_clean();

        $items = $model->get_items_for_menu('new');
        ob_start();
        foreach ($items as $item) {
            $href = _A_::$app->router()->UrlTo('shop',['cat',$item['cid']]);
            $name = $item['cname'];
            $this->template->vars('href',$href, true);
            $this->template->vars('name',$name, true);
            $this->template->view_layout('menu_item');
        }
        $menu_new_category = ob_get_contents();
        ob_end_clean();

        $items = $model->get_items_for_menu('manufacturer');
        ob_start();
        foreach ($items as $item) {
            $href = _A_::$app->router()->UrlTo('shop',['mnf'=>$item['id']]);
            $name = $item['manufacturer'];
            $this->template->vars('href',$href, true);
            $this->template->vars('name',$name, true);
            $this->template->view_layout('menu_item');
        }
        $menu_manufacturers = ob_get_contents();
        ob_end_clean();

        $items = $model->get_items_for_menu('patterns');
        ob_start();
        foreach ($items as $item) {
            $href = _A_::$app->router()->UrlTo('shop',['ptrn'=>$item['id']]);
            $name = $item['pattern'];
            $this->template->vars('href',$href, true);
            $this->template->vars('name',$name, true);
            $this->template->view_layout('menu_item');
        }
        $menu_patterns = ob_get_contents();
        ob_end_clean();

        ob_start();
        $this->template->vars('menu_all_category',$menu_all_category);
        $this->template->vars('menu_new_category',$menu_new_category);
        $this->template->vars('menu_manufacturers',$menu_manufacturers);
        $this->template->vars('menu_patterns',$menu_patterns);
        $this->template->view_layout('shop_menu');
        $shop_menu = ob_get_contents();
        ob_end_clean();

        $this->template->vars('shop_menu', $shop_menu);

    }

    function show_blog_menu()
    {
        $model = new Model_Tools();
        $base_url = BASE_URL;

        $this->template->vars('base_url',$base_url);
        $items = $model->get_items_for_menu('blog_category');
        ob_start();
        foreach ($items as $item) {
            $href = $base_url . "/blog&cat=" . $item['group_id'];
            $name = $item['name'];
            $this->template->vars('href',$href, true);
            $this->template->vars('name',$name, true);
            $this->template->view_layout('menu_item');
        }
        $menu_blog_category = ob_get_contents();
        ob_end_clean();

        ob_start();
        $this->template->vars('menu_blog_category',$menu_blog_category);
        $this->template->view_layout('blog_menu');
        $blog_menu = ob_get_contents();
        ob_end_clean();

        $this->template->vars('blog_menu', $blog_menu);

    }

    function show_menu()
    {
        $base_url = BASE_URL;
        $this->show_shop_menu();
        $this->show_blog_menu();
        $this->template->vars('base_url', $base_url);
        ob_start();
        $this->template->view_layout('menu');
        $menu = ob_get_contents();
        ob_end_clean();
        $this->main->template->vars('menu', $menu);
    }

}