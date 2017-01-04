<?php

  class Controller_Prices extends Controller_Simple {

    protected $name_field = 'title';

    protected function load(&$data) { }

    protected function validate(&$data, &$error) { }

    protected function build_sitemap_url($row, $view) {
      $prms = ['prc' => $row[$this->id_field]];
      $url = 'shop';
      $sef = $row[$this->name_field];
      return _A_::$app->router()->UrlTo($url, $prms, $sef);
    }

    public function index($required_access = true) { }

    public function add($required_access = true) { }

    public function delete($required_access = true) { }

    public function edit($required_access = true) { }

    /**
     * @export
     */
    public function view($partial = false, $required_access = false) {
      $this->template->vars('cart_enable', '_');
      _A_::$app->setSession('sidebar_idx', 5);
      parent::view($partial, $required_access);
    }

    public static function sitemap_order() { return 5; }
  }