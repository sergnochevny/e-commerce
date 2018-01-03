<?php

namespace controllers;

use app\core\App;
use controllers\base\ControllerFormSimple;
use models\ModelCategories;
use models\ModelColors;
use models\ModelManufacturers;
use models\ModelPatterns;

/**
 * Class ControllerClearance
 * @package controllers
 */
class ControllerClearance extends ControllerFormSimple{

  /**
   * @var string
   */
  protected $id_field = 'id';
  /**
   * @var string
   */
  protected $view_title = 'Clearance Decorator and Designer Fabrics Online';
  /**
   * @var string
   */
  protected $form_title_add = 'Add Product To Clearance';
  /**
   * @var array
   */
  protected $resolved_scenario = ['', 'add'];
  /**
   * @var string
   */
  protected $save_warning = "The Fabric has been added to Clearance successfully!";

  /**
   * @param bool $view
   * @return array|null
   */
  protected function search_fields($view = false){
    if($view) {
      $fields = [
        'a.pname', 'a.pvisible', 'a.dt', 'a.pnumber', 'a.piece', 'a.best',
        'a.specials', 'b.cid', 'c.id', 'd.id',
        'e.id', 'a.priceyard'
      ];
    } else {
      $fields = [
        'a.pname', 'a.pvisible', 'a.dt', 'a.pnumber', 'a.piece', 'a.best',
        'a.specials', 'b.cid', 'c.id', 'd.id', 'e.id'
      ];
    }

    return $fields;
  }

  /**
   * @param $data
   */
  protected function load(&$data){
    $data['pid'] = App::$app->post('pid');
  }

  /**
   * @param $data
   * @param $error
   * @return bool|mixed
   */
  protected function validate(&$data, &$error){
    return true;
  }

  /**
   * @param $filter
   * @param bool $view
   * @return array|null
   */
  protected function build_search_filter(&$filter, $view = false){
    $res = parent::build_search_filter($filter, $view);
    if($view) {
      $filter['hidden']['a.pnumber'] = 'null';
      if(!isset($filter['hidden']['a.priceyard'])) $filter['hidden']['a.priceyard'] = '0.00';
      $filter['hidden']['a.pvisible'] = '1';
      $filter['hidden']['a.image1'] = 'null';
      $filter['hidden']['view'] = true;
    }

    return $res;
  }

  /**
   * @param $sort
   * @param bool $view
   * @param null $filter
   */
  protected function build_order(&$sort, $view = false, $filter = null){
    if($view) {
      $sort['b.displayorder'] = 'asc';
      $sort['shop_product_categories.display_order'] = 'asc';
    } else {
      if($this->scenario() == 'add') {
        $sort = ['a.pid' => 'desc'];
      } else {
        $sort['z.id'] = 'asc';
      }
    }
  }

  /**
   * @param $search_data
   * @param bool $view
   * @throws \Exception
   */
  protected function before_search_form_layout(&$search_data, $view = false){
    $categories = [];
    $filter = null;
    $sort = ['a.cname' => 'asc'];
    $rows = ModelCategories::get_list(0, 0, $res_count, $filter, $sort);
    foreach($rows as $row) $categories[$row['cid']] = $row['cname'];
    $patterns = [];
    $sort = ['a.pattern' => 'asc'];
    $rows = ModelPatterns::get_list(0, 0, $res_count, $filter, $sort);
    foreach($rows as $row) $patterns[$row['id']] = $row['pattern'];
    $colors = [];
    $sort = ['a.color' => 'asc'];
    $rows = ModelColors::get_list(0, 0, $res_count, $filter, $sort);
    foreach($rows as $row) $colors[$row['id']] = $row['color'];
    $manufacturers = [];
    $sort = ['a.manufacturer' => 'asc'];
    $rows = ModelManufacturers::get_list(0, 0, $res_count, $filter, $sort);
    foreach($rows as $row) $manufacturers[$row['id']] = $row['manufacturer'];

    $search_data['categories'] = $categories;
    $search_data['patterns'] = $patterns;
    $search_data['colors'] = $colors;
    $search_data['manufacturers'] = $manufacturers;
  }

  /**
   * @param null $data
   * @throws \Exception
   */
  protected function before_form_layout(&$data = null){
    if($this->scenario() !== 'add') {
      App::$app->get('page', null);
    } else {
      $search_form = $this->build_search_filter($filter);
      $this->search_form($search_form);
    }
    $this->scenario('');
  }

  /**
   * @param $rows
   * @param bool $view
   * @param null $type
   */
  protected function after_get_list(&$rows, $view = false, $type = null){
    $url_prms = null;
    if($view) {
      $url_prms['back'] = urlencode(base64_encode('clearance/view'));
    } else {
      $url_prms['back'] = 'clearance';
    }
    $this->template->vars('url_prms', $url_prms);
  }

  /**
   * @param bool $required_access
   */
  public function edit($required_access = true){
  }

  /**
   * @export
   * @param bool $partial
   * @param bool $required_access
   * @throws \Exception
   */
  public function view($partial = false, $required_access = false){
    $this->template->vars('cart_enable', '_');
    App::$app->setSession('sidebar_idx', 7);
    parent::view($partial, $required_access);
  }

}