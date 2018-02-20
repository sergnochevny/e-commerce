<?php

namespace controllers;

use app\core\App;
use classes\controllers\ControllerSimple;
use models\ModelPatterns;

/**
 * Class ControllerPatterns
 * @package controllers
 */
class ControllerPatterns extends ControllerSimple{

  /**
   * @var string
   */
  protected $name_field = 'pattern';
  /**
   * @var string
   */
  protected $form_title_add = 'NEW PATTERN';
  /**
   * @var string
   */
  protected $form_title_edit = 'MODIFY PATTERN';

  /**
   * @param bool $view
   * @return array|null
   */
  protected function search_fields($view = false){
    if($view) return ['a.pattern']; else return parent::search_fields($view);
  }

  /**
   * @param $sort
   * @param bool $view
   * @param null $filter
   */
  protected function build_order(&$sort, $view = false, $filter = null){
    parent::build_order($sort, $view, $filter);
    if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
      $sort = ['a.pattern' => 'asc'];
    }
  }

  /**
   * @param $filter
   * @param bool $view
   * @return array|null
   */
  protected function build_search_filter(&$filter, $view = false){
    $res = parent::build_search_filter($filter, $view);
    if($view) {
      $this->per_page = 24;
      $filter['hidden']['view'] = true;
      $filter['hidden']['c.pvisible'] = 1;
    }

    return $res;
  }

  /**
   * @param $data
   */
  protected function load(&$data){
    $data['id'] = App::$app->get('id');
    $data['pattern'] = ModelPatterns::sanitize(App::$app->post('pattern'));
  }

  /**
   * @param $data
   * @param $error
   * @return bool|mixed
   */
  protected function validate(&$data, &$error){
    $error = null;
    if(empty($data['pattern'])) {
      $error[] = "Pattern Name is required.";

      return false;
    }

    return true;
  }

  /**
   * @export
   * @param bool $partial
   * @param bool $required_access
   * @throws \Exception
   */
  public function view($partial = false, $required_access = false){
    $this->template->vars('cart_enable', '_');
    App::$app->setSession('sidebar_idx', 3);
    parent::view($partial, $required_access);
  }

}