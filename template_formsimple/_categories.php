<?php

  class Controller_Categories extends Controller_FormSimple {

    protected $id_name = 'cid';
    protected $form_title_add = 'NEW CATEGORY';
    protected $form_title_edit = 'MODIFY CATEGORY';

    protected function load(&$data, &$error) {
      $error = null;
      $data = [
        'cid' => _A_::$app->get('category_id'),
        'cname' => mysql_real_escape_string(Model_Categories::sanitize(_A_::$app->post('cname'))),
        'displayorder' => Model_Categories::sanitize(_A_::$app->post('displayorder'))
      ];

      if(empty($data['cname']) || empty($data['displayorder'])) {
        $error = [];
        if(empty($data['cname'])) $error[] = "The Category Name is required.";
        if(empty($data['display_order'])) $error[] = "The Display Order is required.";
        return false;
      }
      return true;
    }

  }