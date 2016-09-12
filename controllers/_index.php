<?php

Class Controller_Index Extends Controller_Controller
{


//////////////////////////////////////////////////////////// INDEX
    function index()
    {
        $this->main->view('index');
    }

    function admin_home()
    {
//        session_destroy();
//        unset($_SESSION);
        $this->main->test_access_rights();
        $shop = new Controller_Shop($this->main);
        $shop->produkt_list();
        $shop->produkt_filtr_list();

        $this->main->view_admin('admin_home');
    }

//////////////////////////////////////////////////////////// AUTHORIZATION

    function admin()
    {
        $authorization = new Controller_Authorization($this->main);
        $authorization->admin_authorization();
    }

    function user_authorization()
    {
        $authorization = new Controller_Authorization($this->main);
        $authorization->user_authorization();
    }

    function admin_log_out()
    {
        $authorization = new Controller_Authorization($this->main);
        $authorization->admin_log_out();
    }

    function user_log_out()
    {
        $authorization = new Controller_Authorization($this->main);
        $authorization->user_log_out();
    }

    function lost_password()
    {
        $authorization = new Controller_Authorization($this->main);
        $authorization->lost_password();
    }

    function remind_sent()
    {
        $authorization = new Controller_Authorization($this->main);
        $authorization->remind_sent();
    }

//    function update_admin_passwd(){
//        $authorization = new Controller_Authorization($this->main);
//        $authorization->update_admin_passwd();
//    }
//////////////////////////////////////////////////////////// AUTHORIZATION

    function add_all_to_cart()
    {
        $matches = new Controller_Matches($this->main);
        $matches->add_all_to_cart();
    }

    function product_in_matches($p_id)
    {
        $matches = new Controller_Matches($this->main);
        return $matches->product_in_matches($p_id);
    }


//////////////////////////////////////////////////////////// MATCHES

//////////////////////////////////////////////////////////// BLOG
//    function convert()
//    {
//        $blog = new Controller_Blog($this->main);
//        $res = mysql_query("select * from blog_post_keys_descriptions");
//        if ($res){
//            while($post=mysql_fetch_assoc($res)){
//                $content = $post['description'];
//                $id = $post['post_id'];
//                $content = mysql_real_escape_string($blog->convertation(html_entity_decode(stripslashes($content))));
//                mysql_query("update blog_post_keys_descriptions set description = '".$content."' where post_id = ".$id);
//            }
//        }
//    }

    function post()
    {
        $blog = new Controller_Blog($this->main);
        $blog->post();
    }

    function admin_blog()
    {
        $this->main->test_access_rights();
        $blog = new Controller_Blog($this->main);
        $blog->admin_blog();
    }

    function del_post()
    {
        $this->main->test_access_rights();
        $blog = new Controller_Blog($this->main);
        $blog->del_post();
    }

    function new_post()
    {
        $this->main->test_access_rights();
        $blog = new Controller_Blog($this->main);
        $blog->new_post();
    }

    function edit_post()
    {
        $this->main->test_access_rights();
        $blog = new Controller_Blog($this->main);
        $blog->edit_post();
    }

    function new_blog_upload_img()
    {
        $this->main->test_access_rights();
        $blog = new Controller_Blog($this->main);
        $blog->new_blog_upload_img();
    }

    function edit_blog_upload_img()
    {
        $this->main->test_access_rights();
        $blog = new Controller_Blog($this->main);
        $blog->edit_blog_upload_img();
    }

    function save_new_post()
    {
        $this->main->test_access_rights();
        $blog = new Controller_Blog($this->main);
        $blog->save_new_post();
    }

    function save_edit_post()
    {
        $this->main->test_access_rights();
        $blog = new Controller_Blog($this->main);
        $blog->save_edit_post();
    }

//////////////////////////////////////////////////////////// BLOG
//////////////////////////////////////////////////////////// BLOGCATEGORY

    function admin_blog_categories()
    {

        $this->main->test_access_rights();
        $blogcategory = new Controller_BlogCategory($this->main);
        $blogcategory->admin_blog_categories();
    }

    function del_blog_category()
    {
        $this->main->test_access_rights();
        $blogcategory = new Controller_BlogCategory($this->main);
        $blogcategory->del_blog_category();
    }

    function edit_blog_category()
    {
        $this->main->test_access_rights();
        $blogcategory = new Controller_BlogCategory($this->main);
        $blogcategory->edit_blog_category();
    }

    function save_blog_category()
    {
        $this->main->test_access_rights();
        $blogcategory = new Controller_BlogCategory($this->main);
        $blogcategory->save_blog_category();
    }

    function new_blog_category()
    {
        $this->main->test_access_rights();
        $blogcategory = new Controller_BlogCategory($this->main);
        $blogcategory->new_blog_category();
    }

    function save_new_blog_category()
    {
        $this->main->test_access_rights();
        $blogcategory = new Controller_BlogCategory($this->main);
        $blogcategory->save_new_blog_category();
    }


    function service()
    {
        $this->main->view('static/service');
    }

    function newsletter()
    {
        $this->main->view('static/newsletter');
    }

    function privacy()
    {
        $this->main->view('static/privacy');
    }

    function contact()
    {
        $this->main->view('static/contact');
    }

    function about()
    {
        $this->main->view('static/about');
    }
//////////////////////////////////////////////////////////// STATIC
//////////////////////////////////////////////////////////// IMAGE

    function del_pic()
    {
        $image = new Controller_Image($this->main);
        $image->del_pic();
    }

    function upload_product_img()
    {
        $image = new Controller_Image($this->main);
        $image->upload_product_img();
    }

    function save_img_link()
    {
        $image = new Controller_Image($this->main);
        $image->save_img_link();
    }

    function modify_images()
    {
        $image = new Controller_Image($this->main);
        $image->modify_images();
    }

//    function show_break_img_count()
//    {
//        set_time_limit(14400);
//        $q_total = "SELECT COUNT(*) FROM `fabrix_products` a" .
//            " WHERE  a.pnumber is not null and a.pvisible = '1'";
//        $res = mysql_query($q_total);
//        $total = mysql_fetch_row($res);
//        $total = $total[0];
//
//        $q = "SELECT pid FROM `fabrix_products` a" .
//            " WHERE  a.pnumber is not null and a.pvisible = '1'";
//        $res = mysql_query($q);
//        $model = new Model_Users();
//        $f = [1, 2, 3, 4, 5];
//        $total_break = 0;
//        $total_break_p = 0;
//        $total_break_v = 0;
//        while ($row = mysql_fetch_assoc($res)) {
//            $pid = $row['pid'];
//            $images = $model->getImage($pid);
//            foreach ($f as $idx) {
//                $img = $images['image' . $idx];
//                if (!empty($img)) {
//                    $filename = 'upload/upload/' . $img;
//                    if (file_exists($filename) && is_readable($filename)) {
//                        $size_img = getimagesize($filename);
//                        if ($size_img) {
//                            $h = $size_img[0];
//                            $w = $size_img[1];
//                            if ($w == 0 || $h == 0) {
//                                $total_break++;
//                            }
//                        } else {
//                            $total_break++;
//                        }
//                    } else {
//                        $total_break++;
//                    }
//                    $filename = 'upload/upload/p_' . $img;
//                    if (file_exists($filename) && is_readable($filename)) {
//                        $size_img = getimagesize($filename);
//                        if ($size_img) {
//                            $h = $size_img[0];
//                            $w = $size_img[1];
//                            if ($w == 0 || $h == 0) {
//                                $total_break_p++;
//                            }
//                        } else {
//                            $total_break_p++;
//                        }
//                    } else {
//                        $total_break_p++;
//                    }
//                    $filename = 'upload/upload/v_' . $img;
//                    if (file_exists($filename) && is_readable($filename)) {
//                        $size_img = getimagesize($filename);
//                        if ($size_img) {
//                            $h = $size_img[0];
//                            $w = $size_img[1];
//                            if ($w == 0 || $h == 0) {
//                                $total_break_v++;
//                            }
//                        } else {
//                            $total_break_v++;
//                        }
//                    } else {
//                        $total_break_v++;
//                    }
//                }
//            }
//        }
//        echo $total . ' | ' . $total_break . ' | ' . $total_break_p . ' | ' . $total_break_v;
//    }

//////////////////////////////////////////////////////////// IMAGE
//////////////////////////////////////////////////////////// CAPTCHA
    function captcha()
    {
        $captcha = new Controller_Captcha($this->main);
        $captcha->gen_captcha();
        $_SESSION['captcha'] = $captcha->key;
    }

//////////////////////////////////////////////////////////// CAPTCHA

    function search()
    {
        $model = new Model_Tools();
        $userInfo = $model->validData($_GET['s']);
        $search_qv = $userInfo['data'];
        $userInfo = $search_qv;
        $this->template->vars('userInfo', $userInfo);
        $this->main->view('search/search');
    }

    function message()
    {
        $this->main->message();
    }

    public function error404()
    {
        $this->main->error404();
    }
}
