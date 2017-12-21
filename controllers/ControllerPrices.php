<?php

namespace controllers;

use app\core\App;
use controllers\base\ControllerSimple;

/**
 * Class ControllerPrices
 * @package controllers
 */
class ControllerPrices extends ControllerSimple{

  /**
   * @var string
   */
  protected $name_field = 'title';

  /**
   * @param $data
   */
  protected function load(&$data){
  }

  /**
   * @param $data
   * @param $error
   * @return mixed|void
   */
  protected function validate(&$data, &$error){
  }

  /**
   * @param $row
   * @param $view
   * @return string
   * @throws \Exception
   */
  protected function build_sitemap_url($row, $view){
    $prms = ['prc' => $row[$this->id_field]];
    $url = 'shop';
    $sef = $row[$this->name_field];

    return App::$app->router()->UrlTo($url, $prms, $sef);
  }

  /**
   * @param bool $required_access
   */
  public function index($required_access = true){
  }

  /**
   * @param bool $required_access
   */
  public function add($required_access = true){
  }

  /**
   * @param bool $required_access
   */
  public function delete($required_access = true){
  }

  /**
   * @param bool $required_access
   */
  public function edit($required_access = true){
  }

  /**
   * @export
   * @throws \Exception
   */
  public function view($partial = false, $required_access = false){
    $this->template->vars('cart_enable', '_');
    App::$app->setSession('sidebar_idx', 5);
    parent::view($partial, $required_access);
  }

  /**
   * @return int|null
   */
  public static function sitemap_order(){
    return 5;
  }
}