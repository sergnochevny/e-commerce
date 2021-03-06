<?php

namespace controllers;

use app\core\App;
use classes\Auth;
use classes\controllers\ControllerSimple;
use classes\helpers\UserHelper;
use models\ModelCategories;
use models\ModelColors;
use models\ModelManufacturers;
use models\ModelPatterns;
use models\ModelProduct;

/**
 * Class ControllerFavorites
 * @package controllers
 */
class ControllerFavorites extends ControllerSimple{

  /**
   * @var string
   */
  protected $form_title_add = 'Add Fabric Favorites';
  /**
   * @var string
   */
  protected $page_title = 'My Fabric Favorites';

  /**
   * @param bool $view
   * @return array|null
   */
  protected function search_fields($view = false){
    return [
      'a.pname', 'a.pvisible', 'a.dt', 'a.pnumber', 'a.piece', 'a.best', 'a.specials', 'b.cid', 'c.id', 'd.id', 'e.id'
    ];
  }

  /**
   * @param $sort
   * @param bool $view
   * @param null $filter
   */
  protected function BuildOrder(&$sort, $view = false, $filter = null){
    parent::BuildOrder($sort, $view, $filter);
    if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
      $sort = [
        'z.dt' => 'desc',
        'a.pid' => 'desc'
      ];
    }
  }

  /**
   * @param $data
   */
  protected function load(&$data){
    $data['pid'] = App::$app->post('pid');
    $data['aid'] = UserHelper::get_from_session()['aid'];
  }

  /**
   * @param $filter
   * @param bool $view
   * @return array|null
   * @throws \InvalidArgumentException
   */
  public function build_search_filter(&$filter, $view = false){
    $res = parent::build_search_filter($filter, $view);
    $filter['hidden']['z.aid'] = UserHelper::get_from_session()['aid'];

    return $res;
  }

  /**
   * @param $data
   * @param $error
   * @return bool|mixed
   */
  protected function validate(&$data, &$error){
    if(empty($data['pid'])) {
      $error[] = 'Select Product to append to Favorites!';
      $this->main->view->setVars('error', $error);

      return false;
    }

    return true;
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
    if(isset($type)) $this->main->view->setVars('action', App::$app->router()->UrlTo($this->controller));
  }

  /**
   * @param $id
   * @param $data
   * @throws \Exception
   */
  protected function after_save($id, &$data){
    $row = ModelProduct::get_by_id($data['pid']);
    $this->save_warning = $row['pname'] . " added to Fabric Favorites!";
  }

  /**
   * @param $url
   * @param $title
   * @throws \Exception
   */
  protected function edit_add_handling($url, $title){
    $this->main->view->setVars('form_title', $title);
    $data = null;
    $this->load($data);
    if($this->form_handling($data) && App::$app->RequestIsPost() && App::$app->RequestIsAjax()) {
      $this->Save($data);
      exit($this->form($url, $data));
    } else {
      $this->Redirect(App::$app->router()->UrlTo('shop'));
    }
  }

  /**
   * @param null $data
   * @throws \Exception
   */
  protected function before_form_layout(&$data = null){
    $this->main->view->setVars('back_url', App::$app->router()->UrlTo('shop'));
  }

  /**
   * @export
   * @throws \Exception
   */
  public function favorites(){
    Auth::check_user_authorized(true);
    $this->main->view->setVars('cart_enable', '_');
    $this->index(false);
  }

  /**
   * @export
   * @param bool $required_access
   * @throws \Exception
   */
  public function add($required_access = false){
    Auth::check_user_authorized();
    parent::add($required_access);
  }

  /**
   * @export
   * @param bool $required_access
   * @throws \Exception
   */
  public function delete($required_access = false){
    parent::delete($required_access);
  }

  /**
   * @param bool $partial
   * @param bool $required_access
   */
  public function view($partial = false, $required_access = false){
  }

  /**
   * @param bool $required_access
   */
  public function edit($required_access = true){
  }

}