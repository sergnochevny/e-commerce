<?php

  class Controller_Colors extends Controller_Simple {

    protected $name_field = 'color';
    protected $form_title_add = 'NEW COLOR';
    protected $form_title_edit = 'MODIFY COLOR';

    protected function search_fields($view = false) {
      if($view) return ['a.color'];
      else return parent::search_fields($view);
    }

    protected function build_order(&$sort, $view = false) {
      parent::build_order($sort, $view);
      if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
        $sort = ['a.color' => 'asc'];
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
      $data['color'] = Model_Colors::sanitize(_A_::$app->post('color'));
    }

    protected function validate(&$data, &$error) {
      if(empty($data['color'])) {
        $error[] = "The Color Name is required.";
        return false;
      }
      return true;
    }

    protected function build_sitemap_url($row, $view) {
      $prms = ['clr' => $row[$this->id_field]];
      $url = 'shop';
      $sef = $row[$this->name_field];
      return _A_::$app->router()->UrlTo($url, $prms, $sef);
    }

    /**
     * @export
     */
    public function view() {
      $this->template->vars('cart_enable', '_');
      _A_::$app->setSession('sidebar_idx', 4);
      parent::view();
    }

    public static function sitemap_order() { return 4; }
  }