<?php

namespace controllers;

use app\core\App;
use classes\controllers\ControllerFormSimple;
use classes\helpers\AdminHelper;
use classes\helpers\BlogHelper;
use models\ModelBlog;
use models\ModelBlogCategory;

/**
 * Class ControllerBlog
 */
class ControllerBlog extends ControllerFormSimple{

  /**
   * @var string
   */
  protected $id_field = 'id';
  /**
   * @var string
   */
  protected $name_field = 'post_title';
  /**
   * @var string
   */
  protected $data_field = 'dt';

  /**
   * @var string
   */
  protected $form_title_add = 'WRITE NEW POST';
  /**
   * @var string
   */
  protected $form_title_edit = 'EDIT POST';

  /**
   * @param $filters
   * @param null $start
   * @param null $search
   * @param bool $return
   * @return string
   * @throws \Exception
   */
  private function select_filter($filters, $start = null, $search = null, $return = false){
    $selected = isset($filters) ? $filters : [];
    $filter = ModelBlog::get_filter_data($count, $start, $search);
    $this->template->vars('destination', 'categories');
    $this->template->vars('total', $count);
    $this->template->vars('search', $search);
    $this->template->vars('type', 'categories_select');
    $this->template->vars('filter_type', 'categories');
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
  private function image($data, $return = false){
    $file_img = trim(str_replace('{base_url}', '', $data['img']), '/\\');
    if(basename($file_img) == $file_img) {
      if(file_exists(APP_PATH . '/web/' . 'images/blog/' . $file_img) &&
        is_file(APP_PATH . '/web/' . 'images/blog/' . $file_img) &&
        is_readable(APP_PATH . '/web/' . 'images/blog/' . $file_img)) {
        $data['img'] = App::$app->router()->UrlTo('images/blog/' . $file_img);
        $data['file_img'] = $file_img;
      } else {
        $data['img'] = App::$app->router()->UrlTo('images/products/not_image.jpg');
        $data['file_img'] = '';
      }
    } else {
      if(file_exists(APP_PATH . '/web/' . $file_img) &&
        is_file(APP_PATH . '/web/' . $file_img) &&
        is_readable(APP_PATH . '/web/' . $file_img)) {
        $data['img'] = App::$app->router()->UrlTo($file_img);
        $data['file_img'] = $file_img;
      } else {
        $data['img'] = App::$app->router()->UrlTo('images/products/not_image.jpg');
        $data['file_img'] = '';
      }
    }
    $this->template->vars('data', $data);
    if($return) return $this->template->render_layout_return('image');

    return $this->template->render_layout('image');
  }

  /**
   * @param null $data
   * @throws \Exception
   */
  private function image_handling(&$data = null){
    $method = App::$app->post('method');
    if($method == 'image.upload') {
      $uploaddir = APP_PATH . '/web/images/blog/';
      $file = 't' . uniqid();
      $ext = substr($_FILES['uploadfile']['name'], strpos($_FILES['uploadfile']['name'], '.'), strlen($_FILES['uploadfile']['name']) - 1);
      $file .= $ext;
      $filetypes = ['.jpg', '.gif', '.bmp', '.png', '.JPG', '.BMP', '.GIF', '.PNG', '.jpeg', '.JPEG'];

      if(!in_array($ext, $filetypes)) {
        $data['error'] = 'Error format';
      } else {
        if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $uploaddir . $file)) {
          if(substr($data['img'], 0, 1) == 't') ModelBlog::delete_img($data['img']);
          $data['img'] = $file;
        } else {
          $data['error'] = 'Error at saving the file!!!';
        }
      }
    }
    $this->image($data);
  }

  /**
   * @param null $data
   * @throws \Exception
   */
  private function filters_handling(&$data = null){
    $method = App::$app->post('method');
    if($method !== 'filter') {
      if($method == 'categories') {
        $this->select_filter(array_keys($data[$method]));
      }
    } else {
      if(!is_null(App::$app->post('filter-type')) && (App::$app->post('filter-type') == 'categories')) {
        $resporse = [];
        ModelBlog::get_filter_selected($data);
        $filters = array_keys($data['categories']);
        $resporse[0] = $this->generate_filter($data, true);

        $search = App::$app->post('filter_select_search_categories');
        $start = App::$app->post('filter_start_categories');
        $filter_limit = (!is_null(App::$app->keyStorage()->system_filter_amount) ? App::$app->keyStorage()->system_filter_amount : FILTER_LIMIT);
        if(!is_null(App::$app->post('down'))) $start = $filter_limit + (isset($start) ? $start : 0);
        if(!is_null(App::$app->post('up'))) $start = (isset($start) ? $start : 0) - $filter_limit;
        if(($start < 0) || (is_null(App::$app->post('down')) && is_null(App::$app->post('up')))) $start = 0;
        $resporse[1] = $this->select_filter($filters, $start, $search, true);
        exit(json_encode($resporse));
      } else {
        ModelBlog::get_filter_selected($data);
        $this->generate_filter($data);
      }
    }
  }

  /**
   * @param $data
   * @param bool $return
   * @return string
   * @throws \Exception
   */
  private function generate_filter($data, $return = false){
    $this->template->vars('filters', $data['categories']);
    $this->template->vars('filter_type', 'categories');
    $this->template->vars('destination', 'categories');
    $this->template->vars('title', 'Select Types');
    if($return) return $this->template->render_layout_return('filter/filter');

    return $this->template->render_layout('filter/filter');
  }

  /**
   * @param $img
   * @return string
   */
  private function path_img($img){
    $img = trim(str_replace('{base_url}', '', $img), '/\\');
    if(basename($img) == $img) {
      if(file_exists(APP_PATH . '/web/images/blog/' . $img) &&
        is_file(APP_PATH . '/web/images/blog/' . $img) &&
        is_readable(APP_PATH . '/web/images/blog/' . $img)) $img = 'images/blog/' . $img;
      else $img = 'images/products/not_image.jpg';
    } else {
      if(!(file_exists(APP_PATH . '/web/' . $img) &&
        is_file(APP_PATH . '/web/' . $img) &&
        is_readable(APP_PATH . '/web/' . $img))) {
        $img = 'images/products/not_image.jpg';
      }
    }

    return $img;
  }

  /**
   * @param $sort
   * @param bool $view
   * @param null $filter
   */
  protected function build_order(&$sort, $view = false, $filter = null){
    parent::build_order($sort, $view, $filter);
    if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
      $sort = ['post_date' => 'desc'];
    }
  }

  /**
   * @param bool $view
   * @return array|null
   */
  protected function search_fields($view = false){
    return [
      'a.post_date',
      'a.post_title',
      'a.post_status',
      'b.group_id',
    ];
  }

  /**
   * @param $data
   * @throws \Exception
   */
  protected function before_save(&$data){
    if(!isset($data[$this->id_field])) $data['post_author'] = AdminHelper::get_from_session();
    $data['post_content'] = BlogHelper::convertation(($data['post_content']));
    $data['post_date'] = date('Y-m-d H:i:s', strtotime($data['post_date']));
  }

  /**
   * @param null $data
   * @return bool
   * @throws \Exception
   */
  protected function form_handling(&$data = null){
    if(App::$app->request_is_post()) {
      if(!is_null(App::$app->post('method'))) {
        if(explode('.', App::$app->post('method'))[0] == 'image') exit($this->image_handling($data));
        exit($this->filters_handling($data));
      }
    }

    return true;
  }

  /**
   * @param null $data
   * @throws \Exception
   */
  protected function form_after_get_data(&$data = null){
    $tmp = ModelBlog::get_desc_keys($data[$this->id_field]);
    $data['description'] = $tmp['description'];
    $data['keywords'] = $tmp['keywords'];
    $data['img'] = ModelBlog::get_img($data[$this->id_field]);
  }

  /**
   * @param null $data
   * @throws \Exception
   */
  protected function before_form_layout(&$data = null){
    $data['description'] = stripslashes($data['description']);
    $data['keywords'] = stripslashes($data['keywords']);
    $data['post_content'] = stripslashes($data['post_content']);
    $data['post_content'] = str_replace('{base_url}', App::$app->router()->UrlTo('/'), $data['post_content']);
    $data['post_content'] = preg_replace('#(style="[^>]*")#U', '', $data['post_content']);
    $data['post_title'] = stripslashes($data['post_title']);
    $data['post_date'] = date('F jS, Y', strtotime($data['post_date']));
    ModelBlog::get_filter_selected($data);
    $data['categories'] = $this->generate_filter($data, true);
    $this->template->vars('image', $this->image($data, true));
  }

  /**
   * @param $filter
   * @param bool $view
   * @return array|null
   * @throws \InvalidArgumentException
   */
  protected function build_search_filter(&$filter, $view = false){
    $res = parent::build_search_filter($filter, $view);
    if($view) {
      $filter['hidden']['a.post_status'] = 'publish';
      if(!empty(App::$app->get('cat'))) {
        $filter['b.group_id'] = App::$app->get('cat');
      }
    }

    return $res;
  }

  /**
   * @param $rows
   * @param bool $view
   * @param $filter
   * @param null $search_form
   * @throws \Exception
   */
  protected function after_get_list(&$rows, $view = false, &$filter = null, &$search_form = null){
    if(isset($rows)) {
      foreach($rows as $key => $row) {
        $rows[$key]['post_title'] = stripslashes($row['post_title']);
        $rows[$key]['post_date'] = date('F jS, Y', strtotime($row['post_date']));

        $data = ModelBlog::get_desc_keys($row['id']);
        if(isset($row['post_content']) && is_array($row['post_content'])) {
          $data = stripslashes($data['description']);
        } else {
          $data = stripslashes($row['post_content']);
          $data = substr(strip_tags(str_replace('{base_url}', App::$app->router()->UrlTo('/'), $data)), 0, 300);
          $data = preg_replace('#(style="[^>]*")#U', '', $data);
        }
        $rows[$key]['description'] = $data;
        $img = ModelBlog::get_img($row['id']);
        $rows[$key]['img'] = App::$app->router()->UrlTo($this->path_img($img));
      }
    }
  }

  /**
   * @param $data
   */
  protected function load(&$data){
    $data['id'] = App::$app->get($this->id_field);
    $data['categories'] = !is_null(App::$app->post('categories')) ? App::$app->post('categories') : [];
    $data['keywords'] = !is_null(App::$app->post('keywords')) ? App::$app->post('keywords') : '';
    $data['post_title'] = !is_null(App::$app->post('post_title')) ? App::$app->post('post_title') : '';
    $data['description'] = !is_null(App::$app->post('description')) ? App::$app->post('description') : '';
    $data['img'] = !is_null(App::$app->post('img')) ? App::$app->post('img') : null;
    $data['post_content'] = !is_null(App::$app->post('post_content')) ? App::$app->post('post_content') : '';
    $data['post_status'] = !is_null(App::$app->post('post_status')) ? App::$app->post('post_status') : 'unpublish';
    $data['post_author'] = !is_null(App::$app->post('post_author')) ? App::$app->post('post_author') : 1;
    $data['post_date'] = !is_null(App::$app->post('post_date')) ? App::$app->post('post_date') : date('F jS, Y');
    $data['categories_select'] = !is_null(App::$app->post('categories_select')) ? App::$app->post('categories_select') : [];
  }

  /**
   * @param $data
   * @param $error
   * @return bool|mixed
   */
  protected function validate(&$data, &$error){
    if(empty($data['post_title']) || empty($data['description']) || empty($data['img']) || empty($data['post_content']) || (count($data['categories']) == 0)) {
      $error = [];
      if(empty($data['post_title'])) {
        $error[] = 'Identity Title Field!!';
      }
      if(empty($data['description'])) {
        $error[] = 'Identity Description Field!!';
      }
      if(count($data['categories']) == 0) {
        $error[] = 'Select at least one category!!!';
      }
      if(empty($data['img'])) {
        $error[] = 'Identity Image!!';
      }
      if(empty($data['post_content'])) {
        $error[] = 'Identity Content Field!!';
      }

      return false;
    }

    return true;
  }

  /**
   * @param bool $view
   * @throws \Exception
   */
  protected function before_list_layout($view = false){
    if(!empty(App::$app->get('cat'))) {
      $category_name = ModelBlogCategory::get_by_id(App::$app->get('cat'))['name'];
      if(!empty($category_name)) {
        $this->template->setMeta('description', $category_name);
        $this->template->setMeta('keywords', strtolower($category_name) . ',' . implode(',', array_filter(explode(' ', strtolower($category_name)))));
        $this->template->setMeta('title', $category_name);
      }
    }
    $this->main->template->vars('category_name', isset($category_name) ? $category_name : null);
  }

  /**
   * @param $search_data
   * @param bool $view
   * @throws \Exception
   */
  protected function before_search_form_layout(&$search_data, $view = false){
    $categories = [];
    $rows = ModelBlogCategory::get_list(0, 0, $res_count);
    foreach($rows as $row) $categories[$row['id']] = $row['name'];

    $search_data['categories'] = $categories;
  }

  /**
   * @param $data
   * @throws \Exception
   */
  protected function after_get_data_item_view(&$data){
    $prms = null;
    if((!empty(App::$app->get('cat')))) $prms['cat'] = App::$app->get('cat');
    $this->main->template->vars('back_url', App::$app->router()->UrlTo('blog/view', $prms));
    if(isset($data)) {
      $data['post_content'] = stripslashes($data['post_content']);
      $data['post_title'] = stripslashes($data['post_title']);
      $data['post_date'] = date('F jS, Y', strtotime($data['post_date']));
      $data['post_content'] = str_replace('{base_url}', App::$app->router()->UrlTo('/'), $data['post_content']);
      $data['post_content'] = preg_replace('#(style="[^>]*")#U', '', $data['post_content']);
      $img = ModelBlog::get_img($data['id']);
      $data['img'] = App::$app->router()->UrlTo($this->path_img($img));
      if(!empty($data['post_title'])) $this->template->setMeta('title', $data['post_title']);
      if(isset($data[$this->id_field])) {
        $desckeys = ModelBlog::get_desc_keys($data[$this->id_field]);
        if(!empty($desckeys['description'])) $this->template->setMeta('description', $desckeys['description']);
        if(!empty($desckeys['keywords'])) $this->template->setMeta('keywords', $desckeys['keywords']);
      }
    }
  }

  /**
   * @param $row
   * @param $view
   * @return string
   * @throws \Exception
   */
  protected function build_sitemap_url($row, $view){
    $prms = [$this->id_field => $row[$this->id_field]];
    $url = 'blog' . ($view ? '/view' : '');
    $sef = $row[$this->name_field];

    return App::$app->router()->UrlTo($url, $prms, $sef);
  }

  /**
   * @param null $back_url
   * @param null $prms
   */
  protected function build_back_url(&$back_url = null, &$prms = null){
    parent::build_back_url($back_url, $prms);
    $back_url .= (!AdminHelper::is_logged()) ? '/view' : '';
  }

  /**
   * @return bool
   */
  public static function sitemap_view(){
    return true;
  }

  /**
   * @return int|null
   */
  public static function sitemap_order(){
    return 7;
  }

}