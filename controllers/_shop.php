<?php

class Controller_Shop extends Controller_Controller
{

    public function produkt_list()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();
        $image_suffix = 'b_';
        $add_product_href = BASE_URL . '/add_product';

        $add_product_href .= '?page=';
        if (!empty(_A_::$app->get('page'))) {
            $add_product_href .= _A_::$app->get('page');
        } else
            $add_product_href .= '1';

        if (!empty(_A_::$app->get('cat'))) {
            $add_product_href .= '&cat=' . _A_::$app->get('cat');
        }
        $this->template->vars('add_product_href', $add_product_href);

        $model->cleanTempProducts();

        if (!empty(_A_::$app->get('page'))) {
            $page = $model->validData(_A_::$app->get('page'));
        } else {
            $page = 1;
        }
        $per_page = 12;

        if (!empty(_A_::$app->get('cat'))) {
            $cat_id = $model->validData(_A_::$app->get('cat'));
            $q_total = "SELECT COUNT(*) FROM `fabrix_products` a" .
                " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                " WHERE  a.pnumber is not null and b.cid='$cat_id'";
        } else {
            $q_total = "SELECT COUNT(*) FROM `fabrix_products` WHERE pnumber is not null ";
        }
        $res = mysql_query($q_total);
        $total = mysql_fetch_row($res)[0];

        if ($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
        if ($page <= 0) $page = 1;

        $start = (($page - 1) * $per_page);
        if (!empty(_A_::$app->get('cat'))) {
            $cat_id = $model->validData(_A_::$app->get('cat'));
            $q = "SELECT a.* FROM `fabrix_products` a" .
                " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
//                " WHERE  a.pnumber is not null and b.cid='$cat_id' ORDER BY a.dt DESC, a.pid DESC LIMIT $start,$per_page";
                " WHERE  a.pnumber is not null and b.cid='" . $cat_id . "'" .
                " ORDER BY b.display_order ASC, a.dt DESC, a.pid DESC" .
                " LIMIT $start,$per_page";
        } else {
            $q = "SELECT * FROM `fabrix_products` WHERE pnumber is not null" .
                " ORDER BY pid DESC" .
                " LIMIT $start,$per_page";
        }
        $res = mysql_query($q);
        $res_count_rows = mysql_num_rows($res);

        $this->template->vars('count_rows', $res_count_rows);

        ob_start();

        while ($row = mysql_fetch_array($res)) {
            $cat_name = $model->getCatName($row[20]);
            $row[8] = substr($row[8], 0, 100);
            $base_url = BASE_URL;

            $filename = 'upload/upload/' . $image_suffix . $row[14];
            if (!(file_exists($filename) && is_file($filename))) {
                $filename = 'upload/upload/not_image.jpg';
            }
            $filename = $base_url . '/' . $filename;

            $href = '';
            if (!empty(_A_::$app->get('page'))) {
                $href .= '&page=' . _A_::$app->get('page');
            }
            if (!empty(_A_::$app->get('cat'))) {
                $href .= '&cat=' . _A_::$app->get('cat');
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

            include('./views/product/product_inner.php');
        }

        $list = ob_get_contents();
        ob_end_clean();
        $this->template->vars('produkt_list', $list);
        $paginator = new Controller_Paginator($this);
        $paginator->produkt_paginator($total, $page);
    }

    /*
     * @export
     */
    public function shop()
    {
        $this->template->vars('cart_enable', '_');
        $this->show_category_list();
        $this->main_produkt_list();
        $this->main->view('shop');
    }

    private function show_category_list()
    {
        $model = new Model_Tools();
        $base_url = BASE_URL;

        $items = $model->get_items_for_menu('all');
        ob_start();
        foreach ($items as $item) {
            $href = $base_url . "/shop&cat=" . $item['cid'];
            $name = $item['cname'];
            $this->template->vars('href', $href, true);
            $this->template->vars('name', $name, true);
            $this->template->view_layout('category_item', 'menu');
        }
        $list_all_category = ob_get_contents();
        $this->template->vars('list_all_category', $list_all_category, true);
        ob_end_clean();
        ob_start();
        $this->template->view_layout('list_categories', 'menu');
        $list_categories = ob_get_contents();
        ob_end_clean();
        $this->template->vars('list_categories', $list_categories);
    }

    private function main_produkt_list()
    {
        $model = new Model_Product();
        $image_suffix = 'b_';
        if (isset($_SESSION['cart']['items'])) {
            $cart_items = $_SESSION['cart']['items'];
        } else {
            $cart_items = [];
        }
        $cart = array_keys($cart_items);
        if (isset($_POST['s']) && (!empty($_POST['s']{0}))) {
            $search = mysql_real_escape_string(strtolower(htmlspecialchars(trim($_POST['s']))));
            $this->template->vars('search', $_POST['s']);
        }

        if (!empty(_A_::$app->get('page'))) {
            $page = $model->validData(_A_::$app->get('page'));
        } else {
            $page = 1;
        }
        $per_page = 12;

        if (!empty(_A_::$app->get('cat'))) {
            $cat_id = $model->validData(_A_::$app->get('cat'));
            $q_total = "SELECT COUNT(*) FROM `fabrix_products` a" .
                " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cat_id'";
            if (isset($search)) {
                $q_total .= " and (LOWER(a.pnumber) like '%" . $search . "%'" .
                    " or LOWER(a.pname) like '%" . $search . "%'";
            }
        } else {
            if (!empty(_A_::$app->get('ptrn'))) {
                $ptrn_id = $model->validData(_A_::$app->get('ptrn'));
                $q_total = "SELECT COUNT(*) FROM `fabrix_products` a" .
                    " LEFT JOIN fabrix_product_patterns b ON a.pid = b.prodid " .
                    " WHERE  a.pnumber is not null and a.pvisible = '1' and b.patternId='$ptrn_id'";

                if (isset($search)) {
                    $q_total .= " and (LOWER(a.pnumber) like '%" . $search . "%'" .
                        " or LOWER(a.pname) like '%" . $search . "%')";
                }

            } else {
                if (!empty(_A_::$app->get('mnf'))) {
                    $mnf_id = $model->validData(_A_::$app->get('mnf'));
                    $q_total = "SELECT COUNT(*) FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1' and manufacturerId = '$mnf_id'";
                    if (isset($search)) {
                        $q_total .= " and (LOWER(pnumber) like '%" . $search . "%'" .
                            " or LOWER(pname) like '%" . $search . "%')";
                    }
                } else {
                    $q_total = "SELECT COUNT(*) FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1' ";
                    if (isset($search)) {
                        $q_total .= " and (LOWER(pnumber) like '%" . $search . "%'" .
                            " or LOWER(pname) like '%" . $search . "%')";
                    }
                }
            }
        }


        $res = mysql_query($q_total);
        $total = mysql_fetch_row($res)[0];

        if ($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
        if ($page <= 0) $page = 1;

        $start = (($page - 1) * $per_page);
        if (!empty(_A_::$app->get('cat'))) {
            $cat_id = $model->validData(_A_::$app->get('cat'));
            $catigori_name = $model->getCatName($cat_id);
            $q = "SELECT a.* FROM `fabrix_products` a" .
                " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cat_id'";

            if (isset($search)) {
                $q .= " and (LOWER(a.pnumber) like '%" . $search . "%'" .
                    " or LOWER(a.pname) like '%" . $search . "%')";
            }

//            $q .= " ORDER BY a.dt DESC, a.pid DESC LIMIT $start,$per_page";
            $q .= " ORDER BY b.display_order LIMIT $start,$per_page";
        } else {
            if (!empty(_A_::$app->get('ptrn'))) {
                $ptrn_id = $model->validData(_A_::$app->get('ptrn'));
                $ptrn_name = $model->getPtrnName($ptrn_id);
                $q = "SELECT a.* FROM `fabrix_products` a" .
                    " LEFT JOIN fabrix_product_patterns b ON a.pid = b.prodId " .
                    " WHERE  a.pnumber is not null and a.pvisible = '1' and b.patternId='$ptrn_id'";

                if (isset($search)) {
                    $q .= " and (LOWER(a.pnumber) like '%" . $search . "%'" .
                        " or LOWER(a.pname) like '%" . $search . "%')";
                }

                $q .= " ORDER BY a.dt DESC, a.pid DESC LIMIT $start,$per_page";

                $this->template->vars('ptrn_name', isset($ptrn_name) ? $ptrn_name : null);
            } else {
                if (!empty(_A_::$app->get('mnf'))) {
                    $mnf_id = $model->validData(_A_::$app->get('mnf'));
                    $mnf_name = $model->getMnfName($mnf_id);
                    $q = "SELECT * FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1' and manufacturerId = '$mnf_id'";
                    if (isset($search)) {
                        $q .= " and (LOWER(pnumber) like '%" . $search . "%'" .
                            " or LOWER(pname) like '%" . $search . "%')";
                    }
                    $q .= " ORDER BY dt DESC, pid DESC LIMIT $start,$per_page";

                    $this->template->vars('mnf_name', isset($mnf_name) ? $mnf_name : null);
                } else {

                    $q = "SELECT * FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1'";

                    if (isset($search)) {
                        $q .= " and (LOWER(pnumber) like '%" . $search . "%'" .
                            " or LOWER(pname) like '%" . $search . "%')";
                    }

                    $q .= " ORDER BY dt DESC, pid DESC LIMIT $start,$per_page";
                }
            }
        }
        $res = mysql_query($q);
        if ($res) {
            $res_count_rows = mysql_num_rows($res);
            $this->template->vars('count_rows', $res_count_rows);

            $mp = new Model_Price();

            $sys_hide_price = $mp->sysHideAllRegularPrices();
            $this->template->vars('sys_hide_price', $sys_hide_price);

            ob_start();
            while ($row = mysql_fetch_array($res)) {
                $cat_name = $model->getCatName($row[20]);
                $row[8] = substr($row[8], 0, 100);
                $base_url = BASE_URL;

                $filename = 'upload/upload/' . $image_suffix . $row[14];
                if (!(file_exists($filename) && is_file($filename))) {
                    $filename = 'upload/upload/not_image.jpg';
                }
                $filename = $base_url . '/' . $filename;

                $href = '';
                if (!empty(_A_::$app->get('page'))) {
                    $href .= '&page=' . _A_::$app->get('page');
                }
                if (!empty(_A_::$app->get('cat'))) {
                    $href .= '&cat=' . _A_::$app->get('cat');
                }
                if (!empty(_A_::$app->get('mnf'))) {
                    $href .= '&mnf=' . _A_::$app->get('mnf');
                }
                if (!empty(_A_::$app->get('ptrn'))) {
                    $href .= '&ptrn=' . _A_::$app->get('ptrn');
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

                $in_cart = in_array($row[0], $cart);

                $hide_price = $row['makePriceVis'];
                $this->template->vars('hide_price', $hide_price);

                include('./views/product/main_produkt_list.php');
            }

            $list = ob_get_contents();
            ob_end_clean();
            $this->template->vars('catigori_name', isset($catigori_name) ? $catigori_name : null);
            $this->template->vars('main_produkt_list', $list);

            $paginator = new Controller_Paginator($this);
            $paginator->produkt_paginator_home($total, $page);
        } else {
            $this->template->vars('count_rows', 0);
            $list = "No Result!!!";
            $this->template->vars('main_produkt_list', $list);
        }
    }

    /*
    * @export
    */
    public function last()
    {
        $this->template->vars('cart_enable', '_');
        $this->show_category_list();
        $this->main_produkt_list_new();
        $page_title = "What's New";
        $this->template->vars('page_title', $page_title);

        $this->main->view('shop');
    }

    private function main_produkt_list_new()
    {
        $max_count_new_items = 50;
        $model = new Model_Product();
        $image_suffix = 'b_';
        if (isset($_SESSION['cart']['items'])) {
            $cart_items = $_SESSION['cart']['items'];
        } else {
            $cart_items = [];
        }
        $cart = array_keys($cart_items);

        if (!empty(_A_::$app->get('page'))) {
            $page = $model->validData(_A_::$app->get('page'));
        } else {
            $page = 1;
        }
        $per_page = 12;

        if (!empty(_A_::$app->get('cat'))) {
            $cat_id = $model->validData(_A_::$app->get('cat'));

            $q_total = "SELECT COUNT(*) FROM `fabrix_products` a" .
                " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cat_id'";

        } else {
            $q_total = "SELECT COUNT(*) FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1' ORDER BY dt DESC";
        }
        $res = mysql_query($q_total);
        $total = mysql_fetch_row($res)[0];
        if ($total > $max_count_new_items) $total = $max_count_new_items;

        if ($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
        if ($page <= 0) $page = 1;

        $start = (($page - 1) * $per_page);

        if ($total < ($start + $per_page)) $per_page = $total - $start;

        if (!empty(_A_::$app->get('cat'))) {
            $cat_id = $model->validData(_A_::$app->get('cat'));
            $catigori_name = $model->getCatName($cat_id);
            $q = "SELECT a.* FROM `fabrix_products` a" .
                " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cat_id' ORDER BY a.dt DESC, a.pid DESC LIMIT $start,$per_page";
        } else {
            $q = "SELECT * FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1' ORDER BY  dt DESC, pid DESC LIMIT $start,$per_page";
        }
        $res = mysql_query($q);
        if ($res) {
            $res_count_rows = mysql_num_rows($res);
            $this->template->vars('count_rows', $res_count_rows);

            $mp = new Model_Price();

            $sys_hide_price = $mp->sysHideAllRegularPrices();
            $this->template->vars('sys_hide_price', $sys_hide_price);

            ob_start();
            while ($row = mysql_fetch_array($res)) {
                $cat_name = $model->getCatName($row[20]);
                $row[8] = substr($row[8], 0, 100);
                $base_url = BASE_URL;
                $filename = 'upload/upload/' . $image_suffix . $row[14];
                if (!(file_exists($filename) && is_file($filename))) {
                    $filename = 'upload/upload/not_image.jpg';
                }
                $filename = $base_url . '/' . $filename;

                $href = '';
                if (!empty(_A_::$app->get('page'))) {
                    $href .= '&page=' . _A_::$app->get('page');
                }
                if (!empty(_A_::$app->get('cat'))) {
                    $href .= '&cat=' . _A_::$app->get('cat');
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

                $in_cart = in_array($row[0], $cart);

                $hide_price = $row['makePriceVis'];
                $this->template->vars('hide_price', $hide_price);

                include('./views/product/main_produkt_list_new.php');
            }

            $list = ob_get_contents();
            ob_end_clean();
            $this->template->vars('catigori_name', isset($catigori_name) ? $catigori_name : '');
            $this->template->vars('main_produkt_list', $list);

            $paginator = new Controller_Paginator($this);
            $paginator->produkt_paginator_home($total, $page, 'shop/last');
        } else {
            $this->template->vars('count_rows', 0);
            $list = "No Result!!!";
            $this->template->vars('main_produkt_list', $list);
        }
    }

    /*
    * @export
    */
    public function specials()
    {
        $this->template->vars('cart_enable', '_');
        $this->show_category_list();
        $this->main_produkt_list_specials();
        $page_title = "Limited time Specials.";
        $this->template->vars('page_title', $page_title);

        $this->main->view('shop');
    }

    private function main_produkt_list_specials()
    {
        $max_count_new_items = 50;
        $model = new Model_Product();
        $image_suffix = 'b_';
        if (isset($_SESSION['cart']['items'])) {
            $cart_items = $_SESSION['cart']['items'];
        } else {
            $cart_items = [];
        }
        $cart = array_keys($cart_items);

        if (!empty(_A_::$app->get('page'))) {
            $page = $model->validData(_A_::$app->get('page'));
        } else {
            $page = 1;
        }
        $per_page = 12;

        if (!empty(_A_::$app->get('cat'))) {
            $cat_id = $model->validData(_A_::$app->get('cat'));

            $q_total = "SELECT COUNT(*) FROM `fabrix_products` a" .
                " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                " WHERE  a.pnumber is not null and a.pvisible = '1' and a.specials='1' and b.cid='$cat_id'";

        } else {
            $q_total = "SELECT COUNT(*) FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1' and specials='1' ORDER BY dt DESC";
        }
        $res = mysql_query($q_total);
        $total = mysql_fetch_row($res)[0];
        if ($total > $max_count_new_items) $total = $max_count_new_items;

        if ($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
        if ($page <= 0) $page = 1;

        $start = (($page - 1) * $per_page);

        if ($total < ($start + $per_page)) $per_page = $total - $start;

        if (!empty(_A_::$app->get('cat'))) {
            $cat_id = $model->validData(_A_::$app->get('cat'));
            $catigori_name = $model->getCatName($cat_id);
            $q = "SELECT a.* FROM `fabrix_products` a" .
                " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                " WHERE  a.pnumber is not null and a.pvisible = '1' and a.specials='1' and b.cid='$cat_id'" .
                " ORDER BY a.dt DESC, a.pid DESC LIMIT $start,$per_page";
        } else {
            $q = "SELECT * FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1' and specials='1'" .
                " ORDER BY  dt DESC, pid DESC LIMIT $start,$per_page";
        }
        $res = mysql_query($q);
        if ($res) {
            $res_count_rows = mysql_num_rows($res);
            $this->template->vars('count_rows', $res_count_rows);

            $mp = new Model_Price();

            $sys_hide_price = $mp->sysHideAllRegularPrices();
            $this->template->vars('sys_hide_price', $sys_hide_price);

            ob_start();
            while ($row = mysql_fetch_array($res)) {
                $cat_name = $model->getCatName($row[20]);
                $row[8] = substr($row[8], 0, 100);
                $base_url = BASE_URL;
                $filename = 'upload/upload/' . $image_suffix . $row[14];
                if (!(file_exists($filename) && is_file($filename))) {
                    $filename = 'upload/upload/not_image.jpg';
                }
                $filename = $base_url . '/' . $filename;

                $href = '';
                if (!empty(_A_::$app->get('page'))) {
                    $href .= '&page=' . _A_::$app->get('page');
                }
                if (!empty(_A_::$app->get('cat'))) {
                    $href .= '&cat=' . _A_::$app->get('cat');
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

                $in_cart = in_array($row[0], $cart);

                $hide_price = $row['makePriceVis'];
                $this->template->vars('hide_price', $hide_price);

                include('./views/product/main_produkt_list_specials.php');
            }

            $list = ob_get_contents();
            ob_end_clean();
            $this->template->vars('catigori_name', isset($catigori_name) ? $catigori_name : '');
            $this->template->vars('main_produkt_list', $list);

            $annotation = 'All specially priced items are at their marked down prices for a LIMITED TIME ONLY, after which they revert to their regular rates.<br>All items available on a FIRST COME, FIRST SERVED basis only.';

            $this->template->vars('annotation', $annotation);

            $paginator = new Controller_Paginator($this);
            $paginator->produkt_paginator_home($total, $page, 'shop_specials');
        } else {
            $this->template->vars('count_rows', 0);
            $list = "No Result!!!";
            $this->template->vars('main_produkt_list', $list);
        }
    }

    /*
    * @export
    */
    public function popular()
    {
        $this->template->vars('cart_enable', '_');
        $this->show_category_list();
        $this->main_produkt_list_popular();
        $page_title = "Popular Textile";
        $this->template->vars('page_title', $page_title);

        $this->main->view('shop');
    }

    private function main_produkt_list_popular()
    {
        $max_count_new_items = 360;
        $model = new Model_Product();
        $image_suffix = 'b_';
        if (isset($_SESSION['cart']['items'])) {
            $cart_items = $_SESSION['cart']['items'];
        } else {
            $cart_items = [];
        }
        $cart = array_keys($cart_items);

        if (!empty(_A_::$app->get('page'))) {
            $page = $model->validData(_A_::$app->get('page'));
        } else {
            $page = 1;
        }
        $per_page = 12;

        if (!empty(_A_::$app->get('cat'))) {
            $cat_id = $model->validData(_A_::$app->get('cat'));
            $q_total = "SELECT COUNT(*) FROM `fabrix_products` a" .
                " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cat_id'";
        } else {
            $q_total = "SELECT COUNT(*) FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1'";
        }
        $res = mysql_query($q_total);
        $total = mysql_fetch_row($res)[0];
        if ($total > $max_count_new_items) $total = $max_count_new_items;

        if ($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
        if ($page <= 0) $page = 1;

        $start = (($page - 1) * $per_page);

        if ($total < ($start + $per_page)) $per_page = $total - $start;

        if (!empty(_A_::$app->get('cat'))) {
            $cat_id = $model->validData(_A_::$app->get('cat'));
            $catigori_name = $model->getCatName($cat_id);
            $q = "SELECT a.* FROM `fabrix_products` a" .
                " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cat_id' ORDER BY popular DESC LIMIT $start,$per_page";
        } else {
            $q = "SELECT * FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1' ORDER BY popular DESC LIMIT $start,$per_page";
        }
        $res = mysql_query($q);
        if ($res) {
            $res_count_rows = mysql_num_rows($res);
            $this->template->vars('count_rows', $res_count_rows);

            $mp = new Model_Price();

            $sys_hide_price = $mp->sysHideAllRegularPrices();
            $this->template->vars('sys_hide_price', $sys_hide_price);

            ob_start();
            while ($row = mysql_fetch_array($res)) {
                $cat_name = $model->getCatName($row[20]);
                $row[8] = substr($row[8], 0, 100);
                $base_url = BASE_URL;

                $filename = 'upload/upload/' . $image_suffix . $row[14];
                if (!(file_exists($filename) && is_file($filename))) {
                    $filename = 'upload/upload/not_image.jpg';
                }
                $filename = $base_url . '/' . $filename;

                $href = '';
                if (!empty(_A_::$app->get('page'))) {
                    $href .= '&page=' . _A_::$app->get('page');
                }
                if (!empty(_A_::$app->get('cat'))) {
                    $href .= '&cat=' . _A_::$app->get('cat');
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

                $in_cart = in_array($row[0], $cart);

                $hide_price = $row['makePriceVis'];
                $this->template->vars('hide_price', $hide_price);

                include('./views/product/main_produkt_list_popular.php');
            }

            $list = ob_get_contents();
            ob_end_clean();
            $this->template->vars('catigori_name', isset($catigori_name) ? $catigori_name : '');
            $this->template->vars('main_produkt_list', $list);

            $paginator = new Controller_Paginator($this);
            $paginator->produkt_paginator_home($total, $page, 'shop_popular');
        } else {
            $this->template->vars('count_rows', 0);
            $list = "No Result!!!";
            $this->template->vars('main_produkt_list', $list);
        }
    }

    /*
    * @export
    */
    public function best()
    {
        $this->template->vars('cart_enable', '_');
        $this->show_category_list();
        $this->main_produkt_list_best();
        $page_title = "Best Textile";
        $this->template->vars('page_title', $page_title);

        $this->main->view('shop');
    }

    private function main_produkt_list_best()
    {
        $model = new Model_Product();
        $image_suffix = 'b_';
        if (isset($_SESSION['cart']['items'])) {
            $cart_items = $_SESSION['cart']['items'];
        } else {
            $cart_items = [];
        }
        $cart = array_keys($cart_items);

        if (!empty(_A_::$app->get('page'))) {
            $page = $model->validData(_A_::$app->get('page'));
        } else {
            $page = 1;
        }
        $per_page = 12;

        if (!empty(_A_::$app->get('cat'))) {
            $cat_id = $model->validData(_A_::$app->get('cat'));
            $q_total = "SELECT COUNT(*) FROM `fabrix_products` a" .
                " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                " WHERE  a.pnumber is not null and a.best='1' and a.pvisible = '1' and b.cid='$cat_id'";
        } else {
            $q_total = "SELECT COUNT(*) FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1' and best = '1'";
        }
        $res = mysql_query($q_total);
        $total = mysql_fetch_row($res)[0];

        if ($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
        if ($page <= 0) $page = 1;

        $start = (($page - 1) * $per_page);

        if (!empty(_A_::$app->get('cat'))) {
            $cat_id = $model->validData(_A_::$app->get('cat'));
            $catigori_name = $model->getCatName($cat_id);
            $q = "SELECT a.* FROM `fabrix_products` a" .
                " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                " WHERE  a.pnumber is not null and a.pvisible = '1'  and a.best = '1' and b.cid='$cat_id' ORDER BY a.dt DESC, a.pid DESC LIMIT $start,$per_page";
        } else {
            $q = "SELECT * FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1' and best = '1' ORDER BY dt DESC, pid DESC LIMIT $start,$per_page";
        }
        $res = mysql_query($q);
        if ($res) {
            $res_count_rows = mysql_num_rows($res);
            $this->template->vars('count_rows', $res_count_rows);

            $mp = new Model_Price();

            $sys_hide_price = $mp->sysHideAllRegularPrices();
            $this->template->vars('sys_hide_price', $sys_hide_price);

            ob_start();
            while ($row = mysql_fetch_array($res)) {
                $cat_name = $model->getCatName($row[20]);
                $row[8] = substr($row[8], 0, 100);
                $base_url = BASE_URL;

                $filename = 'upload/upload/' . $image_suffix . $row[14];
                if (!(file_exists($filename) && is_file($filename))) {
                    $filename = 'upload/upload/not_image.jpg';
                }
                $filename = $base_url . '/' . $filename;

                $href = '';
                if (!empty(_A_::$app->get('page'))) {
                    $href .= '&page=' . _A_::$app->get('page');
                }
                if (!empty(_A_::$app->get('cat'))) {
                    $href .= '&cat=' . _A_::$app->get('cat');
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

                $in_cart = in_array($row[0], $cart);

                $hide_price = $row['makePriceVis'];
                $this->template->vars('hide_price', $hide_price);

                include('./views/product/main_produkt_list_best.php');
            }

            $list = ob_get_contents();
            ob_end_clean();
            $this->template->vars('catigori_name', isset($catigori_name) ? $catigori_name : '');
            $this->template->vars('main_produkt_list', $list);

            $paginator = new Controller_Paginator($this);
            $paginator->produkt_paginator_home($total, $page, 'shop_best');

        } else {
            $this->template->vars('count_rows', 0);
            $list = "No Result!!!";
            $this->template->vars('main_produkt_list', $list);
        }
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
                $base_url = BASE_URL;

                $filename = 'upload/upload/' . $image_suffix . $row[14];
                if (!(file_exists($filename) && is_file($filename))) {
                    $filename = 'upload/upload/not_image.jpg';
                }
                $filename = $base_url . '/' . $filename;

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

                include('./views/widgets/' . $layout . '.php');
                $first = false;
            }

            $list = ob_get_contents();
            ob_end_clean();

        } else {
            $list = "No Result!!!";
        }
        return $list;
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
                        $c_image->modify_images_products($fimage);
                    }
                }
            }
            $count += count($rows);
            echo $count;
        }

    }

    public function produkt_filtr_list()
    {
        $model = new Model_Product();
        $data = $model->produkt_filtr_list();
        $this->template->vars('ProductFiltrList', $data);
    }
}