<?php

  class Controller_Paginator extends Controller_Controller {

    public function paginator($total_rows, $page, $url, $per_page = 12, $showbypage = 10) {
      if($total_rows > $per_page) {
        $prms = null;
        if(!is_null(_A_::$app->get('cat'))) {
          $prms['cat'] = _A_::$app->get('cat');
        }
        if(!is_null(_A_::$app->get('mnf'))) {
          $prms['mnf'] = _A_::$app->get('mnf');
        }
        if(!is_null(_A_::$app->get('ptrn'))) {
          $prms['ptrn'] = _A_::$app->get('ptrn');
        }
        if(!is_null(_A_::$app->get('clr'))) {
          $prms['clr'] = _A_::$app->get('clr');
        }
        if(!is_null(_A_::$app->get('prc'))) {
          $prms['prc'] = _A_::$app->get('prc');
        }

        $this->template->vars('prms', $prms);

        $num_pages = ceil($total_rows / $per_page);
        $last_page = $num_pages;
        $nav_start = floor(($page - 1) / $showbypage) * $showbypage + 1;
        $nav_end = floor(($page - 1) / $showbypage) * $showbypage + $showbypage;
        $nav_end = $nav_end > $last_page ? $last_page : $nav_end;
        $prev_page = $page - 1;
        $next_page = $page + 1;

        $this->template->vars('url', $url);
        $this->template->vars('page', $page);
        $this->template->vars('total_rows', $total_rows);
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
    }

  }