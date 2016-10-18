<?php

  class Controller_BlogCategory extends Controller_Simple  {

    protected $id_name = 'group_id';
    protected $form_title_add = 'ADD NEW CATEGORY';
    protected $form_title_edit = 'EDIT CATEGORY';

    protected function validate(&$data, &$error) {
      $error = null;
      $data = [
        $this->id_name => _A_::$app->get($this->id_name),
        'name' => mysql_real_escape_string(Model_Blogcategory::validData(_A_::$app->post('name'))),
        'slug' => Model_Blogcategory::validData(_A_::$app->post('slug'))
      ];

      if(empty($data['name']) || empty($data['slug'])) {
        $error = [];
        if(empty($data['name'])) $error[] = "The Category Name is required.";
        if(empty($data['slug'])) $error[] = "The Slug is required.";
        return false;
      }
      return true;
    }

  }