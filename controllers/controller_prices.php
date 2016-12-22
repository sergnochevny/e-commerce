<?php

  class Controller_Prices extends Controller_Simple {

    protected function build_search_filter(&$filter, $view = false) {
      $res = parent::build_search_filter($filter, $view);
      if($view) {
        $this->per_page = 24;
        $filter = ['hidden' => ['view' => true, 'a.pvisible' => 1, 'a.priceyard' => 0]];
      }
      return $res;
    }

    protected function load(&$data) { }

    protected function validate(&$data, &$error) { }

    public function index($required_access = true) { }

    public function add($required_access = true) { }

    public function delete($required_access = true) { }

    public function edit($required_access = true) { }

    /**
     * @export
     */
    public function view() {
      $this->template->vars('cart_enable', '_');
      _A_::$app->setSession('sidebar_idx', 5);
      parent::view();
    }

  }