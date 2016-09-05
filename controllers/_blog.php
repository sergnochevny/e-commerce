<?php

class Controller_Blog extends Controller_Base
{

    protected $main;

    function __construct($main)
    {

        $this->main = $main;
        $this->registry = $main->registry;
        $this->template = $main->template;

    }

    function html_split_regex()
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

    function html_split($input)
    {
        return preg_split($this->html_split_regex(), $input, -1, PREG_SPLIT_DELIM_CAPTURE);
    }

    function replace_in_html_tags($haystack, $replace_pairs)
    {
        // Find all elements.
        $textarr = $this->html_split($haystack);
        $changed = false;

        // Optimize when searching for one item.
        if (1 === count($replace_pairs)) {
            // Extract $needle and $replace.
            foreach ($replace_pairs as $needle => $replace) ;

            // Loop through delimiters (elements) only.
            for ($i = 1, $c = count($textarr); $i < $c; $i += 2) {
                if (false !== strpos($textarr[$i], $needle)) {
                    $textarr[$i] = str_replace($needle, $replace, $textarr[$i]);
                    $changed = true;
                }
            }
        } else {
            // Extract all $needles.
            $needles = array_keys($replace_pairs);

            // Loop through delimiters (elements) only.
            for ($i = 1, $c = count($textarr); $i < $c; $i += 2) {
                foreach ($needles as $needle) {
                    if (false !== strpos($textarr[$i], $needle)) {
                        $textarr[$i] = strtr($textarr[$i], $replace_pairs);
                        $changed = true;
                        // After one strtr() break out of the foreach loop and look at next element.
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

    function _autop_newline_preservation_helper($matches)
    {
        return str_replace("\n", "<WPPreserveNewline />", $matches[0]);
    }

    function autop($pee, $br = true)
    {
        $pre_tags = array();

        if (trim($pee) === '')
            return '';

        // Just to make things a little easier, pad the end.
        $pee = $pee . "\n";

        /*
         * Pre tags shouldn't be touched by autop.
         * Replace pre tags with placeholders and bring them back after autop.
         */
        if (strpos($pee, '<pre') !== false) {
            $pee_parts = explode('</pre>', $pee);
            $last_pee = array_pop($pee_parts);
            $pee = '';
            $i = 0;

            foreach ($pee_parts as $pee_part) {
                $start = strpos($pee_part, '<pre');

                // Malformed html?
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
        // Change multiple <br>s into two line breaks, which will turn into paragraphs.
        $pee = preg_replace('|<br\s*/?>\s*<br\s*/?>|', "\n\n", $pee);

        $allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';

        // Add a single line break above block-level opening tags.
        $pee = preg_replace('!(<' . $allblocks . '[\s/>])!', "\n$1", $pee);

        // Add a double line break below block-level closing tags.
        $pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);

        // Standardize newline characters to "\n".
        $pee = str_replace(array("\r\n", "\r"), "\n", $pee);

        // Find newlines in all elements and add placeholders.
        $pee = $this->replace_in_html_tags($pee, array("\n" => " <!-- wpnl --> "));

        // Collapse line breaks before and after <option> elements so they don't get autop'd.
        if (strpos($pee, '<option') !== false) {
            $pee = preg_replace('|\s*<option|', '<option', $pee);
            $pee = preg_replace('|</option>\s*|', '</option>', $pee);
        }

        /*
         * Collapse line breaks inside <object> elements, before <param> and <embed> elements
         * so they don't get autop'd.
         */
        if (strpos($pee, '</object>') !== false) {
            $pee = preg_replace('|(<object[^>]*>)\s*|', '$1', $pee);
            $pee = preg_replace('|\s*</object>|', '</object>', $pee);
            $pee = preg_replace('%\s*(</?(?:param|embed)[^>]*>)\s*%', '$1', $pee);
        }

        /*
         * Collapse line breaks inside <audio> and <video> elements,
         * before and after <source> and <track> elements.
         */
        if (strpos($pee, '<source') !== false || strpos($pee, '<track') !== false) {
            $pee = preg_replace('%([<\[](?:audio|video)[^>\]]*[>\]])\s*%', '$1', $pee);
            $pee = preg_replace('%\s*([<\[]/(?:audio|video)[>\]])%', '$1', $pee);
            $pee = preg_replace('%\s*(<(?:source|track)[^>]*>)\s*%', '$1', $pee);
        }

        // Remove more than two contiguous line breaks.
        $pee = preg_replace("/\n\n+/", "\n\n", $pee);

        // Split up the contents into an array of strings, separated by double line breaks.
        $pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);

        // Reset $pee prior to rebuilding.
        $pee = '';

        // Rebuild the content as a string, wrapping every bit with a <p>.
        foreach ($pees as $tinkle) {
            $pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
        }

        // Under certain strange conditions it could create a P of entirely whitespace.
        $pee = preg_replace('|<p>\s*</p>|', '', $pee);

        // Add a closing <p> inside <div>, <address>, or <form> tag if missing.
        $pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);

        // If an opening or closing block element tag is wrapped in a <p>, unwrap it.
        $pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);

        // In some cases <li> may get wrapped in <p>, fix them.
        $pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee);

        // If a <blockquote> is wrapped with a <p>, move it inside the <blockquote>.
        $pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
        $pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);

        // If an opening or closing block element tag is preceded by an opening <p> tag, remove it.
        $pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);

        // If an opening or closing block element tag is followed by a closing <p> tag, remove it.
        $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);

        // Optionally insert line breaks.
        if ($br) {
            // Replace newlines that shouldn't be touched with a placeholder.
            $pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', [$this, '_autop_newline_preservation_helper'], $pee);

            // Normalize <br>
            $pee = str_replace(array('<br>', '<br/>'), '<br />', $pee);

            // Replace any new line characters that aren't preceded by a <br /> with a <br />.
            $pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee);

            // Replace newline placeholders with newlines.
            $pee = str_replace('<WPPreserveNewline />', "\n", $pee);
        }

        // If a <br /> tag is after an opening or closing block tag, remove it.
        $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);

        // If a <br /> tag is before a subset of opening or closing block tags, remove it.
        $pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
        $pee = preg_replace("|\n</p>$|", '</p>', $pee);

        // Replace placeholder <pre> tags with their original content.
        if (!empty($pre_tags))
            $pee = str_replace(array_keys($pre_tags), array_values($pre_tags), $pee);

        // Restore newlines in all elements.
        if (false !== strpos($pee, '<!-- wpnl -->')) {
            $pee = str_replace(array(' <!-- wpnl --> ', '<!-- wpnl -->'), "\n", $pee);
        }

        return $pee;
    }

    function convertation($txt)
    {

        $base_url = BASE_URL;
//        $txt = preg_replace('#(\s*\[caption[^\]]+\]<a[^>]+><img[^>]+\/><\/a>)(.*?)(\[\/caption\]\s*)#i', '$1<p>$2</p>$3', $txt);
//        $txt = preg_replace('#\[caption([^\]]+)\]#i', '<div$1 class="div_img">', $txt);
//        $txt = preg_replace('#\[\/caption\]#i', '</div>', $txt);
//        $txt = preg_replace('#<a[^>]+>(<img[^>]+\/>)<\/a>#i', '$1', $txt);
//        $txt = preg_replace('#\s*<a[^>]+href ?= ?"http:\/\/www.iluvfabrix[^><]+>(.*)<\/a>\s*#isU', '$1', $txt);
//        $txt = str_replace('http://iluvfabrix.com/blog/wp-content/uploads', '{base_url}/img', $txt);
//        $txt = str_replace('http://www.iluvfabrix.com/blog/wp-content/uploads', '{base_url}/img', $txt);
//        $txt = str_replace('http://iluvfabrix.com', '{base_url}', $txt);
        $txt = str_replace($base_url, '{base_url}', $txt);
//        $txt = str_replace('http://www.iluvfabrix.com', '{base_url}', $txt);
//        $txt = str_replace(['‘', '’'], "'", $txt);
//        $txt = str_replace(" ", " ", $txt);
//        $txt = str_replace('–', "-", $txt);
//        $txt = str_replace('Â ', "", $txt);
//        $txt = str_replace(' Â', "", $txt);
//        $txt = str_replace('Â', "", $txt);

        $txt = $this->autop($txt);

        return $txt;
    }

    function post()
    {
        $model = new Model_Users();

//        $this->widget_new_products();
//        $this->widget_best_products();
//        $this->widget_bsells_products();

        $base_url = BASE_URL;

        $url = 'blog';
        $back_url = $base_url . '/' . $url;
        if (!empty($_GET['page'])) {
            $back_url .= '?page=' . $_GET['page'];
        }
        if ((!empty($_GET['cat']))) {
            $back_url .= (!empty($_GET['page'])) ? '&' : '?';
            $back_url .= 'cat=' . $_GET['cat'];
        }
        $this->template->vars('back_url', $back_url);

        $post_name = explode('/', $_REQUEST['route'])[1];

        $row = $model->get_blog_post_by_post_name($post_name);
        if (isset($row)) {
            ob_start();
            date_default_timezone_set('UTC');
            $post_id = $row['ID'];
            $_GET['post_id'] = $post_id;
            $post_content = stripslashes($row['post_content']);
            $post_title = stripslashes($row['post_title']);
            $post_date = date('F jS, Y', strtotime($row['post_date']));
            $post_content = str_replace('{base_url}', $base_url, $post_content);
            $post_content = preg_replace('#(style="[^>]*")#U','',$post_content);
            $post_img = $model->getPostImg($post_id);
            $file_img = str_replace('{base_url}/', '', $post_img);
            if (file_exists($file_img) && is_file($file_img) && is_readable($file_img)) {
                $post_img = str_replace('{base_url}', $base_url, $post_img);
            } else
                $post_img = null;

            include('./views/index/blog/blog_post.php');

            $list = ob_get_contents();
            ob_end_clean();
            $this->template->vars('catigori_name', isset($catigori_name) ? $catigori_name : null);
        } else
            $list = 'No Post!!';

        $this->template->vars('blog_post', $list);

        $this->main->view('blog/post');
    }

    function main_blog_posts()
    {
        $model = new Model_Users();

        if (!empty($_GET['page'])) {
            $userInfo = $model->validData($_GET['page']);
            $page = $userInfo['data'];
        } else {
            $page = 1;
        }
        $per_page = 6;

        if (!empty($_GET['cat'])) {
            $userInfo = $model->validData($_GET['cat']);
            $cat_id = $userInfo['data'];

            $q_total = "SELECT COUNT(*) FROM `blog_posts` a" .
                " LEFT JOIN blog_group_posts b ON a.ID = b.object_id " .
                " WHERE a.post_status = 'publish' and b.group_id='$cat_id'";
        } else {
            $q_total = "SELECT COUNT(*) FROM `blog_posts` WHERE  post_status = 'publish'";
        }


        $res = mysql_query($q_total);
        $total = mysql_fetch_row($res)[0];

        if ($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
        if ($page <= 0) $page = 1;

        $start = (($page - 1) * $per_page);
        if (!empty($_GET['cat'])) {
            $userInfo = $model->validData($_GET['cat']);
            $cat_id = $userInfo['data'];
            $catigori_name = $model->getPostCatName($cat_id);
            $q = "SELECT a.* FROM `blog_posts` a" .
                " LEFT JOIN blog_group_posts b ON a.ID = b.object_id " .
                " WHERE a.post_status = 'publish' and b.group_id='$cat_id' ORDER BY a.post_date DESC, a.ID DESC LIMIT $start,$per_page";
        } else {
            $q = "SELECT * FROM `blog_posts` WHERE post_status = 'publish' ORDER BY post_date DESC, ID DESC LIMIT $start,$per_page";
        }
        $res = mysql_query($q);
        if ($res) {
            $res_count_rows = mysql_num_rows($res);
            $this->template->vars('count_rows', $res_count_rows);

            ob_start();

            date_default_timezone_set('UTC');

            while ($row = mysql_fetch_assoc($res)) {
                $post_id = $row['ID'];
                $post_name = $row['post_name'];
                $base_url = BASE_URL;

//                $url = 'post?post_id=' . $post_id;
                $url = 'post/' . $post_name;
                $post_href = BASE_URL . '/' . $url;
                if (!empty($_GET['page'])) {
                    $post_href .= '?page=' . $_GET['page'];
                }
                if ((!empty($_GET['cat']))) {
                    $post_href .= (!empty($_GET['page'])) ? '&' : '?';
                    $post_href .= 'cat=' . $_GET['cat'];
                }

                $post_title = stripslashes($row['post_title']);
                $post_date = date('F jS, Y', strtotime($row['post_date']));

                $post_content = $model->getPostDescKeys($post_id);
                if (isset($post_content) && is_array($post_content)) {
                    $post_content = stripslashes($post_content['description']);
                } else {
                    $post_content = stripslashes($row['post_content']);
                    $post_content = substr(strip_tags(str_replace('{base_url}', $base_url, $post_content)), 0, 300);
                    $post_content = preg_replace('#(style="[^>]*")#U','',$post_content);
                }

                $post_img = $model->getPostImg($post_id);
                $filename = str_replace('{base_url}/', '', $post_img);
                if (!(file_exists($filename) && is_file($filename))) {
                    $post_img = '{base_url}/upload/upload/not_image.jpg';
                }

                $post_img = str_replace('{base_url}', $base_url, $post_img);
                include('./views/index/blog/blog_posts.php');
            }

            $list = ob_get_contents();
            ob_end_clean();
            $this->template->vars('catigori_name', isset($catigori_name) ? $catigori_name : null);
            $this->template->vars('blog_posts', $list);

            include_once('controllers/_paginator.php');
            $paginator = new Controller_Paginator($this);
            $paginator->paginator_home($total, $page, 'blog', $per_page);
        } else {
            $this->template->vars('count_rows', 0);
            $list = "No Result!!!";
            $this->template->vars('blog_posts', $list);
        }
    }

    function blog()
    {
        $this->main_blog_posts();
        $this->main->view('blog/blog');
    }

    function admin_main_blog_cat()
    {
        $model = new Model_Users();
        $base_url = BASE_URL;

        $items = $model->get_items_for_menu('blog_category');
        ob_start();
        foreach ($items as $item) {
            $group_id = $item['group_id'];
            $href = $base_url . '/admin_blog?cat=' . $group_id;
            $name = $item['name'];
            include('views/index/blog/blog_admin_cat_select.php');
        }
        $select_cat_option = ob_get_contents();
        ob_end_clean();
        $this->template->vars('select_cat_option', $select_cat_option);
    }

    function admin_main_blog_posts()
    {
        $model = new Model_Users();

        if (!empty($_GET['page'])) {
            $userInfo = $model->validData($_GET['page']);
            $page = $userInfo['data'];
        } else {
            $page = 1;
        }
        $per_page = 6;

        if (!empty($_GET['cat'])) {
            $userInfo = $model->validData($_GET['cat']);
            $cat_id = $userInfo['data'];

            $q_total = "SELECT COUNT(*) FROM `blog_posts` a" .
                " LEFT JOIN blog_group_posts b ON a.ID = b.object_id " .
                " WHERE post_type = 'post' and b.group_id='$cat_id'";
        } else {
            $q_total = "SELECT COUNT(*) FROM `blog_posts` WHERE post_type = 'post'";
        }


        $res = mysql_query($q_total);
        $total = mysql_fetch_row($res)[0];

        if ($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
        if ($page <= 0) $page = 1;

        $start = (($page - 1) * $per_page);
        if (!empty($_GET['cat'])) {
            $userInfo = $model->validData($_GET['cat']);
            $cat_id = $userInfo['data'];
            $catigori_name = $model->getPostCatName($cat_id);
            $q = "SELECT a.* FROM `blog_posts` a" .
                " LEFT JOIN blog_group_posts b ON a.ID = b.object_id " .
                " WHERE post_type = 'post' and b.group_id='$cat_id' ORDER BY a.post_date DESC, a.ID DESC LIMIT $start,$per_page";
        } else {
            $q = "SELECT * FROM `blog_posts` WHERE post_type = 'post' ORDER BY post_date DESC, ID DESC LIMIT $start,$per_page";
        }
        $res = mysql_query($q);
        if ($res) {
            $res_count_rows = mysql_num_rows($res);
            $this->template->vars('count_rows', $res_count_rows);

            ob_start();

            date_default_timezone_set('UTC');

            while ($row = mysql_fetch_assoc($res)) {
                $post_id = $row['ID'];
                $post_name = $row['post_name'];
                $base_url = BASE_URL;

                $url = 'edit_post?post_id=' . $post_id;
                $post_edit_href = $base_url . '/' . $url;
                $url = 'del_post?post_id=' . $post_id;
                $post_del_href = $base_url . '/' . $url;
                if (!empty($_GET['page'])) {
                    $post_edit_href .= '&page=' . $_GET['page'];
                    $post_del_href .= '&page=' . $_GET['page'];
                }
                if ((!empty($_GET['cat']))) {
                    $post_edit_href .= '&cat=' . $_GET['cat'];
                    $post_del_href .= '&cat=' . $_GET['cat'];
                }

                $post_title = stripslashes($row['post_title']);
                $post_date = date('F jS, Y', strtotime($row['post_date']));

                $post_content = $model->getPostDescKeys($post_id);
                if (isset($post_content) && is_array($post_content)) {
                    $post_content = stripslashes($post_content['description']);
                } else {
                    $post_content = stripslashes($row['post_content']);
                    $post_content = substr(strip_tags(str_replace('{base_url}', $base_url, $post_content)), 0, 300);
                    $post_content = preg_replace('#(style="[^>]*")#U','',$post_content);
                }

                $post_img = $model->getPostImg($post_id);
                $filename = str_replace('{base_url}/', '', $post_img);
                if (!(file_exists($filename) && is_file($filename))) {
                    $post_img = '{base_url}/upload/upload/not_image.jpg';
                }

                $post_img = str_replace('{base_url}', $base_url, $post_img);
                include('./views/index/blog/blog_admin_posts.php');
            }

            $list = ob_get_contents();
            ob_end_clean();
            $this->template->vars('cat_name', isset($catigori_name) ? $catigori_name : null);
            $this->template->vars('blog_posts', $list);

            include_once('controllers/_paginator.php');
            $paginator = new Controller_Paginator($this);
            $paginator->paginator_home($total, $page, 'admin_blog', $per_page);
        } else {
            $this->template->vars('count_rows', 0);
            $list = "No Result!!!";
            $this->template->vars('blog_posts', $list);
        }
    }

    function admin_blog_prepapre()
    {
        $model = new Model_Users();

        $new_post_href = BASE_URL . '/new_post';

        $new_post_href .= '?page=';
        if (!empty($_GET['page'])) {
            $new_post_href .= $_GET['page'];
        } else
            $new_post_href .= '1';

        if (!empty($_GET['cat'])) {
            $new_post_href .= '&cat=' . $_GET['cat'];
        }
        $this->template->vars('new_post_href', $new_post_href);


        $this->admin_main_blog_cat();
        $this->admin_main_blog_posts();
    }

    function admin_blog()
    {
        $this->admin_blog_prepapre();
        $this->main->view_admin('blog/blog_admin');
    }

    function admin_blog_content()
    {
        $this->admin_blog_prepapre();
        $this->main->view_layout('blog/blog_admin_content');
    }

    function del_post()
    {
        $model = new Model_Users();
        $userInfo = $model->validData($_GET['post_id']);
        $post_id = $userInfo['data'];
        if (!empty($post_id)) {
            $model->del_post($post_id);
            $warning = ['Article removed successfully!!!'];
            $this->template->vars('warning', $warning);
        } else {
            $error = ['The article failed to remove!!!'];
            $this->template->vars('error', $error);
        }
        $this->admin_blog_content();
    }

    public function get_blog_categories($selected_categories = [])
    {
        $res = '';
        $model = new Model_Users();
        $categories = $model->get_blog_categories();
        ob_start();
        include('views/index/blog/blog_categories_select_options.php');
        $res = ob_get_contents();
        ob_end_clean();
        return $res;
    }

    function new_post_prepare()
    {
        $base_url = BASE_URL;
        $back_url = $base_url . '/admin_blog';
        $back_url .= '?page=';
        if (!empty($_GET['page'])) {
            $back_url .= $_GET['page'];
        } else
            $back_url .= '1';

        if (!empty($_GET['cat'])) {
            $back_url .= '&cat=' . $_GET['cat'];
        }
        $this->template->vars('back_url', $back_url);

        $action_url = $base_url . '/save_new_post';
        $this->template->vars('action_url', $action_url);

        $data['img'] = $this->new_post_img_section();

        $data['categories'] = $this->get_blog_categories();

        $data['title'] = '';
        $data['description'] = '';
        $data['keywords'] = '';
        $data['content'] = '';
        $data['status'] = 'publish';

        $this->template->vars('data', $data);

    }

    function new_post_img_section($img = null)
    {
        $base_url = BASE_URL;
        if (isset($img) && file_exists($img) && is_file($img)) {
            $f_img = $img;
            $img = $base_url . '/' . $img;
        } else {
            $img = $base_url . '/upload/upload/not_image.jpg';
            $f_img = '';
        }
        $this->template->vars('img', $img);
        $this->template->vars('f_img', $f_img);

        ob_start();
        $this->main->view_layout('blog/blog_new_post_img');
        $res = ob_get_contents();
        ob_end_clean();

        return $res;
    }

    function blog_upload_img(){
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

    function new_blog_upload_img()
    {
        $img = $this->blog_upload_img();
        echo $this->new_post_img_section($img);
    }

    function edit_post_imgs($img = null)
    {
        $base_url = BASE_URL;
        if (isset($img) && file_exists($img) && is_file($img)) {
            $f_img = $img;
            $img = $base_url . '/' . $img;
        } else {
            $img = $base_url . '/upload/upload/error_format.png';
            $f_img = '';
        }

        echo json_encode(['img'=>$img, 'f_img'=>$f_img]);

    }

    function edit_blog_upload_img()
    {
        $img = $this->blog_upload_img();
        echo $this->edit_post_imgs($img);
    }

    function new_post()
    {
        $this->new_post_prepare();
        $this->main->view_admin('blog/blog_new_post');
    }

    function save_new_post()
    {

        $base_url = BASE_URL;
        $model = new Model_Users();
        $categories = isset($_POST['categories']) ? $_POST['categories'] : [];
        $keywords = isset($_POST['keywords']) ? $_POST['keywords'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $img = isset($_POST['img']) ? $_POST['img'] : null;
        $content = isset($_POST['content']) ? $_POST['content'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : 'unpublish';

        if (isset($img) && empty($img{0})) $img = null;
        if (empty($title{0}) || empty($description{0}) ||
            !isset($img) || empty($content{0}) ||
            (count($categories) == 0)
        ) {

            $action_url = $base_url . '/save_new_post';
            $this->template->vars('action_url', $action_url);

            $data['img'] = $this->new_post_img_section($img);
            $data['categories'] = $this->get_blog_categories($categories);

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
        $this->main->view_layout('blog/blog_new_post_form');
    }

    function edit_post_prepare()
    {
        $model = new Model_Users();

        $base_url = BASE_URL;

        $url = 'admin_blog';
        $back_url = $base_url . '/' . $url;
        if (!empty($_GET['page'])) {
            $back_url .= '?page=' . $_GET['page'];
        }
        if ((!empty($_GET['cat']))) {
            $back_url .= (!empty($_GET['page'])) ? '&' : '?';
            $back_url .= 'cat=' . $_GET['cat'];
        }
        $this->template->vars('back_url', $back_url);

        $post_id = $_GET['post_id'];

        $row = $model->get_blog_post_by_post_id($post_id);
        if (isset($row)) {
            $categories = $model->get_post_categories_by_post_id($post_id);
            $post_categories = $this->get_blog_categories($categories);
            $post_k_d = $model->getPostDescKeys($post_id);
            $post_description = stripslashes($post_k_d['description']);
            $post_keywords = stripslashes($post_k_d['keywords']);
            $action_url = $base_url . '/save_edit_post?post_id=' . $post_id;
            $post_content = stripslashes($row['post_content']);
            $post_content = str_replace('{base_url}', $base_url, $post_content);
            $post_content = preg_replace('#(style="[^>]*")#U','',$post_content);
            $post_title = stripslashes($row['post_title']);
            $post_status = $row['post_status'];
            date_default_timezone_set('UTC');
            $post_date = date('F jS, Y', strtotime($row['post_date']));
            $post_img = $model->getPostImg($post_id);
            $file_img = str_replace('{base_url}/', '', $post_img);
            if (file_exists($file_img) && is_file($file_img) && is_readable($file_img)) {
                $post_img = str_replace('{base_url}', $base_url, $post_img);
            } else {
                $post_img = $base_url . '/upload/upload/not_image.jpg';
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

    function edit_post()
    {
        $this->edit_post_prepare();
        $this->main->view_admin('blog/blog_edit_post');
    }

    function save_edit_post()
    {

        $base_url = BASE_URL;
        $model = new Model_Users();
        $post_id = $_GET['post_id'];
        $categories = isset($_POST['categories']) ? $_POST['categories'] : [];
        $keywords = isset($_POST['keywords']) ? $_POST['keywords'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $img = isset($_POST['img']) ? $_POST['img'] : null;
        $content = isset($_POST['content']) ? $_POST['content'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : 'unpublish';
        $date = isset($_POST['date']) ? $_POST['date'] : date('F jS, Y');

        if (isset($img) && empty($img{0})) $img = null;
        if ( empty($title{0}) || empty($description{0}) ||
            !isset($img) || empty($content{0}) ||
            (count($categories) == 0)
        ) {

            $action_url = $base_url . '/save_edit_post?post_id=' . $post_id;
            $post_categories = $this->get_blog_categories($categories);
            $post_description = stripslashes($description);
            $post_keywords = stripslashes($keywords);
            $post_content = stripslashes($content);
            $post_title = stripslashes($title);
            $post_status = $status;
            $post_date = stripslashes($date);
            $post_content = str_replace('{base_url}', $base_url, $post_content);

            $file_img = $img;
            if (file_exists($file_img) && is_file($file_img) && is_readable($file_img)) {
                $post_img = '{base_url}/'.$file_img;
                $post_img = str_replace('{base_url}', $base_url, $post_img);
            } else {
                $post_img = $base_url . '/upload/upload/not_image.jpg';
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
            $img = '{base_url}/' . $img;
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
//        $this->main->view_layout('blog/blog_edit_post_form');
        $this->main->view_layout('blog/edit_blog_alert');
    }
}