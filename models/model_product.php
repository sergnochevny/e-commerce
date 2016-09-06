<?php

Class Model_Product extends Model_Model
{

    public function get_total_count($where = null)
    {
        $total = 0;
        $q_total = "SELECT COUNT(*) FROM `fabrix_products`";
        if (isset($where)) {
            $q_total = $q_total . ' ' . $where;
        }

        if ($res = mysql_query($q_total)) {
            $total = mysql_fetch_row($res)[0];
        }

        return $total;
    }

    public function get_products_list($start, $limit, $where = null)
    {
        $list = [];
        $q = "SELECT * FROM `fabrix_products` ORDER BY pid LIMIT " . $start . ", " . $limit;
        if ($res = mysql_query($q)) {
            while ($row = mysql_fetch_array($res)) {
                $list[] = $row;
            }
        }

        return $list;
    }

    public function get_product_by_id($id)
    {
        $product = null;
        $strSQL = "select * from fabrix_products where id = '" . mysql_real_escape_string($id) . "'";
        $result = mysql_query($strSQL);
        if ($result) {
            $product = mysql_fetch_assoc($result);
        }
        return $product;
    }

    public function update_user_data($user_Same_as_billing, $user_email, $user_first_name, $user_last_name, $user_organization,
                                     $user_address, $user_address2, $user_state, $user_city, $user_country, $user_zip, $user_telephone,
                                     $user_fax, $user_bil_email, $user_s_first_name, $user_s_last_name, $s_organization, $user_s_address,
                                     $user_s_address2, $user_s_city, $user_s_state, $user_s_country, $user_s_zip, $user_s_telephone, $user_s_fax,
                                     $user_s_email, $user_id)
    {
        if ($user_Same_as_billing == "1") {
            $q = "UPDATE `fabrix_accounts` SET" .
                " `email` = '" . $user_email .
                "',`bill_firstname` = '" . $user_first_name .
                "',`bill_lastname` = '" . $user_last_name .
                "',`bill_organization` = '" . $user_organization .
                "',`bill_address1` = '" . $user_address .
                "',`bill_address2` = '" . $user_address2 .
                "',`bill_province` = '" . $user_s_state .
                "',`bill_province_other` = ' ',`bill_city` =  '" . $user_city .
                "',`bill_country` = '" . $user_country .
                "',`bill_postal` = '" . $user_zip .
                "',`bill_phone` = '" . $user_telephone .
                "',`bill_fax` = '" . $user_fax .
                "',`bill_email` = '" . $user_bil_email .
                "',`ship_firstname` = '" . $user_first_name .
                "',`ship_lastname` = '" . $user_last_name .
                "',`ship_organization` = '" . $user_organization .
                "',`ship_address1` = '" . $user_address .
                "',`ship_address2` = '" . $user_address2 .
                "',`ship_city` = '" . $user_city .
                "',`ship_province` = '" . $user_s_state .
                "',`ship_province_other` = ' ',`ship_country` = '" . $user_country .
                "',`ship_postal` = '" . $user_zip .
                "',`ship_phone` = '" . $user_telephone .
                "',`ship_fax` = '" . $user_fax .
                "',`ship_email` = '" . $user_bil_email .
                "'WHERE  `aid` = $user_id;";
        } else {
            $q = "UPDATE `fabrix_accounts` SET " .
                " `email` = '" . $user_email .
                "',`bill_firstname` =  '" . $user_first_name .
                "',`bill_lastname` =  '" . $user_last_name .
                "',`bill_organization` =  '" . $user_organization .
                "',`bill_address1` =  '" . $user_address .
                "',`bill_address2` =  '" . $user_address2 .
                "',`bill_province` =  '" . $user_state .
                "',`bill_province_other` =  ' ',`bill_city` =  '" . $user_city .
                "',`bill_country` =  '" . $user_country .
                "',`bill_postal` =  '" . $user_zip .
                "',`bill_phone` =  '" . $user_telephone .
                "',`bill_fax` =  '" . $user_fax .
                "',`bill_email` =  '" . $user_bil_email .
                "',`ship_firstname` =  '" . $user_s_first_name .
                "',`ship_lastname` =  '" . $user_s_last_name .
                "',`ship_organization` =  '" . $s_organization .
                "',`ship_address1` =  '" . $user_s_address .
                "',`ship_address2` =  '" . $user_s_address2 .
                "',`ship_city` =  '" . $user_s_city .
                "',`ship_province` =  '" . $user_s_state .
                "',`ship_province_other` =  ' ',`ship_country` =  '" . $user_s_country .
                "',`ship_postal` =  '" . $user_s_zip .
                "',`ship_phone` =  '" . $user_s_telephone .
                "',`ship_fax` =  '" . $user_s_fax .
                "',`ship_email` =  '" . $user_s_email .
                "'WHERE  `aid` = $user_id;";

        }
        $result = mysql_query($q);
        return $result;
    }

    public function insert_user($user_Same_as_billing, $user_email, $password, $user_first_name, $user_last_name, $user_organization,
                                $user_address, $user_address2, $user_state, $user_city, $user_country, $user_zip,
                                $user_telephone, $user_fax, $user_bil_email, $user_s_first_name, $user_s_last_name,
                                $s_organization, $user_s_address, $user_s_address2, $user_s_city, $user_s_state,
                                $user_s_country, $user_s_zip, $user_s_telephone, $user_s_fax, $user_s_email, $timestamp)
    {
        if ($user_Same_as_billing == "1") {
            $q = "INSERT INTO  `fabrix_accounts`" .
                "(`aid` ,`email` ,`password` ,`bill_firstname` ,`bill_lastname` ," .
                "`bill_organization` ,`bill_address1` ,`bill_address2` ,`bill_province` ," .
                "`bill_province_other` ,`bill_city` ,`bill_country` ,`bill_postal` ," .
                "`bill_phone` ,`bill_fax` ,`bill_email` ,`ship_firstname` ,`ship_lastname` ," .
                "`ship_organization` ,`ship_address1` ,`ship_address2` ,`ship_city` ," .
                "`ship_province` ,`ship_province_other` ,`ship_country` ,`ship_postal` ," .
                "`ship_phone` ,`ship_fax` ,`ship_email` ,`get_newsletter` ,`date_registered` ,`login_counter`)" .
                "VALUES (NULL , '$user_email', '$password', '$user_first_name', '$user_last_name', '$user_organization', '$user_address'," .
                " '$user_address2', '$user_state', ' ', '$user_city', '$user_country', '$user_zip', '$user_telephone', '$user_fax', " .
                " '$user_bil_email', '$user_first_name', '$user_last_name', '$user_organization', '$user_address'," .
                " '$user_address2', '$user_city', '$user_s_state', ' ', '$user_country', '$user_zip', '$user_telephone'," .
                " '$user_fax', '$user_bil_email', '1', '$timestamp', '0');";
        } else {
            $q = "INSERT INTO  `fabrix_accounts` (`aid` , `email` , `password` , `bill_firstname` , `bill_lastname` ," .
                " `bill_organization` , `bill_address1` , `bill_address2` , `bill_province` , `bill_province_other` ," .
                " `bill_city` , `bill_country` , `bill_postal` , `bill_phone` , `bill_fax` , `bill_email` , " .
                "`ship_firstname` , `ship_lastname` , `ship_organization` , `ship_address1` , `ship_address2` , " .
                "`ship_city` , `ship_province` , `ship_province_other` , `ship_country` , `ship_postal` , " .
                "`ship_phone` , `ship_fax` , `ship_email` , `get_newsletter` , `date_registered` , `login_counter`)" .
                " VALUES (NULL ,  '$user_email', '$password', '$user_first_name', '$user_last_name', '$user_organization'," .
                " '$user_address', '$user_address2', '$user_state', ' ', '$user_city', '$user_country', '$user_zip'," .
                " '$user_telephone', '$user_fax', '$user_bil_email', '$user_s_first_name', '$user_s_last_name'," .
                " '$s_organization', '$user_s_address', '$user_s_address2', '$user_s_city', '$user_s_state', ' '," .
                " '$user_s_country', '$user_s_zip', '$user_s_telephone', '$user_s_fax', '$user_s_email', '1', '$timestamp', '0');";
        }
        $result = mysql_query($q);
        return $result;
    }

    public function produkt_filtr_list()
    {
        $x = 0;
        $results = mysql_query("select * from fabrix_categories");
        $catigori = [];
        while ($row = mysql_fetch_array($results)) {
            $x++;
            $catigori[] = [$row[0], $row[1]];
        }
        return array('total_catigori_in_select' => $x, 'catigori_in_select' => $catigori);
    }

    public function del_product($del_produkt_id)
    {
        $strSQL = "DELETE FROM fabrix_products WHERE pid = $del_produkt_id";
        mysql_query($strSQL);

        $strSQL = "DELETE FROM fabrix_product_categories WHERE pid = $del_produkt_id";
        mysql_query($strSQL);

        $strSQL = "DELETE FROM fabrix_product_colours WHERE prodId = $del_produkt_id";
        mysql_query($strSQL);

        $strSQL = "DELETE FROM fabrix_product_patterns WHERE prodId = $del_produkt_id";
        mysql_query($strSQL);

        $strSQL = "DELETE FROM fabrix_specials_products WHERE pid = $del_produkt_id";
        mysql_query($strSQL);
    }

    public function ConfirmProductInsert()
    {
        $q = "DELETE FROM `fabrix_temp_product` WHERE `productId`=" . $_GET['produkt_id'] . " and `sid`='" . session_id() . "'";
        $result = mysql_query($q);
        return $result;
    }

    public function getNewProdukt()
    {
        $this->cleanTempProducts();

        $result = mysql_query("INSERT INTO `fabrix_products` (`pid`, `pname`, `pnumber`, `width`, `yardage`, `priceyard`, `inventory`, `sdesc`, `ldesc`, `rpnumber1`, `rpnumber2`, `rpnumber3`, `rpnumber4`, `rpnumber5`, `image1`, `image2`, `image3`, `image4`, `image5`, `display_order`, `cid`, `pvisible`, `dimensions`, `specials`, `weight_id`, `stock_number`, `manufacturerId`, `metatitle`, `metadescription`, `metakeywords`, `makePriceVis`) VALUES (NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', NULL)");
        $product_id = mysql_insert_id();
        if (isset($product_id) && $product_id > 0) {
            $result = mysql_query("INSERT INTO `fabrix_temp_product` set `productId` = '$product_id', sid='" . session_id() . "'");

            $_GET['produkt_id'] = $product_id;
        }
    }

    public function cleanTempProducts()
    {
        $result = mysql_query("DELETE FROM `fabrix_products` WHERE `pid` in ( select `productId` from `fabrix_temp_product` where `sid`='" . session_id() . "')");
        $result = mysql_query("DELETE FROM `fabrix_temp_product` WHERE `sid`='" . session_id() . "'");
    }

    public function set_product_inventory($pid, $inventory = 0)
    {
        $q = "update fabrix_products set inventory=" . $inventory;
        $q .= ($inventory == 0) ? ", pvisible = 0" : "";
        $q .= " where pid=" . $pid;
        $res = mysql_query($q);
    }

    public function get_product_params($produkt_id)
    {

        $resulthatistim = mysql_query("select * from fabrix_products WHERE pid='$produkt_id'");
        $rowsni = mysql_fetch_array($resulthatistim);
        $p_pname = $rowsni['pname'];
        $pnumber = $rowsni['pnumber'];
        $price = $rowsni['priceyard'];
        $Stock_number = $rowsni['stock_number'];
        $inventory = $rowsni['inventory'];
        $piece = $rowsni['piece'];
        $whole = $rowsni['whole'];
        $quatity = ($inventory > 1) ? 1 : $inventory;
        if ($piece == 1) $quatity = 1;

        return array(
            'produkt_id' => $produkt_id,
            'Product_name' => $p_pname,
            'Product_number' => $pnumber,
            'Price' => $price,
            'Stock_number' => $Stock_number,
            'quantity' => $quatity,
            'inventory' => $inventory,
            'piece' => $piece,
            'whole' => $whole
        );

    }


    public function getProduktInfo()
    {

//        $back_url = urlencode($back_url);

        $produkt_id = $_GET['produkt_id'];
        $resulthatistim = mysql_query("select * from fabrix_products WHERE pid='$produkt_id'");
        $rowsni = mysql_fetch_array($resulthatistim);
        $p_pname = $rowsni['pname'];
        $pnumber = $rowsni['pnumber'];
        $pwidth = $rowsni['width'];
        $yardage = $rowsni['yardage'];
        $priceyard = $rowsni['priceyard'];
        $inventory = $rowsni['inventory'];
        $sdesc = $rowsni['sdesc'];
        $p_ldesc = $rowsni['ldesc'];
        $rpnumber1 = $rowsni['rpnumber1'];
        $rpnumber2 = $rowsni['rpnumber2'];
        $rpnumber3 = $rowsni['rpnumber3'];
        $rpnumber4 = $rowsni['rpnumber4'];
        $rpnumber5 = $rowsni['rpnumber5'];
        $p_image1 = $rowsni['image1'];
        $metadescription = $rowsni['metadescription'];
        $metakeywords = $rowsni['metakeywords'];
        $makePriceVis = $rowsni['makePriceVis'];
        $metadescription = $rowsni['metadescription'];
        $pvisible = $rowsni['pvisible'];
        $Stock_number = $rowsni['stock_number'];
        $dimensions = $rowsni['dimensions'];
        $d_inventory = $rowsni['inventory'];
        $d_specials = $rowsni['specials'];
        $weight_id = $rowsni['weight_id'];
        $piece = $rowsni['piece'];
        $d_cid = $rowsni['cid'];
        $best = $rowsni['best'];
        $whole = $rowsni['whole'];

        $manufacturerId = $rowsni['manufacturerId'];
        if (empty($manufacturerId)) {
            $manufacturerId = "0";
        }
        $sl_cat = 0;
        $sl_cat2 = 0;
        $sl_cat3 = 0;
        $sl_cat4 = 0;
        $patterns = [];
        $result = mysql_query("select patternId from fabrix_product_patterns WHERE prodId='$produkt_id'");
        while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
            $patterns[] = $row[0];
        };

        $pcolours = [];
        $result = mysql_query("select colourId from fabrix_product_colours WHERE prodId='$produkt_id'");
        while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
            $pcolours[] = $row[0];
        };

        $categories = [];
        $result = mysql_query("select cid from fabrix_product_categories WHERE pid='$produkt_id'");
        while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
            $categories[] = $row[0];
        };

        if (count($categories) < 1) $categories = ['1'];
        $results = mysql_query("select * from fabrix_categories");
        while ($row = mysql_fetch_array($results)) {
            if (in_array($row[0], $categories)) {
                $sl_cat .= '<option value="' . $row[0] . '" selected>' . $row[1] . '</option>';
            } else {
                $sl_cat .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
            }
        }
        $results = mysql_query("select * from fabrix_manufacturers");
        while ($row = mysql_fetch_array($results)) {
            if ($row[0] == $manufacturerId) {
                $sl_cat2 .= '<option value="' . $row[0] . '" selected>' . $row[1] . '</option>';
            } else {
                $sl_cat2 .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
            }
        }
        $results = mysql_query("select * from fabrix_colour");
        while ($row = mysql_fetch_array($results)) {
            if (in_array($row[0], $pcolours)) {
                $sl_cat3 .= '<option value="' . $row[0] . '" selected>' . $row[1] . '</option>';
            } else {
                $sl_cat3 .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
            }
        }
        $results = mysql_query("select * from fabrix_patterns");
        while ($row = mysql_fetch_array($results)) {
            if (in_array($row[0], $patterns)) {
                $sl_cat4 .= '<option value="' . $row[0] . '" selected>' . $row[1] . '</option>';
            } else {
                $sl_cat4 .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
            }
        }

        return array(
            'weight_id' => $weight_id,
            'sd_cat' => $sl_cat,
            'pvisible' => $pvisible,
            'metadescription' => $metadescription,
            'produkt_id' => $produkt_id,
            'Title' => $p_pname,
            'Meta_Description' => $metadescription,
            'Meta_Keywords' => $metakeywords,
            'Default_category' => 'test',
            'Categories' => 'test',
            'Product_name' => $p_pname,
            'Product_number' => $pnumber,
            'Width' => $pwidth,
            'Price_Yard' => $priceyard,
            'Stock_number' => $Stock_number,
            'Hide_regular_price' => 'test',
            'Dimensions' => $dimensions,
            'Current_inventory' => $d_inventory,
            'Specials' => $d_specials,
            'Weight' => $pwidth,
            'Manufacturer' => $sl_cat2,
            'Colours' => $sl_cat3,
            'Pattern_Type' => $sl_cat4,
            'Short_description' => $sdesc,
            'Long_description' => $p_ldesc,
            'Related_fabric_1' => $rpnumber1,
            'Related_fabric_2' => $rpnumber2,
            'Related_fabric_3' => $rpnumber3,
            'Related_fabric_4' => $rpnumber4,
            'Related_fabric_5' => $rpnumber5,
            'Main_images' => $p_image1,
            'Position_in_Brunschwig' => 'test',
            'Position_in_Modern' => 'test',
            'Position_in_Designer' => 'test',
            'Position_in_Stripe' => 'test',
            'Position_in_Just_Arrived' => 'test',
            'Long_description' => $p_ldesc,
            'visible' => $makePriceVis,
            'd_image2' => $rowsni['image2'],
            'd_image3' => $rowsni['image3'],
            'd_image4' => $rowsni['image4'],
            'd_image5' => $rowsni['image5'],
            'best' => $best,
            'piece' => $piece,
            'whole' => $whole
        );
    }

    public function getImage($produkt_id)
    {
        $resulthatistim = mysql_query("select * from fabrix_products WHERE pid='$produkt_id'");
        $rowsni = mysql_fetch_assoc($resulthatistim);
        return array('image1' => $rowsni['image1'], 'image2' => $rowsni['image2'], 'image3' => $rowsni['image3'], 'image4' => $rowsni['image4'], 'image5' => $rowsni['image5']);
    }

    public function dbUpdate($bd_g, $pid)
    {
        $result = mysql_query("update fabrix_products set $bd_g=null WHERE pid ='$pid'");
    }

    public function dbUpdateMainPhoto($bd_g, $rest, $produkt_id)
    {
        $result = mysql_query("update fabrix_products set $bd_g='$rest' WHERE pid ='$produkt_id'");
    }

    public function dbUpdateMainNew($image2, $bd_g, $image1, $produkt_id)
    {
        $result = mysql_query("update fabrix_products set image1='$image2', $bd_g='$image1' WHERE pid ='$produkt_id'");
    }

    public function getPrName($p_id)
    {
        $this->PopularPlus($p_id);
        $resulthatistim = mysql_query("select * from fabrix_products WHERE pid='$p_id'");
        $rowsni = mysql_fetch_array($resulthatistim);

        setlocale(LC_MONETARY, 'en_US');

        $price = $rowsni[5];
        $inventory = $rowsni[6];
        $piece = $rowsni[34];

        return array(
            'pname' => $rowsni['pname'],
            'pnumber' => $rowsni['pnumber'],
            'width' => $rowsni['width'],
            'priceyard' => $price,
            'ldesc' => $rowsni['ldesc'],
            'sdesc' => $rowsni['sdesc'],

            'image1' => $rowsni['image1'],
            'image2' => $rowsni['image2'],
            'image3' => $rowsni['image3'],
            'image4' => $rowsni['image4'],
            'image5' => $rowsni['image5'],
            'inventory' => $rowsni[6],
            'piece' => $rowsni[34],
            'dimensions' => $rowsni['dimensions'],
            'vis_price' => $rowsni['makePriceVis']
            //
        );
    }

    function PopularPlus($p_id)
    {
        mysql_query("update fabrix_products set popular = popular+1 WHERE pid='$p_id'");
    }

    public function get_edit_form_checked_fabrics_by_array($fabric_list, $sel_fabrics)
    {
        $fabrics = '';

        $results = mysql_query("select * from fabrix_products");
        while ($row = mysql_fetch_array($results)) {

            $content = $row[2] . '-' . $row[1];
            $content = substr($content, 0, 50);

            if (in_array($row[0], $fabric_list) && ($sel_fabrics == '2')) {
                $fabrics .= '<option value="' . $row[0] . '" selected >' . $content . '</option>';
                $sel_fabrics++;
            } else {
                $fabrics .= '<option value="' . $row[0] . '">' . $content . '</option>';
            }
        }

        return $fabrics;

    }

    public function getCatName($cat_id)
    {
        $resulthatistim = mysql_query("select * from fabrix_categories WHERE cid='$cat_id'");
        $rowsni = mysql_fetch_array($resulthatistim);
        return array('cname' => $rowsni['cname']);
    }

    public function getMnfName($mnf_id)
    {
        $resulthatistim = mysql_query("select * from fabrix_manufacturers WHERE id='$mnf_id'");
        $rowsni = mysql_fetch_array($resulthatistim);
        return array('manufacturer' => $rowsni['manufacturer']);
    }

    public function getPtrnName($ptrn_id)
    {
        $resulthatistim = mysql_query("select * from fabrix_patterns WHERE id='$ptrn_id'");
        $rowsni = mysql_fetch_array($resulthatistim);
        return array('pattern' => $rowsni['pattern']);
    }

    public function get_data_categories($category_id)
    {
        $resulthatistim = mysql_query("select * from fabrix_categories WHERE cid='$category_id'");
        $rowsni = mysql_fetch_array($resulthatistim);
        return array('cname' => $rowsni['cname'],
            'seo' => $rowsni['seo'],
            'displayorder' => $rowsni['displayorder'],
            'isStyle' => $rowsni['isStyle'],
            'isNew' => $rowsni['isNew']);
    }

    public function get_prod_list_by_type($type, $start, $limit, &$res_row_count, &$image_suffix)
    {
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
        $rows = mysql_query($q);
        $res_row_count = mysql_num_rows($rows);
        if ($rows) {
            $res = $rows;
            $rows = [];
            while ($row = mysql_fetch_array($res)) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    public function get_items_for_menu($type)
    {
        $res = [];
        $row_new_count = 50;
        switch ($type) {
            case 'all':
                $q = "SELECT distinct a.*" .
                    " FROM fabrix_categories a" .
                    " LEFT JOIN fabrix_product_categories c on a.cid = c.cid" .
                    " LEFT JOIN fabrix_products b ON b.pid = c.pid" .
                    " WHERE b.pvisible = '1'" .
                    " ORDER BY a.displayorder";
                break;
            case 'new':
                $q = "SELECT distinct a.*" .
                    " FROM (SELECT pid FROM fabrix_products WHERE pvisible = '1' ORDER BY dt DESC LIMIT " . $row_new_count . ") b" .
                    " LEFT JOIN fabrix_product_categories c ON b.pid = c.pid" .
                    " LEFT JOIN fabrix_categories a on a.cid = c.cid" .
                    " ORDER BY a.displayorder";
                break;
            case 'manufacturer':
                $q = "SELECT distinct a.*" .
                    " FROM fabrix_products b " .
                    " INNER JOIN fabrix_manufacturers a ON b.manufacturerId = a.id" .
                    " WHERE b.pvisible = '1'" .
                    " ORDER BY b.dt DESC";
                break;
            case 'patterns':
                $q = "SELECT distinct a.*" .
                    " FROM  fabrix_patterns a" .
                    " LEFT JOIN fabrix_product_patterns c on a.id = c.patternId" .
                    " LEFT JOIN fabrix_products b ON  b.pid = c.prodId" .
                    " WHERE b.pvisible = '1'";
                break;
            case 'blog_category':
                $q = "SELECT distinct a.*" .
                    " FROM blog_groups a" .
                    " LEFT JOIN blog_group_posts c on a.group_id = c.group_id" .
                    " LEFT JOIN blog_posts b ON b.ID = c.object_id" .
                    " WHERE b.post_status = 'publish'";
                break;
        }
        $result = mysql_query($q);
        while ($row = mysql_fetch_assoc($result)) {
            $res[] = $row;
        }
        return $res;
    }

}