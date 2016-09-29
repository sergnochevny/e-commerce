<?php

  Abstract Class Controller_Base {

    protected $layouts;
    public $registry;
    public $template;
    public $vars = [];

    public function __construct() {
      $this->registry = _A_::$app->registry();
      $this->template = new Template($this->layouts, get_called_class());
    }

    public function redirect($url) {
      $router = $this->registry->get('router');
      $router->redirect($url);
    }
  }
