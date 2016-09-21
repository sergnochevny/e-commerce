<?php

class Controller_Menu extends Controller_Controller
{

    function show_menu()
    {
        $base_url = _A_::$app->router()->UrlTo('/');
        $this->show_shop_menu();
        $this->show_blog_menu();
        $this->template->vars('base_url', $base_url);
        ob_start();
        $this->template->view_layout('menu');
        $menu = ob_get_contents();
        ob_end_clean();
        $this->main->template->vars('menu', $menu);
    }

    function show_shop_menu()
    {
        $model = new Model_Tools();
        $base_url = _A_::$app->router()->UrlTo('/');

        $this->template->vars('base_url', $base_url);
        $items = $model->get_items_for_menu('all');
        ob_start();
        foreach ($items as $item) {
            $name = $item['cname'];
            $href = _A_::$app->router()->UrlTo('shop', ['cat' => $item['cid']], $name);
            $this->template->vars('href', $href, true);
            $this->template->vars('name', $name, true);
            $this->template->view_layout('menu_item');
        }
        $menu_all_category = ob_get_contents();
        ob_end_clean();

        $items = $model->get_items_for_menu('new');
        ob_start();
        foreach ($items as $item) {
            $name = $item['cname'];
            $href = _A_::$app->router()->UrlTo('shop/last', ['cat' => $item['cid']], 'new ' . $name);
            $this->template->vars('href', $href, true);
            $this->template->vars('name', $name, true);
            $this->template->view_layout('menu_item');
        }
        $menu_new_category = ob_get_contents();
        ob_end_clean();

        $items = $model->get_items_for_menu('manufacturer');
        ob_start();
        foreach ($items as $item) {
            $name = $item['manufacturer'];
            $href = _A_::$app->router()->UrlTo('shop', ['mnf' => $item['id']], $name);
            $this->template->vars('href', $href, true);
            $this->template->vars('name', $name, true);
            $this->template->view_layout('menu_item');
        }
        $menu_manufacturers = ob_get_contents();
        ob_end_clean();

        $items = $model->get_items_for_menu('patterns');
        ob_start();
        foreach ($items as $item) {
            $name = $item['pattern'];
            $href = _A_::$app->router()->UrlTo('shop', ['ptrn' => $item['id']], $name);
            $this->template->vars('href', $href, true);
            $this->template->vars('name', $name, true);
            $this->template->view_layout('menu_item');
        }
        $menu_patterns = ob_get_contents();
        ob_end_clean();

        ob_start();
        $this->template->vars('menu_all_category', $menu_all_category);
        $this->template->vars('menu_new_category', $menu_new_category);
        $this->template->vars('menu_manufacturers', $menu_manufacturers);
        $this->template->vars('menu_patterns', $menu_patterns);
        $this->template->view_layout('shop_menu');
        $shop_menu = ob_get_contents();
        ob_end_clean();

        $this->template->vars('shop_menu', $shop_menu);

    }

    function show_blog_menu()
    {
        $model = new Model_Tools();
        $base_url = _A_::$app->router()->UrlTo('/');

        $this->template->vars('base_url', $base_url);
        $items = $model->get_items_for_menu('blog_category');
        ob_start();
        foreach ($items as $item) {
            $href = _A_::$app->router()->UrlTo('/blog', ['cat' => $item['group_id']]);
            $name = $item['name'];
            $this->template->vars('href', $href, true);
            $this->template->vars('name', $name, true);
            $this->template->view_layout('menu_item');
        }
        $menu_blog_category = ob_get_contents();
        ob_end_clean();

        ob_start();
        $this->template->vars('menu_blog_category', $menu_blog_category);
        $this->template->view_layout('blog_menu');
        $blog_menu = ob_get_contents();
        ob_end_clean();

        $this->main->template->vars('blog_menu', $blog_menu);

    }

}