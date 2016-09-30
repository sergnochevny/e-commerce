<?php

  class Controller_Colours extends Controller_Controller {

    /**
     * @export
     */
    public function colours() {
      $this->main->test_access_rights();
      $back_url = _A_::$app->router()->UrlTo('/');

      // pagination
      $page = !is_null(_A_::$app->get('page')) ? _A_::$app->get('page') : 1;
      $per_page = 12;
      $start = (($page - 1) * $per_page);
      $this->createPagination($page, $per_page, 'colours');

      // data
      $model = Model_Colours::get_sectioned_list($start, $per_page, $total);
      $this->listData($model, $list);

      $this->template->vars('list', $list);
      $this->template->vars('back_url', $back_url);
      $this->main->view_admin("index");
    }

    /**
     * @export
     */
    public function view() {
      $this->main->test_access_rights();
      $back_url = _A_::$app->router()->UrlTo('/');

      if(!is_null(_A_::$app->get('id'))) {


      }

      $this->template->vars('back_url', $back_url);
      $this->main->view_admin("view");
    }

    /**
     * @export
     */
    public function create() {
      $this->main->test_access_rights();
      $back_url = _A_::$app->router()->UrlTo('');

      $this->template->vars('back_url', $back_url);
      $this->main->view_admin("create");
    }

    /**
     * @export
     */
    public function update() {
      $this->main->test_access_rights();
      if($id = _A_::$app->get('id')) {
        Model_Colours::deleteById($id);
      }
      $this->main->view_admin("update");
    }

    /**
     * @export
     */
    public function delete() {
      $this->main->test_access_rights();
      if(_A_::$app->get('id')) {
      }
    }

    private function form() {

    }

    private function createPagination($page, $per_page, $url) {
      $totally = Model_Colours::amount();
      (new Controller_Paginator($this))->paginator($totally, $page, $url, $per_page);
    }

    private function listData($model, &$list) {
      foreach($model as $row) {
        ob_start();
          $options['id'] = $row['id'];
          $this->template->vars('row', $row);
          $this->template->vars('options', $options);
          $this->template->view_layout('_list');
          $list .= ob_get_contents();
        ob_end_clean();
      }
    }

  }