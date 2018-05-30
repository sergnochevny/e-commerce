<?php

namespace controllers;

use app\core\App;
use classes\controllers\ControllerSimple;
use models\ModelCategories;

/**
 * Class ControllerCategories
 * @package controllers
 */
class ControllerCategories extends ControllerSimple{

  /**
   * @var string
   */
  protected $id_field = 'cid';
  /**
   * @var string
   */
  protected $name_field = 'cname';
  /**
   * @var string
   */
  protected $form_title_add = 'NEW CATEGORY';
  /**
   * @var string
   */
  protected $form_title_edit = 'MODIFY CATEGORY';

  /**
   * @param bool $view
   * @return array|null
   */
  protected function search_fields($view = false){
    if($view) return ['a.cname']; else return parent::search_fields($view);
  }

  /**
   * @param $sort
   * @param bool $view
   * @param null $filter
   */
  protected function BuildOrder(&$sort, $view = false, $filter = null){
    parent::BuildOrder($sort, $view, $filter);
    if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
      $sort = ['a.cname' => 'asc'];
    }
  }

  /**
   * @param $filter
   * @param bool $view
   * @return array|null
   */
  public function build_search_filter(&$filter, $view = false){
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
    $data = [
      $this->id_field => App::$app->get($this->id_field),
      'cname' => ModelCategories::sanitize(App::$app->post('cname')),
      'displayorder' => ModelCategories::sanitize(App::$app->post('displayorder'))
    ];
  }

  /**
   * @param $data
   * @param $error
   * @return bool|mixed
   */
  protected function validate(&$data, &$error){
    $error = null;
    if(empty($data['cname']) || empty($data['displayorder'])) {
      $error = [];
      if(empty($data['cname'])) $error[] = "The Category Name is required.";
      if(empty($data['display_order'])) $error[] = "The Display Order is required.";

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
    $this->main->view->setVars('cart_enable', '_');
    $main_filter = $this->load_search_filter_by_controller('shop');
    if(!empty($main_filter) && is_array($main_filter)) {
      $main_filter['active_filter'] = !empty(array_filter($main_filter));
    }
    $this->main->view->setVars('filter', $main_filter);
    App::$app->setSession('sidebar_idx', 2);
    parent::view($partial, $required_access);
  }

}