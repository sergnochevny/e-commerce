<?php

  class Controller_Colours extends Controller_Controller {

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

    private function isAjaxRequest() {
      return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    private function setJSON() {
      header('Content-Type: application/json');
    }

    private function outputJSON($output) {
      $this->setJSON();
      echo json_encode($output);
    }

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
    public function create() {
      $this->main->test_access_rights();
      $data = null;
      if($this->isAjaxRequest()) {
        if(!is_null(_A_::$app->post('colour_name'))){
          $data['status'] = Model_Colours::create(_A_::$app->post('colour_name')) ? 'created' : null;
        }
        $this->outputJSON($data);
      }
    }

    /**
     * @export
     */
    public function update() {
      $this->main->test_access_rights();
      if($id = _A_::$app->get('id')) {
        if($this->isAjaxRequest()) {
          $name = !is_null(_A_::$app->get('colour_name')) ? _A_::$app->get('colour_name') : '';
          $data['status'] = Model_Colours::update($id, $name) ? 'updated' : null;
          $this->outputJSON($data);
        }
      }
    }

    /**
     * @export
     */
    public function delete() {
      $this->main->test_access_rights();
      if($id = _A_::$app->get('id')) {
        $data = null;
        if($this->isAjaxRequest()) {
          $data['status'] = Model_Colours::deleteById($id) ? 'deleted' : null;
          $this->outputJSON($data);
        }
      }
    }

  }