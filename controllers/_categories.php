<?php

  class Controller_Categories extends Controller_Simple {

    protected $id_name = 'cid';
    protected $form_title_add = 'NEW CATEGORY';
    protected $form_title_edit = 'MODIFY CATEGORY';

    protected function load(&$data) {
      $data = [
        $this->id_name => _A_::$app->get($this->id_name),
        'cname' => mysql_real_escape_string(Model_Categories::validData(_A_::$app->post('cname'))),
        'displayorder' => Model_Categories::validData(_A_::$app->post('displayorder'))
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