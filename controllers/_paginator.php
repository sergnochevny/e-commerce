<?php

class Controller_Paginator extends Controller_Base
{

    protected $main;

    function __construct($main)
    {

        $this->main = $main;
        $this->registry = $main->registry;
        $this->template = $main->template;

    }

    function produkt_paginator($total_rows, $page)
    {

        $per_page = 12;

        $showbypage = 10;
        $num_pages = ceil($total_rows / $per_page);
        $last_page = $num_pages;
        $nav_start = floor(($page - 1) / $showbypage) * $showbypage + 1;
        $nav_end = floor(($page - 1) / $showbypage) * $showbypage + $showbypage;
        $nav_end = $nav_end > $last_page ? $last_page : $nav_end;

        $prev_page = $page - 1;
        $next_page = $page + 1;

        if (isset($_GET['cat'])) $cat_id = $_GET['cat'];

        $base_url = BASE_URL;

        ob_start();

        include('./views/index/paginator/product_paginator.php');
        $paginator = ob_get_contents();
        ob_end_clean();
        $this->template->vars('produkt_paginator', $paginator);
    }

    function paginator_home($total_rows, $page, $url = 'blog', $per_page = 6)
    {

        $showbypage = 10;
        $num_pages = ceil($total_rows / $per_page);
        $last_page = $num_pages;
        $nav_start = floor(($page - 1) / $showbypage) * $showbypage + 1;
        $nav_end = floor(($page - 1) / $showbypage) * $showbypage + $showbypage;
        $nav_end = $nav_end > $last_page ? $last_page : $nav_end;

        $prev_page = $page - 1;
        $next_page = $page + 1;

        if (isset($_GET['cat'])) $cat_id = $_GET['cat'];

        $base_url = BASE_URL;

        ob_start();

        include('./views/index/paginator/paginator_home.php');
        $paginator = ob_get_contents();
        ob_end_clean();
        $this->template->vars('paginator', $paginator);
    }


    function produkt_paginator_home($total_rows, $page, $url = 'shop', $layout = 'product_paginator_home')
    {

        $per_page = 12;

        $showbypage = 10;
        $num_pages = ceil($total_rows / $per_page);
        $last_page = $num_pages;
        $nav_start = floor(($page - 1) / $showbypage) * $showbypage + 1;
        $nav_end = floor(($page - 1) / $showbypage) * $showbypage + $showbypage;
        $nav_end = $nav_end > $last_page ? $last_page : $nav_end;

        $prev_page = $page - 1;
        $next_page = $page + 1;

        if (isset($_GET['cat'])) $cat_id = $_GET['cat'];
        if (isset($_GET['mnf'])) $mnf_id = $_GET['mnf'];
        if (isset($_GET['ptrn'])) $ptrn_id = $_GET['ptrn'];

        $base_url = BASE_URL;

        ob_start();

        if (isset($_POST['s']) && (!empty($_POST['s']{0}))) {
            $layout = 'product_paginator_search';
        }
        include('./views/index/paginator/' . $layout . '.php');
        $paginator = ob_get_contents();
        ob_end_clean();
        $this->template->vars('produkt_paginator', $paginator);
    }

    function user_paginator($total_rows, $page)
    {

        $per_page = 12;

        $showbypage = 10;
        $num_pages = ceil($total_rows / $per_page);
        $last_page = $num_pages;
        $nav_start = floor(($page - 1) / $showbypage) * $showbypage + 1;
        $nav_end = floor(($page - 1) / $showbypage) * $showbypage + $showbypage;
        $nav_end = $nav_end > $last_page ? $last_page : $nav_end;

        $prev_page = $page - 1;
        $next_page = $page + 1;

        $base_url = BASE_URL;

        ob_start();
        include('./views/index/paginator/user_paginator.php');
        $paginator = ob_get_contents();
        ob_end_clean();
        $this->template->vars('user_paginator', $paginator);
    }

    public function orders_paginator($total_rows, $page)
    {

        $per_page = 12;

        $showbypage = 10;
        $num_pages = ceil($total_rows / $per_page);
        $last_page = $num_pages;
        $nav_start = floor(($page - 1) / $showbypage) * $showbypage + 1;
        $nav_end = floor(($page - 1) / $showbypage) * $showbypage + $showbypage;
        $nav_end = $nav_end > $last_page ? $last_page : $nav_end;

        $prev_page = $page - 1;
        $next_page = $page + 1;

        $base_url = BASE_URL;

        ob_start();
        include('./views/index/paginator/orders_paginator.php');
        $paginator = ob_get_contents();
        ob_end_clean();
        $this->template->vars('orders_paginator', $paginator);
    }

    public function orders_history_paginator($total_rows, $page)
    {

        $per_page = 12;

        $showbypage = 10;
        $num_pages = ceil($total_rows / $per_page);
        $last_page = $num_pages;
        $nav_start = floor(($page - 1) / $showbypage) * $showbypage + 1;
        $nav_end = floor(($page - 1) / $showbypage) * $showbypage + $showbypage;
        $nav_end = $nav_end > $last_page ? $last_page : $nav_end;

        $prev_page = $page - 1;
        $next_page = $page + 1;

        $base_url = BASE_URL;

        ob_start();
        include('./views/index/paginator/orders_history_paginator.php');
        $paginator = ob_get_contents();
        ob_end_clean();
        $this->template->vars('orders_history_paginator', $paginator);
    }

    public function comments_paginator($total_rows, $page)
    {
        $base_url = BASE_URL;

        $per_page = 12;
        $showbypage = 10;

        $num_pages = ceil($total_rows / $per_page);
        $last_page = $num_pages;
        $nav_start = floor(($page - 1) / $showbypage) * $showbypage + 1;
        $nav_end = floor(($page - 1) / $showbypage) * $showbypage + $showbypage;
        $nav_end = $nav_end > $last_page ? $last_page : $nav_end;
        $prev_page = $page - 1;
        $next_page = $page + 1;

        ob_start();
        include('./views/index/paginator/comments_paginator.php');
        $paginator = ob_get_contents();
        ob_end_clean();
        $this->template->vars('comments_paginator', $paginator);

    }

    public function user_comments_paginator($total_rows, $page)
    {
        $base_url = BASE_URL;

        $per_page = 12;
        $showbypage = 10;

        $num_pages = ceil($total_rows / $per_page);
        $last_page = $num_pages;
        $nav_start = floor(($page - 1) / $showbypage) * $showbypage + 1;
        $nav_end = floor(($page - 1) / $showbypage) * $showbypage + $showbypage;
        $nav_end = $nav_end > $last_page ? $last_page : $nav_end;
        $prev_page = $page - 1;
        $next_page = $page + 1;

        ob_start();
        include('./views/index/paginator/user_comments_paginator.php');
        $paginator = ob_get_contents();
        ob_end_clean();
        $this->template->vars('comments_paginator', $paginator);

    }


}