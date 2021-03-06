<?php

namespace controllers;

use app\core\controller\ControllerBase;
use Exception;

/**
 * Class ControllerSitemap
 * @package controllers
 */
class ControllerSitemap extends ControllerBase{

  /**
   * @param $url
   * @return mixed
   */
  protected function sanitize_url($url){
    $search = ['&', '\'', '"', '>', '<'];
    $replace = ['&amp;', '&apos;', '&quot;', '&gt;', '&lt;'];
    $url = str_replace($search, $replace, $url);

    return $url;
  }

  /**
   * @export
   * @throws \Exception
   */
  public function sitemap(){

    $this_ = $this;

    $build_sitemap_rows = function($data) use ($this_){
      if(isset($data) && is_array($data)) {
        $rows = [];
        foreach($data as $row) {
          if(isset($row['loc'])) {
            $row['loc'] = $this_->sanitize_url($row['loc']);
            $rows[] = $row;
          }
        }
        $this_->view->setVars('rows', $rows);
        $this_->view->RenderLayout('list');
      }
    };

    set_time_limit(0);
    ob_start();
    ob_implicit_flush(false);
    try {
      $path = APP_PATH . '/controllers/Controller*.php';
      $controllers = [];
      foreach(glob($path) as $file) {
        if(is_readable($file)) {
          $controller = 'controllers\\' . str_replace('.php', '', basename($file));
          if(is_callable([$controller, 'sitemap']) && is_callable([$controller, 'sitemap_order'])) {
            $idx = forward_static_call([$controller, 'sitemap_order']);
            $view = forward_static_call([$controller, 'sitemap_view']);
            if(isset($idx)) $controllers[$idx] = [$controller, $view];
          }
        }
      }
      ksort($controllers);
      foreach($controllers as $item) {
        list($class, $view) = $item;
        $controller = new $class();
        if(is_array($view)) {
          foreach($view as $view_item) {
            forward_static_call([$controller, 'sitemap'], $build_sitemap_rows, $view_item);
          }
        } else {
          forward_static_call([$controller, 'sitemap'], $build_sitemap_rows, $view);
        }
        unset($controller);
      }
    } catch(Exception $e) {
    }
    $list = ob_get_clean();
    $this->view->setVars('list', $list);
    header("Content-type: text/xml");
    $this->view->RenderLayout('sitemap');
  }
}
