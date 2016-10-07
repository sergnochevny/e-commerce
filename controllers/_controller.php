<?php

  class Controller_Controller extends Controller_Base {

    protected $main;

    public function __construct(Controller_Base $main = null) {
      $this->layouts = _A_::$app->config('layouts');
      parent::__construct();
      if(isset($main) && (explode('_', get_class($main))[0] == 'Controller')) {
        $this->main = $main;
      } else {
        $this->main = new Controller_Main($this);
      }
    }

    protected function get_list() {
      $page = !empty(_A_::$app->get('page')) ? _A_::$app->get('page') : 1;
      $per_page = 12;
      $model_name = 'Model_' . ucfirst($this->controller);
      $total = forward_static_call([$model_name, 'get_total_count']);
      if($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
      if($page <= 0) $page = 1;
      $start = (($page - 1) * $per_page);
      $res_count_rows = 0;
      $rows = forward_static_call_array([$model_name, 'get_list'], [$start, $per_page, &$res_count_rows]);

      $this->template->vars('rows', $rows);
      ob_start();
      $this->template->view_layout('rows');
      $rows = ob_get_contents();
      ob_end_clean();
      $this->template->vars('count_rows', $res_count_rows);
      $this->template->vars('list', $rows);
      (new Controller_Paginator($this->main))->paginator($total, $page, $this->controller, $per_page);
      $this->main->view_layout('list');
    }

    /**
     * @export
     */
    public function index() {
      $this->main->test_access_rights();
      ob_start();
      $this->get_list();
      $list = ob_get_contents();
      ob_end_clean();
      $this->template->vars('list', $list);
      if(Controller_Admin::is_logged()) $this->main->view_admin($this->controller);
      else  $this->main->view($this->controller);

    }

  }