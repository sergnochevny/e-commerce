<?php
  class Controller_Manufacturers extends Controller_Simple {

    protected $form_title_add = 'NEW MANUFACTURER';
    protected $form_title_edit = 'MODIFY MANUFACTURER';

    protected function validate(&$data, &$error) {
      $data['id'] = _A_::$app->get('id');
      $data['manufacturer'] = Model_Manufacturers::validData(_A_::$app->post('manufacturer'));
      if(empty($data['manufacturer'])) {
        $error[] = "The Manufacturer Name is required.";
        return false;
      }
      return true;
    }

  }