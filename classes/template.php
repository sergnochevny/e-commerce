<?php

class Template{

  private $template;
  private $layouts;
  private $vars = [];
  private $meta = null;
  public $controller;

  public function __construct($layouts, $controllerName){
    $this->layouts = $layouts;
    $arr = explode('_', $controllerName);
    $this->controller = strtolower($arr[1]);
  }

  public function vars($varname, $value, $token = true){
    if((isset($this->vars[$varname]) == true) && (!$token)) {
      return false;
    }
    $this->vars[$varname] = $value;

    return true;
  }

  public function view($name, $controller = null){
    $pathLayout = SITE_PATH . 'views' . DS . 'layouts' . DS . $this->layouts . '.php';
    if(!isset($controller)) $controller = $this->controller;
    if(is_string($controller) && (strlen($controller) > 0)) $contentPage = SITE_PATH . 'views' . DS . $controller . DS . $name . '.php';
    else $contentPage = SITE_PATH . 'views' . DS . $name . '.php';
    if(file_exists($pathLayout) == false) trigger_error('Layout ' . $this->layouts . ' does not exist.', E_USER_NOTICE);
    if(file_exists($contentPage) == false) trigger_error('Template ' . $name . ' does not exist.', E_USER_NOTICE);
    extract($this->vars);
    ob_start();
    include($contentPage);
    $content = ob_get_contents();
    ob_end_clean();
    include($pathLayout);
  }

  public function view_layout($name, $controller = null){
    if(!isset($controller)) $controller = $this->controller;
    if(is_string($controller) && (strlen($controller) > 0)) $contentPage = SITE_PATH . 'views' . DS . $controller . DS . $name . '.php';
    else $contentPage = SITE_PATH . 'views' . DS . $name . '.php';
    if(file_exists($contentPage) == false) throw new Exception('Template ' . $name . ' does not exist.');
    extract($this->vars);
    include($contentPage);
  }

  public function view_layout_return($name, $controller = null){
    ob_start();
    $this->view_layout($name, $controller);
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
  }

  public function setMeta($key, $value){
    $this->meta[$key] = $value;
  }

  public function getMeta($key = null){
    if(isset($key)) return isset($this->meta[$key]) ? $this->meta[$key] : null;

    return $this->meta;
  }
}