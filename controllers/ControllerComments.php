<?php

namespace controllers;

use app\core\App;
use classes\controllers\ControllerSimple;
use models\ModelComments;

/**
 * Class ControllerComments
 * @package controllers
 */
class ControllerComments extends ControllerSimple{

  /**
   * @var string
   */
  protected $form_title_edit = 'MODIFY COMMENT';
  /**
   * @var string
   */
  protected $view_title = 'COMMENT VIEW';

  /**
   * @param $sort
   * @param bool $view
   * @param null $filter
   */
  protected function BuildOrder(&$sort, $view = false, $filter = null){
    parent::BuildOrder($sort, $view, $filter);
    if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
      $sort = ['a.dt' => 'desc'];
    }
  }

  /**
   * @param $data
   */
  protected function load(&$data){
    $data['id'] = App::$app->get('id');
    $data['title'] = ModelComments::sanitize(App::$app->post('title'));
    $data['data'] = ModelComments::sanitize(App::$app->post('data'));
    $data['moderated'] = ModelComments::sanitize(App::$app->post('moderated'));
  }

  /**
   * @param $data
   * @param $error
   * @return bool|mixed
   */
  protected function validate(&$data, &$error){
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
   * @param bool $view
   * @return array|null
   */
  protected function search_fields($view = false){
    return [
      'a.dt', 'a.title', 'b.email', 'a.moderated'
    ];
  }

  /**
   * @export
   * @throws \Exception
   */
  public function moderate(){
    if($id = App::$app->get('id')) {
      $action = App::$app->get('action');
      if(ModelComments::moderate($id, $action)) {
        $this->index();
      }
    }

    return false;
  }
}