<?php
Abstract Class Controller_Base {

	public $registry;
	public $template;
	public $layouts;
	
	public $vars = array();

	function __construct($registry) {
		$this->registry = $registry;

		$this->template = new Template($this->layouts, 'Controller_index');
	}

	function redirect($url){
		$router = $this->registry->get('router');
		$router->redirect($url);
	}
}
