<?php

  class Controller_Patterns extends Controller_Simple {

    protected $form_title_add = 'NEW PATTERN';
    protected $form_title_edit = 'MODIFY PATTERN';

    protected function search_fields($view = false) {
      if($view) return ['a.pattern'];
      else return parent::search_fields($view);
    }

    protected function build_order(&$sort, $view = false) {
      parent::build_order($sort, $view);
      if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
        $sort = ['a.pattern' => 'asc'];
      }
    }

    protected function build_search_filter(&$filter, $view = false) {
      $res = parent::build_search_filter($filter, $view);
      if($view) {
        $this->per_page = 24;
        $filter['hidden']['view'] = true;
        $filter['hidden']['c.pvisible'] = 1;
      }
      return $res;
    }

    protected function load(&$data) {
      $data['id'] = _A_::$app->get('id');
      $data['pattern'] = Model_Patterns::sanitize(_A_::$app->post('pattern'));
    }

    protected function validate(&$data, &$error) {
      $error = null;
      if(empty($data['pattern'])) {
        $error[] = "Pattern Name is required.";
        return false;
      }
      return true;
    }

    /**
     * @export
     */
    public function view() {
      $this->template->vars('cart_enable', '_');
      _A_::$app->setSession('sidebar_idx', 3);
      parent::view();
    }

  }