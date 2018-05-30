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
  public function getPaginator($total_rows, $page, $url, $prms = null, $per_page = 12, $showbypage = 10){
    $this->main->view->setVars('per_page', $per_page);
    $this->main->view->setVars('per_page_items', App::$app->config('per_page_items'));

    if($total_rows > $per_page) {
      $num_pages = ceil($total_rows / $per_page);
      $last_page = $num_pages;
      $nav_start = floor(($page - 1) / $showbypage) * $showbypage + 1;
      $nav_end = floor(($page - 1) / $showbypage) * $showbypage + $showbypage;
      $nav_end = $nav_end > $last_page ? $last_page : $nav_end;
      $prev_page = $page - 1;
      $next_page = $page + 1;

      $this->main->view->setVars('url', $url);
      $this->main->view->setVars('page', $page);
      $this->main->view->setVars('total_rows', $total_rows);
      $this->main->view->setVars('showbypage', $showbypage);
      $this->main->view->setVars('num_pages', $num_pages);
      $this->main->view->setVars('last_page', $last_page);
      $this->main->view->setVars('nav_start', $nav_start);
      $this->main->view->setVars('nav_end', $nav_end);
      $this->main->view->setVars('prev_page', $prev_page);
      $this->main->view->setVars('next_page', $next_page);

      $this->main->view->setVars('paginator', $this->RenderLayoutReturn('paginator'));
    }

    $this->main->view->setVars('show_by', $this->RenderLayoutReturn('show_by'));
  }

}