<?php

namespace controllers;

use app\core\App;
use controllers\base\ControllerController;
use controllers\base\ControllerFormSimple;
use controllers\base\Paginator;
use Exception;
use models\ModelCategories;
use models\ModelColors;
use models\ModelManufacturers;
use models\ModelPatterns;
use models\ModelProduct;
use models\ModelRelated;

/**
 * Class ControllerRelated
 * @package controllers
 */
class ControllerRelated extends ControllerFormSimple{

  /**
   * @param bool $view
   * @return array|null
   */
  protected function search_fields($view = false){
    if($view) {
      return ['a.pid'];
    } else {
      return [
        'a.pname', 'a.pvisible', 'a.dt', 'a.pnumber', 'a.piece',
        'a.best', 'a.specials', 'b.cid', 'c.id', 'd.id', 'e.id'
      ];
    }
  }

  /**
   * @param $filter
   * @param bool $view
   * @return array|null
   * @throws \Exception
   */
  protected function build_search_filter(&$filter, $view = false){
    $res = parent::build_search_filter($filter, $view);
    $filter['hidden']['a.pid'] = App::$app->get('pid');
    if(!isset($filter['hidden']['a.pid'])) throw new Exception('No Related Products');
    $filter['hidden']['b.image1'] = 'null';
    if($view) {
      $filter['hidden']['b.pnumber'] = 'null';
      $filter['hidden']['b.pvisible'] = '1';
    }

    return $res;
  }

  /**
   * @param $data
   */
  protected function load(&$data){
    $data['pid'] = App::$app->get('pid');
    $data['r_pid'] = App::$app->post('r_pid');
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
   * @param $sort
   * @param bool $view
   * @param null $filter
   */
  protected function build_order(&$sort, $view = false, $filter = null){
    parent::build_order($sort, $view, $filter);
    if($view) {
      $sort['a.id'] = 'desc';
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
   * @param $rows
   * @param bool $view
   * @throws \Exception
   */
  protected function after_get_list(&$rows, $view = false){
    $related_selected = [];
    $pid = App::$app->get('pid');
    if(isset($pid)) {
      $filter['hidden']['view'] = true;
      $filter['hidden']['a.pid'] = $pid;
      $filter['hidden']['b.image1'] = 'null';
      $_rows = ModelRelated::get_list(0, 0, $res_count_rows, $filter);
      if(isset($_rows)) foreach($_rows as $row) $related_selected[] = $row['pid'];
    }
    $this->template->vars('related_selected', $related_selected);
  }

  /**
   * @param bool $view
   * @param bool $return
   * @return mixed|string
   * @throws \Exception
   */
  protected function get_list($view = false, $return = false){
    $c_product = new ControllerProduct($this->main);
    $c_product->scenario($this->scenario());
    $search_form = $this->build_search_filter($filter, $view);
    $idx = $this->load_search_filter_get_idx($filter, $view);
    $pages = App::$app->session('pages');
    $per_pages = App::$app->session('per_pages');
    $sort = $this->load_sort($filter, $view);
    $page = !empty($pages[$this->controller][$idx]) ? $pages[$this->controller][$idx] : 1;
    $per_page = !empty($per_pages[$this->controller][$idx]) ? $per_pages[$this->controller][$idx] : $this->per_page;
    $total = ModelProduct::get_total_count($filter);
    if($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
    if($page <= 0) $page = 1;
    $start = (($page - 1) * $per_page);
    $res_count_rows = 0;
    $rows = ModelProduct::get_list($start, $per_page, $res_count_rows, $filter, $sort);
    $this->after_get_list($rows, $view);
    $c_product->after_get_list($rows, $view);
    if(isset($filter['active'])) $search_form['active'] = $filter['active'];
    $this->search_form($search_form, $view);
    $this->template->vars('rows', $rows);
    $this->template->vars('sort', $sort);
    $this->template->vars('list', $this->template->view_layout_return('rows'));
    $this->template->vars('count_rows', $res_count_rows);
    (new Paginator($this->main))->paginator($total, $page, $this->controller, null, $per_page);
    $this->before_list_layout($view);
    if($return) return $this->main->view_layout_return('list');
    $this->main->view_layout('list');
  }

  /**
   * @export
   * @throws \Exception
   */
  public function view($partial = false, $required_access = false){
    if(App::$app->request_is_ajax()) ControllerController::get_list(true);
    else throw new Exception('No Related Products');
  }

  /**
   * @export
   * @throws \Exception
   */
  public function index($required_access = true){
    if($required_access) $this->main->is_admin_authorized();
    $list = $this->get_list(false, true);
    if(App::$app->request_is_ajax()) exit($list); else {
      throw new Exception('Error 404');
    }
  }

  /**
   * @param bool $required_access
   * @throws \Exception
   */
  public function delete($required_access = true){
    parent::delete($required_access);
  }

}