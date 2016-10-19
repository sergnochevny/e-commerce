<?php

  class Controller_Manufacturers extends Controller_Simple {

    protected $form_title_add = 'NEW MANUFACTURER';
    protected $form_title_edit = 'MODIFY MANUFACTURER';

    protected function load(&$data) {
      $data['id'] = _A_::$app->get('id');
      $data['manufacturer'] = Model_Manufacturers::validData(_A_::$app->post('manufacturer'));
    }

    protected function validate(&$data, &$error) {
      if(empty($data['manufacturer'])) {
        $error[] = "The Manufacturer Name is required.";
        return false;
      }
      return true;
    }

  }