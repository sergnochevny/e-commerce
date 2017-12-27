<?php

namespace controllers;

use app\core\App;
use controllers\base\ControllerSimple;
use models\ModelColors;

/**
 * Class ControllerColors
 * @package controllers
 */
class ControllerColors extends ControllerSimple{

  /**
   * @var string
   */
  protected $name_field = 'color';
  /**
   * @var string
   */
  protected $form_title_add = 'NEW COLOR';
  /**
   * @var string
   */
  protected $form_title_edit = 'MODIFY COLOR';

  /**
   * @param bool $view
   * @return array|null
   */
  protected function search_fields($view = false){
    if($view) return ['a.color']; else return parent::search_fields($view);
  }

  /**
   * @param $sort
   * @param bool $view
   * @param null $filter
   */
  protected function build_order(&$sort, $view = false, $filter = null){
    parent::build_order($sort, $view, $filter);
    if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
      $sort = ['a.color' => 'asc'];
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
    $data['color'] = ModelColors::sanitize(App::$app->post('color'));
  }

  /**
   * @param $data
   * @param $error
   * @return bool|mixed
   */
  protected function validate(&$data, &$error){
    if(empty($data['color'])) {
      $error[] = "The Color Name is required.";

      return false;
    }

    return true;
  }

  /**
   * @param $row
   * @param $view
   * @return string
   * @throws \Exception
   */
  protected function build_sitemap_url($row, $view){
    $prms = ['clr' => $row[$this->id_field]];
    $url = 'shop';
    $sef = $row[$this->name_field];

    return App::$app->router()->UrlTo($url, $prms, $sef);
  }

  /**
   * @export
   * @param bool $partial
   * @param bool $required_access
   * @throws \Exception
   */
  public function view($partial = false, $required_access = false){
    $this->template->vars('cart_enable', '_');
    App::$app->setSession('sidebar_idx', 4);
    parent::view($partial, $required_access);
  }

  /**
   * @return int|null
   */
  public static function sitemap_order(){
    return 4;
  }
}