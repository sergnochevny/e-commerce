<?php

namespace controllers;

use app\core\App;
use classes\controllers\ControllerSimple;
use models\ModelManufacturers;

/**
 * Class ControllerManufacturers
 */
class ControllerManufacturers extends ControllerSimple{

  /**
   * @var string
   */
  protected $name_field = 'manufacturer';
  /**
   * @var string
   */
  protected $form_title_add = 'NEW MANUFACTURER';
  /**
   * @var string
   */
  protected $form_title_edit = 'MODIFY MANUFACTURER';

  /**
   * @param bool $view
   * @return array|null
   */
  protected function search_fields($view = false){
    if($view) return ['a.manufacturer']; else return parent::search_fields($view);
  }

  /**
   * @param $sort
   * @param bool $view
   * @param null $filter
   */
  protected function build_order(&$sort, $view = false, $filter = null){
    parent::build_order($sort, $view, $filter);
    if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
      $sort = ['a.manufacturer' => 'asc'];
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
      $filter['hidden']['b.pvisible'] = 1;
    }

    return $res;
  }

  /**
   * @param $data
   */
  protected function load(&$data){
    $data['id'] = App::$app->get('id');
    $data['manufacturer'] = ModelManufacturers::sanitize(App::$app->post('manufacturer'));
  }

  /**
   * @param $data
   * @param $error
   * @return bool|mixed
   */
  protected function validate(&$data, &$error){
    if(empty($data['manufacturer'])) {
      $error[] = "The Manufacturer Name is required.";

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
    $filter = $this->load_search_filter_by_controller('shop');
    if(!empty($filter) && is_array($filter)) {
      $filter['active_filter'] = !empty(array_filter($filter));
    }
    $this->template->vars('filter', $filter);
    App::$app->setSession('sidebar_idx', 1);
    parent::view($partial, $required_access);
  }

}