<?php

class Controller_Blog extends Controller_Controller
{

    public function post()
    {
        $model = new Model_Blog();

//        $this->widget_new_products();
//        $this->widget_best_products();
//        $this->widget_bsells_products();

        $prms = null;
        if (!empty(_A_::$app->get('page'))) {
            $prms['page'] = _A_::$app->get('page');
        }
        if ((!empty(_A_::$app->get('cat')))) {
            $prms['cat'] = _A_::$app->get('cat');
        }
        $this->main->template->vars('back_url', _A_::$app->router()->UrlTo('blog', $prms));

//        $post_name = _A_::$app->router()->args[0];
//        $row = $model->get_blog_post_by_post_name($post_name);
        $post_id = _A_::$app->get('id');
        $row = $model->get_blog_post_by_post_id($post_id);
        if (isset($row)) {
            ob_start();

//            $post_id = $row['ID'];
//            _A_::$app->get('post_id', $post_id);

            $post_content = stripslashes($row['post_content']);
            $post_title = stripslashes($row['post_title']);
            $post_date = date('F jS, Y', strtotime($row['post_date']));
            $post_content = str_replace('{base_url}', _A_::$app->router()->UrlTo('/'), $post_content);
            $post_content = preg_replace('#(style="[^>]*")#U', '', $post_content);
            $post_img = $model->getPostImg($post_id);
            $file_img = str_replace('{base_url}/', '', $post_img);
            if (file_exists($file_img) && is_file($file_img) && is_readable($file_img)) {
                $post_img = _A_::$app->router()->UrlTo($post_img);
            } else
                $post_img = null;

            $this->template->vars('post_img', $post_img);
            $this->template->vars('file_img', $file_img);
            $this->template->vars('post_content', $post_content);
            $this->template->vars('post_date', $post_date);
            $this->template->vars('post_title', $post_title);
            $this->template->vars('post_id', $post_id);
            $this->template->vars('post_img', $post_img);

            $this->template->view_layout('post_content');

            $list = ob_get_contents();
            ob_end_clean();
            $this->main->template->vars('category_name', isset($category_name) ? $category_name : null);
        } else
            $list = 'No Post!!';
        $this->main->template->vars('blog_post', $list);
        $this->main->view('post');
    }

    public function blog()
    {
        $this->posts();
        $this->main->view('blog');
    }

    private function posts()
    {
        $model = new Model_Blog();

        $page = !empty(_A_::$app->get('page')) ? $model->validData(_A_::$app->get('page')) : 1;
        $per_page = 6;
        $cat_id = null;
        if (!empty(_A_::$app->get('cat'))) {
            $cat_id = $model->validData(_A_::$app->get('cat'));
            $category_name = $model->getPostCatName($cat_id);
        }

        $total = $model->get_count_publish_posts($cat_id);
        if ($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
        if ($page <= 0) $page = 1;
        $start = (($page - 1) * $per_page);

        $rows = $model->get_publish_post_list($cat_id, $start, $per_page, $res_count_rows);
        if ($rows) {
            $this->template->vars('count_rows', $res_count_rows);

            ob_start();

            foreach ($rows as $row) {
                $post_id = $row['ID'];
                $post_name = $row['post_name'];
                $base_url = _A_::$app->router()->UrlTo('/');
                $prms = ['id' => $post_id];
                if (!empty(_A_::$app->get('page'))) {
                    $prms['page'] = _A_::$app->get('page');
                }
                if ((!empty(_A_::$app->get('cat')))) {
                    $prms['cat'] = _A_::$app->get('cat');
                }
                $post_href = _A_::$app->router()->UrlTo('blog/post', $prms);
//                $prms = null;
//                if (!empty(_A_::$app->get('page'))) {
//                    $prms['page'] = _A_::$app->get('page');
//                }
//                if ((!empty(_A_::$app->get('cat')))) {
//                    $prms['cat'] = _A_::$app->get('cat');
//                }
//                $url = _A_::$app->router()->UrlTo('blog/post/' . $post_name);
//                $post_href = _A_::$app->router()->UrlTo('blog/post/' . $post_name, $prms);
                $post_title = stripslashes($row['post_title']);
                $post_date = date('F jS, Y', strtotime($row['post_date']));

                $post_content = $model->getPostDescKeys($post_id);
                if (isset($post_content) && is_array($post_content)) {
                    $post_content = stripslashes($post_content['description']);
                } else {
                    $post_content = stripslashes($row['post_content']);
                    $post_content = substr(strip_tags(str_replace('{base_url}', $base_url, $post_content)), 0, 300);
                    $post_content = preg_replace('#(style="[^>]*")#U', '', $post_content);
                }

                $post_img = $model->getPostImg($post_id);
                $filename = str_replace('{base_url}/', '', $post_img);
                if (!(file_exists($filename) && is_file($filename))) {
                    $post_img = '{base_url}/upload/upload/not_image.jpg';
                }
                $post_img = _A_::$app->router()->UrlTo($post_img);

                $this->template->vars('post_name', $post_name);
                $this->template->vars('post_img', $post_img);
                $this->template->vars('filename', $filename);
                $this->template->vars('post_content', $post_content);
                $this->template->vars('post_date', $post_date);
                $this->template->vars('post_title', $post_title);
                $this->template->vars('post_id', $post_id);
                $this->template->vars('post_href', $post_href);
                $this->template->vars('base_url', $base_url);

                $this->template->view_layout('posts');
            }

            $list = ob_get_contents();
            ob_end_clean();
            $this->main->template->vars('category_name', isset($category_name) ? $category_name : null);
            $this->main->template->vars('blog_posts', $list);
            (new Controller_Paginator($this))->paginator($total, $page, 'blog', $per_page);
        } else {
            $this->main->template->vars('count_rows', 0);
            $list = "No Result!!!";
            $this->main->template->vars('blog_posts', $list);
        }
    }

    public function admin()
    {
        $this->admin_prepapre();
        $this->main->view_admin('blog_admin');
    }

    private function admin_prepapre()
    {
        $prms['page'] = (!empty(_A_::$app->get('page'))) ? _A_::$app->get('page') : '1';
        if (!empty(_A_::$app->get('cat'))) {
            $prms['cat'] = _A_::$app->get('cat');
        }
        $this->template->vars('new_post_href', _A_::$app->router()->UrlTo('blog/add', $prms));
        $this->admin_cat();
        $this->admin_posts();
    }

    function admin_cat()
    {
        $model = new Model_Tools();
        $base_url = _A_::$app->router()->UrlTo('/');

        $items = $model->get_items_for_menu('blog_category');
        ob_start();
        foreach ($items as $item) {
            $group_id = $item['group_id'];
            $href = _A_::$app->router()->UrlTo('blog/admin', ['cat' => $group_id]);
            $name = $item['name'];

            $this->template->vars('base_url', $base_url);
            $this->template->vars('group_id', $group_id);
            $this->template->vars('href', $href);
            $this->template->vars('name', $name);
            $this->template->view_layout('admin_cat_select');
        }
        $select_cat_option = ob_get_contents();
        ob_end_clean();
        $this->template->vars('select_cat_option', $select_cat_option);
    }

    function admin_posts()
    {
        $model = new Model_Blog();

        $page = 1;
        if (!empty(_A_::$app->get('page'))) {
            $page = $model->validData(_A_::$app->get('page'));
        }
        $per_page = 6;

        $cat_id = null;
        if (!empty(_A_::$app->get('cat'))) {
            $cat_id = $model->validData(_A_::$app->get('cat'));
            $category_name = $model->getPostCatName($cat_id);
        }

        $total = $model->get_count_posts($cat_id);
        if ($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
        if ($page <= 0) $page = 1;
        $start = (($page - 1) * $per_page);

        $rows = $model->get_post_list($cat_id, $start, $per_page, $res_count_rows);
        if ($rows) {
            $this->template->vars('count_rows', $res_count_rows);

            ob_start();
            foreach ($rows as $row) {
                $post_id = $row['ID'];
                $post_name = $row['post_name'];
                $base_url = _A_::$app->router()->UrlTo('/');

                $prms = ['post_id' => $post_id];
                if (!empty(_A_::$app->get('page'))) {
                    $prms['page'] = _A_::$app->get('page');
                }
                if ((!empty(_A_::$app->get('cat')))) {
                    $prms['cat'] = _A_::$app->get('cat');
                }

                $post_edit_href = _A_::$app->router()->UrlTo('blog/edit_post', $prms);
                $post_del_href = _A_::$app->router()->UrlTo('blog/del_post', $prms);
                $post_title = stripslashes($row['post_title']);
                $post_date = date('F jS, Y', strtotime($row['post_date']));

                $post_content = $model->getPostDescKeys($post_id);
                if (isset($post_content) && is_array($post_content)) {
                    $post_content = stripslashes($post_content['description']);
                } else {
                    $post_content = stripslashes($row['post_content']);
                    $post_content = substr(strip_tags(str_replace('{base_url}', $base_url, $post_content)), 0, 300);
                    $post_content = preg_replace('#(style="[^>]*")#U', '', $post_content);
                }

                $post_img = $model->getPostImg($post_id);
                $filename = str_replace('{base_url}/', '', $post_img);
                if (!(file_exists($filename) && is_file($filename))) {
                    $post_img = '{base_url}/upload/upload/not_image.jpg';
                }
                $post_img = _A_::$app->router()->UrlTo($post_img);

                $this->template->vars('post_img', $post_img);
                $this->template->vars('post_content', $post_content);
                $this->template->vars('post_date', $post_date);
                $this->template->vars('post_edit_href', $post_edit_href);
                $this->template->vars('post_del_href', $post_del_href);
                $this->template->vars('post_title', $post_date);
                $this->template->vars('post_id', $post_id);
                $this->template->vars('post_name', $post_name);

                $this->template->view_layout('admin_posts');
            }

            $list = ob_get_contents();
            ob_end_clean();
            $this->template->vars('cat_name', isset($category_name) ? $category_name : null);
            $this->template->vars('blog_posts', $list);
            (new Controller_Paginator($this))->paginator($total, $page, 'admin_blog', $per_page);
        } else {
            $this->template->vars('count_rows', 0);
            $list = "No Result!!!";
            $this->template->vars('blog_posts', $list);
        }
    }

    function del()
    {
        $model = new Model_Blog();
        $post_id = $model->validData(_A_::$app->get('post_id'));
        if (!empty($post_id)) {
            $model->del_post($post_id);
            $warning = ['Article removed successfully!!!'];
            $this->template->vars('warning', $warning);
        } else {
            $error = ['The article failed to remove!!!'];
            $this->template->vars('error', $error);
        }
        $this->admin_content();
    }

    private function admin_content()
    {
        $this->admin_prepapre();
        $this->main->view_layout('admin_content');
    }

    public function new_upload_img()
    {
        $img = $this->upload_img();
        echo $this->new_post_img_section($img);
    }

    private function upload_img()
    {
        $img = null;
        $timestamp = time();
        $uploaddir = 'img/blog/';
        $file = $uploaddir . $timestamp . basename($_FILES['uploadfile']['name']);
        $ext = substr($_FILES['uploadfile']['name'], strpos($_FILES['uploadfile']['name'], '.'), strlen($_FILES['uploadfile']['name']) - 1);
        $filetypes = array('.jpg', '.gif', '.bmp', '.png', '.JPG', '.BMP', '.GIF', '.PNG', '.jpeg', '.JPEG');

        if (!in_array($ext, $filetypes)) {
            $error = ['Error format'];
            $this->template->vars('error', $error);
        } else {
            if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {
                $img = $file;
            } else {
                $error = ['Error at saving the file!!!'];
                $this->template->vars('error', $error);
            }
        }
        return $img;
    }

    private function new_post_img_section($img = null)
    {
        $base_url = _A_::$app->router()->UrlTo('/');
        if (isset($img) && file_exists($img) && is_file($img)) {
            $f_img = $img;
            $img = _A_::$app->router()->UrlTo($img);
        } else {
            $img = _A_::$app->router()->UrlTo('upload/upload/not_image.jpg');
            $f_img = '';
        }
        $this->main->template->vars('img', $img);
        $this->main->template->vars('f_img', $f_img);

        ob_start();
        $this->main->view_layout('new_img');
        $res = ob_get_contents();
        ob_end_clean();

        return $res;
    }

    public function edit_upload_img()
    {
        $img = $this->upload_img();
        echo $this->edit_post_imgs($img);
    }

    public function edit_post_imgs($img = null)
    {
        $base_url = _A_::$app->router()->UrlTo('/');
        if (isset($img) && file_exists($img) && is_file($img)) {
            $f_img = $img;
            $img = _A_::$app->router()->UrlTo($img);
        } else {
            $img = _A_::$app->router()->UrlTo('upload/upload/error_format.png');
            $f_img = '';
        }
        echo json_encode(['img' => $img, 'f_img' => $f_img]);

    }

    public function add()
    {
        $this->new_prepare();
        $this->main->view_admin('blog_new_post');
    }

    private function new_prepare()
    {
        $prms['page'] = '1';
        if (!empty(_A_::$app->get('page'))) {
            $prms['page'] = _A_::$app->get('page');
        }
        if (!empty(_A_::$app->get('cat'))) {
            $prms['cat'] = _A_::$app->get('cat');
        }
        $this->template->vars('back_url', _A_::$app->router()->UrlTo('blog/admin', $prms));
        $this->template->vars('action_url', _A_::$app->router()->UrlTo('blog/save_new_post'));
        $data['img'] = $this->new_post_img_section();
        $data['categories'] = $this->get_categories();
        $data['title'] = '';
        $data['description'] = '';
        $data['keywords'] = '';
        $data['content'] = '';
        $data['status'] = 'publish';

        $this->template->vars('data', $data);
    }

    public function get_categories($selected_categories = [])
    {
        $res = '';
        $model = new Model_Blog();
        $categories = $model->get_categories();
        ob_start();
        $this->template->vars('categories', $categories);
        $this->template->view_layout('categories_select_options');
        $res = ob_get_contents();
        ob_end_clean();
        return $res;
    }

    public function save_new()
    {

        $base_url = _A_::$app->router()->UrlTo('/');
        $model = new Model_Blog();
        $categories = !is_null(_A_::$app->post('categories')) ? _A_::$app->post('categories') : [];
        $keywords = !is_null(_A_::$app->post('keywords')) ? _A_::$app->post('keywords') : '';
        $title = !is_null(_A_::$app->post('title')) ? _A_::$app->post('title') : '';
        $description = !is_null(_A_::$app->post('description')) ? _A_::$app->post('description') : '';
        $img = !is_null(_A_::$app->post('img')) ? _A_::$app->post('img') : null;
        $content = !is_null(_A_::$app->post('content')) ? _A_::$app->post('content') : '';
        $status = !is_null(_A_::$app->post('status')) ? _A_::$app->post('status') : 'unpublish';

        if (isset($img) && empty($img{0})) $img = null;
        if (empty($title{0}) || empty($description{0}) ||
            !isset($img) || empty($content{0}) ||
            (count($categories) == 0)
        ) {

            $this->template->vars('action_url', _A_::$app->router()->UrlTo('blog/save_new_post'));

            $data['img'] = $this->new_post_img_section($img);
            $data['categories'] = $this->get_categories($categories);

            $error = [];
            if (empty($title{0})) {
                $error[] = 'Identity Title Field!!';
            }
            if (empty($description{0})) {
                $error[] = 'Identity Description Field!!';
            }
            if (count($categories) == 0) {
                $error[] = 'Select at least one category!!!';
            }
            if (!isset($img)) {
                $error[] = 'Identity Image!!';
            }
            if (empty($content{0})) {
                $error[] = 'Identity Content Field!!';
            }

            $this->template->vars('error', $error);

            $data['title'] = $title;
            $data['description'] = $description;
            $data['keywords'] = $keywords;
            $data['content'] = $content;
            $data['status'] = $status;

            $this->template->vars('data', $data);

        } else {
            $name = $title;
            $title = mysql_real_escape_string(addslashes(trim(html_entity_decode(stripslashes($title)))));
            $keywords = mysql_real_escape_string(addslashes(trim(html_entity_decode(stripslashes($keywords)))));
            $description = mysql_real_escape_string(addslashes(trim(html_entity_decode(stripslashes($description)))));
            $img = '{base_url}/' . $img;
            $name = strtolower(trim(stripslashes($name)));
            $name = preg_replace('#[^\d\w ]+#i', '', $name);
            $name = preg_replace('#[\s]+#i', ' ', $name);
            $name = str_replace(' ', '_', $name);

            $content = mysql_real_escape_string($this->convertation(html_entity_decode(stripslashes($content))));

            $model->save_new_post($title, $keywords, $description, $name, $img, $content, $status, $categories);

            $this->new_post_prepare();
            $warning = ['Article saved successfully!!!'];
            $this->template->vars('warning', $warning);
        }
        $this->main->view_layout('new_form');
    }

    public function convertation($txt)
    {

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

        $txt = $this->autop($txt);

        return $txt;
    }

    private function autop($pee, $br = true)
    {
        $pre_tags = array();

        if (trim($pee) === '')
            return '';

        $pee = $pee . "\n";
        if (strpos($pee, '<pre') !== false) {
            $pee_parts = explode('</pre>', $pee);
            $last_pee = array_pop($pee_parts);
            $pee = '';
            $i = 0;

            foreach ($pee_parts as $pee_part) {
                $start = strpos($pee_part, '<pre');
                if ($start === false) {
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
        $pee = preg_replace('!(<' . $allblocks . '[\s/>])!', "\n$1", $pee);
        $pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
        $pee = str_replace(array("\r\n", "\r"), "\n", $pee);
        $pee = $this->replace_in_html_tags($pee, array("\n" => " <!-- wpnl --> "));
        if (strpos($pee, '<option') !== false) {
            $pee = preg_replace('|\s*<option|', '<option', $pee);
            $pee = preg_replace('|</option>\s*|', '</option>', $pee);
        }
        if (strpos($pee, '</object>') !== false) {
            $pee = preg_replace('|(<object[^>]*>)\s*|', '$1', $pee);
            $pee = preg_replace('|\s*</object>|', '</object>', $pee);
            $pee = preg_replace('%\s*(</?(?:param|embed)[^>]*>)\s*%', '$1', $pee);
        }
        if (strpos($pee, '<source') !== false || strpos($pee, '<track') !== false) {
            $pee = preg_replace('%([<\[](?:audio|video)[^>\]]*[>\]])\s*%', '$1', $pee);
            $pee = preg_replace('%\s*([<\[]/(?:audio|video)[>\]])%', '$1', $pee);
            $pee = preg_replace('%\s*(<(?:source|track)[^>]*>)\s*%', '$1', $pee);
        }
        $pee = preg_replace("/\n\n+/", "\n\n", $pee);
        $pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);
        $pee = '';
        foreach ($pees as $tinkle) {
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
        if ($br) {
            $pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', [$this, '_autop_newline_preservation_helper'], $pee);
            $pee = str_replace(array('<br>', '<br/>'), '<br />', $pee);
            $pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee);
            $pee = str_replace('<WPPreserveNewline />', "\n", $pee);
        }
        $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
        $pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
        $pee = preg_replace("|\n</p>$|", '</p>', $pee);
        if (!empty($pre_tags))
            $pee = str_replace(array_keys($pre_tags), array_values($pre_tags), $pee);
        if (false !== strpos($pee, '<!-- wpnl -->')) {
            $pee = str_replace(array(' <!-- wpnl --> ', '<!-- wpnl -->'), "\n", $pee);
        }

        return $pee;
    }

    private function replace_in_html_tags($haystack, $replace_pairs)
    {
        // Find all elements.
        $textarr = $this->html_split($haystack);
        $changed = false;
        if (1 === count($replace_pairs)) {
            foreach ($replace_pairs as $needle => $replace) ;
            for ($i = 1, $c = count($textarr); $i < $c; $i += 2) {
                if (false !== strpos($textarr[$i], $needle)) {
                    $textarr[$i] = str_replace($needle, $replace, $textarr[$i]);
                    $changed = true;
                }
            }
        } else {
            $needles = array_keys($replace_pairs);
            for ($i = 1, $c = count($textarr); $i < $c; $i += 2) {
                foreach ($needles as $needle) {
                    if (false !== strpos($textarr[$i], $needle)) {
                        $textarr[$i] = strtr($textarr[$i], $replace_pairs);
                        $changed = true;
                        break;
                    }
                }
            }
        }

        if ($changed) {
            $haystack = implode($textarr);
        }

        return $haystack;
    }

    private function html_split($input)
    {
        return preg_split($this->html_split_regex(), $input, -1, PREG_SPLIT_DELIM_CAPTURE);
    }

    private function html_split_regex()
    {
        static $regex;

        if (!isset($regex)) {
            $comments =
                '!'           // Start of comment, after the <.
                . '(?:'         // Unroll the loop: Consume everything until --> is found.
                . '-(?!->)' // Dash not followed by end of comment.
                . '[^\-]*+' // Consume non-dashes.
                . ')*+'         // Loop possessively.
                . '(?:-->)?';   // End of comment. If not found, match all input.

            $cdata =
                '!\[CDATA\['  // Start of comment, after the <.
                . '[^\]]*+'     // Consume non-].
                . '(?:'         // Unroll the loop: Consume everything until ]]> is found.
                . '](?!]>)' // One ] not followed by end of comment.
                . '[^\]]*+' // Consume non-].
                . ')*+'         // Loop possessively.
                . '(?:]]>)?';   // End of comment. If not found, match all input.

            $escaped =
                '(?='           // Is the element escaped?
                . '!--'
                . '|'
                . '!\[CDATA\['
                . ')'
                . '(?(?=!-)'      // If yes, which type?
                . $comments
                . '|'
                . $cdata
                . ')';

            $regex =
                '/('              // Capture the entire match.
                . '<'           // Find start of element.
                . '(?'          // Conditional expression follows.
                . $escaped  // Find end of escaped element.
                . '|'           // ... else ...
                . '[^>]*>?' // Find end of normal element.
                . ')'
                . ')/';
        }

        return $regex;
    }

    public function edit()
    {
        $this->edit_prepare();
        $this->main->view_admin('edit');
    }

    private function edit_prepare()
    {
        $model = new Model_Blog();

        $base_url = _A_::$app->router()->UrlTo('/');

        $prms = null;
        if (!empty(_A_::$app->get('page'))) {
            $prms['page'] = _A_::$app->get('page');
        }
        if ((!empty(_A_::$app->get('cat')))) {
            $prms['cat'] = _A_::$app->get('cat');
        }
        $this->template->vars('back_url', _A_::$app->router()->UrlTo('blog/admin', $prms));

        $post_id = _A_::$app->get('post_id');

        $row = $model->get_blog_post_by_post_id($post_id);
        if (isset($row)) {
            $categories = $model->get_post_categories_by_post_id($post_id);
            $post_categories = $this->get_categories($categories);
            $post_k_d = $model->getPostDescKeys($post_id);
            $post_description = stripslashes($post_k_d['description']);
            $post_keywords = stripslashes($post_k_d['keywords']);
            $action_url = _A_::$app->router()->UrlTo('blog/save_edit_post', ['post_id' => $post_id]);
            $post_content = stripslashes($row['post_content']);
            $post_content = str_replace('{base_url}', $base_url, $post_content);
            $post_content = preg_replace('#(style="[^>]*")#U', '', $post_content);
            $post_title = stripslashes($row['post_title']);
            $post_status = $row['post_status'];
            date_default_timezone_set('UTC');
            $post_date = date('F jS, Y', strtotime($row['post_date']));
            $post_img = $model->getPostImg($post_id);
            $file_img = str_replace('{base_url}', '', $post_img);
            if (file_exists($file_img) && is_file($file_img) && is_readable($file_img)) {
                $post_img = _A_::$app->router()->UrlTo($post_img);
            } else {
                $post_img = _A_::$app->router()->UrlTo('upload/upload/not_image.jpg');
                $file_img = '';
            }

            $this->template->vars('action_url', $action_url);

            $this->template->vars('post_categories', $post_categories);
            $this->template->vars('post_description', $post_description);
            $this->template->vars('post_keywords', $post_keywords);
            $this->template->vars('post_content', $post_content);
            $this->template->vars('post_title', $post_title);
            $this->template->vars('post_status', $post_status);
            $this->template->vars('post_date', $post_date);
            $this->template->vars('post_img', $post_img);
            $this->template->vars('file_img', $file_img);
        }
    }

    public function save_edit()
    {

        $base_url = _A_::$app->router()->UrlTo('/');
        $model = new Model_Blog();
        $post_id = _A_::$app->get('post_id');
        $categories = !is_null(_A_::$app->post('categories')) ? _A_::$app->post('categories') : [];
        $keywords = !is_null(_A_::$app->post('keywords')) ? _A_::$app->post('keywords') : '';
        $title = !is_null(_A_::$app->post('title')) ? _A_::$app->post('title') : '';
        $description = !is_null(_A_::$app->post('description')) ? _A_::$app->post('description') : '';
        $img = !is_null(_A_::$app->post('img')) ? _A_::$app->post('img') : null;
        $content = !is_null(_A_::$app->post('content')) ? _A_::$app->post('content') : '';
        $status = !is_null(_A_::$app->post('status')) ? _A_::$app->post('status') : 'unpublish';
        $date = !is_null(_A_::$app->post('date')) ? _A_::$app->post('date') : date('F jS, Y');

        if (isset($img) && empty($img{0})) $img = null;
        if (empty($title{0}) || empty($description{0}) ||
            !isset($img) || empty($content{0}) ||
            (count($categories) == 0)
        ) {

            $action_url = _A_::$app->router()->UrlTo('save_edit_post', ['post_id' => $post_id]);
            $post_categories = $this->get_categories($categories);
            $post_description = stripslashes($description);
            $post_keywords = stripslashes($keywords);
            $post_content = stripslashes($content);
            $post_title = stripslashes($title);
            $post_status = $status;
            $post_date = stripslashes($date);
            $post_content = str_replace('{base_url}', $base_url, $post_content);

            $file_img = $img;
            if (file_exists($file_img) && is_file($file_img) && is_readable($file_img)) {
                $post_img = '{base_url}' . $file_img;
                $post_img = _A_::$app->router()->UrlTo($post_img);
            } else {
                $post_img = _A_::$app->router()->UrlTo('upload/upload/not_image.jpg');
                $file_img = '';
            }

            $error = [];
            if (empty($title{0})) {
                $error[] = 'Identity Title Field!!';
            }
            if (empty($description{0})) {
                $error[] = 'Identity Description Field!!';
            }
            if (count($categories) == 0) {
                $error[] = 'Select at least one category!!!';
            }
            if (!isset($img)) {
                $error[] = 'Identity Image!!';
            }
            if (empty($content{0})) {
                $error[] = 'Identity Content Field!!';
            }

            $this->template->vars('error', $error);

            $this->template->vars('action_url', $action_url);
            $this->template->vars('post_categories', $post_categories);
            $this->template->vars('post_description', $post_description);
            $this->template->vars('post_keywords', $post_keywords);
            $this->template->vars('post_content', $post_content);
            $this->template->vars('post_title', $post_title);
            $this->template->vars('post_status', $post_status);
            $this->template->vars('post_date', $post_date);
            $this->template->vars('post_img', $post_img);
            $this->template->vars('file_img', $file_img);


        } else {
            $name = html_entity_decode($title);
            $title = mysql_real_escape_string(addslashes(html_entity_decode(trim(stripslashes($title)))));
            $keywords = mysql_real_escape_string(addslashes(trim(html_entity_decode(stripslashes($keywords)))));
            $description = mysql_real_escape_string(addslashes(trim(html_entity_decode(stripslashes($description)))));
            $img = '{base_url}' . $img;
            $name = strtolower(trim(stripslashes($name)));
            $name = preg_replace('#[^\d\w ]+#i', '', $name);
            $name = preg_replace('#[\s]+#i', ' ', $name);
            $name = str_replace(' ', '_', $name);

            $content = mysql_real_escape_string($this->convertation(html_entity_decode(stripslashes($content))));

            $model->save_edit_post($post_id, $title, $keywords, $description, $name, $img, $content, $status, $categories);

            $this->edit_post_prepare();
            $warning = ['Article saved successfully!!!'];
            $this->template->vars('warning', $warning);
        }
        $this->main->view_layout('edit_alert');
    }

    private function _autop_newline_preservation_helper($matches)
    {
        return str_replace("\n", "<WPPreserveNewline />", $matches[0]);
    }

    public function convertcontent(){

        $res = mysql_query('select id, post_content from blog_posts');
        if($res){
            while($row = mysql_fetch_assoc($res)){
                $id = $row['id'];
                $content = mysql_real_escape_string($this->convertation(html_entity_decode(stripslashes($row['post_content']))));
                mysql_query("update blog_posts set post_content = '" . $content . "' where id = ".$id);
            }
        }
    }
}