<?php

/**
 * Class Application
 * @property \Router router
 * @property \KeyStorage keystorage
 */
class Application extends Core{

  /**
   * @var
   */
  protected $keystorage;

  /**
   * @throws \Exception
   */
  protected function init(){
    parent::init();
    $this->SelectDB('default');
    $this->router = new Router($this);
    $this->keystorage = new KeyStorage();
    $this->keystorage->init();
  }

  /**
   *
   */
  public function run(){
    $this->router->start();
  }

}