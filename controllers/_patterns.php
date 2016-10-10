<?php

  class Controller_Patterns extends Controller_Simple {

    protected $form_title_add = 'NEW PATTERN';
    protected $form_title_edit = 'MODIFY PATTERN';

    protected function load(&$data, &$error) {
      $data['id'] = _A_::$app->get('id');
      $data['pattern'] = Model_Patterns::validData(_A_::$app->post('pattern'));
      if(empty($data['pattern'])) {
        $error[] = "Pattern Name is required.";
        return false;
      }
      return true;
    }

  }