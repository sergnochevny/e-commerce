<?php

  class Application extends Core {

    protected function init() {
      parent::init();
      $this->router = new Router();
      $this->registry()->set('router', $this->router);
      $this->SelectDB('iluvfabrix');
    }

    public function run() {
      $this->router->start();
    }

  }