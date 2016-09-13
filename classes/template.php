<?php

Class Template
{

    private $template;
    private $controller;
    private $layouts;
    private $vars = array();

    function __construct($layouts, $controllerName)
    {
        $this->layouts = $layouts;
        $arr = explode('_', $controllerName);
        $this->controller = strtolower($arr[1]);
    }


    function vars($varname, $value, $token = true)
    {
        if ((isset($this->vars[$varname]) == true) && (!$token)) {
            return false;
        }
        $this->vars[$varname] = $value;
        return true;
    }


    function view($name, $controller = null)
    {
        $pathLayout = SITE_PATH . 'views' . DS . 'layouts' . DS . $this->layouts . '.php';
        if (!isset($controller)) $controller = $this->controller;
        if (!isset($controller) || (is_string($controller) && (strlen($controller) > 0)))
            $contentPage = SITE_PATH . 'views' . DS . $controller . DS . $name . '.php';
        else
            $contentPage = SITE_PATH . 'views' . DS . $name . '.php';
        if (file_exists($pathLayout) == false) {
            trigger_error('Layout `' . $this->layouts . '` does not exist.', E_USER_NOTICE);
            return false;
        }
        if (file_exists($contentPage) == false) {
            trigger_error('Template `' . $name . '` does not exist.', E_USER_NOTICE);
            return false;
        }
        extract($this->vars);
        include($pathLayout);
    }

    function view_layout($name, $controller = null)
    {
        if (!isset($controller)) $controller = $this->controller;
        if (!isset($controller) || (is_string($controller) && (strlen($controller) > 0)))
            $contentPage = SITE_PATH . 'views' . DS . $controller . DS . $name . '.php';
        else
            $contentPage = SITE_PATH . 'views' . DS . $name . '.php';
        if (file_exists($contentPage) == false) {
            trigger_error('Template `' . $name . '` does not exist.', E_USER_NOTICE);
            return false;
        }
        extract($this->vars);
        include($contentPage);
    }

}