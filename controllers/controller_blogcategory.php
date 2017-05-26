<?php

  class Controller_BlogCategory extends Controller_Simple {

    protected $id_field = 'id';
    protected $form_title_add = 'ADD NEW CATEGORY';
    protected $form_title_edit = 'EDIT CATEGORY';

    protected function build_order(&$sort, $view = false, $filter = null) {
      parent::build_order($sort, $view, $filter);
      if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
        $sort = ['a.name' => 'desc'];
      }
    }

    protected function load(&$data) {
      $data = [
        $this->id_field => _A_::$app->get($this->id_field),
        'name' => Model_Blogcategory::sanitize(_A_::$app->post('name')),
      ];
    }

    protected function validate(&$data, &$error) {
      $error = null;
      if(empty($data['name'])) {
        $error[] = "The Category Name is required.";
        return false;
      }
      return true;
    }

  }