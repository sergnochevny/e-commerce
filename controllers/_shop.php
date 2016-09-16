<?php

class Controller_Shop extends Controller_Controller
{

    public function all_products()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();
        $image_suffix = 'b_';

        $page = !empty(_A_::$app->get('page')) ? $model->validData(_A_::$app->get('page')) : 1;

        $add_product_prms['page'] = $page;
        if (!empty(_A_::$app->get('cat'))) {
            $add_product_prms['cat'] = _A_::$app->get('cat');
        }

        $this->main->template->vars('add_product_href', _A_::$app->router()->UrlTo('product/add', $add_product_prms));

        $model->cleanTempProducts();
        $per_page = 12;

        $total = $model->get_count_products_by_type('all');
        if ($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
        if ($page <= 0) $page = 1;
        $start = (($page - 1) * $per_page);

        if (!empty(_A_::$app->get('cat'))) {
            $cat_id = $model->validData(_A_::$app->get('cat'));
        }
        $res_count_rows = 0;
        $rows = $model->get_products_by_type('all', $start, $per_page, $res_count_rows);
        $this->template->vars('count_rows', $res_count_rows);

        ob_start();
        foreach ($rows as $row) {
            $cat_name = $model->getCatName($row[20]);
            $row[8] = substr($row[8], 0, 100);

            $filename = 'upload/upload/' . $image_suffix . $row[14];
            if (!(file_exists($filename) && is_file($filename))) {
                $filename = 'upload/upload/not_image.jpg';
            }
            $filename = _A_::$app->router()->UrlTo($filename);

            $url_prms = ['p_id' => $row[0]];
            if (!empty(_A_::$app->get('page'))) {
                $url_prms['page'] = _A_::$app->get('page');
            }
            if (!empty(_A_::$app->get('cat'))) {
                $url_prms['cat'] = _A_::$app->get('cat');
            }

            $price = $row[5];
            $inventory = $row[6];
            $piece = $row[34];
            if ($piece == 1 && $inventory > 0) {
                $price = $price * $inventory;
                $price = "$" . number_format($price, 2);
                $format_price = sprintf('%s /piece', $price);
            } else {
                $price = "$" . number_format($price, 2);
                $format_price = sprintf('%s /yard', $price);
            }

            $this->template->vars('cat_name', $cat_name);
            $this->template->vars('url_prms', $url_prms);
            $this->template->vars('filename', $filename);
            $this->template->vars('row', $row);
            $this->template->vars('piece', $piece);
            $this->template->vars('price', $price);
            $this->template->vars('inventory', $inventory);
            $this->template->vars('format_price', $format_price);
            $this->template->vars('hide_price', $row['makePriceVis']);
            $this->template->view_layout('inner');
        }

        $list = ob_get_contents();
        ob_end_clean();
        $this->main->template->vars('list', $list);
        $paginator = new Controller_Paginator($this);
        $paginator->product_paginator($total, $page);
    }

    /*
     * @export
     */
    public function shop()
    {
        $this->template->vars('cart_enable', '_');
        $this->show_category_list();
        $this->product_list();
        $this->main->view('shop');
    }

    private function show_category_list()
    {
        $model = new Model_Tools();

        $items = $model->get_items_for_menu('all');
        ob_start();
        foreach ($items as $item) {
            $href = _A_::$app->router()->UrlTo('shop', ['cat' => $item['cid']]);
            $name = $item['cname'];
            $this->template->vars('href', $href, true);
            $this->template->vars('name', $name, true);
            $this->template->view_layout('category_item', 'menu');
        }
        $list_all_category = ob_get_contents();
        $this->template->vars('list_all_category', $list_all_category, true);
        ob_end_clean();
        ob_start();
        $this->template->view_layout('categories', 'menu');
        $list_categories = ob_get_contents();
        ob_end_clean();
        $this->main->template->vars('list_categories', $list_categories);
    }

    private function product_list()
    {
        $model = new Model_Product();
        $image_suffix = 'b_';
        $cart_items = isset(_A_::$app->session('cart')['items']) ? _A_::$app->session('cart')['items'] : [];
        $cart = array_keys($cart_items);

        if (!is_null(_A_::$app->session('s')) && (!empty(_A_::$app->post('s')))) {
            $search = mysql_real_escape_string(strtolower(htmlspecialchars(trim(_A_::$app->session('s')))));
            $this->template->vars('search', _A_::$app->post('s'));
        }

        $page = !empty(_A_::$app->get('page')) ? $model->validData(_A_::$app->get('page')) : 1;
        $per_page = 12;
        $total = $model->get_total($search);
        if ($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
        if ($page <= 0) $page = 1;
        $start = (($page - 1) * $per_page);
        if (!empty(_A_::$app->get('cat'))) {
            $cat_id = $model->validData(_A_::$app->get('cat'));
            $catigori_name = $model->getCatName($cat_id);
        } else {
            if (!empty(_A_::$app->get('ptrn'))) {
                $this->template->vars('ptrn_name', isset($ptrn_name) ? $ptrn_name : null);
            } else {
                if (!empty(_A_::$app->get('mnf'))) {
                    $mnf_id = $model->validData(_A_::$app->get('mnf'));
                    $mnf_name = $model->getMnfName($mnf_id);
                    $this->template->vars('mnf_name', isset($mnf_name) ? $mnf_name : null);
                }
            }
        }
        $rows = $model->get_products($start, $per_page, false, $search);
        $res_count_rows = $model->get_products($start, $per_page, true, $search);
        if ($rows) {
            $this->main->template->vars('count_rows', $res_count_rows);
            $mp = new Model_Price();
            $sys_hide_price = $mp->sysHideAllRegularPrices();
            $this->main->template->vars('sys_hide_price', $sys_hide_price);
            ob_start();
            foreach ($rows as $row) {
                $cat_name = $model->getCatName($row[20]);
                $row[8] = substr($row[8], 0, 100);
                $filename = 'upload/upload/' . $image_suffix . $row[14];
                if (!(file_exists($filename) && is_file($filename))) {
                    $filename = 'upload/upload/not_image.jpg';
                }
                $filename = _A_::$app->router()->UrlTo($filename);

                $opt = null;
                if (!empty(_A_::$app->get('page'))) {
                    $opt['page'] = _A_::$app->get('page');
                }
                if (!empty(_A_::$app->get('cat'))) {
                    $opt['cat'] = _A_::$app->get('cat');
                }
                if (!empty(_A_::$app->get('mnf'))) {
                    $opt['mnf'] = _A_::$app->get('mnf');
                }
                if (!empty(_A_::$app->get('ptrn'))) {
                    $opt['ptrn'] = _A_::$app->get('ptrn');
                }

                $pid = $row[0];
                $price = $row[5];
                $inventory = $row[6];
                $piece = $row[34];
                $format_price = '';
                $price = $mp->getPrintPrice($price, $format_price, $inventory, $piece);

                $discountIds = array();
                $saleprice = $row[5];
                $sDiscount = 0;
                $saleprice = $mp->calculateProductSalePrice($pid, $saleprice, $discountIds);
                $this->template->vars('bProductDiscount', $mp->checkProductDiscount($pid, $sDiscount, $saleprice, $discountIds));
                $format_sale_price = '';
                $this->template->vars('saleprice', $mp->getPrintPrice($saleprice, $format_sale_price, $inventory, $piece));
                $this->template->vars('format_sale_price', $format_sale_price);
                $this->template->vars('in_cart', in_array($row[0], $cart));
                $hide_price = $row['makePriceVis'];
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
            $this->main->template->vars('catigori_name', isset($catigori_name) ? $catigori_name : null);
            $this->main->template->vars('list', $list);

            $paginator = new Controller_Paginator($this);
            $paginator->product_paginator_home($total, $page);
        } else {
            $this->main->template->vars('count_rows', 0);
            $list = "No Result!!!";
            $this->main->template->vars('list', $list);
        }
    }

    /*
    * @export
    */
    public function last()
    {
        $this->template->vars('cart_enable', '_');
        $this->show_category_list();
        $this->product_list_by_type('last', 50);
        $this->main->template->vars('page_title', 'What\'s New');

        $this->main->view('shop');
    }

    private function product_list_by_type($type = 'last', $max_count_items = 50)
    {
        $model = new Model_Product();
        $image_suffix = 'b_';
        $cart_items = isset(_A_::$app->session('cart')['items']) ? _A_::$app->session('cart')['items'] : [];
        $cart = array_keys($cart_items);
        $page = !empty(_A_::$app->get('page')) ? $model->validData(_A_::$app->get('page')) : 1;
        $per_page = 12;

        if (!empty(_A_::$app->get('cat'))) {
            $cat_id = $model->validData(_A_::$app->get('cat'));
            $this->template->vars('cat_id', $cat_id);
        }

        $total = $model->get_count_products_by_type($type);
        if ($total > $max_count_items) $total = $max_count_items;
        if ($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
        if ($page <= 0) $page = 1;
        $start = (($page - 1) * $per_page);
        if ($total < ($start + $per_page)) $per_page = $total - $start;
        $res_count_rows = 0;
        $rows = $model->get_products_by_type($type, $start, $per_page, $res_count_rows);
        $this->template->vars('count_rows', $res_count_rows);

        if ($rows) {

            $mp = new Model_Price();

            $sys_hide_price = $mp->sysHideAllRegularPrices();
            $this->template->vars('sys_hide_price', $sys_hide_price);

            ob_start();
            foreach ($rows as $row) {
                $cat_name = $model->getCatName($row[20]);
                $row[8] = substr($row[8], 0, 100);
                $filename = 'upload/upload/' . $image_suffix . $row[14];
                if (!(file_exists($filename) && is_file($filename))) {
                    $filename = 'upload/upload/not_image.jpg';
                }
                $filename = _A_::$app->router()->UrlTo($filename);

                $url_prms = ['p_id' => $row[0]];
                if (!empty(_A_::$app->get('page'))) {
                    $url_prms['page'] = _A_::$app->get('page');
                }
                if (!empty(_A_::$app->get('cat'))) {
                    $url_prms['cat'] = _A_::$app->get('cat');
                }

                $pid = $row[0];
                $price = $row[5];
                $inventory = $row[6];
                $piece = $row[34];
                $format_price = '';
                $price = $mp->getPrintPrice($price, $format_price, $inventory, $piece);

                $discountIds = array();
                $saleprice = $row[5];
                $sDiscount = 0;
                $saleprice = $mp->calculateProductSalePrice($pid, $saleprice, $discountIds);
                $bProductDiscount = $mp->checkProductDiscount($pid, $sDiscount, $saleprice, $discountIds);
                $format_sale_price = '';
                $saleprice = $mp->getPrintPrice($saleprice, $format_sale_price, $inventory, $piece);

                $this->template->vars('cat_name', $cat_name);
                $this->template->vars('url_prms', $url_prms);
                $this->template->vars('filename', $filename);
                $this->template->vars('row', $row);
                $this->template->vars('pid', $pid);
                $this->template->vars('piece', $piece);
                $this->template->vars('price', $price);
                $this->template->vars('inventory', $inventory);
                $this->template->vars('format_sale_price', $format_sale_price);
                $this->template->vars('saleprice', $saleprice);
                $this->template->vars('bProductDiscount', $bProductDiscount);
                $this->template->vars('sDiscount', $sDiscount);
                $this->template->vars('in_cart', in_array($row[0], $cart));
                $this->template->vars('hide_price', $row['makePriceVis']);
                $this->template->view_layout($type);
            }

            $list = ob_get_contents();
            ob_end_clean();
            $this->main->template->vars('catigori_name', isset($catigori_name) ? $catigori_name : '');
            $this->main->template->vars('list', $list);

            (new Controller_Paginator($this))->product_paginator_home($total, $page, 'shop/' . $type);
        } else {
            $this->main->template->vars('count_rows', 0);
            $list = "No Result!!!";
            $this->main->template->vars('list', $list);
        }
    }

    /*
    * @export
    */
    public function specials()
    {
        $this->template->vars('cart_enable', '_');
        $this->show_category_list();
        $this->product_list_by_type('specials', 360);
        $page_title = "Limited time Specials.";
        $annotation = 'All specially priced items are at their marked down prices for a LIMITED TIME ONLY, after which they revert to their regular rates.<br>All items available on a FIRST COME, FIRST SERVED basis only.';
        $this->main->template->vars('page_title', $page_title);
        $this->main->template->vars('annotation', $annotation);
        $this->main->view('shop');
    }

    /*
    * @export
    */
    public function popular()
    {
        $this->template->vars('cart_enable', '_');
        $this->show_category_list();
        $this->product_list_by_type('popular', 360);
        $this->main->template->vars('page_title', 'Popular Textile');
        $this->main->view('shop');
    }

    /*
    * @export
    */
    public function best()
    {
        $this->template->vars('cart_enable', '_');
        $this->show_category_list();
        $this->product_list_by_type('best', 360);
        $this->main->template->vars('page_title', 'Best Textile');
        $this->main->view('shop');
    }

    public function modify_products_images()
    {
        $model = new Model_Product();
        $c_image = new Controller_Image();
        $per_page = 12;
        $page = 1;

        $total = $model->get_total_count();
        $count = 0;
        while ($page <= ceil($total / $per_page)) {
            $start = (($page++ - 1) * $per_page);
            $rows = $model->get_products_list($start, $per_page);
            foreach ($rows as $row) {
                for ($i = 1; $i < 5; $i++) {
                    $fimage = $row['image' . $i];
                    if (isset($fimage) && is_string($fimage) && strlen($fimage) > 0) {
                        $c_image->modify_products($fimage);
                    }
                }
            }
            $count += count($rows);
            echo $count;
        }

    }

    /*
    * @export
    */
    public function product_filtr_list()
    {
        $this->main->template->vars('ProductFiltrList', (new Model_Product())->product_filtr_list());
    }

    function widget_popular()
    {
        echo $this->widget_products('popular', 0, 5);
    }

    public function widget_products($type, $start, $limit, $layout = 'widget_products')
    {
        $model = new Model_Product();
        $rows = $model->get_prod_list_by_type($type, $start, $limit, $row_count, $image_suffix);
        if ($rows) {

            $mp = new Model_Price();

            $sys_hide_price = $mp->sysHideAllRegularPrices();
            $this->template->vars('sys_hide_price', $sys_hide_price);

            ob_start();
            $first = true;
            $last = false;
            $i = 1;
            foreach ($rows as $row) {
                $cat_name = $model->getCatName($row[20]);
                $row[8] = substr($row[8], 0, 100);

                $filename = 'upload/upload/' . $image_suffix . $row[14];
                if (!(file_exists($filename) && is_file($filename))) {
                    $filename = 'upload/upload/not_image.jpg';
                }
                $filename = _A_::$app->router()->UrlTo($filename);

                $pid = $row[0];
                $price = $row[5];
                $inventory = $row[6];
                $piece = $row[34];
                $format_price = '';
                $price = $mp->getPrintPrice($price, $format_price, $inventory, $piece);

                $discountIds = array();
                $saleprice = $row[5];
                $sDiscount = 0;
                $saleprice = $mp->calculateProductSalePrice($pid, $saleprice, $discountIds);
                $bProductDiscount = $mp->checkProductDiscount($pid, $sDiscount, $saleprice, $discountIds);
                $format_sale_price = '';
                $saleprice = $mp->getPrintPrice($saleprice, $format_sale_price, $inventory, $piece);

                $hide_price = $row['makePriceVis'];
                $this->template->vars('hide_price', $hide_price);

                $last = $i++ == $row_count;

                $this->template->vars('last', $last);
                $this->template->vars('first', $first);
                $this->template->vars('saleprice', $saleprice);
                $this->template->vars('format_sale_price', $format_sale_price);
                $this->template->vars('bProductDiscount', $bProductDiscount);
                $this->template->vars('sDiscount', $sDiscount);
                $this->template->vars('piece', $piece);
                $this->template->vars('inventory', $inventory);
                $this->template->vars('discountIds', $discountIds);
                $this->template->vars('pid', $pid);
                $this->template->vars('cat_name', $cat_name);
                $this->template->vars('filename', $filename);
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

    function widget_new()
    {
        echo $this->widget_products('new', 0, 5);
    }

    function widget_new_carousel()
    {
        echo $this->widget_products('carousel', 0, 30, 'widget_new_products_carousel');
    }

    function widget_best()
    {
        echo $this->widget_products('best', 0, 5);
    }

    function widget_bsells()
    {
        echo $this->widget_products('bsells', 3, 5);
    }

    function widget_bsells_horiz()
    {
        echo $this->widget_products('bsells', 0, 3, 'widget_bsells_products_horiz');
    }

}