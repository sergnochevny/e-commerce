<?php

  class Controller_Info extends Controller_FormSimple {

    protected $id_name = 'id';
    protected $_scenario = 'home';
    protected $resolved_scenario = ['home' => 1, 'product' => 2, 'cart' => 3];
    protected $title_scenario = [
      'home' => 'Notice on Home Page',
      'product' => 'Notice on Product Page',
      'cart' => 'Notice with timeout on Cart'
    ];

    public function scenario($scenario = null) {
      if(!empty($scenario) && in_array($scenario, array_keys($this->resolved_scenario))) {
        $this->_scenario = $scenario;
      }
      return $this->_scenario;
    }

    protected function load(&$data) {
      $data['title'] = _A_::$app->post('title') ? _A_::$app->post('title') : '';
      $data['message'] = _A_::$app->post('message') ? _A_::$app->post('message') : '';
      $data['visible'] = Model_Product::sanitize(_A_::$app->post('visible') ? _A_::$app->post('visible') : 0);
      $data['f1'] = $this->resolved_scenario[$this->scenario()];
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

    protected function before_form_layout(&$data = null) {
      $this->template->vars('form_title', $this->title_scenario[$this->scenario()]);
      if(empty($data['f2'])) $data['f2'] = 10;

      $data['title'] = stripslashes($data['title']);
      $data['message'] = stripslashes($data['message']);
      $data['message'] = str_replace('{base_url}', _A_::$app->router()->UrlTo('/'), $data['message']);
      $data['message'] = preg_replace('#(style="[^>]*")#U', '', $data['message']);
    }

    protected function form($url, $data = null) {
      if(!isset($data)) {
        $data = forward_static_call(['Model_' . ucfirst($this->controller), 'get_by_f1'], $this->resolved_scenario[$this->scenario()]);
        $this->form_after_get_data($data);
      }
      $this->before_form_layout($data);
      if(!is_null($this->scenario())) $prms['method'] = $this->scenario();
      $action = _A_::$app->router()->UrlTo($url, $prms);
      $this->template->vars('scenario', $this->scenario());
      $this->template->vars('data', $data);
      $this->template->vars('action', $action);
      $this->main->view_layout('form');
    }

    protected function before_save(&$data) {
      if(!isset($data[$this->id_name])) $data['post_author'] = Controller_Admin::get_from_session();
      $data['title'] = addslashes(trim(html_entity_decode(($data['title']))));
      $data['message'] = addslashes(html_entity_decode(Controller_Blog::convertation(($data['message']))));
    }

    protected function after_get_data_item_view(&$data) {
      $data['title'] = stripslashes($data['title']);
      $data['message'] = stripslashes($data['message']);
      $data['message'] = str_replace('{base_url}', _A_::$app->router()->UrlTo('/'), $data['message']);
      $data['message'] = preg_replace('#(style="[^>]*")#U', '', $data['message']);
    }

    public function delete($required_access = true) { }

    public function add($required_access = true) { }

    public function index($required_access = true) { }

    /**
     * @export
     */
    public function view() {
      if(_A_::$app->request_is_ajax()) {
        if(!is_null($this->scenario()) && in_array($this->scenario(), array_keys($this->resolved_scenario))) {
          $f1 = $this->resolved_scenario[$this->scenario()];
          $data = forward_static_call(['Model_' . ucfirst($this->controller), 'get_by_f1'], $f1);
          $this->after_get_data_item_view($data);
          $this->template->vars('data', $data);
          $this->main->view_layout('view/' . $this->scenario());
        } else Controller_Controller::view();
      } else {
        parent::view();
      }
    }

  }