<?php

namespace controllers;

use app\core\App;
use controllers\base\ControllerFormSimple;
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
   * @param $pee
   * @param bool $br
   * @return null|string|string[]
   */
  private static function autop($pee, $br = true){
    $pre_tags = [];

    if(trim($pee) === '') return '';

    $pee = $pee . "\n";
    if(strpos($pee, '<pre') !== false) {
      $pee_parts = explode('</pre>', $pee);
      $last_pee = array_pop($pee_parts);
      $pee = '';
      $i = 0;

      foreach($pee_parts as $pee_part) {
        $start = strpos($pee_part, '<pre');
        if($start === false) {
          $pee .= $pee_part;
          continue;
        }

        $name = "<pre wp-pre-tag-$i></pre>";
        $pre_tags[$name] = substr($pee_part, $start) . '</pre>';

        $pee .= substr($pee_part, 0, $start) . $name;
        $i++;
      }

      $pee .= $last_pee;
    }
    $pee = preg_replace('|<br\s*/?>\s*<br\s*/?>|', "\n\n", $pee);

    $allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';
    $unaryblocks = '(?:img)';
    $pee = preg_replace('!(<' . $allblocks . '[\s/>])!', "\n$1", $pee);
    $pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
    $pee = str_replace(["\r\n", "\r"], "\n", $pee);
    $pee = static::replace_in_html_tags($pee, ["\n" => " <!-- wpnl --> "]);
    if(strpos($pee, '<option') !== false) {
      $pee = preg_replace('|\s*<option|', '<option', $pee);
      $pee = preg_replace('|</option>\s*|', '</option>', $pee);
    }
    if(strpos($pee, '</object>') !== false) {
      $pee = preg_replace('|(<object[^>]*>)\s*|', '$1', $pee);
      $pee = preg_replace('|\s*</object>|', '</object>', $pee);
      $pee = preg_replace('%\s*(</?(?:param|embed)[^>]*>)\s*%', '$1', $pee);
    }
    if(strpos($pee, '<source') !== false || strpos($pee, '<track') !== false) {
      $pee = preg_replace('%([<\[](?:audio|video)[^>\]]*[>\]])\s*%', '$1', $pee);
      $pee = preg_replace('%\s*([<\[]/(?:audio|video)[>\]])%', '$1', $pee);
      $pee = preg_replace('%\s*(<(?:source|track)[^>]*>)\s*%', '$1', $pee);
    }
    $pee = preg_replace("/\n\n+/", "\n\n", $pee);
//      $pee = preg_replace('|<p>\s*</p>|', '', $pee);
    $pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);
    $pee = '';
    foreach($pees as $tinkle) {
      $pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
    }
    $pee = preg_replace('|<p>\s*</p>|', '', $pee);
    $pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);
    $pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
    $pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee);
    $pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
    $pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);
    $pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
    $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
    $pee = preg_replace('!<p>\s*(<' . $unaryblocks . '[^>]*/>)!', "$1", $pee);
    $pee = preg_replace('!(<' . $unaryblocks . '[^>]*/>)\s*</p>!', "$1", $pee);
    if($br) {
      $pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', [
        'static',
        '_autop_newline_preservation_helper'
      ], $pee);
      $pee = str_replace(['<br>', '<br/>'], '<br />', $pee);
      $pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee);
      $pee = str_replace('<WPPreserveNewline />', "\n", $pee);
    }
    $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
    $pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
    $pee = preg_replace("|\n</p>$|", '</p>', $pee);
    if(!empty($pre_tags)) $pee = str_replace(array_keys($pre_tags), array_values($pre_tags), $pee);
    if(false !== strpos($pee, '<!-- wpnl -->')) {
      $pee = str_replace([' <!-- wpnl --> ', '<!-- wpnl -->'], "\n", $pee);
    }

    return $pee;
  }

  /**
   * @param $haystack
   * @param $replace_pairs
   * @return string
   */
  private static function replace_in_html_tags($haystack, $replace_pairs){
    // Find all elements.
    $textarr = static::html_split($haystack);
    $changed = false;
    if(1 === count($replace_pairs)) {
      foreach($replace_pairs as $needle => $replace)
        for($i = 1, $c = count($textarr); $i < $c; $i += 2) {
          if(false !== strpos($textarr[$i], $needle)) {
            $textarr[$i] = str_replace($needle, $replace, $textarr[$i]);
            $changed = true;
          }
        }
    } else {
      $needles = array_keys($replace_pairs);
      for($i = 1, $c = count($textarr); $i < $c; $i += 2) {
        foreach($needles as $needle) {
          if(false !== strpos($textarr[$i], $needle)) {
            $textarr[$i] = strtr($textarr[$i], $replace_pairs);
            $changed = true;
            break;
          }
        }
      }
    }

    if($changed) {
      $haystack = implode($textarr);
    }

    return $haystack;
  }

  /**
   * @param $input
   * @return array[]|false|string[]
   */
  private static function html_split($input){
    return preg_split(static::html_split_regex(), $input, -1, PREG_SPLIT_DELIM_CAPTURE);
  }

  /**
   * @return string
   */
  private static function html_split_regex(){
    static $regex;

    if(!isset($regex)) {
      $comments = '!'           // Start of comment, after the <.
        . '(?:'         // Unroll the loop: Consume everything until --> is found.
        . '-(?!->)' // Dash not followed by end of comment.
        . '[^\-]*+' // Consume non-dashes.
        . ')*+'         // Loop possessively.
        . '(?:-->)?';   // End of comment. If not found, match all input.

      $cdata = '!\[CDATA\['  // Start of comment, after the <.
        . '[^\]]*+'     // Consume non-].
        . '(?:'         // Unroll the loop: Consume everything until ]]> is found.
        . '](?!]>)' // One ] not followed by end of comment.
        . '[^\]]*+' // Consume non-].
        . ')*+'         // Loop possessively.
        . '(?:]]>)?';   // End of comment. If not found, match all input.

      $escaped = '(?='           // Is the element escaped?
        . '!--' . '|' . '!\[CDATA\[' . ')' . '(?(?=!-)'      // If yes, which type?
        . $comments . '|' . $cdata . ')';

      $regex = '/('              // Capture the entire match.
        . '<'           // Find start of element.
        . '(?'          // Conditional expression follows.
        . $escaped  // Find end of escaped element.
        . '|'           // ... else ...
        . '[^>]*>?' // Find end of normal element.
        . ')' . ')/';
    }

    return $regex;
  }

  /**
   * @param $matches
   * @return mixed
   */
  private static function _autop_newline_preservation_helper($matches){
    return str_replace("\n", "<WPPreserveNewline />", $matches[0]);
  }

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
    if($return) return $this->template->view_layout_return('filter/select');
    return $this->template->view_layout('filter/select');
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
    if($return) return $this->template->view_layout_return('image');
    return $this->template->view_layout('image');
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
    if($return) return $this->template->view_layout_return('filter/filter');

    return $this->template->view_layout('filter/filter');
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
    if(!isset($data[$this->id_field])) $data['post_author'] = ControllerAdmin::get_from_session();
    $data['post_title'] = addslashes(trim(html_entity_decode(($data['post_title']))));
    $data['keywords'] = addslashes(trim(html_entity_decode(($data['keywords']))));
    $data['description'] = addslashes(trim(html_entity_decode(($data['description']))));
    $data['post_content'] = addslashes(html_entity_decode(static::convertation(($data['post_content']))));
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
    $desckeys = ModelBlog::get_desc_keys($data[$this->id_field]);
    $data['description'] = $desckeys['description'];
    $data['keywords'] = $desckeys['keywords'];
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
   * @throws \Exception
   */
  protected function after_get_list(&$rows, $view = false){
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
    $back_url .= (!ControllerAdmin::is_logged()) ? '/view' : '';
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

  /**
   * @param $txt
   * @return mixed|null|string|string[]
   * @throws \Exception
   */
  public static function convertation($txt){

//        $txt = preg_replace('#(\s*\[caption[^\]]+\]<a[^>]+><img[^>]+\/><\/a>)(.*?)(\[\/caption\]\s*)#i', '$1<p>$2</p>$3', $txt);
//        $txt = preg_replace('#\[caption([^\]]+)\]#i', '<div$1 class="div_img">', $txt);
//        $txt = preg_replace('#\[\/caption\]#i', '</div>', $txt);
//        $txt = preg_replace('#<a[^>]+>(<img[^>]+\/>)<\/a>#i', '$1', $txt);
//        $txt = preg_replace('#\s*<a[^>]+href ?= ?"http:\/\/www.iluvfabrix[^><]+>(.*)<\/a>\s*#isU', '$1', $txt);
//        $txt = str_replace('http://iluvfabrix.com/blog/wp-content/uploads', '{base_url}/img', $txt);
//        $txt = str_replace('http://www.iluvfabrix.com/blog/wp-content/uploads', '{base_url}/img', $txt);
//        $txt = str_replace('http://iluvfabrix.com', '{base_url}', $txt);

    $txt = str_replace(App::$app->router()->UrlTo('/'), '{base_url}', $txt);
    $txt = str_replace('http://www.iluvfabrix.com', '{base_url}', $txt);
    $txt = preg_replace('#[^ \.]*\.iluvfabrix\.com#i', '{base_url}', $txt);
    $txt = str_replace('{base_url}/', '{base_url}', $txt);
    $txt = str_replace(['‘', '’'], "'", $txt);
    $txt = str_replace(" ", " ", $txt);
    $txt = str_replace('–', "-", $txt);
    $txt = preg_replace('#[^\x{00}-\x{7f}]#i', '', $txt);

    $txt = static::autop($txt);

    return $txt;
  }

}