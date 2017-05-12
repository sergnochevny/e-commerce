<?php

  class Controller_Blog extends Controller_FormSimple {

    protected $id_field = 'id';
    protected $name_field = 'post_title';
    protected $data_field = 'dt';

    protected $form_title_add = 'WRITE NEW POST';
    protected $form_title_edit = 'EDIT POST';

    private static function autop($pee, $br = true) {
      $pre_tags = [];

      if(trim($pee) === '')
        return '';

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
        $pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', ['static', '_autop_newline_preservation_helper'], $pee);
        $pee = str_replace(['<br>', '<br/>'], '<br />', $pee);
        $pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee);
        $pee = str_replace('<WPPreserveNewline />', "\n", $pee);
      }
      $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
      $pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
      $pee = preg_replace("|\n</p>$|", '</p>', $pee);
      if(!empty($pre_tags))
        $pee = str_replace(array_keys($pre_tags), array_values($pre_tags), $pee);
      if(false !== strpos($pee, '<!-- wpnl -->')) {
        $pee = str_replace([' <!-- wpnl --> ', '<!-- wpnl -->'], "\n", $pee);
      }

      return $pee;
    }

    private static function replace_in_html_tags($haystack, $replace_pairs) {
      // Find all elements.
      $textarr = static::html_split($haystack);
      $changed = false;
      if(1 === count($replace_pairs)) {
        foreach($replace_pairs as $needle => $replace)
          ;
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

    private static function html_split($input) {
      return preg_split(static::html_split_regex(), $input, -1, PREG_SPLIT_DELIM_CAPTURE);
    }

    private static function html_split_regex() {
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

    private static function _autop_newline_preservation_helper($matches) {
      return str_replace("\n", "<WPPreserveNewline />", $matches[0]);
    }

    private function select_filter($filters, $start = null, $search = null) {
      $selected = isset($filters) ? $filters : [];
      $filter = Model_Blog::get_filter_data($count, $start, $search);
      $this->template->vars('destination', 'categories');
      $this->template->vars('total', $count);
      $this->template->vars('search', $search);
      $this->template->vars('type', 'categories_select');
      $this->template->vars('filter_type', 'categories');
      $this->template->vars('filter_data_start', isset($start) ? $start : 0);
      $this->template->vars('selected', $selected);
      $this->template->vars('filter', $filter);
      $this->template->view_layout('filter/select');
    }

    private function image($data) {
      $file_img = trim(str_replace('{base_url}', '', $data['img']), '/\\');
      if(basename($file_img) == $file_img) {
        if(file_exists('img/blog/' . $file_img) && is_file('img/blog/' . $file_img) && is_readable('img/blog/' . $file_img)) {
          $data['img'] = _A_::$app->router()->UrlTo('img/blog/' . $file_img);
          $data['file_img'] = $file_img;
        } else {
          $data['img'] = _A_::$app->router()->UrlTo('upload/upload/not_image.jpg');
          $data['file_img'] = '';
        }
      } else {
        if(file_exists($file_img) && is_file($file_img) && is_readable($file_img)) {
          $data['img'] = _A_::$app->router()->UrlTo($file_img);
          $data['file_img'] = $file_img;
        } else {
          $data['img'] = _A_::$app->router()->UrlTo('upload/upload/not_image.jpg');
          $data['file_img'] = '';
        }
      }
      $this->template->vars('data', $data);
      $this->template->view_layout('image');
    }

    private function image_handling(&$data = null) {
      $method = _A_::$app->post('method');
      if($method == 'image.upload') {
        $uploaddir = 'img/blog/';
        $file = 't' . uniqid();
        $ext = substr($_FILES['uploadfile']['name'], strpos($_FILES['uploadfile']['name'], '.'), strlen($_FILES['uploadfile']['name']) - 1);
        $file .= $ext;
        $filetypes = ['.jpg', '.gif', '.bmp', '.png', '.JPG', '.BMP', '.GIF', '.PNG', '.jpeg', '.JPEG'];

        if(!in_array($ext, $filetypes)) {
          $data['error'] = 'Error format';
        } else {
          if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $uploaddir . $file)) {
            if(substr($data['img'], 0, 1) == 't') Model_Blog::delete_img($data['img']);
            $data['img'] = $file;
          } else {
            $data['error'] = 'Error at saving the file!!!';
          }
        }
      }
      $this->image($data);
    }

    private function filters_handling(&$data = null) {
      $method = _A_::$app->post('method');
      if($method !== 'filter') {
        if($method == 'categories') {
          $this->select_filter(array_keys($data[$method]));
        }
      } else {
        if(!is_null(_A_::$app->post('filter-type')) && (_A_::$app->post('filter-type') == 'categories')) {
          $resporse = [];
          ob_start();
          Model_Blog::get_filter_selected($data);
          $filters = array_keys($data['categories']);
          $this->generate_filter($data);
          $resporse[0] = ob_get_contents();
          ob_end_clean();

          ob_start();
          $search = _A_::$app->post('filter_select_search_categories');
          $start = _A_::$app->post('filter_start_categories');
          $filter_limit = (!is_null(_A_::$app->keyStorage()->system_filter_amount) ? _A_::$app->keyStorage()->system_filter_amount : FILTER_LIMIT);
          if(!is_null(_A_::$app->post('down'))) $start = $filter_limit + (isset($start) ? $start : 0);
          if(!is_null(_A_::$app->post('up'))) $start = (isset($start) ? $start : 0) - $filter_limit;
          if(($start < 0) || (is_null(_A_::$app->post('down')) && is_null(_A_::$app->post('up')))) $start = 0;
          $this->select_filter($filters, $start, $search);
          $resporse[1] = ob_get_contents();
          ob_end_clean();
          exit(json_encode($resporse));
        } else {
          Model_Blog::get_filter_selected($data);
          $this->generate_filter($data);
        }
      }
    }

    private function generate_filter($data) {
      $this->template->vars('filters', $data['categories']);
      $this->template->vars('filter_type', 'categories');
      $this->template->vars('destination', 'categories');
      $this->template->vars('title', 'Select Types');
      $this->template->view_layout('filter/filter');
    }

    private function path_img($img) {
      $img = trim(str_replace('{base_url}', '', $img), '/\\');
      if(basename($img) == $img) {
        if(file_exists('img/blog/' . $img) && is_file('img/blog/' . $img) && is_readable('img/blog/' . $img))
          $img = 'img/blog/' . $img;
        else $img = 'upload/upload/not_image.jpg';
      } else {
        if(!(file_exists($img) && is_file($img) && is_readable($img))) {
          $img = 'upload/upload/not_image.jpg';
        }
      }
      return $img;
    }

    protected function build_order(&$sort, $view = false) {
      parent::build_order($sort, $view);
      if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
        $sort = ['post_date' => 'desc'];
      }
    }

    protected function search_fields($view = false) {
      return [
        'a.post_date', 'a.post_title', 'a.post_status',
        'b.group_id',
      ];
    }

    protected function before_save(&$data) {
      if(!isset($data[$this->id_field])) $data['post_author'] = Controller_Admin::get_from_session();
      $data['post_title'] = addslashes(trim(html_entity_decode(($data['post_title']))));
      $data['keywords'] = addslashes(trim(html_entity_decode(($data['keywords']))));
      $data['description'] = addslashes(trim(html_entity_decode(($data['description']))));
      $data['post_content'] = addslashes(html_entity_decode(static::convertation(($data['post_content']))));
    }

    protected function form_handling(&$data = null) {
      if(_A_::$app->request_is_post()) {
        if(!is_null(_A_::$app->post('method'))) {
          if(explode('.', _A_::$app->post('method'))[0] == 'image') exit($this->image_handling($data));
          exit($this->filters_handling($data));
        }
      }
      return true;
    }

    protected function form_after_get_data(&$data = null) {
      $desckeys = Model_Blog::get_desc_keys($data[$this->id_field]);
      $data['description'] = $desckeys['description'];
      $data['keywords'] = $desckeys['keywords'];
      $data['img'] = Model_Blog::get_img($data[$this->id_field]);
    }

    protected function before_form_layout(&$data = null) {
      $data['description'] = stripslashes($data['description']);
      $data['keywords'] = stripslashes($data['keywords']);
      $data['post_content'] = stripslashes($data['post_content']);
      $data['post_content'] = str_replace('{base_url}', _A_::$app->router()->UrlTo('/'), $data['post_content']);
      $data['post_content'] = preg_replace('#(style="[^>]*")#U', '', $data['post_content']);
      $data['post_title'] = stripslashes($data['post_title']);
      $data['post_date'] = date('F jS, Y', strtotime($data['post_date']));

      ob_start();
      Model_Blog::get_filter_selected($data);
      $this->generate_filter($data);
      $data['categories'] = ob_get_contents();
      ob_end_clean();
      ob_start();
      $this->image($data);
      $image = ob_get_contents();
      ob_end_clean();
      $this->template->vars('image', $image);
    }

    protected function build_search_filter(&$filter, $view = false) {
      $res = parent::build_search_filter($filter, $view);
      if($view) {
        $filter = ['a.post_status' => 'publish'];
        if(!empty(_A_::$app->get('cat'))) {
          $filter['b.group_id'] = _A_::$app->get('cat');
        }
      }
      return $res;
    }

    protected function after_get_list(&$rows, $view = false) {
      if(isset($rows)) {
        foreach($rows as $key => $row) {
          $rows[$key]['post_title'] = stripslashes($row['post_title']);
          $rows[$key]['post_date'] = date('F jS, Y', strtotime($row['post_date']));

          $data = Model_Blog::get_desc_keys($row['id']);
          if(isset($row['post_content']) && is_array($row['post_content'])) {
            $data = stripslashes($data['description']);
          } else {
            $data = stripslashes($row['post_content']);
            $data = substr(strip_tags(str_replace('{base_url}', _A_::$app->router()->UrlTo('/'), $data)), 0, 300);
            $data = preg_replace('#(style="[^>]*")#U', '', $data);
          }
          $rows[$key]['description'] = $data;
          $img = Model_Blog::get_img($row['id']);
          $rows[$key]['img'] = _A_::$app->router()->UrlTo($this->path_img($img));
        }
      }
    }

    protected function load(&$data) {
      $data['id'] = _A_::$app->get($this->id_field);
      $data['categories'] = !is_null(_A_::$app->post('categories')) ? _A_::$app->post('categories') : [];
      $data['keywords'] = !is_null(_A_::$app->post('keywords')) ? _A_::$app->post('keywords') : '';
      $data['post_title'] = !is_null(_A_::$app->post('post_title')) ? _A_::$app->post('post_title') : '';
      $data['description'] = !is_null(_A_::$app->post('description')) ? _A_::$app->post('description') : '';
      $data['img'] = !is_null(_A_::$app->post('img')) ? _A_::$app->post('img') : null;
      $data['post_content'] = !is_null(_A_::$app->post('post_content')) ? _A_::$app->post('post_content') : '';
      $data['post_status'] = !is_null(_A_::$app->post('post_status')) ? _A_::$app->post('post_status') : 'unpublish';
      $data['post_author'] = !is_null(_A_::$app->post('post_author')) ? _A_::$app->post('post_author') : 1;
      $data['post_date'] = !is_null(_A_::$app->post('post_date')) ? _A_::$app->post('post_date') : date('F jS, Y');
      $data['categories_select'] = !is_null(_A_::$app->post('categories_select')) ? _A_::$app->post('categories_select') : [];
    }

    protected function validate(&$data, &$error) {
      if(empty($data['post_title']) || empty($data['description']) ||
        empty($data['img']) || empty($data['post_content']) || (count($data['categories']) == 0)
      ) {
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

    protected function before_list_layout($view = false) {
      if(!empty(_A_::$app->get('cat'))) {
        $category_name = Model_Blogcategory::get_by_id(_A_::$app->get('cat'))['name'];
        if(!empty($category_name)) {
          $this->template->setMeta('description', $category_name);
          $this->template->setMeta('keywords', strtolower($category_name) . ',' . implode(',', array_filter(explode(' ', strtolower($category_name)))));
          $this->template->setMeta('title', $category_name);
        }
      }
      $this->main->template->vars('category_name', isset($category_name) ? $category_name : null);
    }

    protected function before_search_form_layout(&$search_data, $view = false) {
      $categories = [];
      $rows = Model_Blogcategory::get_list(0, 0, $res_count);
      foreach($rows as $row) $categories[$row['id']] = $row['name'];

      $search_data['categories'] = $categories;
    }

    protected function after_get_data_item_view(&$data) {
      $prms = null;
      if((!empty(_A_::$app->get('cat')))) $prms['cat'] = _A_::$app->get('cat');
      $this->main->template->vars('back_url', _A_::$app->router()->UrlTo('blog/view', $prms));
      if(isset($data)) {
        $data['post_content'] = stripslashes($data['post_content']);
        $data['post_title'] = stripslashes($data['post_title']);
        $data['post_date'] = date('F jS, Y', strtotime($data['post_date']));
        $data['post_content'] = str_replace('{base_url}', _A_::$app->router()->UrlTo('/'), $data['post_content']);
        $data['post_content'] = preg_replace('#(style="[^>]*")#U', '', $data['post_content']);
        $img = Model_Blog::get_img($data['id']);
        $data['img'] = _A_::$app->router()->UrlTo($this->path_img($img));
        if(!empty($data['post_title'])) $this->template->setMeta('title', $data['post_title']);
        if(isset($data[$this->id_field])) {
          $desckeys = Model_Blog::get_desc_keys($data[$this->id_field]);
          if(!empty($desckeys['description'])) $this->template->setMeta('description', $desckeys['description']);
          if(!empty($desckeys['keywords'])) $this->template->setMeta('keywords', $desckeys['keywords']);
        }
      }
    }

    protected function build_sitemap_url($row, $view) {
      $prms = [$this->id_field => $row[$this->id_field]];
      $url = 'blog' . ($view ? '/view' : '');
      $sef = $row[$this->name_field];
      return _A_::$app->router()->UrlTo($url, $prms, $sef);
    }

    protected function build_back_url(&$back_url = null, &$prms = null) {
      parent::build_back_url($back_url, $prms);
      $back_url .= (!Controller_Admin::is_logged()) ? '/view' : '';
    }

    public static function sitemap_view() { return true; }

    public static function sitemap_order() { return 7; }

    public static function convertation($txt) {

//        $txt = preg_replace('#(\s*\[caption[^\]]+\]<a[^>]+><img[^>]+\/><\/a>)(.*?)(\[\/caption\]\s*)#i', '$1<p>$2</p>$3', $txt);
//        $txt = preg_replace('#\[caption([^\]]+)\]#i', '<div$1 class="div_img">', $txt);
//        $txt = preg_replace('#\[\/caption\]#i', '</div>', $txt);
//        $txt = preg_replace('#<a[^>]+>(<img[^>]+\/>)<\/a>#i', '$1', $txt);
//        $txt = preg_replace('#\s*<a[^>]+href ?= ?"http:\/\/www.iluvfabrix[^><]+>(.*)<\/a>\s*#isU', '$1', $txt);
//        $txt = str_replace('http://iluvfabrix.com/blog/wp-content/uploads', '{base_url}/img', $txt);
//        $txt = str_replace('http://www.iluvfabrix.com/blog/wp-content/uploads', '{base_url}/img', $txt);
//        $txt = str_replace('http://iluvfabrix.com', '{base_url}', $txt);

      $txt = str_replace(_A_::$app->router()->UrlTo('/'), '{base_url}', $txt);
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