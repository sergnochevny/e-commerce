<?php

namespace classes;

use app\core\App;
use classes\controllers\ControllerController;

/**
 * Class Paginator
 * @package classes
 */
class Paginator extends ControllerController{

  /**
   * @param $total_rows
   * @param $page
   * @param $url
   * @param null $prms
   * @param int $per_page
   * @param int $showbypage
   * @throws \Exception
   */
  public function paginator($total_rows, $page, $url, $prms = null, $per_page = 12, $showbypage = 10){
    $this->template->vars('per_page', $per_page);
    $this->template->vars('per_page_items', App::$app->config('per_page_items'));

    if($total_rows > $per_page) {
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
      $this->template->vars('showbypage', $showbypage);
      $this->template->vars('num_pages', $num_pages);
      $this->template->vars('last_page', $last_page);
      $this->template->vars('nav_start', $nav_start);
      $this->template->vars('nav_end', $nav_end);
      $this->template->vars('prev_page', $prev_page);
      $this->template->vars('next_page', $next_page);

      $this->main->template->vars('paginator', $this->template->render_layout_return('paginator'));
    }

    $this->main->template->vars('show_by', $this->template->render_layout_return('show_by'));
  }

}