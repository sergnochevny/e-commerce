<?php


Class Router {

	private $registry;
	private $path;
	private $args = array();


	function __construct($registry) {
		$this->registry = $registry;
	}


	function setPath($path) {

        $path = rtrim($path, '/\\');
        $path .= DS;

        if (is_dir($path) == false) {
			throw new Exception ('Invalid controller path: `' . $path . '`');

        }
        $this->path = $path;
	}	
	

	private function getController(&$file, &$controller, &$action, &$args) {
        $route = (empty($_GET['route'])) ? '' : $_GET['route'];
		unset($_GET['route']);
        if (empty($route)) {
			$route = 'index'; 
		}
		

        $route = trim($route, '/\\');
        $parts = explode('/', $route);


        $cmd_path = $this->path;
        foreach ($parts as $part) {
			$fullpath = $cmd_path . $part;


			if (is_dir($fullpath)) {
				$cmd_path .= $part . DS;
				array_shift($parts);
				continue;
			}


			if (is_file($fullpath . '.php')) {
				$controller = $part;
				array_shift($parts);
				break;
			}
        }

		
        if (empty($controller)) {
			$controller = 'index'; 
		}


        $action = array_shift($parts);
        if (empty($action)) { 
			$action = 'index'; 
		}

        $file = $cmd_path . $controller . '.php';
        $args = $parts;
	}
	
	function start() {

        $this->getController($file, $controller, $action, $args);

		$end_uri = explode('/', $_SERVER['REQUEST_URI']);
		array_pop($end_uri);
		if ($action == 'post') array_pop($end_uri);
		$b_u = strtolower(explode('/', $_SERVER['SERVER_PROTOCOL'])[0]) . "://" . $_SERVER['SERVER_NAME'] . ($_SERVER['SERVER_PORT'] == '80' ? '' : ':' . $_SERVER['SERVER_PORT']) . implode('/', $end_uri);
		define('BASE_URL', $b_u);

		if (is_readable($file) == false) {
			include_once('controllers/_main.php');
			$main = new Controller_Main($this->registry);
			$main->error404();
        }
		

        include ($file);

        $class = 'Controller_' . $controller;
		$this->registry->controller = $controller;
		$this->registry->action = $action;

        $controller = new $class($this->registry);

        if (is_callable(array($controller, $action)) == false) {
			include_once('controllers/_main.php');
			$main = new Controller_Main($controller);
			$main->error404();
        }


        $controller->$action();
	}

	public function redirect($url){
		exit("<script>window.location='" . $url . "';</script>");
	}
}
