<?php

Class Model_Users
{

    function checkCouponCode($sid,$cde){

        $iCnt = 0;
        $sSQL = sprintf("SELECT sid FROM fabrix_specials WHERE coupon_code='%s';",$cde);
        $result = mysql_query($sSQL) or die(mysql_error());
        $iCnt = mysql_num_rows($result);
        if($iCnt==1){ #verify that it is not this record with the same coupon code
            $rs = mysql_fetch_row($result);
            if($sid==$rs[0]){
                $iCnt = 0;
            }
        }
        mysql_free_result($result);

        if($iCnt>0){
            return true;
        } else {
            return false;
        }

    }

    function generateCouponCode($sid){

        $sCde = "";
        $possible = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        for($i=0; $i<10; $i++) {
            $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
            $sCde .= $char;
        }

        #ensure that the code is unique (keep getting a new one until it is)
        while($this->checkCouponCode($sid,$sCde)){
            $sCde = $this->generateCouponCode();
        }

        return $sCde;

    }


    public function blog_category_is_empty($group_id)
    {
        $q = "select * from blog_group_posts where group_id = '$group_id'";
        $res = mysql_query($q);
        return ($res && (mysql_num_rows($res) < 1));
    }

    public function del_product($del_produkt_id){
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

    public function del_blog_category($group_id)
    {
        $q = "delete from blog_group_posts where group_id = '$group_id'";
        $res = mysql_query($q);
        if ($res) {
            $q = "delete from blog_groups where group_id = '$group_id'";
            $res = mysql_query($q);
        }
    }

    public function get_blog_categories()
    {
        $res = null;
        $q = "select * from blog_groups";
        $result = mysql_query($q);
        if ($result) {
            while ($row = mysql_fetch_assoc($result)) {
                $res[] = $row;
            }
        }
        return $res;
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

    public function get_blog_post_by_post_name($post_name)
    {
        $result = null;
        $q = "select * from blog_posts where post_name = '$post_name'";
        $res = mysql_query($q);
        if ($res && mysql_num_rows($res) > 0) {
            $result = mysql_fetch_assoc($res);
        }
        return $result;
    }

    public function get_blog_post_by_post_id($post_id)
    {
        $result = null;
        $q = "select * from blog_posts where id = '$post_id'";
        $res = mysql_query($q);
        if ($res && mysql_num_rows($res) > 0) {
            $result = mysql_fetch_assoc($res);
        }
        return $result;
    }

    public function get_post_categories_by_post_id($post_id)
    {
        $result = [];
        $q = "select group_id from blog_group_posts where object_id = '$post_id'";
        $res = mysql_query($q);
        if ($res && mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $result[] = $row['group_id'];
            }
        }
        return $result;
    }

    public function ConfirmProductInsert(){
        $q = "DELETE FROM `fabrix_temp_product` WHERE `productId`=".$_GET['produkt_id']." and `sid`='" . session_id() . "'";
        $result = mysql_query($q);
        return $result;
    }

    public function cleanTempProducts(){
        $result = mysql_query("DELETE FROM `fabrix_products` WHERE `pid` in ( select `productId` from `fabrix_temp_product` where `sid`='" . session_id() . "')");
        $result = mysql_query("DELETE FROM `fabrix_temp_product` WHERE `sid`='" . session_id() . "'");
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

    public function get_blog_category($group_id)
    {
        $resulthatistim = mysql_query("select * from blog_groups WHERE group_id='$group_id'");
        $rowsni = mysql_fetch_array($resulthatistim);
        $name = $rowsni['name'];
        $slug = $rowsni['pnumber'];
        $id = $rowsni['group_id'];

        return array(
            'id' => $id,
            'name' => $name,
            'slug' => $slug
        );
    }

    public function del_post($post_id)
    {
        $strSQL = "DELETE FROM blog_group_posts WHERE object_id = $post_id";
        mysql_query($strSQL);
        $strSQL = "DELETE FROM blog_post_img WHERE post_id = $post_id";
        mysql_query($strSQL);
        $strSQL = "DELETE FROM blog_post_keys_descriptions WHERE post_id = $post_id";
        mysql_query($strSQL);
        $strSQL = "DELETE FROM blog_posts WHERE id = $post_id";
        mysql_query($strSQL);
    }

    public function set_product_inventory($pid, $inventory=0){
        $q = "update fabrix_products set inventory=".$inventory;
        $q .= ($inventory == 0)?", pvisible = 0":"";
        $q .= " where pid=".$pid;
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


    public function meta_page($route_control)
    {
        $page_Description = '';
        $page_KeyWords = '';
        $page_Name = '';

        $route_control = explode('/', $route_control)[0];
        if ($route_control == 'post') {
            $post_id = isset($_GET['post_id']) ? $_GET['post_id'] : null;
            if (isset($post_id)) {
                $result = mysql_query("select post_title from blog_posts WHERE ID='$post_id'");
                if ($result && mysql_num_rows($result) > 0) {
                    $row = mysql_fetch_assoc($result);
                    $page_Name = $row['post_title'];
                }
                $result = mysql_query("select * from blog_post_keys_descriptions WHERE post_id='$post_id'");
                if ($result && mysql_num_rows($result) > 0) {
                    $row = mysql_fetch_assoc($result);
                    $page_Description = stripslashes($row['description']);
                    $page_KeyWords = stripslashes($row['keywords']);
                }
            }
        } elseif ($route_control == "product_page") {
            $p_id = $_GET['p_id'];
            $result = mysql_query("select * from fabrix_products WHERE pid='$p_id'");
            $row = mysql_fetch_array($result);
            $page_Description = $row['metadescription'];
            $page_KeyWords = $row['metakeywords'];
            $page_Name = $row['pname'];
        } else {
            $resulthatistim = mysql_query("SELECT * FROM `page_title` WHERE `control` LIKE '$route_control'");
            $row = mysql_fetch_array($resulthatistim);
            if (!empty($row['id'])) {
                $page_Name = $row['name_page'];
                $page_Description = $row['m_desc'];
                $page_KeyWords = $row['m_key'];
            }
        }

        if (empty($page_Name{0})){
            $page_Name = "Upholstery Fabric";
        }
        if (empty($page_Description{0})){
            $page_Description = "Upholstery Fabric";
        }
        if (empty($page_KeyWords{0})){
            $page_KeyWords = "Upholstery Fabric";
        }
        return array('page_KeyWords' => $page_KeyWords, 'page_Description' => $page_Description, 'page_Name' => $page_Name);
    }

    public function getAccessRights($login)
    {
        $resulthatistim = mysql_query("select * from users WHERE login='$login'");
        $rowsni = mysql_fetch_array($resulthatistim);
        return array('enter_soll' => $rowsni['soll'], 'password' => $rowsni['password'], 'character' => $rowsni['character']);
    }

    public function validData($data)
    {
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = trim($data);
        $data = substr($data, 0, 155);

        return array('data' => $data);
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

    public function getCatName($cat_id)
    {
        $resulthatistim = mysql_query("select * from fabrix_categories WHERE cid='$cat_id'");
        $rowsni = mysql_fetch_array($resulthatistim);
        return array('cname' => $rowsni['cname']);
    }

    public function getPostCatName($cat_id)
    {
        $resulthatistim = mysql_query("select * from blog_groups WHERE group_id='$cat_id'");
        $rowsni = mysql_fetch_array($resulthatistim);
        $res = null;
        if (mysql_num_rows($resulthatistim) > 0) {
            $res = $rowsni['name'];
        }
        return $res;
    }

    public function getPostImg($post_id)
    {
        $resulthatistim = mysql_query("select * from blog_post_img WHERE post_id='$post_id'");
        $res = null;
        if ($resulthatistim && mysql_num_rows($resulthatistim) > 0) {
            $rowsni = mysql_fetch_array($resulthatistim);
            $res = $rowsni['img'];
        }
        return $res;
    }

    public function getPostDescKeys($post_id)
    {
        $resulthatistim = mysql_query("select * from blog_post_keys_descriptions WHERE post_id='$post_id'");
        $res = null;
        if ($resulthatistim && mysql_num_rows($resulthatistim) > 0) {
            $rowsni = mysql_fetch_assoc($resulthatistim);
            $res = $rowsni;
        }
        return $res;
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

    function PopularPlus($p_id)
    {
        mysql_query("update fabrix_products set popular = popular+1 WHERE pid='$p_id'");
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

    public function get_order($order_id)
    {
        $resulthatistim = mysql_query("select * from fabrix_orders WHERE oid='$order_id'");
        $rowsni = mysql_fetch_array($resulthatistim);
        $dat = gmdate("F j, Y, g:i a", $rowsni['order_date']);
        return array('shipping_cost' => $rowsni['shipping_cost'], 'order_date' => $dat, 'handling' => $rowsni['handling'], 'shipping_discount' => $rowsni['shipping_discount'], 'coupon_discount' => $rowsni['coupon_discount'], 'total_discount' => $rowsni['total_discount'], 'taxes' => $rowsni['taxes'], 'total' => $rowsni['total']);
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

    public function get_user_edit_data($user_id)
    {
        $resulthatistim = mysql_query("select * from fabrix_accounts WHERE aid='$user_id'");
        $rowsni = mysql_fetch_array($resulthatistim);
        return array(
            'email' => $rowsni['email'],
            'bill_firstname' => $rowsni['bill_firstname'],
            'bill_lastname' => $rowsni['bill_lastname'],
            'bill_organization' => $rowsni['bill_organization'],
            'bill_address1' => $rowsni['bill_address1'],
            'bill_address2' => $rowsni['bill_address2'],
            'bill_province' => $rowsni['bill_province'],
            'bill_province_other' => $rowsni['bill_province_other'],
            'bill_city' => $rowsni['bill_city'],
            'bill_country' => $rowsni['bill_country'],
            'bill_postal' => $rowsni['bill_postal'],
            'bill_phone' => $rowsni['bill_phone'],
            'bill_fax' => $rowsni['bill_fax'],
            'bill_email' => $rowsni['bill_email'],
            'ship_firstname' => $rowsni['ship_firstname'],
            'ship_lastname' => $rowsni['ship_lastname'],
            'ship_organization' => $rowsni['ship_organization'],
            'ship_address1' => $rowsni['ship_address1'],
            'ship_address2' => $rowsni['ship_address2'],
            'ship_city' => $rowsni['ship_city'],
            'ship_province' => $rowsni['ship_province'],
            'ship_province_other' => $rowsni['ship_province_other'],
            'ship_country' => $rowsni['ship_country'],
            'ship_postal' => $rowsni['ship_postal'],
            'ship_phone' => $rowsni['ship_phone'],
            'ship_fax' => $rowsni['ship_fax'],
            'ship_email' => $rowsni['ship_email']
        );
    }

    public function del_discount($discounts_id){

        $sSQL = sprintf("DELETE FROM fabrix_specials_products WHERE sid=%u",$discounts_id);
        mysql_query($sSQL);
        $sSQL = sprintf("DELETE FROM fabrix_specials_users WHERE sid=%u",$discounts_id);
        mysql_query($sSQL);
        $strSQL = "DELETE FROM fabrix_specials WHERE sid = $discounts_id";
        mysql_query($strSQL);

    }

    public function get_edit_discounts_data($discounts_id)
    {
        $resulthatistim = mysql_query("select * from fabrix_specials WHERE sid='$discounts_id'");
        $rowsni = mysql_fetch_array($resulthatistim);

        date_default_timezone_set('UTC');

        $date_start = date("m/d/Y", $rowsni['date_start']);
        $date_endb = date("m/d/Y", $rowsni['date_end']);

        $sel_fabrics = $rowsni['product_type'];
        $results = mysql_query("select * from fabrix_products  order by pnumber, pname");
        $fabric_list = '';
        while ($row = mysql_fetch_array($results)) {
            $content = $row[2] . '-' . $row[1];
            $content = substr($content, 0, 50);
            $result = mysql_query("SELECT pid FROM fabrix_specials_products WHERE pid='$row[0]' && sid='$discounts_id'");
            $myrow = mysql_fetch_array($result);
            if (!empty($myrow['pid']) && $sel_fabrics == "2") {
                $fabric_list .= '<option value="' . $row[0] . '" selected>' . $content . '</option>';
            } else {
                $fabric_list .= '<option value="' . $row[0] . '">' . $content . '</option>';
            }
        }

        $users_check = $rowsni['user_type'];
        $results = mysql_query("select * from fabrix_accounts order by email, bill_firstname, bill_lastname");
        $users = '';
        while ($row = mysql_fetch_array($results)) {

            $content = $row[1] . '-' . $row[3] . ' ' . $row[4];
            $content = substr($content, 0, 60);
            $result = mysql_query("SELECT aid FROM fabrix_specials_users WHERE aid='$row[0]' && sid='$discounts_id'");
            $myrow = mysql_fetch_array($result);
            if (!empty($myrow['aid']) && $users_check == '4') {
                $users .= '<option value="' . $row[0] . '" selected >' . $content . '</option>';
            } else {
                $users .= '<option value="' . $row[0] . '">' . $content . '</option>';
            }
        }

        return array('discount_comment1' => $rowsni['discount_comment1'],
            'discount_comment2' => $rowsni['discount_comment2'],
            'discount_comment3' => $rowsni['discount_comment3'],
            'discount_amount' => $rowsni['discount_amount'],
            'coupon_code' => $rowsni['coupon_code'],
            'allow_multiple' => $rowsni['allow_multiple'],
            'date_start' => $date_start,
            'date_end' => $date_endb,
            'enabled' => $rowsni['enabled'],
            'fabric_list' => $fabric_list,
            'users_list' => $users,
            'countdown' => $rowsni['countdown'],
            'sel_fabrics' => $sel_fabrics,
            'users_check' => $users_check,
            'required_amount' => $rowsni['required_amount'],
            'promotion_type' => $rowsni['promotion_type'],
            'discount_type' => $rowsni['discount_type'],
            'required_type' => $rowsni['required_type'],
            'discount_amount_type' => $rowsni['discount_amount_type'],
            'iShippingType' => $rowsni['shipping_type'],
            'shipping_type' => $rowsni['shipping_type']
        );
    }

    public function get_new_discounts_data()
    {
        date_default_timezone_set('UTC');

        $date_start = date("m/d/Y");
        $date_endb = date("m/d/Y");


        $sel_fabrics = 1;
        $results = mysql_query("select * from fabrix_products order by pnumber, pname");
        $fabric_list = '';
        while ($row = mysql_fetch_array($results)) {
            $content = $row[2] . '-' . $row[1];
            $content = substr($content, 0, 50);
            $fabric_list .= '<option value="' . $row[0] . '">' . $content . '</option>';
        }

        $users_check = 1;
        $results = mysql_query("select * from fabrix_accounts order by email, bill_firstname, bill_lastname");
        $users = '';
        while ($row = mysql_fetch_array($results)) {

            $content = $row[1] . '-' . $row[3] . ' ' . $row[4];
            $content = substr($content, 0, 60);
            $users .= '<option value="' . $row[0] . '">' . $content . '</option>';
        }

        return array('discount_comment1' => '',
            'discount_comment2' => '',
            'discount_comment3' => '',
            'discount_amount' => '0.00',
            'coupon_code' => '',
            'allow_multiple' => 0,
            'date_start' => $date_start,
            'date_end' => $date_endb,
            'enabled' => 1,
            'fabric_list' => $fabric_list,
            'users_list' => $users,
            'countdown' => '',
            'sel_fabrics' => $sel_fabrics,
            'users_check' => $users_check,
            'required_amount' => '0.00',
            'promotion_type' => 0,
            'discount_type' => 1,
            'required_type' => 0,
            'discount_amount_type' => 0
        );
    }

    public function get_edit_form_checked_users_by_array($users_list, $users_check)
    {

        $users = '';
        $results = mysql_query("select * from fabrix_accounts  order by email, bill_firstname, bill_lastname");
        while ($row = mysql_fetch_array($results)) {

            $content = $row[1] . '-' . $row[3] . ' ' . $row[4];
            $content = substr($content, 0, 60);
            if (in_array($row[0], $users_list) && ($users_check == "4")) {
                $users .= '<option value="' . $row[0] . '" selected >' . $content . '</option>';
            } else {
                $users .= '<option value="' . $row[0] . '">' . $content . '</option>';
            }
        }
        return $users;

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

    public function search($produkt_serch)
    {
        $search_product = 0;
        $results = mysql_query("SELECT * FROM `fabrix_products` WHERE `sdesc` LIKE '%$produkt_serch%' ORDER BY `pid` DESC");
        while ($row = mysql_fetch_array($results)) {
            $search_product++;
            $row[8] = substr($row[8], 0, 100);
            $filename = "upload/upload/$row[14]";
            if (!file_exists($filename)) {
                $filename = "not_image.jpg";
            }
            $images .= $filename;
            $product_id = $row[0];
            $product_description .= $row[8];
            setlocale(LC_MONETARY, 'en_US');
            $product_amount .= number_format($row[5],2);
            $resulthatistim = mysql_query("select * from fabrix_categories WHERE cid='$row[22]'");
            $rowsni = mysql_fetch_array($resulthatistim);
            $product_catigori = $rowsni['cname'];
        }
        return array('results_serch' => $search_product, 'filename' => $images, 'product_id' => $product_id, 'product_description' => $product_description, 'product_amount' => $product_amount, 'product_catigori' => $product_catigori);
    }


    public function get_prise_in_cart()
    {
        $cart = $_SESSION['cart']['items'];
        $total = 0;
        foreach ($cart as $key => $item) {
            $total += ($item['quantity'] * $item['saleprice']);
        }
        if (!empty($total)) {
            setlocale(LC_MONETARY, 'en_US');
            $total = "$" . number_format($total, 2);
        } else {
            $total = "$0.00";
        }
        return array('am_total_cart' => $total);
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

    public function save_new_post($title, $keywords, $description, $name, $img, $content, $status, $categories)
    {

        $q = "insert into blog_posts" .
            "(post_date, post_content, post_title, post_status,post_name, post_modified, post_type,post_excerpt,post_content_filtered,pinged,to_ping)" .
            " values(NOW(), '$content', '$title', '$status', '$name', NOW(), 'post','','','','')";

        $res = mysql_query($q);
        if ($res) {
            $post_id = mysql_insert_id();

            $q = "delete from blog_group_posts where post_id = '$post_id'";
            $res = mysql_query($q);

            foreach ($categories as $group) {
                $q = "insert into blog_group_posts(object_id, group_id) values ('$post_id', '$group')";
                $res = mysql_query($q);
            }

            $q = "delete from blog_post_keys_descriptions where post_id = '$post_id'";
            $res = mysql_query($q);

            $q = "insert into blog_post_keys_descriptions(post_id, keywords, description) values('$post_id', '$keywords', '$description')";
            $res = mysql_query($q);

            $q = "delete from blog_post_img where post_id = '$post_id'";
            $res = mysql_query($q);

            $q = "insert into blog_post_img(post_id, img) values('$post_id', '$img')";
            $res = mysql_query($q);
        }
    }

    public function save_edit_post($post_id, $title, $keywords, $description, $name, $img, $content, $status, $categories)
    {

        $q = "update blog_posts" .
            " set post_content = '$content', post_title = '$title', post_status = '$status' ,post_name = '$name'," .
            " post_modified = NOW()" .
            " WHERE id = '$post_id'";

        $res = mysql_query($q);
        if ($res) {
            $q = "delete from blog_group_posts where object_id = '$post_id'";
            $res = mysql_query($q);

            foreach ($categories as $group) {
                $q = "insert into blog_group_posts(object_id, group_id) values ('$post_id', '$group')";
                $res = mysql_query($q);
            }

            $q = "delete from blog_post_keys_descriptions where post_id = '$post_id'";
            $res = mysql_query($q);

            $q = "insert into blog_post_keys_descriptions(post_id, keywords, description) values ('$post_id', '$keywords', '$description')";
            $res = mysql_query($q);

            $q = "delete from blog_post_img where post_id = '$post_id'";
            $res = mysql_query($q);

            $q = "insert into blog_post_img(post_id, img) values('$post_id', '$img')";
            $res = mysql_query($q);
        }
    }
}