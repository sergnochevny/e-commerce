<?php

namespace controllers;

use app\core\App;
use classes\controllers\ControllerController;
use classes\controllers\ControllerFormSimple;
use classes\helpers\AdminHelper;
use classes\helpers\BlogHelper;
use models\ModelProduct;

/**
 * Class ControllerInfo
 * @package controllers
 */
class ControllerInfo extends ControllerFormSimple{

  /**
   * @var string
   */
  protected $id_field = 'id';

  /**
   * @var string
   */
  protected $_scenario = 'home';

  /**
   * @var array
   */
  protected $resolved_scenario = [
    'home' => 1,
    'product' => 2,
    'cart' => 3
  ];

  /**
   * @var array
   */
  protected $title_scenario = [
    'home' => 'Notice on Home Page',
    'product' => 'Notice on Product Page',
    'cart' => 'Notice with timeout on Cart'
  ];

  /**
   * @param $data
   */
  protected function load(&$data){
    if(App::$app->request_is_post()) {
      $data['title'] = App::$app->post('title') ? App::$app->post('title') : '';
      $data['message'] = App::$app->post('message') ? App::$app->post('message') : '';
      $data['visible'] = ModelProduct::sanitize(App::$app->post('visible') ? App::$app->post('visible') : 0);
      $data['f1'] = $this->resolved_scenario[$this->scenario()];
      $data['f2'] = ModelProduct::sanitize(App::$app->post('f2')) ? App::$app->post('f2') : '';
    }
  }

  /**
   * @param $data
   * @param $error
   * @return bool|mixed
   */
  protected function validate(&$data, &$error){
    if(empty($data['title']) || empty($data['message']) ||
      (empty($data['f2']) && ($this->scenario() == 'cart')) ||
      ((!empty($data['f2']) && ((float)$data['f2'] <= 0)) && ($this->scenario() == 'cart'))) {
      $error = [];
      if(empty($data['title'])) $error[] = 'Identify <b>Title</b> field !';
      if(empty($data['message'])) $error[] = 'Identify <b>Content</b> field !';
      if(empty($data['f2']) && ($this->scenario() == 'cart')) {
        $error[] = 'Identify <b>Timeout</b> field !';
      }
      if((!empty($data['f2']) && ((float)$data['f2'] <= 0)) && ($this->scenario() == 'cart')) {
        $error[] = 'The field <b>Timeout</b> value must be greater than zero';
      }
      $this->main->template->vars('error', $error);

      return false;
    }

    return true;
  }

  /**
   * @param null $data
   * @throws \Exception
   */
  protected function before_form_layout(&$data = null){
    if(!empty($data)) {
      $this->main->template->vars('form_title', $this->title_scenario[$this->scenario()]);
      if(empty($data['f2'])) $data['f2'] = 10;

      $data['title'] = stripslashes($data['title']);
      $data['message'] = stripslashes($data['message']);
      $data['message'] = str_replace('{base_url}', App::$app->router()->UrlTo('/'), $data['message']);
      $data['message'] = preg_replace('#(style="[^>]*")#U', '', $data['message']);
    }
  }

  /**
   * @param $url
   * @param null $data
   * @param bool $return
   * @return mixed|string
   * @throws \Exception
   */
  protected function form($url, $data = null, $return = false){
    if(!isset($data)) {
      $filter = ['hidden' => ['f1' => $this->resolved_scenario[$this->scenario()]]];
      $data = forward_static_call([App::$modelsNS . '\Model' . ucfirst($this->controller), 'get_by_f1'], $filter);
      $this->form_after_get_data($data);
    }
    $this->before_form_layout($data);
    $prms = null;
    if(!is_null($this->scenario())) $prms['method'] = $this->scenario();
    $action = App::$app->router()->UrlTo($url, $prms);
    $this->main->template->vars('scenario', $this->scenario());
    $this->main->template->vars('data', $data);
    $this->main->template->vars('action', $action);
    if($return) return $this->render_layout_return('form', $return && App::$app->request_is_ajax());

    return $this->render_layout('form');
  }

  /**
   * @param $data
   * @throws \Exception
   */
  protected function before_save(&$data){
    if(!isset($data[$this->id_field])) $data['post_author'] = AdminHelper::get_from_session();
    $data['title'] = addslashes(trim(html_entity_decode(($data['title']))));
    $data['message'] = addslashes(html_entity_decode(BlogHelper::convertation(($data['message']))));
  }

  /**
   * @param $data
   * @throws \Exception
   */
  protected function after_get_data_item_view(&$data){
    if(!empty($data)) {
      $data['title'] = stripslashes($data['title']);
      $data['message'] = stripslashes($data['message']);
      $data['message'] = str_replace('{base_url}', App::$app->router()->UrlTo('/'), $data['message']);
      $data['message'] = preg_replace('#(style="[^>]*")#U', '', $data['message']);
    }
  }

  /**
   * @param null $scenario
   * @return null|string
   */
  public function scenario($scenario = null){
    if(!empty($scenario) && in_array($scenario, array_keys($this->resolved_scenario))) {
      $this->_scenario = $scenario;
    }

    return $this->_scenario;
  }

  /**
   * @param bool $required_access
   */
  public function delete($required_access = true){
  }

  /**
   * @param bool $required_access
   */
  public function add($required_access = true){
  }

  /**
   * @param bool $required_access
   */
  public function index($required_access = true){
  }

  /**
   * @export
   * @param bool $partial
   * @param bool $required_access
   * @param bool $as_widget
   * @throws \Exception
   */
  public function view($partial = false, $required_access = false, $as_widget = false){
    if($as_widget || App::$app->request_is_ajax()) {
      if(!is_null($this->scenario()) && in_array($this->scenario(), array_keys($this->resolved_scenario))) {
        $filter['hidden']['visible'] = 1;
        $filter['hidden']["f1"] = $this->resolved_scenario[$this->scenario()];
        $data = forward_static_call([App::$modelsNS . '\Model' . ucfirst($this->controller), 'get_by_f1'], $filter);
        $this->after_get_data_item_view($data);
        $this->main->template->vars('data', $data);
        $this->render_layout('view/' . $this->scenario(), !$as_widget);
      } else ControllerController::view($partial, $required_access);
    } else parent::view($partial, $required_access);
  }

}