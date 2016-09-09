<?php

class Controller_Controller extends Controller_Base
{
    protected $main;

    function __construct(Controller_Base $main = null)
    {
        $this->layouts = _A_::$app->config('layouts');
        parent::__construct();
        if(isset($main) && (explode('_', get_class($main))[0] == 'Controller')){
            $this->main = $main;
        } else {
            $this->main = new Controller_Main($this);
        }
    }
}