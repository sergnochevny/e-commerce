<?php

class Controller_Paginator extends Controller_Controller
{
    function produkt_paginator($total_rows, $page)
    {
        $this->template->vars('url', 'admin_home');
        if (!is_null(_A_::$app->get('cat'))) {
            $cat_id = _A_::$app->get('cat');
            $this->template->vars('cat_id', $cat_id);
        }
        $this->paginator($total_rows, $page);
    }

    protected function paginator($total_rows, $page, $per_page = 12, $showbypage = 10)
    {
        $base_url = BASE_URL;
        $num_pages = ceil($total_rows / $per_page);
        $last_page = $num_pages;
        $nav_start = floor(($page - 1) / $showbypage) * $showbypage + 1;
        $nav_end = floor(($page - 1) / $showbypage) * $showbypage + $showbypage;
        $nav_end = $nav_end > $last_page ? $last_page : $nav_end;
        $prev_page = $page - 1;
        $next_page = $page + 1;

        $this->template->vars('page', $page);
        $this->template->vars('total_rows', $total_rows);
        $this->template->vars('base_url', $base_url);
        $this->template->vars('per_page', $per_page);
        $this->template->vars('showbypage', $showbypage);
        $this->template->vars('num_pages', $num_pages);
        $this->template->vars('last_page', $last_page);
        $this->template->vars('nav_start', $nav_start);
        $this->template->vars('nav_end', $nav_end);
        $this->template->vars('prev_page', $prev_page);
        $this->template->vars('next_page', $next_page);

        ob_start();
        $this->template->view_layout('paginator');
        $paginator = ob_get_contents();
        ob_end_clean();
        $this->main->template->vars('paginator', $paginator);
    }

    function paginator_home($total_rows, $page, $url = 'blog', $per_page = 6)
    {

        $this->template->vars('url', $url);
        if (!is_null(_A_::$app->get('cat'))) {
            $cat_id = _A_::$app->get('cat');
            $this->template->vars('cat_id', $cat_id);
        }
        $this->paginator($total_rows, $page, $per_page);
    }

    function produkt_paginator_home($total_rows, $page, $url = 'shop')
    {

        if (!is_null(_A_::$app->post('s')) && (empty(_A_::$app->post('s')))) {
            $layout = 'product_paginator_search';
        }

        $this->template->vars('url', $url);
        if (!is_null(_A_::$app->get('cat'))) {
            $cat_id = _A_::$app->get('cat');
            $this->template->vars('cat_id', $cat_id);
        }
        if (!is_null(_A_::$app->get('mnf'))) {
            $mnf_id = _A_::$app->get('mnf');
            $this->template->vars('mnf_id', $mnf_id);
        }
        if (!is_null(_A_::$app->get('ptrn'))) {
            $ptrn_id = _A_::$app->get('ptrn');
            $this->template->vars('ptrn_id', $ptrn_id);
        }
        $this->paginator($total_rows, $page);
    }

    function user_paginator($total_rows, $page)
    {
        $this->template->vars('url', 'users');
        $this->paginator($total_rows, $page);
    }

    public function orders_paginator($total_rows, $page)
    {
        $this->template->vars('url', 'orders/customer_history');
        $this->paginator($total_rows, $page);
    }

    public function orders_history_paginator($total_rows, $page)
    {
        $this->template->vars('url', 'orders/history');
        $this->paginator($total_rows, $page);
    }

    public function comments_paginator($total_rows, $page)
    {
        $this->template->vars('url', 'comments/admin');
        $this->paginator($total_rows, $page);
    }

    public function user_comments_paginator($total_rows, $page)
    {
        $this->template->vars('url', 'comments');
        $this->paginator($total_rows, $page);
    }


}