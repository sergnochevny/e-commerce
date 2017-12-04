<?php

abstract class Controller_Base{

  protected $layouts;
  protected $controller;
  protected $model_name;

  public $registry;
  public $template;
  public $vars = [];

  public function __construct(){
    $this->registry = _A_::$app->registry();
    $this->template = new Template($this->layouts, get_called_class());
    $this->controller = strtolower(str_replace('Controller_', '', get_called_class()));
    $this->model_name = 'Model_' . ucfirst($this->controller);
  }

  public function redirect($url){
    _A_::$app->router()->redirect($url);
  }
}
