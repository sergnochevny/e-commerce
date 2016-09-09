<?php
Abstract Class Controller_Base {

	public $registry;
	public $template;

	protected $layouts;
	
	public $vars = array();

	function __construct() {
		$this->registry = _A_::$app->registry();
		$this->template = new Template($this->layouts, get_called_class());
	}

	function redirect($url){
		$router = $this->registry->get('router');
		$router->redirect($url);
	}
}
