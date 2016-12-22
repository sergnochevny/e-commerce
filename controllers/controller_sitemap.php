<?php

  Class Controller_Sitemap Extends Controller_Base {

    protected function sanitize_url($url) {
      $search = ['&', '\'', '"', '>', '<'];
      $replace = ['&amp;', '&apos;', '&quot;', '&gt;', '&lt;'];
      $url = str_replace($search, $replace, $url);
      return $url;
    }

    /**
     * @export
     */
    public function sitemap() {

      $this_ = $this;

      $build_sitemap_rows = function ($data) use ($this_){
        if(isset($data) && is_array($data)) {
          $rows = [];
          foreach($data as $row) {
            if(isset($row['loc'])) {
              $row['loc'] = $this_->sanitize_url($row['loc']);
              $rows[] = $row;
            }
          }
          $this_->template->vars('rows', $rows);
          $this_->template->view_layout('list');
        }
      };

      set_time_limit(0);
      ob_start();
      try {
        $path = SITE_PATH . 'controllers/controller_*.php';
        $controllers = [];
        foreach(glob($path) as $file) {
          if(is_readable($file)) {
            $controller = str_replace('.php', '', strtolower(basename($file)));
            if(is_callable([$controller, 'sitemap']) && is_callable([$controller, 'sitemap_order'])) {
              $idx = forward_static_call([$controller, 'sitemap_order']);
              if (isset($idx)) $controllers[$idx] = $controller;
            }
          }
        }
        ksort($controllers);
        foreach($controllers as $class){
          $controller = new $class();
          forward_static_call([$controller, 'sitemap'], $build_sitemap_rows);
          unset($controller);
        }
      } catch(Exception $e) {
      }
      $list = ob_get_contents();
      ob_end_clean();

      $this->template->vars('list', $list);
      header("Content-type: text/xml");
      $this->template->view_layout('sitemap');
    }
  }
