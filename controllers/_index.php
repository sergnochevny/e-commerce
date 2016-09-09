<?php

Class Controller_Index Extends Controller_Base
{

    public $layouts = "first_layouts";
    private $main;

    function __construct()
    {
        parent::__construct();
        $this->main = new Controller_Main($this);
    }

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

    function authorization()
    {
        $authorization = new Controller_Authorization($this->main);
        $authorization->authorization();
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

//////////////////////////////////////////////////////////// MATCHES
    function matches()
    {
        $this->template->vars('cart_enable', '_');

        $matches = new Controller_Matches($this->main);
        $matches->matches();
    }

    function add_matches()
    {
        $matches = new Controller_Matches($this->main);
        $matches->add_matches();
    }

    function del_matches()
    {
        $matches = new Controller_Matches($this->main);
        $matches->del_matches();
    }

    function clear_matches()
    {
        $matches = new Controller_Matches($this->main);
        $matches->clear_matches();
    }

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

//////////////////////////////////////////////////////////// BLOGCATEGORY
//////////////////////////////////////////////////////////// BASKET

    function cart()
    {
        $redirect_to_url = true;
        $this->main->is_user_authorized($redirect_to_url);
        $cart = new Controller_Cart($this->main);
        $cart->cart();
    }

    function proceed_checkout()
    {
        $redirect_to_url = true;
        $this->main->is_user_authorized($redirect_to_url);
        $cart = new Controller_Cart($this->main);
        $cart->proceed_checkout();
    }

    function proceed_agreem()
    {
        $redirect_to_url = true;
        $this->main->is_user_authorized($redirect_to_url);
        $cart = new Controller_Cart($this->main);
        $cart->proceed_agreem();
    }

    function shipping_calc()
    {
        $redirect_to_url = true;
        $this->main->is_user_authorized($redirect_to_url);
        $cart = new Controller_Cart($this->main);
        $cart->shipping_calc();
    }

    function get_cart_subtotal_ship()
    {
        $redirect_to_url = true;
        $this->main->is_user_authorized($redirect_to_url);
        $cart = new Controller_Cart($this->main);
        $cart->get_cart_subtotal_ship();
    }

    function cart_amount()
    {
        $cart = new Controller_Cart($this->main);
        $cart->cart_amount();
    }

    function cart_items_amount()
    {
        $cart = new Controller_Cart($this->main);
        $cart->cart_items_amount();
    }

    function cart_samples_amount()
    {
        $cart = new Controller_Cart($this->main);
        $cart->cart_samples_amount();
    }

    function cart_samples_legend()
    {
        $cart = new Controller_Cart($this->main);
        $cart->cart_samples_legend();
    }

    function add_cart()
    {
        $cart = new Controller_Cart($this->main);
        $cart->add_cart();
    }

    function add_samples_cart()
    {
        $cart = new Controller_Cart($this->main);
        $cart->add_samples_cart();
    }

    function change_product_cart()
    {
        $cart = new Controller_Cart($this->main);
        $cart->change_product_cart();
    }

    function del_product_cart()
    {
        $cart = new Controller_Cart($this->main);
        $cart->del_product_cart();
    }

    function del_sample_cart()
    {
        $cart = new Controller_Cart($this->main);
        $cart->del_sample_cart();
    }

    function coupon_total_calc()
    {
        $cart = new Controller_Cart($this->main);
        $cart->coupon_total_calc();
    }

    function get_price_in_cart()
    {
        $model = new Model_Cart();
        $userInfo = $model->get_price_in_cart();
        $this->template->vars('userInfo', $userInfo);
        echo $userInfo['am_total_cart'];
    }

    function pay_mail()
    {
        $cart = new Controller_Cart($this->main);
        $cart->pay_mail();
    }


//////////////////////////////////////////////////////////// BASKET
//////////////////////////////////////////////////////////// STATIC

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
//////////////////////////////////////////////////////////// SHOP

    function shop()
    {
        $shop = new Controller_Shop($this->main);
        $shop->shop();
    }

    function shop_last()
    {
        $shop = new Controller_Shop($this->main);
        $shop->shop_last();
    }

    function shop_specials()
    {
        $shop = new Controller_Shop($this->main);
        $shop->shop_specials();
    }

    function shop_popular()
    {
        $shop = new Controller_Shop($this->main);
        $shop->shop_popular();
    }

    function shop_best()
    {
        $shop = new Controller_Shop($this->main);
        $shop->shop_best();
    }

    function widget_popular_products()
    {
        $shop = new Controller_Shop($this->main);
        echo $shop->widget_products('popular', 0, 5);
    }

    function widget_new_products()
    {
        $shop = new Controller_Shop($this->main);
        echo $shop->widget_products('new', 0, 5);
    }

    function widget_new_products_carousel()
    {
        $shop = new Controller_Shop($this->main);
        echo $shop->widget_products('carousel', 0, 30, 'widget_new_products_carousel');
    }

    function widget_best_products()
    {
        $shop = new Controller_Shop($this->main);
        echo $shop->widget_products('best', 0, 5);
    }

    function widget_bsells_products()
    {
        $shop = new Controller_Shop($this->main);
        echo $shop->widget_products('bsells', 3, 5);
    }

    function widget_bsells_products_horiz()
    {
        $shop = new Controller_Shop($this->main);
        echo $shop->widget_products('bsells', 0, 3, 'widget_bsells_products_horiz');
    }

//////////////////////////////////////////////////////////// SHOP
//////////////////////////////////////////////////////////// PRODUCT

    function product_page($url = 'shop')
    {
        $product = new Controller_Product($this->main);
        $product->product_page();
    }

    function product_page_specials()
    {
        $url = 'shop_specials';
        $this->product_page($url);
    }

    function product_page_last()
    {
        $url = 'shop_last';
        $this->product_page($url);
    }

    function product_page_best()
    {
        $url = 'shop_best';
        $this->product_page($url);
    }

    function product_page_popular()
    {
        $url = 'shop_popular';
        $this->product_page($url);
    }

    function edit_db()
    {
        $product = new Controller_Product($this->main);
        $product->edit_db();
    }

    function save_db()
    {
        $product = new Controller_Product($this->main);
        $product->save_db();
    }

    function edit()
    {
        $product = new Controller_Product($this->main);
        $product->edit();
    }

    function add_product()
    {
        $product = new Controller_Product($this->main);
        $product->add_product();
    }

    function del_produkt()
    {
        $product = new Controller_Product($this->main);
        $product->del_produkt();
    }

//////////////////////////////////////////////////////////// PRODUCT

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
//////////////////////////////////////////////////////////// USER

    function modify_accounts_password()
    {
        $user = new Controller_User($this->main);
        $user->modify_accounts_password();
    }

    function users()
    {
        $user = new Controller_User($this->main);
        $user->users();
    }

    function users_list()
    {
        $user = new Controller_User($this->main);
        $user->users_list();
    }

    function del_user()
    {
        $user = new Controller_User($this->main);
        $user->del_user();
    }


    function edit_user()
    {
        $user = new Controller_User($this->main);
        $user->edit_user();
    }

    function new_user()
    {
        $user = new Controller_User($this->main);
        $user->new_user();
    }

    function save_edit_user()
    {
        $user = new Controller_User($this->main);
        $user->save_edit_user();
    }

    function save_new_user()
    {
        $user = new Controller_User($this->main);
        $user->save_new_user();
    }

    public function get_province_list()
    {
        $user = new Controller_User($this->main);
        $user->get_province_list();
    }

    public function registration_user()
    {
        $user = new Controller_User($this->main);
        $user->registration_user();
    }

    public function save_registration_user()
    {
        $user = new Controller_User($this->main);
        $user->save_registration_user();
    }

    public function save_edit_registration_data()
    {
        $user = new Controller_User($this->main);
        $user->save_edit_registration_data();
    }

    public function change_registration_data()
    {
        $user = new Controller_User($this->main);
        $user->change_registration_data();
    }

//////////////////////////////////////////////////////////// USER
//////////////////////////////////////////////////////////// CATEGORIES

    function categories()
    {

        $categories = new Controller_Categories($this->main);
        $categories->categories();

    }

    function category_list()
    {

        $categories = new Controller_Categories($this->main);
        $categories->category_list();

    }

    function del_categories()
    {
        $categories = new Controller_Categories($this->main);
        $categories->del_categories();
    }

    function edit_categories()
    {
        $categories = new Controller_Categories($this->main);
        $categories->edit_categories();
    }

    function save_data_categories()
    {
        $categories = new Controller_Categories($this->main);
        $categories->save_data_categories();
    }

    function new_categories()
    {
        $categories = new Controller_Categories($this->main);
        $categories->new_categories();
    }

    function save_new_categories()
    {
        $categories = new Controller_Categories($this->main);
        $categories->save_new_categories();
    }

//////////////////////////////////////////////////////////// CATEGORIES
//////////////////////////////////////////////////////////// DISCOUNT

    function discounts()
    {
        $discount = new Controller_Discount($this->main);
        $discount->discounts();
    }

    function del_discounts()
    {
        $discount = new Controller_Discount($this->main);
        $discount->del_discounts();
    }

    function add_discounts()
    {
        $discount = new Controller_Discount($this->main);
        $discount->add_discounts();
    }

    function edit_discounts()
    {
        $discount = new Controller_Discount($this->main);
        $discount->edit_discounts();
    }


    function usage_discounts()
    {
        $discount = new Controller_Discount($this->main);
        $discount->usage_discounts();
    }

    function edit_discounts_data()
    {
        $discount = new Controller_Discount($this->main);
        $discount->edit_discounts_data();
    }

    function save_discounts_data()
    {
        $discount = new Controller_Discount($this->main);
        $discount->save_discounts_data();
    }

//////////////////////////////////////////////////////////// DISCOUNT
//////////////////////////////////////////////////////////// ORDER

    function orders()
    {
        $order = new Controller_Order($this->main);
        $order->orders();
    }

    function order()
    {
        $order = new Controller_Order($this->main);
        $order->order();
    }

    function discount_order()
    {
        $order = new Controller_Order($this->main);
        $order->discount_order();
    }

    function customer_orders_history()
    {
        $redirect_to_url = true;
        $this->main->is_user_authorized($redirect_to_url);
        $order = new Controller_Order($this->main);
        $order->customer_orders_history();
    }

    function customer_order_info()
    {
        $redirect_to_url = true;
        $this->main->is_user_authorized($redirect_to_url);
        $order = new Controller_Order($this->main);
        $order->customer_order_info();
    }

    function order_info()
    {
        $order = new Controller_Order($this->main);
        $order->order_info();
    }

    function orders_history()
    {
        $order = new Controller_Order($this->main);
        $order->orders_history();
    }

    function edit_orders_info()
    {
        $order = new Controller_Order($this->main);
        $order->edit_orders_info();
    }

//////////////////////////////////////////////////////////// ORDER
//////////////////////////////////////////////////////////// CAPTCHA
    function captcha()
    {
        $captcha = new Controller_Captcha($this->main);
        $captcha->gen_captcha();
        $_SESSION['captcha'] = $captcha->key;
    }

//////////////////////////////////////////////////////////// CAPTCHA
////////////////////////////////////////////////////////////// COMMENTS

    public function comments()
    {
        $comments = new Controller_Comments($this->main);
        $comments->show();
    }

    public function add_comment()
    {
        $comments = new Controller_Comments($this->main);
        $comments->comment_add();
    }

    public function comment_save()
    {
        $comments = new Controller_Comments($this->main);
        $comments->comment_save();
    }

    public function admin_comments()
    {
        $adm = new Controller_Comments($this->main);
        $adm->show_comments();
    }

    public function comment_delete()
    {
        $adm = new Controller_Comments($this->main);
        $adm->delete();
    }

    public function comment_edit()
    {
        $adm = new Controller_Comments($this->main);
        $adm->edit();
    }

    public function view_comment()
    {
        $adm = new Controller_Comments($this->main);
        $adm->show_comment();
    }

    public function public_comment()
    {
        $adm = new Controller_Comments($this->main);
        $adm->public_comment();
    }

    public function comment_update_save()
    {
        $adm = new Controller_Comments($this->main);
        $adm->update_comment();
    }

    public function update_comment_list()
    {
        $adm = new Controller_Comments($this->main);
        $adm->update_comment_list();
    }

    //////////////////////////////////////////////////////////// COMMENTS

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
