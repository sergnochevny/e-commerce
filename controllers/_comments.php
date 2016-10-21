<?php

  class Controller_Comments extends Controller_Simple  {

    protected $form_title_edit = 'MODIFY COMMENT';
    protected $view_title = 'COMMENT VIEW';

    protected function load(&$data) {
      $data['id'] = _A_::$app->get('id');
      $data['title'] = Model_Comments::validData(_A_::$app->post('title'));
      $data['data'] = Model_Comments::validData(_A_::$app->post('data'));
      $data['moderated'] = Model_Comments::validData(_A_::$app->post('moderated'));
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

    /**
     * @export
     */
    public function moderate(){
      if($id = _A_::$app->get('id')){
        $action = _A_::$app->get('action');
        if(Model_Comments::moderate($id, $action)){
          $this->index();
        }
      }
      return false;
    }
  }