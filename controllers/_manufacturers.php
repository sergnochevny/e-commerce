<?php

  class Controller_Manufacturers extends Controller_Simple {

    protected $form_title_add = 'NEW MANUFACTURER';
    protected $form_title_edit = 'MODIFY MANUFACTURER';

    protected function search_fields($view = false) {
      if($view) return ['a.manufacturer'];
      else return parent::search_fields($view);
    }

    protected function build_order(&$sort, $view = false) {
      parent::build_order($sort, $view);
      if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
        $sort = ['a.manufacturer' => 'asc'];
      }
    }

    protected function build_search_filter(&$filter, $view = false) {
      $res = parent::build_search_filter($filter, $view);
      if($view) {
        $this->per_page = 24;
        $filter['hidden']['view'] = true;
        $filter['hidden']['b.pvisible'] = 1;
      }
      return $res;
    }

    protected function load(&$data) {
      $data['id'] = _A_::$app->get('id');
      $data['manufacturer'] = Model_Manufacturers::sanitize(_A_::$app->post('manufacturer'));
    }

    protected function validate(&$data, &$error) {
      if(empty($data['manufacturer'])) {
        $error[] = "The Manufacturer Name is required.";
        return false;
      }
      return true;
    }

    /**
     * @export
     */
    public function view() {
      $this->template->vars('cart_enable', '_');
      parent::view();
    }

  }