<?php

  abstract class Controller_Simple extends Controller_Controller {

    protected $id_name = 'id';
    protected $form_title_add;
    protected $form_title_edit;
    protected $view_title;

    protected function form($url) {
      $id = _A_::$app->get($this->id_name);
      $prms = null;
      if(isset($id)) $prms[$this->id_name] = $id;
      if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
      $action = _A_::$app->router()->UrlTo($url, $prms);
      $data = forward_static_call(['Model_' . ucfirst($this->controller), 'get_by_id'], $id);
      $this->template->vars('data', $data);
      $this->template->vars('action', $action);
      $this->main->view_layout('form');
    }

    protected function edit_add_handling($url, $title) {
      if(_A_::$app->request_is_post()) {
        $this->save();
        $this->get_list();
      } else {
        $this->template->vars('form_title', $title);
        $this->form($url);
      }
    }

    protected abstract function load(&$data, &$error);

    protected function save() {
      $error = $data = null;
      if($this->load($data, $error)) {
        try {
          forward_static_call(['Model_' . ucfirst($this->controller), 'save'], $data);
          $warning = ["All data was saved successfully!"];
        } catch(Exception $e) {
          $error[] = $e->getMessage();
        }
      }
      $this->template->vars('warning', isset($warning) ? $warning : null);
      $this->template->vars('error', isset($error) ? $error : null);
    }

    /**
     * @export
     */
    public function add() {
      $this->main->test_access_rights();
      $this->edit_add_handling($this->controller . '/add', $this->form_title_add);
    }

    /**
     * @export
     */
    public function view(){
      $id = _A_::$app->get($this->id_name);
      $data = forward_static_call(['Model_' . ucfirst($this->controller), 'get_by_id'], $id);
      $this->template->vars('view_title', $this->view_title);
      $this->template->vars('data', $data);
      $this->main->view_layout('view');
    }

    /**
     * @export
     */
    public function edit() {
      $this->main->test_access_rights();
      $this->edit_add_handling($this->controller . '/edit', $this->form_title_edit);
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