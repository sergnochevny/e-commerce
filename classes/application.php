<?php

  class Application extends Core {

    protected $keystorage;

    protected function init() {
      parent::init();
      $this->SelectDB('iluvfabrix');
      $this->router = new Router($this);
      $this->keystorage = new KeyStorage();
      $this->registry()->set('router', $this->router);
    }

    public function run() {
      $this->router->start();
    }

  }