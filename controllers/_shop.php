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
        $search = mysql_real_escape_string(strtolower(htmlspecialchars(trim(_A_::$app->post('s')))));
        $this->main->template->vars('search', _A_::$app->post('s'));
      }

      $page = !empty(_A_::$app->get('page')) ? Model_Product::validData(_A_::$app->get('page')) : 1;
      $per_page = 12;
      $total = Model_Product::get_total($search);
      if($page > ceil($total / $per_page))
        $page = ceil($total / $per_page);
      if($page <= 0)
        $page = 1;
      $start = (($page - 1) * $per_page);
      if(!empty(_A_::$app->get('cat'))) {
        $cat_id = Model_Product::validData(_A_::$app->get('cat'));
        $category_name = Model_Product::getCatName($cat_id);
      } else {
        if(!empty(_A_::$app->get('ptrn'))) {
          $ptrn_name = Model_Product::getPtrnName(_A_::$app->get('ptrn'));
          $this->template->vars('ptrn_name', isset($ptrn_name) ? $ptrn_name : null);
        } else {
          if(!empty(_A_::$app->get('mnf'))) {
            $mnf_id = Model_Product::validData(_A_::$app->get('mnf'));
            $mnf_name = Model_Product::getMnfName($mnf_id);
            $this->template->vars('mnf_name', isset($mnf_name) ? $mnf_name : null);
          }
        }
      }
      $rows = Model_Product::get_products($start, $per_page, $count_rows, $search);
      if($rows) {
        $this->main->template->vars('count_rows', $count_rows);
        $sys_hide_price = Model_Price::sysHideAllRegularPrices();
        $this->main->template->vars('sys_hide_price', $sys_hide_price);
        ob_start();
        foreach($rows as $row) {
          $cat_name = Model_Product::getCatName($row[20]);
          $row[8] = substr($row[8], 0, 100);
          $filename = 'upload/upload/' . $image_suffix . $row[14];
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

          $pid = $row[0];
          $price = $row[5];
          $inventory = $row[6];
          $piece = $row[34];
          $format_price = '';
          $price = Model_Price::getPrintPrice($price, $format_price, $inventory, $piece);

          $discountIds = [];
          $saleprice = $row[5];
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
          $this->main->template->vars('hide_price', $hide_price);
          $this->template->vars('hide_price', $hide_price);
          $this->template->vars('filename', $filename);
          $this->template->vars('sys_hide_price', $sys_hide_price);
          $this->template->vars('row', $row);
          $this->template->vars('price', $price);
          $this->template->vars('search', $search);
          $this->template->vars('opt', $opt);
          $this->template->view_layout('list');
        }

        $list = ob_get_contents();
        ob_end_clean();
        $this->main->template->vars('category_name', isset($category_name) ? $category_name : null);
        $this->main->template->vars('list', $list);

        $paginator = new Controller_Paginator($this);
        $paginator->paginator($total, $page, 'shop', $per_page);
      } else {
        $this->main->template->vars('count_rows', 0);
        $list = "No Result!!!";
        $this->main->template->vars('list', $list);
      }
    }

    private function product_list_by_type($type = 'last', $max_count_items = 50) {
      $image_suffix = 'b_';
      $cart_items = isset(_A_::$app->session('cart')['items']) ? _A_::$app->session('cart')['items'] : [];
      $cart = array_keys($cart_items);
      $page = !empty(_A_::$app->get('page')) ? Model_Product::validData(_A_::$app->get('page')) : 1;
      $per_page = 12;

      if(!empty(_A_::$app->get('cat'))) {
        $cat_id = Model_Product::validData(_A_::$app->get('cat'));
        $this->template->vars('cat_id', $cat_id);
      }

      $total = Model_Product::get_count_by_type($type);
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
      $rows = Model_Product::get_list_by_type($type, $start, $limit, $res_count_rows);
      $this->template->vars('count_rows', $res_count_rows);

      if($rows) {
        $sys_hide_price = Model_Price::sysHideAllRegularPrices();
        $this->template->vars('sys_hide_price', $sys_hide_price);

        ob_start();
        foreach($rows as $row) {
          $cat_name = Model_Product::getCatName($row[20]);
          $row[8] = substr($row[8], 0, 100);
          $filename = 'upload/upload/' . $image_suffix . $row[14];
          if(!(file_exists($filename) && is_file($filename))) {
            $filename = 'upload/upload/not_image.jpg';
          }
          $filename = _A_::$app->router()->UrlTo($filename);

          $url_prms = ['p_id' => $row[0], 'back' => $type];
          if(!empty(_A_::$app->get('page'))) {
            $url_prms['page'] = _A_::$app->get('page');
          }
          if(!empty(_A_::$app->get('cat'))) {
            $url_prms['cat'] = _A_::$app->get('cat');
          }

          $pid = $row[0];
          $price = $row[5];
          $inventory = $row[6];
          $piece = $row[34];
          $format_price = '';
          $price = Model_Price::getPrintPrice($price, $format_price, $inventory, $piece);

          $discountIds = [];
          $saleprice = $row[5];
          $sDiscount = 0;
          $saleprice = Model_Price::calculateProductSalePrice($pid, $saleprice, $discountIds);
          $bProductDiscount = Model_Price::checkProductDiscount($pid, $sDiscount, $saleprice, $discountIds);
          $format_sale_price = '';
          $saleprice = Model_Price::getPrintPrice($saleprice, $format_sale_price, $inventory, $piece);

          $this->template->vars('cat_name', $cat_name);
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
        $this->main->template->vars('list', $list);

        (new Controller_Paginator($this->main))->paginator($total, $page, 'shop' . DS . $type, $per_page);
      } else {
        $this->main->template->vars('count_rows', 0);
        $list = "No Result!!!";
        $this->main->template->vars('list', $list);
      }
    }

    private function widget_products($type, $start, $limit, $layout = 'widget_products') {
      $rows = Model_Product::get_widget_list_by_type($type, $start, $limit, $row_count, $image_suffix);
      if($rows) {
        $sys_hide_price = Model_Price::sysHideAllRegularPrices();
        $this->template->vars('sys_hide_price', $sys_hide_price);

        ob_start();
        $first = true;
        $last = false;
        $i = 1;
        foreach($rows as $row) {
          $cat_name = Model_Product::getCatName($row[20]);
          $row[8] = substr($row[8], 0, 100);

          $filename = 'upload/upload/' . $image_suffix . $row[14];
          if(!(file_exists($filename) && is_file($filename))) {
            $filename = 'upload/upload/not_image.jpg';
          }
          $filename = _A_::$app->router()->UrlTo($filename);

          $pid = $row[0];
          $price = $row[5];
          $inventory = $row[6];
          $piece = $row[34];
          $price = Model_Price::getPrintPrice($price, $format_price, $inventory, $piece);

          $discountIds = [];
          $saleprice = $row[5];
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
          $this->template->vars('cat_name', $cat_name);
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
        $list = "No Result!!!";
      }
      return $list;
    }

    public function all_products() {
      $this->main->test_access_rights();
      $image_suffix = 'b_';

      $page = !empty(_A_::$app->get('page')) ? Model_Product::validData(_A_::$app->get('page')) : 1;

      $add_product_prms['page'] = $page;
      if(!empty(_A_::$app->get('cat'))) {
        $add_product_prms['cat'] = _A_::$app->get('cat');
      }

      $this->main->template->vars('add_product_href', _A_::$app->router()->UrlTo('product/add', $add_product_prms));

      Model_Product::cleanTempProducts();
      $per_page = 12;

      $total = Model_Product::get_count_by_type('all');
      if($page > ceil($total / $per_page))
        $page = ceil($total / $per_page);
      if($page <= 0)
        $page = 1;
      $start = (($page - 1) * $per_page);

      if(!empty(_A_::$app->get('cat'))) {
        $cat_id = Model_Product::validData(_A_::$app->get('cat'));
      }
      $res_count_rows = 0;
      $rows = Model_Product::get_list_by_type('all', $start, $per_page, $res_count_rows);

      ob_start();
      foreach($rows as $row) {
        $cat_name = Model_Product::getCatName($row[20]);
        $row[8] = substr($row[8], 0, 100);

        $filename = 'upload/upload/' . $image_suffix . $row[14];
        if(!(file_exists($filename) && is_file($filename))) {
          $filename = 'upload/upload/not_image.jpg';
        }
        $filename = _A_::$app->router()->UrlTo($filename);

        $url_prms = ['p_id' => $row[0]];
        if(!empty(_A_::$app->get('page'))) {
          $url_prms['page'] = _A_::$app->get('page');
        }
        if(!empty(_A_::$app->get('cat'))) {
          $url_prms['cat'] = _A_::$app->get('cat');
        }

        $price = $row[5];
        $inventory = $row[6];
        $piece = $row[34];
        if($piece == 1 && $inventory > 0) {
          $price = $price * $inventory;
          $price = "$" . number_format($price, 2);
          $format_price = sprintf('%s / piece', $price);
        } else {
          $price = "$" . number_format($price, 2);
          $format_price = sprintf('%s / yard', $price);
        }

        $this->template->vars('cat_name', $cat_name);
        $this->template->vars('url_prms', $url_prms);
        $this->template->vars('filename', $filename);
        $this->template->vars('row', $row);
        $this->template->vars('piece', $piece);
        $this->template->vars('price', $price);
        $this->template->vars('inventory', $inventory);
        $this->template->vars('format_price', $format_price);
        $this->template->vars('hide_price', $row['hideprice']);
        $this->template->view_layout('inner');
      }
      $list = ob_get_contents();
      ob_end_clean();
      $this->main->template->vars('count_rows', $res_count_rows);
      $this->main->template->vars('list', $list);
      (new Controller_Paginator($this->main))->paginator($total, $page, 'product', $per_page);
    }

    /**
     * @export
     */
    public function shop() {
      $this->template->vars('cart_enable', '_');
      $this->show_category_list();
      $this->product_list();
      $this->main->view('shop');
    }

    /**
     * @export
     */
    public function last() {
      $this->template->vars('cart_enable', '_');
      //$this->show_category_list();
      $this->product_list_by_type('last', 50);
      $this->main->template->vars('page_title', 'What\'s New');
      $this->main->view('shop');
    }

    /**
     * @export
     */
    public function specials() {
      $this->template->vars('cart_enable', '_');
//      $this->show_category_list();
      $this->product_list_by_type('specials', 360);
      $page_title = "Limited time Specials.";
      $annotation = 'All specially priced items are at their marked down prices for a LIMITED TIME ONLY, after which they revert to their regular rates.<br>All items available on a FIRST COME, FIRST SERVED basis only.';
      $this->main->template->vars('page_title', $page_title);
      $this->main->template->vars('annotation', $annotation);
      $this->main->view('shop');
    }

    /**
     * @export
     */
    public function popular() {
      $this->template->vars('cart_enable', '_');
      $this->product_list_by_type('popular', 360);
      $this->main->template->vars('page_title', 'Popular Textile');
      $this->main->view('shop');
    }

    /**
     * @export
     */
    public function best() {
      $this->template->vars('cart_enable', '_');
//      $this->show_category_list();
      $this->product_list_by_type('best', 360);
      $this->main->template->vars('page_title', 'Best Textile');
      $this->main->view('shop');
    }

    /**
     * @export
     */
    public function bestsellers() {
      $this->template->vars('cart_enable', '_');
//      $this->show_category_list();
      $this->product_list_by_type('bsells', 360);
      $this->main->template->vars('page_title', 'Best Sellers');
      $this->main->view('shop');
    }

//    public function modify_products_images() {
//      $c_image = new Controller_Image();
//      $per_page = 12;
//      $page = 1;
//
//      $total = Model_Product::get_total_count();
//      $count = 0;
//      while($page <= ceil($total / $per_page)) {
//        $start = (($page++ - 1) * $per_page);
//        $rows = Model_Product::get_list($start, $per_page);
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
      $this->main->template->vars('ProductFilterList', Model_Product::product_filter_list());
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
      $cat_id = null;
      if(!empty(_A_::$app->get('cat'))) {
        $cat_id = Model_Blog::validData(_A_::$app->get('cat'));
        $category_name = Model_Blog::getPostCatName($cat_id);
      }

      $total = Model_Blog::get_count_publish_posts($cat_id);
      if($page > ceil($total / $per_page))
        $page = ceil($total / $per_page);
      if($page <= 0)
        $page = 1;
      $start = (($page - 1) * $per_page);

      $rows = Model_Blog::get_publish_post_list($cat_id, $start, $per_page, $res_count_rows);
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



  }