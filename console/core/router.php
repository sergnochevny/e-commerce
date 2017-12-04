<?php

class Router{

  private $app = null;
  private $path;
  public $route;
  public $controller;
  public $action;
  public $args = [];

  public function __construct($app = null){
    if(isset($app)) $this->app = $app;
  }

  private function parse_argv(){
    $argv = _A_::$app->server('argv');
    if(is_array($argv) && (count($argv) > 1)) {
      array_shift($argv);
      $this->route = array_shift($argv);
      $this->route_explode_parts($this->route, $controller, $action);
      $this->action = $action;
      $this->controller = $controller;
      $this->args = $argv;
    }
  }

  private function setPath($path){
    $path = rtrim($path, '/\\');
    $path .= DS;

    if(is_dir($path) == false) {
      throw new Exception ('Invalid controller path: ' . $path . '');
    }
    $this->path = $path;
  }

  private function route_explode_parts($route, &$controller, &$action){
    $parts = explode('/', $route);
    $cmd_path = $this->path;
    foreach($parts as $part) {
      if(is_dir($cmd_path . $part)) {
        $cmd_path .= $part . DS;
        array_shift($parts);
        continue;
      }
      if(is_file($cmd_path . 'controller_' . $part . '.php')) {
        $controller = $part;
        array_shift($parts);
        break;
      }
    }
    if(empty($controller)) $controller = 'index';
    $action = array_shift($parts);
    if(empty($action)) $action = $controller;
  }

  protected function init(){
    $this->setPath(APP_PATH . DS . 'console' . DS . 'controllers' . DS);
    $this->parse_argv();
  }

  public function start(){
    $this->init();

    $file = null;
    try {
      if(empty($this->controller) || empty($this->action)) {
        throw new Exception('Command line error');
      }
      $class = 'Controller_' . $this->controller;
      _A_::$app->registry()->set('controller', $this->controller);
      _A_::$app->registry()->set('action', $this->action);

      $controller = new $class();
      $call = null;
      $reflection = new ReflectionClass($controller);
      if($reflection->hasMethod($this->action)) {
        if(boolval(preg_match('#(@console)#i', $reflection->getMethod($this->action)->getDocComment(), $export)))
          if(is_callable([$controller, $this->action])) $call = $this->action;
      } elseif(($this->controller == $this->action) && $reflection->hasMethod('index')) {
        if(boolval(preg_match('#(@console)#i', $reflection->getMethod('index')->getDocComment(), $export)))
          if(is_callable([$controller, 'index'])) $call = 'index';
      }
      if(is_callable([$controller, $call]) && isset($this->app)) call_user_func([$controller, $call]);
    } catch(Exception $e) {
      fwrite(STDOUT, $e->getMessage());
    }
  }

  public function UrlTo($path, $params = null, $to_sef = null, $sef_exclude_params = null, $canonical = false, $no_ctrl_ignore = false){
    return $path;
  }

}
