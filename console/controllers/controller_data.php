<?php

  class Controller_Data extends Controller_Base {

    protected function search_fields($view = false) {
      return [
        'a.pname', 'a.pvisible', 'a.dt', 'a.pnumber',
        'a.piece', 'a.best', 'a.specials', 'b.cid',
        'c.id', 'd.id', 'e.id', 'a.priceyard'
      ];
    }

    protected function build_search_filter(&$filter, $view = false) {
      $search = null;
      $type = isset($filter['type']) ? $filter['type'] : null;
      $res = parent::build_search_filter($filter, $view);
      $filter['fields']['a.pnumber'] = ['not' => true, 'condition' => 'is', 'value' => null];
      if(!isset($filter['fields']['a.priceyard']) && !isset($filter['a.priceyard'])) {
        $filter['fields']['a.priceyard'] = ['not' => false, 'condition' => '>', 'value' => '0.00'];
      }
      $filter['fields']['a.pvisible'] = ['not' => false, 'condition' => '=', 'value' => '1'];
      $filter['fields']['a.image1'] = ['not' => true, 'condition' => 'is', 'value' => null];

      if(isset($type)) {
        $filter['type'] = $type;
        $res['type'] = $type;
        switch($type) {
          case 'best':
            unset($filter['a.best']);
            unset($res['a.best']);
            $filter['fields']['a.best'] = ['not' => false, 'condition' => '=', 'value' => '1'];
            $res['fields']['a.best'] = ['not' => false, 'condition' => '=', 'value' => '1'];
            break;
          case 'specials':
            unset($filter['a.specials']);
            unset($res['a.specials']);
            $filter['fields']['a.specials'] = ['not' => false, 'condition' => '=', 'value' => '1'];
            $res['fields']['a.specials'] = ['not' => false, 'condition' => '=', 'value' => '1'];
            break;
          case 'discounted':
            unset($filter['a.specials']);
            unset($res['a.specials']);
            $filter['fields']['a.specials'] = ['not' => false, 'condition' => '=', 'value' => '1'];
            $res['fields']['a.specials'] = ['not' => false, 'condition' => '=', 'value' => '1'];
            break;
        }
      }
      return $res;
    }

    protected function build_order(&$sort, $view = false, $filter = null) {
      $type = isset($filter['type']) ? $filter['type'] : null;
      if(isset($type)) {
        switch($type) {
          case 'last':
            $sort['a.dt'] = 'desc';
            $sort['a.pid'] = 'desc';
            break;
          case 'popular':
            $sort['a.popular'] = 'desc';
            break;
          case 'bestsellers':
            $sort['s'] = 'desc';
            break;
          default:
            $sort['a.pid'] = 'desc';
        }
      } else {
        $sort['b.displayorder'] = 'asc';
        $sort['fabrix_product_categories.display_order'] = 'asc';
      }
    }

    protected function get_list_by_type($type = 'last', $limit = 60) {
      $filter['type'] = $type;
      $this->build_search_filter($filter);
      $sort = $this->load_sort($filter);
      $rows = Model_Shop::get_list(false, 0, $limit, $res_count_rows, $filter, $sort);
      return $rows;
    }

    /**
     * @console
     */
    public function collect() {
      $rows = $this->get_list_by_type('specials');
      fwrite(STDOUT, print_r($rows, true));
    }

  }
