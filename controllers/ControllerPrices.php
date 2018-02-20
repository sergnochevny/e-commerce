<?php

namespace controllers;

use app\core\App;
use classes\controllers\ControllerSimple;

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
   * @param bool $partial
   * @param bool $required_access
   * @throws \Exception
   */
  public function view($partial = false, $required_access = false){
    $this->template->vars('cart_enable', '_');
    App::$app->setSession('sidebar_idx', 5);
    parent::view($partial, $required_access);
  }
  
}