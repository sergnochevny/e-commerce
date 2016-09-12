<?php

class Controller_Product extends Controller_Controller
{

    function product($url = 'shop')
    {
        $model = new Model_Product();
        $samples_model = new Model_Samples();
        $userInfo = $model->validData($_GET['p_id']);
        $produkt_id = $userInfo['data'];
        $userInfo = $model->getPrName($produkt_id);

        include_once('controllers/_matches.php');
        $matches = new Controller_Matches($this->main);
        if ($matches->product_in_matches($produkt_id)) $this->template->vars('in_matches', '1');

        $this->template->vars('userInfo', $userInfo);
        $priceyard = $userInfo['priceyard'];
        $pid = $produkt_id;
        $aPrds = [];
        $aPrds[] = $pid;    #add product id
        $aPrds[] = 1;        #add qty

        #get the shipping
        if (isset($_SESSION['cart']['ship'])) {
            $shipping = (int)$_SESSION['cart']['ship'];
        } else {
            $shipping = DEFAULT_SHIPPING;
            $_SESSION['cart']['ship'] = $shipping;
        }

        if (isset($_SESSION['cart']['ship_roll'])) {
            $bShipRoll = (boolean)$_SESSION['cart']['ship_roll'];
        } else {
            $bShipRoll = false;
            $_SESSION['cart']['ship_roll'] = 0;
        }

        $shipcost = 0;

        #grab the user id
        if (isset($_SESSION['user'])) {
            $uid = (int)$_SESSION['user']['aid'];
        } else {
            $uid = 0;
        }
        $bTemp = false;

        $mp = new Model_Price();

        $sys_hide_price = $mp->sysHideAllRegularPrices();
        $hide_price = $userInfo['vis_price'];
        $this->template->vars('sys_hide_price', $sys_hide_price);
        $this->template->vars('hide_price', $hide_price);

        $bSystemDiscount = false;
        $discountIds = [];
        $sSystemDiscount = false;
        $sPriceDiscount = '';
        $rSystemDiscount = 0;
        $rDiscountPrice = 0;
        $rSystemDiscount = $mp->calculateDiscount(DISCOUNT_CATEGORY_ALL, $uid, $aPrds, $priceyard, $shipcost, '', $bTemp, true, $sPriceDiscount, $sSystemDiscount, $shipping, $discountIds);
        if ((strlen($sSystemDiscount) > 0) || ($rSystemDiscount > 0)) {
            $bSystemDiscount = true;
            $rDiscountPrice = $priceyard - $rSystemDiscount;
        }

        #check the price for the discount
        if ($bSystemDiscount) {
            $rExDiscountPrice = $rDiscountPrice;
        } else {
            $rExDiscountPrice = $priceyard;
        }

        $inventory = $userInfo['inventory'];
        $piece = $userInfo['piece'];
        $format_price = '';
        $price = $mp->getPrintPrice($priceyard, $format_price, $inventory, $piece);

        #check if the product has its own discount
        $sDiscount = '';
        $bDiscount = $mp->checkProductDiscount($pid, $sDiscount, $rExDiscountPrice, $discountIds);

        $this->template->vars('format_price', $format_price);

        ob_start();
        if ($rSystemDiscount > 0) {
            $tmp = $mp->getPrintPrice($rDiscountPrice, $sDiscountPrice, $inventory, $piece);
            $field_name = "Sale price:";
            $field_value = sprintf("%s<br><strong>%s</strong>", $sPriceDiscount, $sDiscountPrice);
            include('views/discount/product_page_discount_info.php');
        }

        if ($bDiscount) {
            $tmp = $mp->getPrintPrice($rExDiscountPrice, $sDiscountPrice, $inventory, $piece);
            if ($bSystemDiscount) {
                $field_name = "Extra disc. price:";
            } else {
                $field_name = "Sale price:";
            }
            if ($bSystemDiscount) {
                $field_value = sprintf("<strong>%s</strong><br>Reduced a further %s.", $sDiscountPrice, $sDiscount);
            } else {
                $field_value = sprintf("<strong>%s</strong><br>Reduced by %s.", $sDiscountPrice, $sDiscount);
            }
            include('views/discount/product_page_discount_info.php');
        }

        if (strlen($sSystemDiscount) > 0) {
            $field_name = 'Shipping discount:';
            $field_value = $sSystemDiscount;
            include('views/discount/product_page_discount_info.php');
        }

        if (count($discountIds) > 0) {
            if ($mp->getNextChangeInDiscoutDate($discountIds) > 0) {
                $field_name = 'Sale ends in:';
                $field_value = $mp->displayDiscountTimeRemaining($discountIds);
                include('views/discount/product_page_discount_info.php');
            }
        }
        $discount_info = ob_get_contents();
        ob_end_clean();
        $this->template->vars('discount_info', $discount_info);

        if (isset($_SESSION['cart']['items'])) {
            $cart_items = $_SESSION['cart']['items'];
        } else {
            $cart_items = [];
        }
        $cart = array_keys($cart_items);
        $in_cart = in_array($produkt_id, $cart);
        if ($in_cart) $this->template->vars('in_cart', '1');

        if (!isset($_GET['matches'])) {
            if (!isset($_GET['cart'])) {

                $back_url = BASE_URL . '/' . $url . '?page=';
                if (!empty($_GET['page'])) {
                    $back_url .= $_GET['page'];
                } else
                    $back_url .= '1';
                if ((!empty($_GET['cat']))) {
                    $back_url .= '&cat=' . $_GET['cat'];
                }
                if ((!empty($_GET['mnf']))) {
                    $back_url .= '&mnf=' . $_GET['mnf'];
                }
                if ((!empty($_GET['ptrn']))) {
                    $back_url .= '&ptrn=' . $_GET['ptrn'];
                }
            } else {

                $back_url = BASE_URL . '/cart';
            }

        } else {

            $back_url = BASE_URL . '/matches';

        }

        if (isset($_POST['s']) && (!empty($_POST['s']{0}))) {
            $search = mysql_real_escape_string(strtolower(htmlspecialchars(trim($_POST['s']))));
            $this->template->vars('search', $_POST['s']);
        }

        $allowed_samples = $samples_model->allowedSamples($pid);
        $this->template->vars('allowed_samples', $allowed_samples);

        $this->template->vars('cart_enable', '_');

        $this->template->vars('back_url', $back_url);

        $this->main->view('product_page');
    }

    function edit()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();

        $action_url = 'edit_db?produkt_id=' . $_GET['produkt_id'];
        $this->template->vars('action_url', $action_url);

        $back_url = BASE_URL . '/admin_home';

        $back_url .= '?page=';
        if (!empty($_GET['page'])) {
            $back_url .= $_GET['page'];
        } else
            $back_url .= '1';

        if (!empty($_GET['cat'])) {
            $back_url .= '&cat=' . $_GET['cat'];
        }
        $this->template->vars('back_url', $back_url);

        $userInfo = $model->getProduktInfo();

        ob_start();
        include_once('controllers/_image.php');
        $cimage = new Controller_Image($this->main);
        $cimage->modify_images();
        $m_images = ob_get_contents();
        ob_end_clean();

        $this->template->vars('modify_images', $m_images);

        $this->template->vars('userInfo', $userInfo);
        $this->main->view_admin('product/edit');
    }

    function edit_db()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();

        $action_url = 'edit_db?produkt_id=' . $_GET['produkt_id'];
        $this->template->vars('action_url', $action_url);

        if (!empty($_GET['produkt_id'])) {
            include('include/post_edit_db.php');

            if (empty($post_product_num{0}) || empty($post_tp_name{0}) || empty($post_p_yard{0})) {

                $error = [];
                if (empty($post_product_num{0})) $error[] = 'Identify Product Number field !';
                if (empty($post_tp_name{0})) $error[] = 'Identify Product Name field !';
                if (empty($post_p_yard{0})) $error[] = 'Identify Price field !';
                $this->template->vars('error', $error);

                $sl_cat = 0;
                $sl_cat2 = 0;
                $sl_cat3 = 0;
                $sl_cat4 = 0;


                if (!(isset($post_categori) && is_array($post_categori) && count($post_categori) > 0)) {
                    $post_categori = ['1'];
                }
                $results = mysql_query("select * from fabrix_categories");
                while ($row = mysql_fetch_array($results)) {
                    if (in_array($row[0], $post_categori)) {
                        $sl_cat .= '<option value="' . $row[0] . '" selected>' . $row[1] . '</option>';
                    } else {
                        $sl_cat .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                    }
                }

                if (empty($post_manufacturer{0})) {
                    $post_manufacturer = 0;
                }
                $results = mysql_query("select * from fabrix_manufacturers");
                while ($row = mysql_fetch_array($results)) {
                    if ($row[0] == $post_manufacturer) {
                        $sl_cat2 .= '<option value="' . $row[0] . '" selected>' . $row[1] . '</option>';
                    } else {
                        $sl_cat2 .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                    }
                }

                if (!(isset($p_colors) && is_array($p_colors) && count($p_colors) > 0)) {
                    $p_colors = [];
                }
                $results = mysql_query("select * from fabrix_colour");
                while ($row = mysql_fetch_array($results)) {
                    if (in_array($row[0], $p_colors)) {
                        $sl_cat3 .= '<option value="' . $row[0] . '" selected>' . $row[1] . '</option>';
                    } else {
                        $sl_cat3 .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                    }
                }

                if (!(isset($patterns) && is_array($patterns) && count($patterns) > 0)) {
                    $patterns = [];
                }
                $results = mysql_query("select * from fabrix_patterns");
                while ($row = mysql_fetch_array($results)) {
                    if (in_array($row[0], $patterns)) {
                        $sl_cat4 .= '<option value="' . $row[0] . '" selected>' . $row[1] . '</option>';
                    } else {
                        $sl_cat4 .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                    }
                }

                $userInfo = array(
                    'weight_id' => $post_weight_cat,
                    'sd_cat' => $sl_cat,
                    'pvisible' => $post_vis,
                    'metadescription' => $post_desc,
                    'produkt_id' => $produkt_id,
                    'Meta_Description' => $post_desc,
                    'Meta_Keywords' => $post_mkey,
                    'Product_name' => $post_tp_name,
                    'Product_number' => $post_product_num,
                    'Width' => $post_width,
                    'Price_Yard' => $post_p_yard,
                    'Stock_number' => $post_st_nom,
                    'Dimensions' => $post_dimens,
                    'Current_inventory' => $post_curret_in,
                    'Specials' => $post_special,
                    'Weight' => $post_weight_cat,
                    'Manufacturer' => $sl_cat2,
                    'New_Manufacturer' => $New_Manufacturer,
                    'Colours' => $sl_cat3,
                    'New_Colour' => $post_new_color,
                    'Pattern_Type' => $sl_cat4,
                    'New_Pattern' => $pattern_type,
                    'Short_description' => $post_short_desk,
                    'Long_description' => $post_Long_description,
                    'Related_fabric_1' => $post_fabric_1,
                    'Related_fabric_2' => $post_fabric_2,
                    'Related_fabric_3' => $post_fabric_3,
                    'Related_fabric_4' => $post_fabric_4,
                    'Related_fabric_5' => $post_fabric_5,
                    'Position_in_Brunschwig' => 'test',
                    'Position_in_Modern' => 'test',
                    'Position_in_Designer' => 'test',
                    'Position_in_Stripe' => 'test',
                    'Position_in_Just_Arrived' => 'test',
                    'visible' => $post_hide_prise,
                    'best' => $best,
                    'piece' => $piece,
                    'whole' => $whole

                );

                $this->template->vars('userInfo', $userInfo);

                ob_start();
                include_once('controllers/_image.php');
                $cimage = new Controller_Image($this->main);
                $cimage->modify_images();
                $m_images = ob_get_contents();
                ob_end_clean();

                $this->template->vars('modify_images', $m_images);

                $this->main->view_layout('product/edit_form');
            } else {

                if (!empty($New_Manufacturer)) {
                    mysql_query("INSERT INTO fabrix_manufacturers set manufacturer='$New_Manufacturer'");
                    $post_manufacturer = mysql_insert_id();
                }
                if (!empty($post_new_color)) {
                    mysql_query("INSERT INTO fabrix_colour set colour='$post_new_color'");
                    $p_colors[] = (string)mysql_insert_id();
                }
                if (!empty($pattern_type)) {
                    $result = mysql_query("INSERT INTO fabrix_patterns SET pattern='$pattern_type'");
                    $patterns[] = (string)mysql_insert_id();
                }

                //PageTitle='$post_title', patterns='$Pattern_Type', pcolours='$p_colors',
                $sql = "update fabrix_products set manufacturerId='$post_manufacturer', weight_id='$post_weight_cat', specials='$post_special', inventory='$post_curret_in', dimensions='$post_dimens', makePriceVis='$post_hide_prise', stock_number='$post_st_nom', priceyard='$post_p_yard', width='$post_width', pnumber='$post_product_num', pvisible='$post_vis', rpnumber5='$post_fabric_5', rpnumber4='$post_fabric_4', rpnumber3='$post_fabric_3', rpnumber2='$post_fabric_2', rpnumber1='$post_fabric_1', metakeywords='$post_mkey', metadescription='$post_desc', ldesc='$post_Long_description', pname='$post_tp_name', sdesc='$post_short_desk', best = '$best', piece='$piece', whole='$whole' WHERE pid ='$produkt_id'";

                //echo $sql;

                $result = mysql_query($sql);

                if ($result) {
                    if (!(isset($post_categori) && is_array($post_categori) && count($post_categori) > 0)) {
                        $post_categori = ['1'];
                    }
                    if (count($post_categori) > 0) {
                        mysql_query("DELETE FROM fabrix_product_categories WHERE pid='$produkt_id'");
                        foreach ($post_categori as $cid) {
                            mysql_query("REPLACE INTO fabrix_product_categories SET pid='$produkt_id', cid='$cid'");
                        }
                    }

                    if (count($p_colors) > 0) {
                        mysql_query("DELETE FROM fabrix_product_colours WHERE prodID='$produkt_id'");
                        foreach ($p_colors as $colourId) {
                            mysql_query("REPLACE INTO fabrix_product_colours SET prodID='$produkt_id', colourId='$colourId'");
                        }
                    }

                    if (count($patterns) > 0) {
                        mysql_query("DELETE FROM fabrix_product_patterns WHERE prodID='$produkt_id'");
                        foreach ($patterns as $patternId) {
                            mysql_query("REPLACE INTO fabrix_product_patterns SET prodID='$produkt_id', patternId='$patternId'");
                        }
                    }

                    $this->template->vars('warning', ["Product Data saved successfully!"]);
                } else {
                    $this->template->vars('warning', [mysql_error()]);
                }

                $this->edit_form();
            }

        } else {
            $this->template->vars('error', "Error!");
            $this->edit_form();
        }
        //exit ("<script>location.href='admin_home';</script>");
    }

    function save_db()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();

        $action_url = 'save_db?produkt_id=' . isset($_GET['produkt_id']) ?: $_GET['produkt_id'] . '';
        $this->template->vars('action_url', $action_url);

        if (!empty($_GET['produkt_id'])) {
            include('include/post_edit_db.php');

            if (empty($post_product_num{0}) || empty($post_tp_name{0}) || empty($post_p_yard{0})) {

                $error = [];
                if (empty($post_product_num{0})) $error[] = 'Identify Product Number field !';
                if (empty($post_tp_name{0})) $error[] = 'Identify Product Name field !';
                if (empty($post_p_yard{0})) $error[] = 'Identify Price field !';
                $this->template->vars('error', $error);

                $sl_cat = 0;
                $sl_cat2 = 0;
                $sl_cat3 = 0;
                $sl_cat4 = 0;


                if (!(isset($post_categori) && is_array($post_categori) && count($post_categori) > 0)) {
                    $post_categori = ['1'];
                }
                $results = mysql_query("select * from fabrix_categories");
                while ($row = mysql_fetch_array($results)) {
                    if (in_array($row[0], $post_categori)) {
                        $sl_cat .= '<option value="' . $row[0] . '" selected>' . $row[1] . '</option>';
                    } else {
                        $sl_cat .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                    }
                }

                if (empty($post_manufacturer{0})) {
                    $post_manufacturer = 0;
                }
                $results = mysql_query("select * from fabrix_manufacturers");
                while ($row = mysql_fetch_array($results)) {
                    if ($row[0] == $post_manufacturer) {
                        $sl_cat2 .= '<option value="' . $row[0] . '" selected>' . $row[1] . '</option>';
                    } else {
                        $sl_cat2 .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                    }
                }

                if (!(isset($p_colors) && is_array($p_colors) && count($p_colors) > 0)) {
                    $p_colors = [];
                }
                $results = mysql_query("select * from fabrix_colour");
                while ($row = mysql_fetch_array($results)) {
                    if (in_array($row[0], $p_colors)) {
                        $sl_cat3 .= '<option value="' . $row[0] . '" selected>' . $row[1] . '</option>';
                    } else {
                        $sl_cat3 .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                    }
                }

                if (!(isset($patterns) && is_array($patterns) && count($patterns) > 0)) {
                    $patterns = [];
                }
                $results = mysql_query("select * from fabrix_patterns");
                while ($row = mysql_fetch_array($results)) {
                    if (in_array($row[0], $patterns)) {
                        $sl_cat4 .= '<option value="' . $row[0] . '" selected>' . $row[1] . '</option>';
                    } else {
                        $sl_cat4 .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                    }
                }

                $userInfo = array(
                    'weight_id' => $post_weight_cat,
                    'sd_cat' => $sl_cat,
                    'pvisible' => $post_vis,
                    'metadescription' => $post_desc,
                    'produkt_id' => $produkt_id,
                    'Meta_Description' => $post_desc,
                    'Meta_Keywords' => $post_mkey,
                    'Product_name' => $post_tp_name,
                    'Product_number' => $post_product_num,
                    'Width' => $post_width,
                    'Price_Yard' => $post_p_yard,
                    'Stock_number' => $post_st_nom,
                    'Dimensions' => $post_dimens,
                    'Current_inventory' => $post_curret_in,
                    'Specials' => $post_special,
                    'Weight' => $post_weight_cat,
                    'Manufacturer' => $sl_cat2,
                    'New_Manufacturer' => $New_Manufacturer,
                    'Colours' => $sl_cat3,
                    'New_Colour' => $post_new_color,
                    'Pattern_Type' => $sl_cat4,
                    'New_Pattern' => $pattern_type,
                    'Short_description' => $post_short_desk,
                    'Long_description' => $post_Long_description,
                    'Related_fabric_1' => $post_fabric_1,
                    'Related_fabric_2' => $post_fabric_2,
                    'Related_fabric_3' => $post_fabric_3,
                    'Related_fabric_4' => $post_fabric_4,
                    'Related_fabric_5' => $post_fabric_5,
                    'Position_in_Brunschwig' => 'test',
                    'Position_in_Modern' => 'test',
                    'Position_in_Designer' => 'test',
                    'Position_in_Stripe' => 'test',
                    'Position_in_Just_Arrived' => 'test',
                    'visible' => $post_hide_prise,
                    'best' => $best,
                    'piece' => $piece,
                    'whole' => $whole
                );

                $this->template->vars('userInfo', $userInfo);

                ob_start();
                include_once('controllers/_image.php');
                $cimage = new Controller_Image($this->main);
                $cimage->modify_images();
                $m_images = ob_get_contents();
                ob_end_clean();

                $this->template->vars('modify_images', $m_images);

                $this->main->view_layout('product/edit_form');
            } else {

                if (!empty($New_Manufacturer)) {
                    mysql_query("INSERT INTO fabrix_manufacturers set manufacturer='$New_Manufacturer'");
                    $post_manufacturer = mysql_insert_id();
                }
                if (!empty($post_new_color)) {
                    mysql_query("INSERT INTO fabrix_colour set colour='$post_new_color'");
                    $p_colors[] = (string)mysql_insert_id();
                }
                if (!empty($pattern_type)) {
                    $result = mysql_query("INSERT INTO fabrix_patterns SET pattern='$pattern_type'");
                    $patterns[] = (string)mysql_insert_id();
                }

                //PageTitle='$post_title', patterns='$Pattern_Type', pcolours='$p_colors',
                $sql = "update fabrix_products set manufacturerId='$post_manufacturer', weight_id='$post_weight_cat', specials='$post_special', inventory='$post_curret_in', dimensions='$post_dimens', makePriceVis='$post_hide_prise', stock_number='$post_st_nom', priceyard='$post_p_yard', width='$post_width', pnumber='$post_product_num', pvisible='$post_vis', rpnumber5='$post_fabric_5', rpnumber4='$post_fabric_4', rpnumber3='$post_fabric_3', rpnumber2='$post_fabric_2', rpnumber1='$post_fabric_1', metakeywords='$post_mkey', metadescription='$post_desc', ldesc='$post_Long_description', pname='$post_tp_name', sdesc='$post_short_desk', best = '$best', piece='$piece', whole = '$whole'  WHERE pid ='$produkt_id'";

                //echo $sql;

                $result = mysql_query($sql);

                if (!(isset($post_categori) && is_array($post_categori) && count($post_categori) > 0)) {
                    $post_categori = ['1'];
                }
                if (count($post_categori) > 0) {
                    mysql_query("DELETE FROM fabrix_product_categories WHERE pid='$produkt_id'");
                    foreach ($post_categori as $cid) {
                        mysql_query("REPLACE INTO fabrix_product_categories SET pid='$produkt_id', cid='$cid'");
                    }
                }

                if (count($p_colors) > 0) {
                    mysql_query("DELETE FROM fabrix_product_colours WHERE prodID='$produkt_id'");
                    foreach ($p_colors as $colourId) {
                        mysql_query("REPLACE INTO fabrix_product_colours SET prodID='$produkt_id', colourId='$colourId'");
                    }
                }

                if (count($patterns) > 0) {
                    mysql_query("DELETE FROM fabrix_product_patterns WHERE prodID='$produkt_id'");
                    foreach ($patterns as $patternId) {
                        mysql_query("REPLACE INTO fabrix_product_patterns SET prodID='$produkt_id', patternId='$patternId'");
                    }
                }

                if ($model->ConfirmProductInsert()) {
                    $this->template->vars('warning', ["Product Data saved successfully!"]);
                } else {
                    $this->template->vars('error', [mysql_error()]);
                };

                $model->getNewProdukt();

                $action_url = 'save_db?produkt_id=' . $_GET['produkt_id'];
                $this->template->vars('action_url', $action_url, true);

                $this->edit_form();
            }

        } else {
            $this->template->vars('error', "Error!");
            $this->edit_form();
        }
        //exit ("<script>location.href='admin_home';</script>");
    }

    function edit_form()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();

        $userInfo = $model->getProduktInfo();
        $this->template->vars('userInfo', $userInfo);

        ob_start();
        include_once('controllers/_image.php');
        $cimage = new Controller_Image($this->main);
        $cimage->modify_images();
        $m_images = ob_get_contents();
        ob_end_clean();

        $this->template->vars('modify_images', $m_images);

        $this->main->view_layout('product/edit_form');
    }

    function add()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();

        $model->getNewProdukt();

        $action_url = 'save_db?produkt_id=' . $_GET['produkt_id'];
        $this->template->vars('action_url', $action_url);

        $back_url = BASE_URL . '/admin_home';

        $back_url .= '?page=';
        if (!empty($_GET['page'])) {
            $back_url .= $_GET['page'];
        } else
            $back_url .= '1';

        if (!empty($_GET['cat'])) {
            $back_url .= '&cat=' . $_GET['cat'];
        }
        $this->template->vars('back_url', $back_url);

        $userInfo = $model->getProduktInfo();

        ob_start();
        include_once('controllers/_image.php');
        $cimage = new Controller_Image($this->main);
        $cimage->modify_images();
        $m_images = ob_get_contents();
        ob_end_clean();

        $this->template->vars('modify_images', $m_images);

        $this->template->vars('userInfo', $userInfo);
        $this->main->view_admin('product/add_product');
    }

    private function del_imgs($pid)
    {
        $model = new Model_Product();
        $images = $model->getImage($pid);
        $fields_idx = [1, 2, 3, 4, 5];
        foreach ($fields_idx as $idx) {
            $filename = $images['image' . $idx];
            if (!empty($filename)) {
                if (file_exists("upload/upload/" . $filename)) {
                    unlink("upload/upload/$filename");
                }
                if (file_exists("upload/upload/b_" . $filename)) {
                    unlink("upload/upload/b_" . $filename);
                }
                if (file_exists("upload/upload/v_" . $filename)) {
                    unlink("upload/upload/v_" . $filename);
                }
            }
        }
    }

    function del()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();
        $userInfo = $model->validData($_GET['produkt_id']);
        $del_produkt_id = $userInfo['data'];
        $page = isset($_GET['page']) ? $_GET['page'] : null;
        $cat = isset($_GET['cat']) ? $_GET['cat'] : null;
        if (!empty($del_produkt_id)) {

            $this->del_imgs($del_produkt_id);
            $model->del_product($del_produkt_id);

            $base_url = BASE_URL;
            $href = $base_url . '/admin_home';
            if (isset($page) && isset($cat)) {
                $href .= '?page=' . $page . '&cat=' . $cat;
            } else {
                $href .= isset($page) ? '?page=' . $page : '';
                $href .= isset($cat) ? '?cat=' . $cat : '';
            }
            exit ("<script>window.location.href='" . $href . "';</script>");
//            $this->admin_home();
        }
    }

}