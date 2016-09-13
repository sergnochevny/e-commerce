<?php

class Controller_Product extends Controller_Controller
{

    function product($url = 'shop')
    {
        $model = new Model_Product();
        $samples_model = new Model_Samples();
        $produkt_id = $model->validData( _A_::$app->get('p_id'));
        $userInfo = $model->getPrName($produkt_id);

        $matches = new Controller_Matches($this->main);
        if ($matches->product_in($p_id)) $this->template->vars('in_matches', '1');

        $this->template->vars('userInfo', $userInfo);
        $priceyard = $userInfo['priceyard'];
        $pid = $p_id;
        $aPrds = [];
        $aPrds[] = $pid;    #add product id
        $aPrds[] = 1;        #add qty

        #get the shipping
        if (!is_null(_A_::$app->session('cart')['ship'])) {
            $shipping = (int)_A_::$app->session('cart')['ship'];
        } else {
            $shipping = DEFAULT_SHIPPING;
            $_cart = _A_::$app->session('cart');
            $_cart['ship'] = $shipping;
            _A_::$app->setSession('cart', $_cart);
        }

        if (!is_null(_A_::$app->get('cart')['ship_roll'])) {
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
        if (!is_null(_A_::$app->session('user'))) {
            $uid = (int)_A_::$app->session('user')['aid'];
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
            $this->template->vars('field_name', $field_name);
            $this->template->vars('field_value', $field_value);
            $this->template->view_layout('discount_info');
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
            $this->template->vars('field_name', $field_name);
            $this->template->vars('field_value', $field_value);
            $this->template->view_layout('discount_info');
        }

        if (strlen($sSystemDiscount) > 0) {
            $field_name = 'Shipping discount:';
            $field_value = $sSystemDiscount;
            $this->template->vars('field_name', $field_name);
            $this->template->vars('field_value', $field_value);
            $this->template->view_layout('discount_info');
        }

        if (count($discountIds) > 0) {
            if ($mp->getNextChangeInDiscoutDate($discountIds) > 0) {
                $field_name = 'Sale ends in:';
                $field_value = $mp->displayDiscountTimeRemaining($discountIds);
                $this->template->vars('field_name', $field_name);
                $this->template->vars('field_value', $field_value);
                $this->template->view_layout('discount_info');
            }
        }
        $discount_info = ob_get_contents();
        ob_end_clean();
        $this->template->vars('discount_info', $discount_info);

        if (!is_null(_A_::$app->session('cart')['items'])) {
            $cart_items = _A_::$app->session('cart')['items'];
        } else {
            $cart_items = [];
        }
        $cart = array_keys($cart_items);
        $in_cart = in_array($p_id, $cart);
        if ($in_cart) $this->template->vars('in_cart', '1');

        if (is_null(_A_::$app->get('matches'))) {
            if (is_null(_A_::$app->get('cart'))) {

                $url_prms = ['page' => '1'];
                if (!empty(_A_::$app->get('page'))) {
                    $url_prms['page'] = _A_::$app->get('page');
                }
                if ((!empty(_A_::$app->get('cat')))) {
                    $url_prms['cat'] = _A_::$app->get('cat');
                }
                if ((!empty(_A_::$app->get('mnf')))) {
                    $back_url .= '&mnf=' . _A_::$app->get('mnf');
                }
                if ((!empty(_A_::$app->get('ptrn')))) {
                    $back_url .= '&ptrn=' . _A_::$app->get('ptrn');
                }
                $back_url = _A_::$app->router()->UrlTo($url, $url_prms);
            } else {

                $back_url = _A_::$app->router()->UrlTo('cart');
            }

        } else {
            $back_url = _A_::$app->router()->UrlTo('matches');
        }

        if (!is_null(_A_::$app->post('s')) && (!empty(_A_::$app->post('s')))) {
            $search = mysql_real_escape_string(strtolower(htmlspecialchars(trim(_A_::$app->post('s')))));
            $this->main->template->vars('search', _A_::$app->post('s'));
        }

        $allowed_samples = $samples_model->allowedSamples($pid);
        $this->template->vars('allowed_samples', $allowed_samples);
        $this->template->vars('cart_enable', '_');
        $this->template->vars('back_url', $back_url);
        $this->main->view('product');
    }

    function edit()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();

        $prms = null;
        if(!is_null(_A_::$app->get('p_id'))){
            $prms['p_id']= _A_::$app->get('p_id');
        }
        $action_url = _A_::$app->router()->UrlTo('edit_db',$prms);
        $this->template->vars('action_url', $action_url);
        $prms = ['page'=>'1'];
        if (!empty(_A_::$app->get('page'))) {
            $prms['page'] = _A_::$app->get('page');
        }
        if (!empty(_A_::$app->get('cat'))) {
            $prms['cat'] = _A_::$app->get('cat');
        }
        $back_url = _A_::$app->router()->UrlTo('admin_home',$prms);
        $this->template->vars('back_url', $back_url);

        $userInfo = $model->getProductInfo();

        ob_start();
        $cimage = new Controller_Image($this->main);
        $cimage->modify_images();
        $m_images = ob_get_contents();
        ob_end_clean();

        $this->main->template->vars('modify_images', $m_images);
        $this->main->template->vars('userInfo', $userInfo);
        $this->main->view_admin('edit');
    }

    function edit_db()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();

        $action_url = _A_::$app->router()->UrlTo('product/edit_db',['p_id' => _A_::$app->get('p_id')]);
        $this->template->vars('action_url', $action_url);

        if (!empty(_A_::$app->get('p_id'))) {
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
                    'weight_id'                 => $post_weight_cat,
                    'sd_cat'                    => $sl_cat,
                    'pvisible'                  => $post_vis,
                    'metadescription'           => $post_desc,
                    'produkt_id'                => $produkt_id,
                    'Meta_Description'          => $post_desc,
                    'Meta_Keywords'             => $post_mkey,
                    'Product_name'              => $post_tp_name,
                    'Product_number'            => $post_product_num,
                    'Width'                     => $post_width,
                    'Price_Yard'                => $post_p_yard,
                    'Stock_number'              => $post_st_nom,
                    'Dimensions'                => $post_dimens,
                    'Current_inventory'         => $post_curret_in,
                    'Specials'                  => $post_special,
                    'Weight'                    => $post_weight_cat,
                    'Manufacturer'              => $sl_cat2,
                    'New_Manufacturer'          => $New_Manufacturer,
                    'Colours'                   => $sl_cat3,
                    'New_Colour'                => $post_new_color,
                    'Pattern_Type'              => $sl_cat4,
                    'New_Pattern'               => $pattern_type,
                    'Short_description'         => $post_short_desk,
                    'Long_description'          => $post_Long_description,
                    'Related_fabric_1'          => $post_fabric_1,
                    'Related_fabric_2'          => $post_fabric_2,
                    'Related_fabric_3'          => $post_fabric_3,
                    'Related_fabric_4'          => $post_fabric_4,
                    'Related_fabric_5'          => $post_fabric_5,
                    'Position_in_Brunschwig'    => 'test',
                    'Position_in_Modern'        => 'test',
                    'Position_in_Designer'      => 'test',
                    'Position_in_Stripe'        => 'test',
                    'Position_in_Just_Arrived'  => 'test',
                    'visible'                   => $post_hide_prise,
                    'best'                      => $best,
                    'piece'                     => $piece,
                    'whole'                     => $whole

                );

                $this->template->vars('userInfo', $userInfo);

                ob_start();
                $cimage = new Controller_Image($this->main);
                $cimage->modify_images();
                $m_images = ob_get_contents();
                ob_end_clean();

                $this->template->vars('modify_images', $m_images);
                $this->main->view_layout('edit_form');
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
                $sql = "update fabrix_products set manufacturerId='$post_manufacturer', weight_id='$post_weight_cat', specials='$post_special', inventory='$post_curret_in', dimensions='$post_dimens', makePriceVis='$post_hide_prise', stock_number='$post_st_nom', priceyard='$post_p_yard', width='$post_width', pnumber='$post_product_num', pvisible='$post_vis', rpnumber5='$post_fabric_5', rpnumber4='$post_fabric_4', rpnumber3='$post_fabric_3', rpnumber2='$post_fabric_2', rpnumber1='$post_fabric_1', metakeywords='$post_mkey', metadescription='$post_desc', ldesc='$post_Long_description', pname='$post_tp_name', sdesc='$post_short_desk', best = '$best', piece='$piece', whole='$whole' WHERE pid ='$p_id'";

                //echo $sql;

                $result = mysql_query($sql);

                if ($result) {
                    if (!(isset($post_categori) && is_array($post_categori) && count($post_categori) > 0)) {
                        $post_categori = ['1'];
                    }
                    if (count($post_categori) > 0) {
                        mysql_query("DELETE FROM fabrix_product_categories WHERE pid='$p_id'");
                        foreach ($post_categori as $cid) {
                            mysql_query("REPLACE INTO fabrix_product_categories SET pid='$p_id', cid='$cid'");
                        }
                    }

                    if (count($p_colors) > 0) {
                        mysql_query("DELETE FROM fabrix_product_colours WHERE prodID='$p_id'");
                        foreach ($p_colors as $colourId) {
                            mysql_query("REPLACE INTO fabrix_product_colours SET prodID='$p_id', colourId='$colourId'");
                        }
                    }

                    if (count($patterns) > 0) {
                        mysql_query("DELETE FROM fabrix_product_patterns WHERE prodID='$p_id'");
                        foreach ($patterns as $patternId) {
                            mysql_query("REPLACE INTO fabrix_product_patterns SET prodID='$p_id', patternId='$patternId'");
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
    }

    function edit_form()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();

        $userInfo = $model->getproductInfo();
        $this->template->vars('userInfo', $userInfo);

        ob_start();
        $cimage = new Controller_Image($this->main);
        $cimage->modify_images();
        $m_images = ob_get_contents();
        ob_end_clean();

        $this->template->vars('modify_images', $m_images);
        $this->main->view_layout('edit_form');
    }

    function save()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();
        $prms = !is_null(_A_::$app->get('p_id')) ? ['p_id' => _A_::$app->get('p_id')]:null;
        $action_url = _A_::$app->router()->UrlTo('product/save', $prms);
        $this->template->vars('action_url', $action_url);

        if (!empty(_A_::$app->get('p_id'))) {
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
                    'p_id' => $p_id,
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
                $sql = "update fabrix_products set manufacturerId='$post_manufacturer', weight_id='$post_weight_cat', specials='$post_special', inventory='$post_curret_in', dimensions='$post_dimens', makePriceVis='$post_hide_prise', stock_number='$post_st_nom', priceyard='$post_p_yard', width='$post_width', pnumber='$post_product_num', pvisible='$post_vis', rpnumber5='$post_fabric_5', rpnumber4='$post_fabric_4', rpnumber3='$post_fabric_3', rpnumber2='$post_fabric_2', rpnumber1='$post_fabric_1', metakeywords='$post_mkey', metadescription='$post_desc', ldesc='$post_Long_description', pname='$post_tp_name', sdesc='$post_short_desk', best = '$best', piece='$piece', whole = '$whole'  WHERE pid ='$p_id'";

                //echo $sql;

                $result = mysql_query($sql);

                if (!(isset($post_categori) && is_array($post_categori) && count($post_categori) > 0)) {
                    $post_categori = ['1'];
                }
                if (count($post_categori) > 0) {
                    mysql_query("DELETE FROM fabrix_product_categories WHERE pid='$p_id'");
                    foreach ($post_categori as $cid) {
                        mysql_query("REPLACE INTO fabrix_product_categories SET pid='$p_id', cid='$cid'");
                    }
                }

                if (count($p_colors) > 0) {
                    mysql_query("DELETE FROM fabrix_product_colours WHERE prodID='$p_id'");
                    foreach ($p_colors as $colourId) {
                        mysql_query("REPLACE INTO fabrix_product_colours SET prodID='$p_id', colourId='$colourId'");
                    }
                }

                if (count($patterns) > 0) {
                    mysql_query("DELETE FROM fabrix_product_patterns WHERE prodID='$p_id'");
                    foreach ($patterns as $patternId) {
                        mysql_query("REPLACE INTO fabrix_product_patterns SET prodID='$p_id', patternId='$patternId'");
                    }
                }

                if ($model->ConfirmProductInsert()) {
                    $this->template->vars('warning', ["Product Data saved successfully!"]);
                } else {
                    $this->template->vars('error', [mysql_error()]);
                };

                $model->getNewproduct();
                $action_url = _A_::$app->router()->UrlTo('product/save',['p_id' => _A_::$app->get('p_id')]);
                $this->template->vars('action_url', $action_url);
                $this->edit_form();
            }
        } else {
            $this->template->vars('error', "Error!");
            $this->edit_form();
        }
    }

    function add()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();

        $model->getNewproduct();

        $action_url = _A_::$app->router()->UrlTo('product/save',['p_id' => _A_::$app->get('p_id')]);
        $this->template->vars('action_url', $action_url);
        $prms = ['page'=>'1'];
        if (!empty(_A_::$app->get('page'))) {
            $prms['page'] = _A_::$app->get('page');
        }

        if (!empty(_A_::$app->get('cat'))) {
            $prms['cat'] = _A_::$app->get('cat');
        }
        $back_url = _A_::$app->router()->UrlTo('admin_home',$prms);
        $this->template->vars('back_url', $back_url);

        $userInfo = $model->getproductInfo();
        ob_start();
        $cimage = new Controller_Image($this->main);
        $cimage->modify_images();
        $m_images = ob_get_contents();
        ob_end_clean();

        $this->template->vars('modify_images', $m_images);

        $this->template->vars('userInfo', $userInfo);
        $this->main->view_admin('add');
    }

    function del()
    {
        $this->main->test_access_rights();
        $model = new Model_Product();
        $del_p_id = $model->validData(_A_::$app->get('p_id'));
        if (!empty($del_p_id)) {

            $this->del_image($del_p_id);
            $model->del_product($del_p_id);

            $prms = null;
            if (!is_null(_A_::$app->get('page'))) {
                $prms['page'] = _A_::$app->get('page');
            }
            if (!is_null(_A_::$app->get('cat'))) {
                $prms['cat'] = _A_::$app->get('cat');
            }
            $href = _A_::$app->router()->UrlTo('admin_home',$prms);
            exit ("<script>window.location.href='" . $href . "';</script>");
        }
    }

    private function del_image($pid)
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
}