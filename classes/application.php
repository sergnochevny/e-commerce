<?php

class Application extends Core
{

    public function run()
    {
        $this->router->start();
    }

    protected function init()
    {
        parent::init();
        $this->router = new Router();
        $this->registry()->set('router',$this->router);
        $this->SelectDB('iluvfabrix');
    }

}