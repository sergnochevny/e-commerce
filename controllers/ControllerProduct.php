<?php

namespace controllers;

use app\core\App;
use classes\controllers\ControllerFormSimple;
use models\ModelCategories;
use models\ModelColors;
use models\ModelManufacturers;
use models\ModelPatterns;
use models\ModelProduct;
use models\ModelRelated;

/**
 * Class ControllerProduct
 * @package controllers
 */
class ControllerProduct extends ControllerFormSimple{

  /**
   * @var string
   */
  protected $id_field = 'pid';
  /**
   * @var string
   */
  protected $form_title_add = 'NEW PRODUCT';
  /**
   * @var string
   */
  protected $form_title_edit = 'MODIFY PRODUCT';

  /**
   * @param $method
   * @param $filters
   * @param null $start
   * @param null $search
   * @param bool $return
   * @return string
   * @throws \Exception
   */
  private function select_filter($method, $filters, $start = null, $search = null, $return = false){
    $selected = isset($filters) ? $filters : [];
    $filter = ModelProduct::get_filter_data($method, $count, $start, $search);
    $this->template->vars('destination', $method);
    $this->template->vars('total', $count);
    $this->template->vars('search', $search);
    $this->template->vars('type', $method . '_select');
    $this->template->vars('filter_type', $method);
    $this->template->vars('filter_data_start', isset($start) ? $start : 0);
    $this->template->vars('selected', $selected);
    $this->template->vars('filter', $filter);
    if($return) return $this->template->render_layout_return('filter/select');
    return $this->template->render_layout('filter/select');
  }

  /**
   * @param $data
   * @param bool $return
   * @return string
   * @throws \Exception
   */
  private function images($data, $return = false){
    $not_image = App::$app->router()->UrlTo('images/products/not_image.jpg');
    $data['u_image1'] = empty($data['image1']) || !is_file(APP_PATH.'/web/images/products/' . $data['image1']) ? '' :
      App::$app->router()->UrlTo('images/products/v_' . $data['image1']);
    $data['u_image2'] = empty($data['image2']) || !is_file(APP_PATH.'/web/images/products/' . $data['image2']) ? '' :
      App::$app->router()->UrlTo('images/products/b_' . $data['image2']);
    $data['u_image3'] = empty($data['image3']) || !is_file(APP_PATH.'/web/images/products/' . $data['image3']) ? '' :
      App::$app->router()->UrlTo('images/products/b_' . $data['image3']);
    $data['u_image4'] = empty($data['image4']) || !is_file(APP_PATH.'/web/images/products/' . $data['image4']) ? '' :
      App::$app->router()->UrlTo('images/products/b_' . $data['image4']);
    $data['u_image5'] = empty($data['image5']) || !is_file(APP_PATH.'/web/images/products/' . $data['image5']) ? '' :
      App::$app->router()->UrlTo('images/products/b_' . $data['image5']);
    $this->template->vars('not_image', $not_image);
    $this->template->vars('data', $data);
    if($return) return $this->template->render_layout_return('images');
    $this->template->render_layout('images');
  }

  /**
   * @param null $data
   * @throws \Exception
   */
  private function images_handling(&$data = null){
    $method = App::$app->post('method');
    if($method == 'images.main') {
      if(!is_null(App::$app->post('idx'))) {
        $idx = App::$app->post('idx');
        $image = $data['image' . $idx];
        $data['image' . $idx] = $data['image1'];
        $data['image1'] = $image;
      }
    } elseif($method == 'images.upload') {
      $idx = !is_null(App::$app->post('idx')) ? App::$app->post('idx') : 1;
      $uploaddir = APP_PATH . '/web/images/products/';
      $file = 't' . uniqid() . '.jpg';
      $ext = strtolower(substr($_FILES['uploadfile']['name'], strpos($_FILES['uploadfile']['name'], '.'), strlen($_FILES['uploadfile']['name']) - 1));
      $filetypes = ['.jpg', '.gif', '.bmp', '.png', '.jpeg'];

      if(!in_array($ext, $filetypes)) {
        $this->template->vars('img_error', 'Error format');
      } else {
        if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $uploaddir . $file)) {
          if(substr($data['image' . $idx], 0, 1) == 't') ModelProduct::delete_img($data['image' . $idx]);
          $data['image' . $idx] = $file;
          ModelProduct::convert_image($uploaddir, $file);
        } else {
          $this->template->vars('img_error', 'Upload error');
        }
      }
    } elseif($method == 'images.delete') {
      $idx = App::$app->post('idx');
      $data['image' . $idx] = '';
    }
    $this->images($data);
  }

  /**
   * @param null $data
   * @throws \Exception
   */
  private function filters_handling(&$data = null){
    $method = App::$app->post('method');
    if($method !== 'filter') {
      if(in_array($method, ['categories', 'colors', 'patterns'])) {
        $this->select_filter($method, array_keys($data[$method]));
      }
    } else {
      if(!is_null(App::$app->post('filter-type'))) {
        $method = App::$app->post('filter-type');
        $resporse = [];

        ModelProduct::get_filter_selected($method, $data);
        $filters = array_keys($data[$method]);
        $resporse[0] = $this->generate_filter($data, $method, true);

        $resporse[1] = null;
        $search = App::$app->post('filter_select_search_' . $method);
        $start = App::$app->post('filter_start_' . $method);
        $filter_limit = (!is_null(App::$app->keyStorage()->system_filter_amount) ? App::$app->keyStorage()->system_filter_amount : FILTER_LIMIT);
        if(!is_null(App::$app->post('down'))) $start = $filter_limit + (isset($start) ? $start : 0);
        if(!is_null(App::$app->post('up'))) $start = (isset($start) ? $start : 0) - $filter_limit;
        if(($start < 0) || (is_null(App::$app->post('down')) && is_null(App::$app->post('up')))) $start = 0;
        if(in_array($method, ['colors', 'patterns', 'categories'])) {
          $resporse[1] = $this->select_filter($method, $filters, $start, $search, true);
        }
        exit(json_encode($resporse));
      } else {
        $method = App::$app->post('type');
        ModelProduct::get_filter_selected($method, $data);
        $this->generate_filter($data, $method);
      }
    }
  }

  /**
   * @param $data
   * @param $type
   * @param bool $return
   * @return string
   * @throws \Exception
   */
  private function generate_filter($data, $type, $return = false){
    $filters = $data[$type];
    $this->template->vars('filters', $filters);
    $this->template->vars('filter_type', $type);
    $this->template->vars('destination', $type);
    $this->template->vars('title', 'Select ' . ucfirst($type));
    if($return) return $this->template->render_layout_return('filter/filter');
    return $this->template->render_layout('filter/filter');
  }

  /**
   * @param $data
   * @param $selected
   * @param bool $return
   * @return string
   * @throws \Exception
   */
  private function generate_select($data, $selected, $return = false){
    $this->template->vars('selected', is_array($selected) ? $selected : [$selected]);
    $this->template->vars('data', is_array($data) ? $data : [$data]);
    if($return) return $this->template->render_layout_return('select');
    return $this->template->render_layout('select');
  }

  /**
   * @param $data
   * @param bool $return
   * @return string
   * @throws \Exception
   */
  private function generate_related($data, $return = false){
    $pid = $data['pid'];
    $rows = null;
    if(isset($pid)) {
      $filter['hidden']['view'] = true;
      $filter['hidden']['a.pid'] = $pid;
      $filter['hidden']['b.image1'] = 'null';
      $res_count_rows = 0;
      $rows = ModelRelated::get_list(0, 0, $res_count_rows, $filter);
    }
    $this->template->vars('rows', $rows);
    $this->template->vars('list', $this->template->render_layout_return('related/rows'));
    if($return) return $this->main->render_layout_return('related/list');
    return $this->main->render_layout('related/list');
  }

  /**
   * @param bool $view
   * @return array|null
   */
  protected function search_fields($view = false){
    return [
      'a.pname', 'a.pvisible', 'a.dt', 'a.pnumber', 'a.piece', 'a.best', 'a.specials', 'b.cid', 'c.id', 'd.id', 'e.id'
    ];
  }

  /**
   * @param $sort
   * @param bool $view
   * @param null $filter
   */
  protected function build_order(&$sort, $view = false, $filter = null){
    parent::build_order($sort, $view, $filter);
    if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
      $sort = ['a.pid' => 'desc'];
    }
  }

  /**
   * @param $data
   */
  protected function load(&$data){
    $data['pid'] = App::$app->get('pid');
    $data['metadescription'] = ModelProduct::sanitize(App::$app->post('metadescription') ? App::$app->post('metadescription') : '');
    $data['metakeywords'] = ModelProduct::sanitize(App::$app->post('metakeywords') ? App::$app->post('metakeywords') : '');
    $data['metatitle'] = ModelProduct::sanitize(App::$app->post('metatitle') ? App::$app->post('metatitle') : '');
    $data['pname'] = ModelProduct::sanitize(App::$app->post('pname') ? App::$app->post('pname') : '');
    $data['pnumber'] = ModelProduct::sanitize(App::$app->post('pnumber')) ? App::$app->post('pnumber') : '';
    $data['width'] = ModelProduct::sanitize(App::$app->post('width')) ? App::$app->post('width') : null;
    $data['priceyard'] = ModelProduct::sanitize(App::$app->post('priceyard')) ? App::$app->post('priceyard') : 0;
    $data['hideprice'] = ModelProduct::sanitize(!is_null(App::$app->post('hideprice'))) ? App::$app->post('hideprice') : 0;
    $data['dimensions'] = ModelProduct::sanitize(App::$app->post('dimensions')) ? App::$app->post('dimensions') : '';
    $data['weight'] = ModelProduct::sanitize(!is_null(App::$app->post('weight'))) ? App::$app->post('weight') : '';
    $data['manufacturerId'] = ModelProduct::sanitize(App::$app->post('manufacturerId')) ? App::$app->post('manufacturerId') : null;
    $data['sdesc'] = ModelProduct::sanitize(App::$app->post('sdesc') ? App::$app->post('sdesc') : '');
    $data['ldesc'] = ModelProduct::sanitize(App::$app->post('ldesc') ? App::$app->post('ldesc') : '');;
    $data['weight_id'] = ModelProduct::sanitize(App::$app->post('weight_id') ? App::$app->post('weight_id') : null);
    $data['colors'] = !is_null(App::$app->post('colors')) ? App::$app->post('colors') : [];
    $data['colors_select'] = !is_null(App::$app->post('colors_select')) ? App::$app->post('colors_select') : [];
    $data['categories'] = !is_null(App::$app->post('categories')) ? App::$app->post('categories') : [];
    $data['categories_select'] = !is_null(App::$app->post('categories_select')) ? App::$app->post('categories_select') : [];
    $data['patterns'] = !is_null(App::$app->post('patterns')) ? App::$app->post('patterns') : [];
    $data['patterns_select'] = !is_null(App::$app->post('patterns_select')) ? App::$app->post('patterns_select') : [];
    $data['specials'] = ModelProduct::sanitize(!is_null(App::$app->post('specials')) ? App::$app->post('specials') : 0);
    $data['pvisible'] = ModelProduct::sanitize(App::$app->post('pvisible') ? App::$app->post('pvisible') : 0);
    $data['best'] = ModelProduct::sanitize(!is_null(App::$app->post('best')) ? App::$app->post('best') : 0);
    $data['piece'] = !is_null(App::$app->post('piece')) ? App::$app->post('piece') : 0;
    $data['whole'] = !is_null(App::$app->post('whole')) ? App::$app->post('whole') : 0;
    $data['stock_number'] = ModelProduct::sanitize(App::$app->post('stock_number') ? App::$app->post('stock_number') : '');
    $data['image1'] = ModelProduct::sanitize(App::$app->post('image1') ? App::$app->post('image1') : '');
    $data['image2'] = ModelProduct::sanitize(App::$app->post('image2') ? App::$app->post('image2') : '');
    $data['image3'] = ModelProduct::sanitize(App::$app->post('image3') ? App::$app->post('image3') : '');
    $data['image4'] = ModelProduct::sanitize(App::$app->post('image4') ? App::$app->post('image4') : '');
    $data['image5'] = ModelProduct::sanitize(App::$app->post('image5') ? App::$app->post('image5') : '');
    $data['inventory'] = !is_null(App::$app->post('inventory')) ? App::$app->post('inventory') : 0;
    $data['related'] = !is_null(App::$app->post('related')) ? App::$app->post('related') : [];
    $data['related_select'] = !is_null(App::$app->post('related_select')) ? App::$app->post('related_select') : [];
  }

  /**
   * @param $data
   * @param $error
   * @return bool|mixed
   */
  protected function validate(&$data, &$error){

    if(empty($data['ldesc']) || empty($data['pnumber']) || empty($data['pname']) || empty($data['priceyard']) || (!empty($data['priceyard']) && empty((float)$data['priceyard'])) || (!empty($data['priceyard']) && ((float)$data['priceyard'] < 0))) {
      $error = [];
      if(empty($data['ldesc'])) $error[] = 'Identify Long Description field !';
      if(empty($data['pnumber'])) $error[] = 'Identify Product Number field !';
      if(empty($data['pname'])) $error[] = 'Identify Product Name field !';
      if(empty($data['priceyard'])) $error[] = 'Identify Price field !';
      if((!empty($data['priceyard']) && empty((float)$data['priceyard'])) || (!empty($data['priceyard']) && ((float)$data['priceyard'] < 0))) $error[] = "The field 'Price' value must be greater than zero!";
      $this->template->vars('error', $error);

      return false;
    }

    return true;
  }

  /**
   * @param $data
   */
  protected function before_save(&$data){
    if(empty($data['sdesc'])) $data['sdesc'] = trim($data['ldesc']);
    if(empty($data['metadescription'])) $data['metadescription'] = $data['sdesc'];
    if(empty($data['metatitle'])) $data['metatitle'] = $data['pname'];
    if(empty($data['metakeywords'])) $data['metakeywords'] = strtolower(implode(',', array_filter(array_map('trim', explode(',', $data['metadescription'])))));
    if(empty($data['image1'])) $data['pvisible'] = 0;
  }

  /**
   * @param null $data
   * @return bool
   * @throws \Exception
   */
  protected function form_handling(&$data = null){
    if(App::$app->request_is_post()) {
      if(!is_null(App::$app->post('method'))) {
        if(explode('.', App::$app->post('method'))[0] == 'images') exit($this->images_handling($data));
        exit($this->filters_handling($data));
      }
    }

    return true;
  }

  /**
   * @param null $data
   * @throws \Exception
   */
  protected function before_form_layout(&$data = null){

    $data['manufacturers'] = ModelProduct::get_manufacturers();
    foreach(['categories', 'colors', 'patterns'] as $type) {
      ModelProduct::get_filter_selected($type, $data);
      $data[$type] = $this->generate_filter($data, $type, true);
    }
    $data['manufacturers'] = $this->generate_select($data['manufacturers'], $data['manufacturerId'], true);
    $this->template->vars('related', $this->generate_related($data, true));
    $this->template->vars('images', $this->images($data, true));
  }

  /**
   * @param $search_data
   * @param bool $view
   * @throws \Exception
   */
  protected function before_search_form_layout(&$search_data, $view = false){
    $categories = [];
    $filter = null;
    $sort = ['a.cname' => 'asc'];
    $rows = ModelCategories::get_list(0, 0, $res_count, $filter, $sort);
    foreach($rows as $row) $categories[$row['cid']] = $row['cname'];
    $patterns = [];
    $sort = ['a.pattern' => 'asc'];
    $rows = ModelPatterns::get_list(0, 0, $res_count, $filter, $sort);
    foreach($rows as $row) $patterns[$row['id']] = $row['pattern'];
    $colors = [];
    $sort = ['a.color' => 'asc'];
    $rows = ModelColors::get_list(0, 0, $res_count, $filter, $sort);
    foreach($rows as $row) $colors[$row['id']] = $row['color'];
    $manufacturers = [];
    $sort = ['a.manufacturer' => 'asc'];
    $rows = ModelManufacturers::get_list(0, 0, $res_count, $filter, $sort);
    foreach($rows as $row) $manufacturers[$row['id']] = $row['manufacturer'];

    $search_data['categories'] = $categories;
    $search_data['patterns'] = $patterns;
    $search_data['colors'] = $colors;
    $search_data['manufacturers'] = $manufacturers;
  }
}