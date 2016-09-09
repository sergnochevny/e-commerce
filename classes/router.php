<?php


Class Router
{

    public $base_url;
    public $route;
    public $controller;
    public $action;

    private $path;
    private $args = [];

    protected function init()
    {
        $this->route = (empty(_A_::$app->get('route'))) ? '' : _A_::$app->get('route');
        $get = _A_::$app->get();
        unset($get['route']);
        _A_::$app->setGet($get);
//        _A_::$app->get('route', );
        if (empty($this->route)) $this->route = 'index';
        $this->route = trim($this->route, '/\\');
        $this->setPath(SITE_PATH . 'controllers' . DS);
    }

    private function setPath($path)
    {

        $path = rtrim($path, '/\\');
        $path .= DS;

        if (is_dir($path) == false) {
            throw new Exception ('Invalid controller path: `' . $path . '`');
        }
        $this->path = $path;
    }

    public function start()
    {
        $this->init();

        $file = null;
        $this->getController();
        $this->setBaseUrl();
        try {
            $class = 'Controller_' . $this->controller;
            _A_::$app->registry()->set('controller', $this->controller);
            _A_::$app->registry()->set('action', $this->action);

            $controller = new $class();

            if (is_callable([$controller, $this->action]) == false) {
                $main = new Controller_Main($controller);
                $main->error404();
            } else {
                call_user_func([$controller, $this->action]);
            }
        }catch (Exception $e){
            (new Controller_Main())->error404($e->getMessage());
        }
    }

    function getController()
    {
        $parts = explode('/', $this->route);
        $cmd_path = $this->path;
        foreach ($parts as $part) {
            if (is_dir($cmd_path . $part)) {
                $cmd_path .= $part . DS;
                array_shift($parts);
                continue;
            }
            if (is_file($cmd_path . '_' . $part . '.php')) {
                $this->controller = $part;
                array_shift($parts);
                break;
            }
        }
        if (empty($this->controller)) $this->controller = 'index';
        $this->action = array_shift($parts);
        if (empty($this->action)) $this->action = $this->controller;
        $this->args = $parts;
    }

    private function setBaseUrl()
    {
        $end_uri = explode('/', _A_::$app->server('REQUEST_URI'));
        array_pop($end_uri);
        if ($this->action == 'post') array_pop($end_uri);
        $this->base_url = strtolower(explode('/', _A_::$app->server('SERVER_PROTOCOL'))[0]) .
            "://" . _A_::$app->server('SERVER_NAME') .
            (_A_::$app->server('SERVER_PORT') == '80' ? '' : ':' . _A_::$app->server('SERVER_PORT')) .
            implode('/', $end_uri);
        define('BASE_URL', $this->base_url);
    }

    public function redirect($url)
    {
        exit("<script>window.location='" . $url . "';</script>");
    }
}
