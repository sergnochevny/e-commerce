<?php

  abstract class Controller_Formsimple extends Controller_Controller {

    protected $id_name = 'id';
    protected $form_title_add;
    protected $form_title_edit;

    protected abstract function load(&$data, &$error);

    protected function form_handling(&$data = null) { return true; }

    protected function form_after_get_data(&$data = null) { }

    protected function form($url, $data = null) {
      $id = _A_::$app->get($this->id_name);
      if(!isset($data)) $data = forward_static_call(['Model_' . ucfirst($this->controller), 'get_by_id'], $id);
      $this->form_after_get_data($data);
      $prms = null;
      if(isset($id)) $prms[$this->id_name] = $id;
      if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
      $action = _A_::$app->router()->UrlTo($url, $prms);
      $this->template->vars($this->id_name, $id);
      $this->template->vars('data', $data);
      $this->template->vars('action', $action);
      $this->main->view_layout('form');
    }

    protected function edit_add_handling($url, $back_url, $title) {
      $this->template->vars('form_title', $title);
      if( $this->form_handling($data) && _A_::$app->request_is_post()) {
        $data = null;
        $this->save($data);
        exit($this->form($url, $data));
      }
      ob_start();
      $this->form($url);
      $form = ob_get_contents();
      ob_end_clean();
      $prms = null;
      if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
      $back_url = _A_::$app->router()->UrlTo($back_url, $prms);
      $this->template->vars('back_url', $back_url);
      $this->template->vars('form', $form);
      $this->main->view_admin('edit');
    }

    protected function save(&$data) {
      $result = false;
      $error = $data = null;
      if($this->load($data, $error)) {
        try {
          forward_static_call(['Model_' . ucfirst($this->controller), 'save'], $data);
          $warning = ["All Data saved successfully!"];
          $result = true;
        } catch(Exception $e) {
          $error[] = $e->getMessage();
        }
      }
      if(isset($warning)) $this->template->vars('warning', $warning);
      if(isset($error)) $this->template->vars('error', $error);

      return $result;
    }

    /**
     * @export
     */
    public function add() {
      $this->main->test_access_rights();
      $this->edit_add_handling($this->controller . '/add', $this->controller, $this->form_title_add);
    }

    /**
     * @export
     */
    public function edit() {
      $this->main->test_access_rights();
      $this->edit_add_handling($this->controller . '/edit', $this->controller, $this->form_title_edit);
    }

    /**
     * @export
     */
    public function delete() {
      $this->main->test_access_rights();
      if(_A_::$app->request_is_ajax() && ($id = _A_::$app->get($this->id_name))) {
        try {
          forward_static_call(['Model_' . ucfirst($this->controller), 'delete'], $id);
        } catch(Exception $e) {
          $error[] = $e->getMessage();
          $this->template->vars('error', $error);
        }
        exit($this->get_list());
      }
      $this->index();
    }

  }