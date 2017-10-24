<?php

/**
 * Class Application
 * @property \Router router
 * @property \KeyStorage keystorage
 */
class Application extends Core{

  protected $keystorage;

  protected function init(){
    parent::init();
    $this->SelectDB('default');
    $this->router = new Router($this);
    $this->keystorage = new KeyStorage();
  }

  public function run(){
    $this->router->start();
  }

}