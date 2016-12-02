<?php

  class Application extends Core {

    protected $keystorage;

    protected function init() {
      parent::init();
      $this->router = new Router($this);
      $this->keystorage = new KeyStorage();
      $this->registry()->set('router', $this->router);
      $this->SelectDB('iluvfabrix');
    }

    public function run() {
      $this->router->start();
    }

  }