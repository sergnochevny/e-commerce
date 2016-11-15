<?php

  class Controller_Categories extends Controller_Simple {

    protected $id_name = 'cid';
    protected $form_title_add = 'NEW CATEGORY';
    protected $form_title_edit = 'MODIFY CATEGORY';

    protected function build_order(&$sort, $view = false) {
      parent::build_order($sort, $view);
      if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
        $sort = ['a.cname' => 'asc'];
      }
    }

    protected function build_search_filter(&$filter, $view = false) {
      $res = parent::build_search_filter($filter, $view);
      if($view) {
        $this->per_page = 24;
        $filter = ['hidden' => ['view' => true, 'b.pvisible' => 1]];
      }
      return $res;
    }

    protected function load(&$data) {
      $data = [
        $this->id_name => _A_::$app->get($this->id_name),
        'cname' => Model_Categories::sanitize(_A_::$app->post('cname')),
        'displayorder' => Model_Categories::sanitize(_A_::$app->post('displayorder'))
      ];
    }

    protected function validate(&$data, &$error) {
      $error = null;
      if(empty($data['cname']) || empty($data['displayorder'])) {
        $error = [];
        if(empty($data['cname'])) $error[] = "The Category Name is required.";
        if(empty($data['display_order'])) $error[] = "The Display Order is required.";
        return false;
      }
      return true;
    }

  }