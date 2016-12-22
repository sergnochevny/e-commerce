<?php

  class Controller_BlogCategory extends Controller_Simple  {

    protected $id_name = 'id';
    protected $form_title_add = 'ADD NEW CATEGORY';
    protected $form_title_edit = 'EDIT CATEGORY';

    protected function build_order(&$sort, $view = false) {
      parent::build_order($sort, $view);
      if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
        $sort = ['a.name' => 'desc'];
      }
    }

    protected function load(&$data) {
      $data = [
        $this->id_name => _A_::$app->get($this->id_name),
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