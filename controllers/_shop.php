<?php

class Controller_Shop extends Controller_Base
{

    protected $main;

    function __construct($main)
    {

        $this->main = $main;
        $this->registry = $main->registry;
        $this->template = $main->template;

    }

    function produkt_list()
    {
        $this->main->test_access_rights();
        $model = new Model_Users();
        $image_suffix = 'b_';
        $add_product_href = BASE_URL . '/add_product';

        $add_product_href .= '?page=';
        if (!empty($_GET['page'])) {
            $add_product_href .= $_GET['page'];
        } else
            $add_product_href .= '1';

        if (!empty($_GET['cat'])) {
            $add_product_href .= '&cat=' . $_GET['cat'];
        }
        $this->template->vars('add_product_href', $add_product_href);

        $model->cleanTempProducts();

        if (!empty($_GET['page'])) {
            $userInfo = $model->validData($_GET['page']);
            $page = $userInfo['data'];
        } else {
            $page = 1;
        }
        $per_page = 12;

        if (!empty($_GET['cat'])) {
            $userInfo = $model->validData($_GET['cat']);
            $cat_id = $userInfo['data'];
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
        if (!empty($_GET['cat'])) {
            $userInfo = $model->validData($_GET['cat']);
            $cat_id = $userInfo['data'];
            $q = "SELECT a.* FROM `fabrix_products` a" .
                " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                " WHERE  a.pnumber is not null and b.cid='$cat_id' ORDER BY a.dt DESC, a.pid DESC LIMIT $start,$per_page";
        } else {
            $q = "SELECT * FROM `fabrix_products` WHERE pnumber is not null ORDER BY pid DESC LIMIT $start,$per_page";
        }
        $res = mysql_query($q);
        $res_count_rows = mysql_num_rows($res);

        $this->template->vars('count_rows', $res_count_rows);

        ob_start();

        while ($row = mysql_fetch_array($res)) {
            $userInfo = $model->getCatName($row[20]);
            $cat_name = $userInfo['cname'];
            $row[8] = substr($row[8], 0, 100);
            $base_url = BASE_URL;

            $filename = 'upload/upload/' . $image_suffix . $row[14];
            if (!(file_exists($filename) && is_file($filename))) {
                $filename = 'upload/upload/not_image.jpg';
            }
            $filename = $base_url . '/' . $filename;

            $href = '';
            if (!empty($_GET['page'])) {
                $href .= '&page=' . $_GET['page'];
            }
            if (!empty($_GET['cat'])) {
                $href .= '&cat=' . $_GET['cat'];
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

            include('./views/index/product/product_inner.php');
        }

        $list = ob_get_contents();
        ob_end_clean();
        $this->template->vars('produkt_list', $list);

        include_once('controllers/_paginator.php');
        $paginator = new Controller_Paginator($this);
        $paginator->produkt_paginator($total, $page);
    }

    function produkt_filtr_list()
    {
        $model = new Model_Users();
        $userInfo = $model->produkt_filtr_list();
        $this->template->vars('ProductFiltrList', $userInfo);
    }

    private function show_category_list()
    {
        $model = new Model_Users();
        $base_url = BASE_URL;

        $items = $model->get_items_for_menu('all');
        ob_start();
        foreach ($items as $item) {
            $href = $base_url . "/shop&cat=" . $item['cid'];
            $name = $item['cname'];
            include('views/index/menu/category_item.php');
        }
        $list_all_category = ob_get_contents();
        ob_end_clean();
        ob_start();
        include('views/index/menu/list_categories.php');
        $list_categories = ob_get_contents();
        ob_end_clean();
        $this->template->vars('list_categories', $list_categories);
    }

    function shop()
    {
        $this->template->vars('cart_enable', '_');
        $this->show_category_list();
        $this->main_produkt_list();
        $this->main->view('shop');
    }

    function shop_last()
    {
        $this->template->vars('cart_enable', '_');
        $this->show_category_list();
        $this->main_produkt_list_new();
        $page_title = "What's New";
        $this->template->vars('page_title', $page_title);

        $this->main->view('shop');
    }

    function shop_specials()
    {
        $this->template->vars('cart_enable', '_');
        $this->show_category_list();
        $this->main_produkt_list_specials();
        $page_title = "Limited time Specials.";
        $this->template->vars('page_title', $page_title);

        $this->main->view('shop');
    }

    function shop_popular()
    {
        $this->template->vars('cart_enable', '_');
        $this->show_category_list();
        $this->main_produkt_list_popular();
        $page_title = "Popular Textile";
        $this->template->vars('page_title', $page_title);

        $this->main->view('shop');
    }

    function shop_best()
    {
        $this->template->vars('cart_enable', '_');
        $this->show_category_list();
        $this->main_produkt_list_best();
        $page_title = "Best Textile";
        $this->template->vars('page_title', $page_title);

        $this->main->view('shop');
    }

    function main_produkt_list()
    {
        $model = new Model_Users();
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

        if (!empty($_GET['page'])) {
            $userInfo = $model->validData($_GET['page']);
            $page = $userInfo['data'];
        } else {
            $page = 1;
        }
        $per_page = 12;

        if (!empty($_GET['cat'])) {
            $userInfo = $model->validData($_GET['cat']);
            $cat_id = $userInfo['data'];

            $q_total = "SELECT COUNT(*) FROM `fabrix_products` a" .
                " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cat_id'";
            if (isset($search)) {
                $q_total .= " and (LOWER(a.pnumber) like '%" . $search . "%'" .
                    " or LOWER(a.pname) like '%" . $search . "%'";
            }
        } else {
            if (!empty($_GET['ptrn'])) {
                $userInfo = $model->validData($_GET['ptrn']);
                $ptrn_id = $userInfo['data'];

                $q_total = "SELECT COUNT(*) FROM `fabrix_products` a" .
                    " LEFT JOIN fabrix_product_patterns b ON a.pid = b.prodid " .
                    " WHERE  a.pnumber is not null and a.pvisible = '1' and b.patternId='$ptrn_id'";

                if (isset($search)) {
                    $q_total .= " and (LOWER(a.pnumber) like '%" . $search . "%'" .
                        " or LOWER(a.pname) like '%" . $search . "%')";
                }

            } else {
                if (!empty($_GET['mnf'])) {
                    $userInfo = $model->validData($_GET['mnf']);
                    $mnf_id = $userInfo['data'];

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
        if (!empty($_GET['cat'])) {
            $userInfo = $model->validData($_GET['cat']);
            $cat_id = $userInfo['data'];
            $catigori_name = $model->getCatName($cat_id);
            $q = "SELECT a.* FROM `fabrix_products` a" .
                " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cat_id'";

            if (isset($search)) {
                $q .= " and (LOWER(a.pnumber) like '%" . $search . "%'" .
                    " or LOWER(a.pname) like '%" . $search . "%')";
            }

            $q .= " ORDER BY a.dt DESC, a.pid DESC LIMIT $start,$per_page";
        } else {
            if (!empty($_GET['ptrn'])) {
                $userInfo = $model->validData($_GET['ptrn']);
                $ptrn_id = $userInfo['data'];
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
                if (!empty($_GET['mnf'])) {
                    $userInfo = $model->validData($_GET['mnf']);
                    $mnf_id = $userInfo['data'];
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
                $userInfo = $model->getCatName($row[20]);
                $cat_name = $userInfo['cname'];
                $row[8] = substr($row[8], 0, 100);
                $base_url = BASE_URL;

                $filename = 'upload/upload/' . $image_suffix . $row[14];
                if (!(file_exists($filename) && is_file($filename))) {
                    $filename = 'upload/upload/not_image.jpg';
                }
                $filename = $base_url . '/' . $filename;

                $href = '';
                if (!empty($_GET['page'])) {
                    $href .= '&page=' . $_GET['page'];
                }
                if (!empty($_GET['cat'])) {
                    $href .= '&cat=' . $_GET['cat'];
                }
                if (!empty($_GET['mnf'])) {
                    $href .= '&mnf=' . $_GET['mnf'];
                }
                if (!empty($_GET['ptrn'])) {
                    $href .= '&ptrn=' . $_GET['ptrn'];
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

                include('./views/index/product/main_produkt_list.php');
            }

            $list = ob_get_contents();
            ob_end_clean();
            $this->template->vars('catigori_name', isset($catigori_name) ? $catigori_name : null);
            $this->template->vars('main_produkt_list', $list);

            include_once('controllers/_paginator.php');
            $paginator = new Controller_Paginator($this);
            $paginator->produkt_paginator_home($total, $page);
        } else {
            $this->template->vars('count_rows', 0);
            $list = "No Result!!!";
            $this->template->vars('main_produkt_list', $list);
        }
    }

    function main_produkt_list_new()
    {
        $max_count_new_items = 50;
        $model = new Model_Users();
        $image_suffix = 'b_';
        if (isset($_SESSION['cart']['items'])) {
            $cart_items = $_SESSION['cart']['items'];
        } else {
            $cart_items = [];
        }
        $cart = array_keys($cart_items);

        if (!empty($_GET['page'])) {
            $userInfo = $model->validData($_GET['page']);
            $page = $userInfo['data'];
        } else {
            $page = 1;
        }
        $per_page = 12;

        if (!empty($_GET['cat'])) {
            $userInfo = $model->validData($_GET['cat']);
            $cat_id = $userInfo['data'];

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

        if (!empty($_GET['cat'])) {
            $userInfo = $model->validData($_GET['cat']);
            $cat_id = $userInfo['data'];
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
                $userInfo = $model->getCatName($row[20]);
                $cat_name = $userInfo['cname'];
                $row[8] = substr($row[8], 0, 100);
                $base_url = BASE_URL;
                $filename = 'upload/upload/' . $image_suffix . $row[14];
                if (!(file_exists($filename) && is_file($filename))) {
                    $filename = 'upload/upload/not_image.jpg';
                }
                $filename = $base_url . '/' . $filename;

                $href = '';
                if (!empty($_GET['page'])) {
                    $href .= '&page=' . $_GET['page'];
                }
                if (!empty($_GET['cat'])) {
                    $href .= '&cat=' . $_GET['cat'];
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

                include('./views/index/product/main_produkt_list_new.php');
            }

            $list = ob_get_contents();
            ob_end_clean();
            $this->template->vars('catigori_name', isset($catigori_name) ? $catigori_name : '');
            $this->template->vars('main_produkt_list', $list);

            include_once('controllers/_paginator.php');
            $paginator = new Controller_Paginator($this);
            $paginator->produkt_paginator_home($total, $page, 'shop_last');
        } else {
            $this->template->vars('count_rows', 0);
            $list = "No Result!!!";
            $this->template->vars('main_produkt_list', $list);
        }
    }

    function main_produkt_list_specials()
    {
        $max_count_new_items = 50;
        $model = new Model_Users();
        $image_suffix = 'b_';
        if (isset($_SESSION['cart']['items'])) {
            $cart_items = $_SESSION['cart']['items'];
        } else {
            $cart_items = [];
        }
        $cart = array_keys($cart_items);

        if (!empty($_GET['page'])) {
            $userInfo = $model->validData($_GET['page']);
            $page = $userInfo['data'];
        } else {
            $page = 1;
        }
        $per_page = 12;

        if (!empty($_GET['cat'])) {
            $userInfo = $model->validData($_GET['cat']);
            $cat_id = $userInfo['data'];

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

        if (!empty($_GET['cat'])) {
            $userInfo = $model->validData($_GET['cat']);
            $cat_id = $userInfo['data'];
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
                $userInfo = $model->getCatName($row[20]);
                $cat_name = $userInfo['cname'];
                $row[8] = substr($row[8], 0, 100);
                $base_url = BASE_URL;
                $filename = 'upload/upload/' . $image_suffix . $row[14];
                if (!(file_exists($filename) && is_file($filename))) {
                    $filename = 'upload/upload/not_image.jpg';
                }
                $filename = $base_url . '/' . $filename;

                $href = '';
                if (!empty($_GET['page'])) {
                    $href .= '&page=' . $_GET['page'];
                }
                if (!empty($_GET['cat'])) {
                    $href .= '&cat=' . $_GET['cat'];
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

                include('./views/index/product/main_produkt_list_specials.php');
            }

            $list = ob_get_contents();
            ob_end_clean();
            $this->template->vars('catigori_name', isset($catigori_name) ? $catigori_name : '');
            $this->template->vars('main_produkt_list', $list);

            $annotation = 'All specially priced items are at their marked down prices for a LIMITED TIME ONLY, after which they revert to their regular rates.<br>All items available on a FIRST COME, FIRST SERVED basis only.';

            $this->template->vars('annotation', $annotation);

            include_once('controllers/_paginator.php');
            $paginator = new Controller_Paginator($this);
            $paginator->produkt_paginator_home($total, $page, 'shop_specials');
        } else {
            $this->template->vars('count_rows', 0);
            $list = "No Result!!!";
            $this->template->vars('main_produkt_list', $list);
        }
    }

    function main_produkt_list_popular()
    {
        $max_count_new_items = 360;
        $model = new Model_Users();
        $image_suffix = 'b_';
        if (isset($_SESSION['cart']['items'])) {
            $cart_items = $_SESSION['cart']['items'];
        } else {
            $cart_items = [];
        }
        $cart = array_keys($cart_items);

        if (!empty($_GET['page'])) {
            $userInfo = $model->validData($_GET['page']);
            $page = $userInfo['data'];
        } else {
            $page = 1;
        }
        $per_page = 12;

        if (!empty($_GET['cat'])) {
            $userInfo = $model->validData($_GET['cat']);
            $cat_id = $userInfo['data'];

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

        if (!empty($_GET['cat'])) {
            $userInfo = $model->validData($_GET['cat']);
            $cat_id = $userInfo['data'];
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
                $userInfo = $model->getCatName($row[20]);
                $cat_name = $userInfo['cname'];
                $row[8] = substr($row[8], 0, 100);
                $base_url = BASE_URL;

                $filename = 'upload/upload/' . $image_suffix . $row[14];
                if (!(file_exists($filename) && is_file($filename))) {
                    $filename = 'upload/upload/not_image.jpg';
                }
                $filename = $base_url . '/' . $filename;

                $href = '';
                if (!empty($_GET['page'])) {
                    $href .= '&page=' . $_GET['page'];
                }
                if (!empty($_GET['cat'])) {
                    $href .= '&cat=' . $_GET['cat'];
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

                include('./views/index/product/main_produkt_list_popular.php');
            }

            $list = ob_get_contents();
            ob_end_clean();
            $this->template->vars('catigori_name', isset($catigori_name) ? $catigori_name : '');
            $this->template->vars('main_produkt_list', $list);

            include_once('controllers/_paginator.php');
            $paginator = new Controller_Paginator($this);
            $paginator->produkt_paginator_home($total, $page, 'shop_popular');
        } else {
            $this->template->vars('count_rows', 0);
            $list = "No Result!!!";
            $this->template->vars('main_produkt_list', $list);
        }
    }

    function main_produkt_list_best()
    {
        $model = new Model_Users();
        $image_suffix = 'b_';
        if (isset($_SESSION['cart']['items'])) {
            $cart_items = $_SESSION['cart']['items'];
        } else {
            $cart_items = [];
        }
        $cart = array_keys($cart_items);

        if (!empty($_GET['page'])) {
            $userInfo = $model->validData($_GET['page']);
            $page = $userInfo['data'];
        } else {
            $page = 1;
        }
        $per_page = 12;

        if (!empty($_GET['cat'])) {
            $userInfo = $model->validData($_GET['cat']);
            $cat_id = $userInfo['data'];

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

        if (!empty($_GET['cat'])) {
            $userInfo = $model->validData($_GET['cat']);
            $cat_id = $userInfo['data'];
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
                $userInfo = $model->getCatName($row[20]);
                $cat_name = $userInfo['cname'];
                $row[8] = substr($row[8], 0, 100);
                $base_url = BASE_URL;

                $filename = 'upload/upload/' . $image_suffix . $row[14];
                if (!(file_exists($filename) && is_file($filename))) {
                    $filename = 'upload/upload/not_image.jpg';
                }
                $filename = $base_url . '/' . $filename;

                $href = '';
                if (!empty($_GET['page'])) {
                    $href .= '&page=' . $_GET['page'];
                }
                if (!empty($_GET['cat'])) {
                    $href .= '&cat=' . $_GET['cat'];
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

                include('./views/index/product/main_produkt_list_best.php');
            }

            $list = ob_get_contents();
            ob_end_clean();
            $this->template->vars('catigori_name', isset($catigori_name) ? $catigori_name : '');
            $this->template->vars('main_produkt_list', $list);

            include_once('controllers/_paginator.php');
            $paginator = new Controller_Paginator($this);
            $paginator->produkt_paginator_home($total, $page, 'shop_best');

        } else {
            $this->template->vars('count_rows', 0);
            $list = "No Result!!!";
            $this->template->vars('main_produkt_list', $list);
        }
    }

    function widget_products($type, $start, $limit, $layout = 'widget_products')
    {
        $model = new Model_Users();

        $q = "";
        $image_suffix = '';
        switch ($type) {
            case 'new':
                $q = "SELECT * FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1' ORDER BY  dt DESC, pid DESC LIMIT " . $start . "," . $limit;
                break;
            case 'carousel':
                $image_suffix = 'b_';
                $q = "SELECT * FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1' ORDER BY  dt DESC, pid DESC LIMIT " . $start . "," . $limit;
                break;
            case 'best':
                $q = "SELECT * FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1' and best = '1' ORDER BY pid DESC LIMIT " . $start . "," . $limit;
                break;
            case 'bsells':
                $q = "select n.*" .
                    " from (SELECT a.pid, SUM(b.quantity) as s" .
                    " FROM fabrix_products a" .
                    " LEFT JOIN fabrix_order_details b ON a . pid = b . product_id" .
                    " WHERE a . pnumber is not null and a . pvisible = '1'" .
                    " GROUP BY a . pid" .
                    " ORDER BY s DESC" .
                    " LIMIT " . $start . "," . $limit . ") m" .
                    " LEFT JOIN fabrix_products n ON m.pid = n.pid";
                break;
            case 'popular':
                $q = "SELECT * FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1' ORDER BY popular DESC LIMIT " . $start . "," . $limit;
                break;
        }
        $res = mysql_query($q);
        $row_count = mysql_num_rows($res);
        if ($res) {

            $mp = new Model_Price();

            $sys_hide_price = $mp->sysHideAllRegularPrices();
            $this->template->vars('sys_hide_price', $sys_hide_price);

            ob_start();
            $first = true;
            $last = false;
            $i = 1;
            while ($row = mysql_fetch_array($res)) {
                $userInfo = $model->getCatName($row[20]);
                $cat_name = $userInfo['cname'];
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

                include('./views/index/widgets/' . $layout . '.php');
                $first = false;
            }

            $list = ob_get_contents();
            ob_end_clean();

        } else {
            $list = "No Result!!!";
        }
        return $list;
    }

}