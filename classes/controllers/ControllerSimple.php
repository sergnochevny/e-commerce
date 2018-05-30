<?php

namespace classes\controllers;

use app\core\App;
use app\core\model\ModelBase;
use classes\Auth;
use classes\helpers\CaptchaHelper;
use Exception;

/**
 * Class ControllerSimple
 * @package controllers\base
 */
abstract class ControllerSimple extends ControllerController{

  protected $id_field = 'id';
  protected $name_field = 'name';
  protected $form_title_add;
  protected $form_title_edit;
  protected $save_warning = "All Data saved successfully!";

  protected function load(&$data){
    if(App::$app->RequestIsPost()) {
      $post = App::$app->post();
      foreach($post as $key => $value) {
        $data[$key] = ModelBase::Sanitize($value);
      }
    }
  }

  /**
   * @param $data
   * @param $error
   * @return mixed
   */
  protected abstract function validate(&$data, &$error);

  /**
   * @param null $data
   * @return bool
   */
  protected function form_handling(&$data = null){
    return true;
  }

  /**
   * @param null $data
   */
  protected function form_after_get_data(&$data = null){
  }

  /**
   * @param null $data
   */
  protected function before_form_layout(&$data = null){
  }

  /**
   * @param null $id
   */
  protected function after_delete($id = null){
  }

  /**
   * @param $id
   * @param $data
   */
  protected function after_save($id, &$data){
  }

  /**
   * @param $data
   */
  protected function before_save(&$data){
  }

  /**
   * @param $data
   */
  protected function after_get_data_item_view(&$data){
  }

  /**
   * @param $url
   * @param null $data
   * @param bool $return
   * @return mixed
   * @throws \Exception
   */
  protected function form($url, $data = null, $return = false){
    $id = App::$app->get($this->id_field);
    if(!isset($data)) {
      $data = forward_static_call([ App::$modelsNS . '\Model' . ucfirst($this->controller), 'get_by_id'], $id);
      $this->form_after_get_data($data);
    }
    $this->before_form_layout($data);
    $prms = null;
    if(isset($id)) $prms[$this->id_field] = $id;
    if(!empty($this->scenario())) $prms['method'] = $this->scenario();
    $action = App::$app->router()->UrlTo($url, $prms);
    $this->main->view->setVars($this->id_field, $id);
    $this->main->view->setVars('data', $data);
    $this->main->view->setVars('scenario', $this->scenario());
    $this->main->view->setVars('action', $action);
    if($this->scenario() == 'short') {
      $captcha = CaptchaHelper::gen_captcha();
      $this->main->view->setVars('captcha', $captcha);
    }
    if($return) return $this->RenderLayoutReturn((!empty($this->scenario()) ? $this->scenario() . DS : '') . 'form', $return && App::$app->RequestIsAjax());
    return $this->RenderLayout((!empty($this->scenario()) ? $this->scenario() . DS : '') . 'form');
  }

  /**
   * @param $url
   * @param $title
   * @throws \Exception
   */
  protected function edit_add_handling($url, $title){
    $data = null;
    $this->load($data);
    $this->set_back_url();
    if(App::$app->RequestIsPost() && $this->form_handling($data)) {
      $this->Save($data);
      $this->get_list();
    } else {
      $this->main->view->setVars('form_title', $title);
      $this->form($url);
    }
  }

  /**
   * @param $data
   * @return bool
   */
  protected function Save(&$data){
    $result = false;
    $error = null;
    if($this->validate($data, $error)) {
      try {
        $data['scenario'] = $this->scenario();
        $this->before_save($data);
        $id = forward_static_call_array([$this->model, 'Save'], [&$data]);
        $this->after_save($id, $data);
        $warning = [$this->save_warning];
        $result = true;
      } catch(Exception $e) {
        $error[] = $e->getMessage();
      }
    }
    if(isset($warning)) $this->main->view->setVars('warning', $warning);
    if(isset($error)) $this->main->view->setVars('error', $error);

    return $result;
  }

  /**
   * @export
   * @param bool $required_access
   * @throws \Exception
   */
  public function add($required_access = true){
    if($required_access) Auth::check_admin_authorized();
    $this->edit_add_handling($this->controller . '/add', $this->form_title_add);
  }

  /**
   * @export
   * @param bool $partial
   * @param bool $required_access
   * @throws \Exception
   */
  public function view($partial = false, $required_access = false){
    if($required_access) Auth::check_admin_authorized();
    if(!is_null(App::$app->get($this->id_field))) {
      $id = App::$app->get($this->id_field);
      $data = forward_static_call([ App::$modelsNS . '\Model' . ucfirst($this->controller), 'get_by_id'], $id);
      $this->after_get_data_item_view($data);
      $this->set_back_url();
      $this->main->view->setVars('scenario', $this->scenario());
      $this->main->view->setVars('data', $data);
      if($partial) $this->RenderLayout('view' . (!empty($this->scenario()) ? DS . $this->scenario() : '') . DS . 'detail');
      elseif($required_access) $this->main-> render_view_admin('view' . (!empty($this->scenario()) ? DS . $this->scenario() : '') . DS . 'detail');
      else $this->render_view('view' . (!empty($this->scenario()) ? DS . $this->scenario() : '') . DS . 'detail');
    } else parent::view($partial);
  }

  /**
   * @export
   * @param bool $required_access
   * @throws \Exception
   */
  public function edit($required_access = true){
    if($required_access) Auth::check_admin_authorized();
    $this->edit_add_handling($this->controller . '/edit', $this->form_title_edit);
  }

  /**
   * @export
   * @param bool $required_access
   * @throws \Exception
   */
  public function delete($required_access = true){
    if($required_access) Auth::check_admin_authorized();
    if(App::$app->RequestIsPost() && App::$app->RequestIsAjax() && ($id = App::$app->get($this->id_field))) {
      try {
        forward_static_call([ App::$modelsNS . '\Model' . ucfirst($this->controller), 'delete'], $id);
        $this->after_delete($id);
      } catch(Exception $e) {
        $error[] = $e->getMessage();
        $this->main->view->setVars('error', $error);
      }
      exit($this->get_list());
    }
    $this->index($required_access);
  }

}