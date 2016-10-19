<?php

  class Controller_Colours extends Controller_Simple {

    protected $form_title_add = 'NEW COLOUR';
    protected $form_title_edit = 'MODIFY COLOUR';

    protected function load(&$data) {
      $data['id'] = _A_::$app->get('id');
      $data['colour'] = Model_Colours::validData(_A_::$app->post('colour'));
    }

    protected function validate(&$data, &$error) {
      if(empty($data['colour'])) {
        $error[] = "The Colour Name is required.";
        return false;
      }
      return true;
    }

  }