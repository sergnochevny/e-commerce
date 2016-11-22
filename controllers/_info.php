<?php

  class Controller_Info extends Controller_FormSimple {

    protected $id_name = 'id';
    protected $_scenario = 'home';
    protected $resolved_scenario = ['home' => 1, 'product' => 2, 'cart' => 3];

    protected function scenario($scenario = null) {
      if(!empty($scenario) && in_array($scenario, array_keys($this->resolved_scenario))) {
        $this->_scenario = $scenario;
      }
    }

    protected function before_save(&$data) {
      $data['f1'] = $this->resolved_scenario[$this->scenario()];
    }

    protected function load(&$data) {
      $data['id'] = _A_::$app->get('id');
      $data['title'] = Model_Product::sanitize(_A_::$app->post('metadescription') ? _A_::$app->post('title') : '');
      $data['message'] = Model_Product::sanitize(_A_::$app->post('message') ? _A_::$app->post('message') : '');
      $data['visible'] = Model_Product::sanitize(_A_::$app->post('visible') ? _A_::$app->post('visible') : 0);
      $data['f2'] = Model_Product::sanitize(_A_::$app->post('f2')) ? _A_::$app->post('f2') : '';
    }

    protected function validate(&$data, &$error) {

      if(empty($data['title']) || empty($data['message']) ||
        (empty($data['f2']) && ($this->scenario() == 'cart'))
      ) {
        $error = [];
        if(empty($data['title'])) $error[] = 'Identify Title field !';
        if(empty($data['message'])) $error[] = 'Identify Content field !';
        if(empty($data['f2']) && ($this->_scenario == 'cart')) {
          $error[] = 'Identify Timeout field !';
        }
        $this->template->vars('error', $error);
        return false;
      }

      return true;
    }

    protected function form_handling(&$data = null) {
      if(_A_::$app->request_is_post()) {
        if(!is_null(_A_::$app->post('method'))) {
          $this->scenario(_A_::$app->post('method'));
        }
      }
      return true;
    }

    protected function before_form_layout(&$data = null) {
      $data['scenario'] = $this->scenario();
    }

    public function delete($required_access = true) {}

    public function add($required_access = true) {}

    public function index($required_access = true) {}

  }