<?php

  abstract class Controller_Simple extends Controller_Controller {

    protected $id_name = 'id';
    protected $form_title_add;
    protected $form_title_edit;
    protected $view_title;
    protected $save_warning = "All Data saved successfully!";

    protected abstract function load(&$data);

    protected abstract function validate(&$data, &$error);

    protected function form_handling(&$data = null) { return true; }

    protected function form_after_get_data(&$data = null) { }

    protected function before_form_layout(&$data = null) { }

    protected function after_delete($id = null) { }

    protected function after_save($id, &$data) { }

    protected function before_save(&$data) { }

    protected function after_get_data_item_view(&$data) { }

    protected function form($url, $data = null) {
      $id = _A_::$app->get($this->id_name);
      if(!isset($data)) {
        $data = forward_static_call(['Model_' . ucfirst($this->controller), 'get_by_id'], $id);
        $this->form_after_get_data($data);
      }
      $this->before_form_layout($data);
      $prms = null;
      if(isset($id)) $prms[$this->id_name] = $id;
      if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
      $action = _A_::$app->router()->UrlTo($url, $prms);
      $this->template->vars($this->id_name, $id);
      $this->template->vars('data', $data);
      $this->template->vars('action', $action);
      $this->main->view_layout('form');
    }

    protected function edit_add_handling($url, $title, $back_url = null) {
      $data = null;
      $this->load($data);
      if($this->form_handling($data) && _A_::$app->request_is_post()) {
        $this->save($data);
        $this->get_list();
      } else {
        $this->template->vars('form_title', $title);
        $this->form($url);
      }
    }

    protected function save(&$data) {
      $result = false;
      $error = null;
      if($this->validate($data, $error)) {
        try {
          $this->before_save($data);
          $id = forward_static_call_array(['Model_' . ucfirst($this->controller), 'save'], [&$data]);
          $this->after_save($id, $data);
          $warning = [$this->save_warning];
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
    public function add($required_access = true) {
      if($required_access) $this->main->is_admin_authorized();
      $this->edit_add_handling($this->controller . '/add', $this->form_title_add, $this->controller);
    }

    /**
     * @export
     */
    public function view() {
      if(!is_null(_A_::$app->get($this->id_name))) {
        $id = _A_::$app->get($this->id_name);
        $data = forward_static_call(['Model_' . ucfirst($this->controller), 'get_by_id'], $id);
        $this->after_get_data_item_view($data);
        $this->template->vars('view_title', $this->view_title);
        $this->template->vars('data', $data);
        $this->main->view_layout('view');
      } else parent::view();
    }

    /**
     * @export
     */
    public function edit($required_access = true) {
      if($required_access) $this->main->is_admin_authorized();
      $this->edit_add_handling($this->controller . '/edit', $this->form_title_edit, $this->controller);
    }

    /**
     * @export
     */
    public function delete($required_access = true) {
      if($required_access) $this->main->is_admin_authorized();
      if(_A_::$app->request_is_post() && _A_::$app->request_is_ajax() && ($id = _A_::$app->get($this->id_name))) {
        try {
          forward_static_call(['Model_' . ucfirst($this->controller), 'delete'], $id);
          $this->after_delete($id);
        } catch(Exception $e) {
          $error[] = $e->getMessage();
          $this->template->vars('error', $error);
        }
        exit($this->get_list());
      }
      $this->index($required_access);
    }

  }