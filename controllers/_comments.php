<?php

  class Controller_Comments extends Controller_Simple  {

    protected $form_title_edit = 'MODIFY COMMENT';
    protected $view_title = 'COMMENT VIEW';

    protected function load(&$data) {
      $data['id'] = _A_::$app->get('id');
      $data['title'] = Model_Colours::validData(_A_::$app->post('title'));
      $data['data'] = Model_Colours::validData(_A_::$app->post('data'));
      $data['moderated'] = Model_Colours::validData(_A_::$app->post('moderated'));
    }

    protected function validate(&$data, &$error) {
      if(empty($data['title'])) {
        $error[] = "The Post Name is required.";
        return false;
      }
      if(empty($data['data'])) {
        $error[] = "The Post Content is required.";
        return false;
      }
      if($data['moderated'] === 'null') {
        $error[] = "Please, specify comment status.";
        return false;
      }
      return true;
    }
  }