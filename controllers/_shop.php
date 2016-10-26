<?php

  class Controller_Shop extends Controller_Controller {

    private function show_category_list() {
      $items = Model_Tools::get_items_for_menu('all');
      $this->template->vars('items', $items, true);
      ob_start();
      $list = ob_get_contents();
      $this->template->vars('list', $list, true);
      ob_end_clean();
      ob_start();
      $this->template->view_layout('categories', 'menu');
      $categories = ob_get_contents();
      ob_end_clean();
      $this->main->template->vars('categories', $categories);
    }

    private function product_list() {
      $image_suffix = 'b_';
      $cart_items = isset(_A_::$app->session('cart')['items']) ? _A_::$app->session('cart')['items'] : [];
      $cart = array_keys($cart_items);
      $search = null;
      if(!is_null(_A_::$app->post('s')) && (!empty(_A_::$app->post('s')))) {
        $search = strtolower(htmlspecialchars(trim(_A_::$app->post('s'))));
        $this->main->template->vars('search', _A_::$app->post('s'));
      }

      $page = !empty(_A_::$app->get('page')) ? Model_Shop::validData(_A_::$app->get('page')) : 1;
      $per_page = 12;
      $total = Model_Shop::get_total($search);
      if($page > ceil($total / $per_page))
        $page = ceil($total / $per_page);
      if($page <= 0)
        $page = 1;
      $start = (($page - 1) * $per_page);
      if(!empty(_A_::$app->get('cat'))) {
        $cid = Model_Shop::validData(_A_::$app->get('cat'));
        if ($category = Model_Categories::get_by_id($cid)) $category_name = $category['cname'];

      } else {
        if(!empty(_A_::$app->get('ptrn'))) {
          if($ptrn = Model_Patterns::get_by_id(_A_::$app->get('ptrn'))) $ptrn_name = $ptrn['pattern'];
          $this->template->vars('ptrn_name', isset($ptrn_name) ? $ptrn_name : null);
        } else {
          if(!empty(_A_::$app->get('mnf'))) {
            $mnf_id = _A_::$app->get('mnf');
            if ($mnf = Model_Manufacturers::get_by_id($mnf_id)) $mnf_name = $mnf['manufacturer'];
            $this->template->vars('mnf_name', isset($mnf_name) ? $mnf_name : null);
          }
        }
      }
      $rows = Model_Shop::get_products($start, $per_page, $count_rows, $search);
      if($rows) {
        $this->main->template->vars('count_rows', $count_rows);
        $sys_hide_price = Model_Price::sysHideAllRegularPrices();
        $this->main->template->vars('sys_hide_price', $sys_hide_price);
        ob_start();
        foreach($rows as $row) {
          $row['ldesc'] = substr($row['ldesc'], 0, 100);
          $filename = 'upload/upload/' . $image_suffix . $row['image1'];
          if(!(file_exists($filename) && is_file($filename))) {
            $filename = 'upload/upload/not_image.jpg';
          }
          $filename = _A_::$app->router()->UrlTo($filename);

          $opt = null;
          if(!empty(_A_::$app->get('page'))) {
            $opt['page'] = _A_::$app->get('page');
          }
          if(!empty(_A_::$app->get('cat'))) {
            $opt['cat'] = _A_::$app->get('cat');
          }
          if(!empty(_A_::$app->get('mnf'))) {
            $opt['mnf'] = _A_::$app->get('mnf');
          }
          if(!empty(_A_::$app->get('ptrn'))) {
            $opt['ptrn'] = _A_::$app->get('ptrn');
          }

          $pid = $row['pid'];
          $price = $row['priceyard'];
          $inventory = $row['inventory'];
          $piece = $row['piece'];
          $format_price = '';
          $price = Model_Price::getPrintPrice($price, $format_price, $inventory, $piece);

          $discountIds = [];
          $saleprice = $row['priceyard'];
          $sDiscount = 0;
          $saleprice = Model_Price::calculateProductSalePrice($pid, $saleprice, $discountIds);
          $this->template->vars('bProductDiscount', Model_Price::checkProductDiscount($pid, $sDiscount, $saleprice, $discountIds));
          $format_sale_price = '';
          $this->template->vars('saleprice', Model_Price::getPrintPrice($saleprice, $format_sale_price, $inventory, $piece));
          $this->template->vars('format_sale_price', $format_sale_price);
          $this->template->vars('format_price', $format_price);
          $this->template->vars('in_cart', in_array($row[0], $cart));
          $hide_price = $row['hideprice'];
          $this->template->vars('hide_price', $hide_price);
          $this->template->vars('filename', $filename);
          $this->template->vars('sys_hide_price', $sys_hide_price);
          $this->template->vars('row', $row);
          $this->template->vars('price', $price);
          $this->template->vars('search', $search);
          $this->template->vars('opt', $opt);
          $this->template->view_layout('rows');
        }

        $rows = ob_get_contents();
        ob_end_clean();
        $this->main->template->vars('category_name', isset($category_name) ? $category_name : null);
        $this->main->template->vars('rows', $rows);

        $paginator = new Controller_Paginator($this);
        $paginator->paginator($total, $page, 'shop', $per_page);
      } else {
        $this->main->template->vars('count_rows', 0);
        $rows = "No Result!";
        $this->main->template->vars('rows', $rows);
      }
      $this->template->view_layout('list');
    }

    private function product_list_by_type($type = 'last', $max_count_items = 50) {
      $image_suffix = 'b_';
      $cart_items = isset(_A_::$app->session('cart')['items']) ? _A_::$app->session('cart')['items'] : [];
      $cart = array_keys($cart_items);
      $page = !empty(_A_::$app->get('page')) ? Model_Shop::validData(_A_::$app->get('page')) : 1;
      $per_page = 12;

      if(!empty(_A_::$app->get('cat'))) {
        $cid = Model_Shop::validData(_A_::$app->get('cat'));
        $this->template->vars('cat_id', $cid);
      }

      $total = Model_Shop::get_count_by_type($type);
      if($total > $max_count_items)
        $total = $max_count_items;
      if($page > ceil($total / $per_page))
        $page = ceil($total / $per_page);
      if($page <= 0)
        $page = 1;
      $start = (($page - 1) * $per_page);
      $limit = $per_page;
      if($total < ($start + $per_page)) $limit = $total - $start;

      $res_count_rows = 0;
      $rows = Model_Shop::get_list_by_type($type, $start, $limit, $res_count_rows);
      $this->template->vars('count_rows', $res_count_rows);

      if($rows) {
        $sys_hide_price = Model_Price::sysHideAllRegularPrices();
        $this->template->vars('sys_hide_price', $sys_hide_price);

        ob_start();
        foreach($rows as $row) {
          $row['sdesc'] = substr($row['sdesc'], 0, 100);
          $row['ldesc'] = substr($row['ldesc'], 0, 100);
          $filename = 'upload/upload/' . $image_suffix . $row['image1'];
          if(!(file_exists($filename) && is_file($filename))) {
            $filename = 'upload/upload/not_image.jpg';
          }
          $filename = _A_::$app->router()->UrlTo($filename);

          $url_prms = ['pid' => $row['pid'], 'back' => $type];
          if(!empty(_A_::$app->get('page'))) {
            $url_prms['page'] = _A_::$app->get('page');
          }
          if(!empty(_A_::$app->get('cat'))) {
            $url_prms['cat'] = _A_::$app->get('cat');
          }

          $pid = $row['pid'];
          $price = $row['priceyard'];
          $inventory = $row['inventory'];
          $piece = $row['piece'];
          $format_price = '';
          $price = Model_Price::getPrintPrice($price, $format_price, $inventory, $piece);

          $discountIds = [];
          $saleprice = $row['priceyard'];
          $sDiscount = 0;
          $saleprice = Model_Price::calculateProductSalePrice($pid, $saleprice, $discountIds);
          $bProductDiscount = Model_Price::checkProductDiscount($pid, $sDiscount, $saleprice, $discountIds);
          $format_sale_price = '';
          $saleprice = Model_Price::getPrintPrice($saleprice, $format_sale_price, $inventory, $piece);

          $this->template->vars('url_prms', $url_prms);
          $this->template->vars('filename', $filename);
          $this->template->vars('row', $row);
          $this->template->vars('pid', $pid);
          $this->template->vars('piece', $piece);
          $this->template->vars('price', $price);
          $this->template->vars('inventory', $inventory);
          $this->template->vars('format_sale_price', $format_sale_price);
          $this->template->vars('format_price', $format_price);
          $this->template->vars('saleprice', $saleprice);
          $this->template->vars('bProductDiscount', $bProductDiscount);
          $this->template->vars('sDiscount', $sDiscount);
          $this->template->vars('in_cart', in_array($row[0], $cart));
          $this->template->vars('hide_price', $row['hideprice']);
          $this->template->view_layout($type);
        }

        $list = ob_get_contents();
        ob_end_clean();
        $this->main->template->vars('category_name', isset($category_name) ? $category_name : '');
        $this->main->template->vars('rows', $list);

        (new Controller_Paginator($this->main))->paginator($total, $page, 'shop' . DS . $type, $per_page);
      } else {
        $this->main->template->vars('count_rows', 0);
        $list = "No Result!";
        $this->main->template->vars('rows', $list);
      }
      $this->template->view_layout('list');
    }

    private function widget_products($type, $start, $limit, $layout = 'widget_products') {
      $rows = Model_Shop::get_widget_list_by_type($type, $start, $limit, $row_count, $image_suffix);
      if($rows) {
        $sys_hide_price = Model_Price::sysHideAllRegularPrices();
        $this->template->vars('sys_hide_price', $sys_hide_price);

        ob_start();
        $first = true;
        $last = false;
        $i = 1;
        foreach($rows as $row) {
          $row['sdesc'] = substr($row['sdesc'], 0, 100);
          $row['ldesc'] = substr($row['ldesc'], 0, 100);
          $filename = 'upload/upload/' . $image_suffix . $row['image1'];
          if(!(file_exists($filename) && is_file($filename))) {
            $filename = 'upload/upload/not_image.jpg';
          }
          $filename = _A_::$app->router()->UrlTo($filename);
          $pid = $row['pid'];
          $price = $row['priceyard'];
          $inventory = $row['inventory'];
          $piece = $row['piece'];
          $price = Model_Price::getPrintPrice($price, $format_price, $inventory, $piece);

          $discountIds = [];
          $saleprice = $row['priceyard'];
          $sDiscount = 0;
          $saleprice = Model_Price::calculateProductSalePrice($pid, $saleprice, $discountIds);
          $bProductDiscount = Model_Price::checkProductDiscount($pid, $sDiscount, $saleprice, $discountIds);
          $format_sale_price = '';
          $saleprice = Model_Price::getPrintPrice($saleprice, $format_sale_price, $inventory, $piece);

          $hide_price = $row['hideprice'];
          $this->template->vars('hide_price', $hide_price);

          $last = $i++ == $row_count;

          $this->template->vars('last', $last);
          $this->template->vars('first', $first);
          $this->template->vars('saleprice', $saleprice);
          $this->template->vars('price', $price);
          $this->template->vars('format_sale_price', $format_sale_price);
          $this->template->vars('bProductDiscount', $bProductDiscount);
          $this->template->vars('sDiscount', $sDiscount);
          $this->template->vars('piece', $piece);
          $this->template->vars('inventory', $inventory);
          $this->template->vars('discountIds', $discountIds);
          $this->template->vars('pid', $pid);
          $this->template->vars('filename', $filename);
          $this->template->vars('format_price', $format_price);
          $this->template->vars('row', $row);
          $this->template->vars('hide_price', $hide_price);
          $this->template->vars('sys_hide_price', $sys_hide_price);

          $this->template->view_layout('widgets/' . $layout);
          $first = false;
        }

        $list = ob_get_contents();
        ob_end_clean();
      } else {
        $list = "No Result!";
      }
      return $list;
    }

    /**
     * @export
     */
    public function shop() {
      $this->template->vars('cart_enable', '_');
      $this->show_category_list();
      if(_A_::$app->request_is_ajax()) exit($this->product_list());
      else {
        ob_start();
        $this->product_list();
        $list = ob_get_contents();
        ob_end_clean();
        $this->template->vars('list',$list);
      }
      $this->main->view('shop');
    }

    /**
     * @export
     */
    public function last() {
      $this->template->vars('cart_enable', '_');
      $this->main->template->vars('page_title', 'What\'s New');
      if(_A_::$app->request_is_ajax()) exit($this->product_list_by_type('last', 50));
      else {
        //$this->show_category_list();
        ob_start();
        $this->product_list_by_type('last', 50);
        $list = ob_get_contents();
        ob_end_clean();
        $this->template->vars('list',$list);
      }
      $this->main->view('shop');
    }

    /**
     * @export
     */
    public function specials() {
      $this->template->vars('cart_enable', '_');
      $page_title = "Limited time Specials.";
      $annotation = 'All specially priced items are at their marked down prices for a LIMITED TIME ONLY, after which they revert to their regular rates.<br>All items available on a FIRST COME, FIRST SERVED basis only.';
      $this->main->template->vars('page_title', $page_title);
      $this->main->template->vars('annotation', $annotation);
      if(_A_::$app->request_is_ajax()) exit($this->product_list_by_type('specials', 360));
      else {
//      $this->show_category_list();
        ob_start();
        $this->product_list_by_type('specials', 360);
        $list = ob_get_contents();
        ob_end_clean();
        $this->template->vars('list',$list);
      }
      $this->main->view('shop');
    }

    /**
     * @export
     */
    public function popular() {
      $this->template->vars('cart_enable', '_');
      $this->main->template->vars('page_title', 'Popular Textile');
      if(_A_::$app->request_is_ajax()) exit($this->product_list_by_type('popular', 360));
      else {
//      $this->show_category_list();
        ob_start();
        $this->product_list_by_type('popular', 360);
        $list = ob_get_contents();
        ob_end_clean();
        $this->template->vars('list',$list);
      }
      $this->main->view('shop');
    }

    /**
     * @export
     */
    public function best() {
      $this->template->vars('cart_enable', '_');
      $this->main->template->vars('page_title', 'Best Textile');
      if(_A_::$app->request_is_ajax()) exit($this->product_list_by_type('best', 360));
      else {
//      $this->show_category_list();
        ob_start();
        $this->product_list_by_type('best', 360);
        $list = ob_get_contents();
        ob_end_clean();
        $this->template->vars('list',$list);
      }
      $this->main->view('shop');
    }

    /**
     * @export
     */
    public function bestsellers() {
      $this->template->vars('cart_enable', '_');
      $this->main->template->vars('page_title', 'Best Sellers');
      if(_A_::$app->request_is_ajax()) exit($this->product_list_by_type('bsells', 360));
      else {
//      $this->show_category_list();
        ob_start();
        $this->product_list_by_type('bsells', 360);
        $list = ob_get_contents();
        ob_end_clean();
        $this->template->vars('list',$list);
      }
      $this->main->view('shop');
    }

//    public function modify_products_images() {
//      $c_image = new Controller_Image();
//      $per_page = 12;
//      $page = 1;
//
//      $total = Model_Shop::get_total_count();
//      $count = 0;
//      while($page <= ceil($total / $per_page)) {
//        $start = (($page++ - 1) * $per_page);
//        $rows = Model_Shop::get_list($start, $per_page);
//        foreach($rows as $row) {
//          for($i = 1; $i < 5; $i++) {
//            $fimage = $row['image' . $i];
//            if(isset($fimage) && is_string($fimage) && strlen($fimage) > 0) {
//              $c_image->modify_products($fimage);
//            }
//          }
//        }
//        $count += count($rows);
//        echo $count;
//      }
//    }

    /**
     * @export
     */
    public function product_filter_list() {
      $this->main->template->vars('ProductFilterList', Model_Shop::product_filter_list());
    }

    /**
     * @export
     */
    public function widget_popular() {
      echo $this->widget_products('popular', 0, 5);
    }

    /**
     * @export
     */
    public function widget_new() {
      echo $this->widget_products('new', 0, 5);
    }

    /**
     * @export
     */
    public function widget_new_carousel() {
      echo $this->widget_products('carousel', 0, 30, 'widget_new_products_carousel');
    }

    /**
     * @export
     */
    public function widget_best() {
      echo $this->widget_products('best', 0, 5);
    }

    /**
     * @export
     */
    public function widget_bsells() {
      echo $this->widget_products('bsells', 6, 5);
    }

    /**
     * @export
     */
    public function widget_bsells_horiz() {
      echo $this->widget_products('bsells', 0, 6, 'widget_bsells_products_horiz');
    }


    private function posts() {
      $page = !empty(_A_::$app->get('page')) ? Model_Blog::validData(_A_::$app->get('page')) : 1;
      $per_page = 6;
      $cid = null;
      if(!empty(_A_::$app->get('cat'))) {
        $cid = Model_Blog::validData(_A_::$app->get('cat'));
        $category_name = Model_Blog::getPostCatName($cid);
      }

      $total = Model_Blog::get_count_publish_posts($cid);
      if($page > ceil($total / $per_page))
        $page = ceil($total / $per_page);
      if($page <= 0)
        $page = 1;
      $start = (($page - 1) * $per_page);

      $rows = Model_Blog::get_publish_post_list($cid, $start, $per_page, $res_count_rows);
      if($rows) {
        $this->template->vars('count_rows', $res_count_rows);

        ob_start();

        foreach($rows as $row) {
          $post_id = $row['ID'];
          $post_name = $row['post_name'];
          $base_url = _A_::$app->router()->UrlTo('/');
          $prms = ['id' => $post_id];
          if(!empty(_A_::$app->get('page'))) {
            $prms['page'] = _A_::$app->get('page');
          }
          if((!empty(_A_::$app->get('cat')))) {
            $prms['cat'] = _A_::$app->get('cat');
          }
          $post_title = stripslashes($row['post_title']);
          $post_href = _A_::$app->router()->UrlTo('blog/post', $prms, $post_title);
          $post_date = date('F jS, Y', strtotime($row['post_date']));

          $post_content = Model_Blog::getPostDescKeys($post_id);
          if(isset($post_content) && is_array($post_content)) {
            $post_content = stripslashes($post_content['description']);
          } else {
            $post_content = stripslashes($row['post_content']);
            $post_content = substr(strip_tags(str_replace('{base_url}', $base_url, $post_content)), 0, 300);
            $post_content = preg_replace('#(style="[^>]*")#U', '', $post_content);
          }

          $post_img = Model_Blog::getPostImg($post_id);
          $filename = str_replace('{base_url}/', '', $post_img);
          if(!(file_exists($filename) && is_file($filename))) {
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
        (new Controller_Paginator($this->main))->paginator($total, $page, 'blog', $per_page);
      } else {
        $this->main->template->vars('count_rows', 0);
        $list = "No Result!!!";
        $this->main->template->vars('blog_posts', $list);
      }
    }

    /**
     * @export
     */
    public function product() {
      $pid = _A_::$app->get('pid');
      $data = Model_Shop::get_product($pid);

      $matches = new Controller_Matches($this->main);
      if($matches->product_in($pid))
        $this->template->vars('in_matches', '1');

      $priceyard = $data['priceyard'];
      $aPrds = [];
      $aPrds[] = $pid;    #add product id
      $aPrds[] = 1;        #add qty

      #get the shipping
      if(!is_null(_A_::$app->session('cart')) && isset(_A_::$app->session('cart')['ship'])) {
        $shipping = (int)_A_::$app->session('cart')['ship'];
      } else {
        $shipping = DEFAULT_SHIPPING;
        $_cart = _A_::$app->session('cart');
        $_cart['ship'] = $shipping;
        _A_::$app->setSession('cart', $_cart);
      }

      if(!is_null(_A_::$app->get('cart')) && isset(_A_::$app->session('cart')['ship_roll'])) {
        $bShipRoll = (boolean)_A_::$app->session('cart')['ship_roll'];
      } else {
        $bShipRoll = false;
        $cart = _A_::$app->session('cart');
        $cart['ship_roll'] = 0;
        _A_::$app->setSession('cart', $cart);
      }

      $shipcost = 0;

      #grab the user id
      $uid = 0;
      if(!is_null(_A_::$app->session('user'))) {
        $uid = (int)_A_::$app->session('user')['aid'];
      }
      $bTemp = false;
      $sys_hide_price = Model_Price::sysHideAllRegularPrices();
      $hide_price = $data['hideprice'];
      $this->template->vars('hide_price', $hide_price);

      $bSystemDiscount = false;
      $discountIds = [];
      $sSystemDiscount = false;
      $sPriceDiscount = '';
      $rSystemDiscount = 0;
      $rDiscountPrice = 0;
      $rSystemDiscount = Model_Price::calculateDiscount(DISCOUNT_CATEGORY_ALL, $uid, $aPrds, $priceyard, $shipcost, '', $bTemp, true, $sPriceDiscount, $sSystemDiscount, $shipping, $discountIds);
      if((strlen($sSystemDiscount) > 0) || ($rSystemDiscount > 0)) {
        $bSystemDiscount = true;
        $rDiscountPrice = $priceyard - $rSystemDiscount;
      }

      #check the price for the discount
      if($bSystemDiscount) {
        $rExDiscountPrice = $rDiscountPrice;
      } else {
        $rExDiscountPrice = $priceyard;
      }

      $inventory = $data['inventory'];
      $piece = $data['piece'];
      $format_price = '';
      $price = Model_Price::getPrintPrice($priceyard, $format_price, $inventory, $piece);

      #check if the product has its own discount
      $sDiscount = '';
      $bDiscount = Model_Price::checkProductDiscount($pid, $sDiscount, $rExDiscountPrice, $discountIds);
      $data['format_price'] = $format_price;

      ob_start();
      if($rSystemDiscount > 0) {
        $tmp = Model_Price::getPrintPrice($rDiscountPrice, $sDiscountPrice, $inventory, $piece);
        $field_name = "Sale price:";
        $field_value = sprintf("%s<br><strong>%s</strong>", $sPriceDiscount, $sDiscountPrice);
        $this->template->vars('field_name', $field_name);
        $this->template->vars('field_value', $field_value);
        $this->template->view_layout('product/discount');
      }

      if($bDiscount) {
        $tmp = Model_Price::getPrintPrice($rExDiscountPrice, $sDiscountPrice, $inventory, $piece);
        if($bSystemDiscount) {
          $field_name = "Extra disc. price:";
        } else {
          $field_name = "Sale price:";
        }
        if($bSystemDiscount) {
          $field_value = sprintf("<strong>%s</strong><br>Reduced a further %s.", $sDiscountPrice, $sDiscount);
        } else {
          $field_value = sprintf("<strong>%s</strong><br>Reduced by %s.", $sDiscountPrice, $sDiscount);
        }
        $this->template->vars('field_name', $field_name);
        $this->template->vars('field_value', $field_value);
        $this->template->view_layout('product/discount');
      }

      if(strlen($sSystemDiscount) > 0) {
        $field_name = 'Shipping discount:';
        $field_value = $sSystemDiscount;
        $this->template->vars('field_name', $field_name);
        $this->template->vars('field_value', $field_value);
        $this->template->view_layout('product/discount');
      }

      if(count($discountIds) > 0) {
        if(Model_Price::getNextChangeInDiscoutDate($discountIds) > 0) {
          $field_name = 'Sale ends in:';
          $field_value = Model_Price::displayDiscountTimeRemaining($discountIds);
          $this->template->vars('field_name', $field_name);
          $this->template->vars('field_value', $field_value);
          $this->template->view_layout('product/discount');
        }
      }
      $discount_info = ob_get_contents();
      ob_end_clean();
      $this->template->vars('discount_info', $discount_info);

      if(isset(_A_::$app->session('cart')['items'])) {
        $cart_items = _A_::$app->session('cart')['items'];
      } else {
        $cart_items = [];
      }
      $cart = array_keys($cart_items);
      $in_cart = in_array($pid, $cart);
      if($in_cart)
        $this->template->vars('in_cart', '1');

      $url_prms = ['page' => '1'];
      if(!empty(_A_::$app->get('page'))) {
        $url_prms['page'] = _A_::$app->get('page');
      }
      if((!empty(_A_::$app->get('cat')))) {
        $url_prms['cat'] = _A_::$app->get('cat');
      }
      if((!empty(_A_::$app->get('mnf')))) {
        $url_prms['mnf'] = _A_::$app->get('mnf');
      }
      if((!empty(_A_::$app->get('ptrn')))) {
        $url_prms['ptrn'] = _A_::$app->get('ptrn');
      }

      if(!is_null(_A_::$app->get('back'))) {
        $back = _A_::$app->get('back');
        switch($back) {
          case 'matches':
            $back_url = _A_::$app->router()->UrlTo('matches');
            break;
          case 'cart':
            $back_url = _A_::$app->router()->UrlTo('cart');
            break;
          default:
            $back_url = _A_::$app->router()->UrlTo('shop' . DS . $back, $url_prms);
        }
      } else {
        $back_url = _A_::$app->router()->UrlTo('shop', $url_prms);
      }

      if(!is_null(_A_::$app->post('s')) && (!empty(_A_::$app->post('s')))) {
        $search = strtolower(htmlspecialchars(trim(_A_::$app->post('s'))));
        $this->main->template->vars('search', _A_::$app->post('s'));
      }

      $this->template->vars('data', $data);
      $this->template->vars('sys_hide_price', $sys_hide_price);

      $allowed_samples = Model_Samples::allowedSamples($pid);
      $this->template->vars('allowed_samples', $allowed_samples);
      $this->template->vars('cart_enable', '_');
      $this->template->vars('back_url', $back_url);
      $this->main->view('product/view');
    }


  }