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

    public function product_filtr_list()
    {
        $x = 0;
        $results = mysql_query("select * from fabrix_categories");
        $category = [];
        while ($row = mysql_fetch_array($results)) {
            $x++;
            $category[] = [$row[0], $row[1]];
        }
        return array('total_category_in_select' => $x, 'category_in_select' => $category);
    }

    public function del_product($del_p_id)
    {
        $strSQL = "DELETE FROM fabrix_products WHERE pid = $del_p_id";
        mysql_query($strSQL);

        $strSQL = "DELETE FROM fabrix_product_categories WHERE pid = $del_p_id";
        mysql_query($strSQL);

        $strSQL = "DELETE FROM fabrix_product_colours WHERE prodId = $del_p_id";
        mysql_query($strSQL);

        $strSQL = "DELETE FROM fabrix_product_patterns WHERE prodId = $del_p_id";
        mysql_query($strSQL);

        $strSQL = "DELETE FROM fabrix_specials_products WHERE pid = $del_p_id";
        mysql_query($strSQL);
    }

    public function ConfirmProductInsert($pid)
    {
        $q = "DELETE FROM `fabrix_temp_product` WHERE `productId`=" . $pid . " and `sid`='" . session_id() . "'";
        $result = mysql_query($q);
        return $result;
    }

    public function getNewproduct()
    {
        $this->cleanTempProducts();

        $result = mysql_query("INSERT INTO `fabrix_products` (`pid`, `pname`, `pnumber`, `width`, `yardage`, `priceyard`, `inventory`, `sdesc`, `ldesc`, `rpnumber1`, `rpnumber2`, `rpnumber3`, `rpnumber4`, `rpnumber5`, `image1`, `image2`, `image3`, `image4`, `image5`, `display_order`, `cid`, `pvisible`, `dimensions`, `specials`, `weight_id`, `stock_number`, `manufacturerId`, `metatitle`, `metadescription`, `metakeywords`, `makePriceVis`) VALUES (NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', NULL)");
        $product_id = mysql_insert_id();
        if (isset($product_id) && $product_id > 0) {
            $result = mysql_query("INSERT INTO `fabrix_temp_product` set `productId` = '$product_id', sid='" . session_id() . "'");

            _A_::$app->get('p_id', $product_id);
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

    public function get_product_params($p_id)
    {

        $resulthatistim = mysql_query("select * from fabrix_products WHERE pid='$p_id'");
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
            'p_id' => $p_id,
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

    public function getProductCatInfo($post_categori, $post_manufacturer, $p_colors, $patterns)
    {
        $sl_cat = '';
        $sl_cat2 = '';
        $sl_cat3 = '';
        $sl_cat4 = '';
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
        return [
            'sl_cat' => $sl_cat,
            'sl_cat2' => $sl_cat2,
            'sl_cat3' => $sl_cat3,
            'sl_cat4' => $sl_cat4
        ];
    }

    public function getProductInfo($pid)
    {

//        $back_url = urlencode($back_url);

        $p_id = $pid;
        $resulthatistim = mysql_query("select * from fabrix_products WHERE pid='$p_id'");
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
        $patterns = [];
        $result = mysql_query("select patternId from fabrix_product_patterns WHERE prodId='$p_id'");
        while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
            $patterns[] = $row[0];
        };

        $pcolours = [];
        $result = mysql_query("select colourId from fabrix_product_colours WHERE prodId='$p_id'");
        while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
            $pcolours[] = $row[0];
        };

        $categories = [];
        $result = mysql_query("select cid from fabrix_product_categories WHERE pid='$p_id'");
        while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
            $categories[] = $row[0];
        };

        if (count($categories) < 1) $categories = ['1'];

        $cats = $this->getProductCatInfo($categories, $manufacturerId, $pcolours, $patterns);
        $sl_cat = $cats['sl_cat'];
        $sl_cat2 = $cats['sl_cat2'];
        $sl_cat3 = $cats['sl_cat3'];
        $sl_cat4 = $cats['sl_cat4'];

        return array(
            'weight_id' => $weight_id,
            'sd_cat' => $sl_cat,
            'pvisible' => $pvisible,
            'metadescription' => $metadescription,
            'p_id' => $p_id,
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

    public function getImage($p_id)
    {
        $resulthatistim = mysql_query("select * from fabrix_products WHERE pid='$p_id'");
        $rowsni = mysql_fetch_assoc($resulthatistim);
        return array('image1' => $rowsni['image1'], 'image2' => $rowsni['image2'], 'image3' => $rowsni['image3'], 'image4' => $rowsni['image4'], 'image5' => $rowsni['image5']);
    }

    public function dbUpdate($bd_g, $pid)
    {
        $result = mysql_query("update fabrix_products set $bd_g=null WHERE pid ='$pid'");
    }

    public function dbUpdateMainPhoto($bd_g, $rest, $p_id)
    {
        $result = mysql_query("update fabrix_products set $bd_g='$rest' WHERE pid ='$p_id'");
    }

    public function dbUpdateMainNew($image2, $bd_g, $image1, $p_id)
    {
        $result = mysql_query("update fabrix_products set image1='$image2', $bd_g='$image1' WHERE pid ='$p_id'");
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
        return $rowsni['cname'];
    }

    public function getMnfName($mnf_id)
    {
        $resulthatistim = mysql_query("select * from fabrix_manufacturers WHERE id='$mnf_id'");
        $rowsni = mysql_fetch_array($resulthatistim);
        return $rowsni['manufacturer'];
    }

    public function getPtrnName($ptrn_id)
    {
        $resulthatistim = mysql_query("select * from fabrix_patterns WHERE id='$ptrn_id'");
        $rowsni = mysql_fetch_array($resulthatistim);
        return $rowsni['pattern'];
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

    public function get_products_by_type($type = 'new', $start, $per_page, &$res_row_count = 0)
    {
        $q = "";
        switch ($type) {
            case 'all':
                if (!empty(_A_::$app->get('cat'))) {
                    $cat_id = $this->validData(_A_::$app->get('cat'));
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
                break;
            case 'last':
                if (!empty(_A_::$app->get('cat'))) {
                    $cat_id = $this->validData(_A_::$app->get('cat'));
                    $q = "SELECT a.* FROM `fabrix_products` a" .
                        " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                        " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cat_id' ORDER BY a.dt DESC, a.pid DESC LIMIT $start,$per_page";
                } else {
                    $q = "SELECT * FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1' ORDER BY  dt DESC, pid DESC LIMIT $start,$per_page";
                }
                break;
            case 'best':
                if (!empty(_A_::$app->get('cat'))) {
                    $cat_id = $this->validData(_A_::$app->get('cat'));
                    $q = "SELECT a.* FROM `fabrix_products` a" .
                        " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                        " WHERE  a.pnumber is not null and a.pvisible = '1'  and a.best = '1' and b.cid='$cat_id' ORDER BY a.dt DESC, a.pid DESC LIMIT $start,$per_page";
                } else {
                    $q = "SELECT * FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1' and best = '1' ORDER BY dt DESC, pid DESC LIMIT $start,$per_page";
                }
                break;
            case 'specials':
                if (!empty(_A_::$app->get('cat'))) {
                    $cat_id = $this->validData(_A_::$app->get('cat'));
                    $q = "SELECT a.* FROM `fabrix_products` a" .
                        " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                        " WHERE  a.pnumber is not null and a.pvisible = '1' and a.specials='1' and b.cid='$cat_id'" .
                        " ORDER BY a.dt DESC, a.pid DESC LIMIT $start,$per_page";
                } else {
                    $q = "SELECT * FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1' and specials='1'" .
                        " ORDER BY  dt DESC, pid DESC LIMIT $start,$per_page";
                }
                break;
            case 'popular':
                if (!empty(_A_::$app->get('cat'))) {
                    $cat_id = $this->validData(_A_::$app->get('cat'));
                    $q = "SELECT a.* FROM `fabrix_products` a" .
                        " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                        " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cat_id' ORDER BY popular DESC LIMIT $start,$per_page";
                } else {
                    $q = "SELECT * FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1' ORDER BY popular DESC LIMIT $start,$per_page";
                }
                break;
        }
        $res = mysql_query($q);
        $rows = null;
        if ($res) {
            $rows = mysql_query($q);
            $res_row_count = mysql_num_rows($rows);
            if ($rows) {
                $res = $rows;
                $rows = [];
                while ($row = mysql_fetch_array($res)) {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    public function get_count_products_by_type($type)
    {
        switch ($type) {
            case 'all':
                if (!empty(_A_::$app->get('cat'))) {
                    $cat_id = $this->validData(_A_::$app->get('cat'));
                    $q_total = "SELECT COUNT(*) FROM `fabrix_products` a" .
                        " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                        " WHERE  a.pnumber is not null and b.cid='$cat_id'";
                } else {
                    $q_total = "SELECT COUNT(*) FROM `fabrix_products` WHERE pnumber is not null ";
                }
                break;
            case 'last':
                if (!empty(_A_::$app->get('cat'))) {
                    $cat_id = $this->validData(_A_::$app->get('cat'));
                    $q_total = "SELECT COUNT(*) FROM `fabrix_products` a" .
                        " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                        " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cat_id'";

                } else {
                    $q_total = "SELECT COUNT(*) FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1' ORDER BY dt DESC";
                }
                break;
            case 'best':
                if (!empty(_A_::$app->get('cat'))) {
                    $cat_id = $this->validData(_A_::$app->get('cat'));
                    $q_total = "SELECT COUNT(*) FROM `fabrix_products` a" .
                        " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                        " WHERE  a.pnumber is not null and a.best='1' and a.pvisible = '1' and b.cid='$cat_id'";
                } else {
                    $q_total = "SELECT COUNT(*) FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1' and best = '1'";
                }
                break;
            case 'specials':
                if (!empty(_A_::$app->get('cat'))) {
                    $cat_id = $this->validData(_A_::$app->get('cat'));
                    $q_total = "SELECT COUNT(*) FROM `fabrix_products` a" .
                        " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                        " WHERE  a.pnumber is not null and a.pvisible = '1' and a.specials='1' and b.cid='$cat_id'";

                } else {
                    $q_total = "SELECT COUNT(*) FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1' and specials='1' ORDER BY dt DESC";
                }
                break;
            case 'popular':
                if (!empty(_A_::$app->get('cat'))) {
                    $cat_id = $this->validData(_A_::$app->get('cat'));
                    $q_total = "SELECT COUNT(*) FROM `fabrix_products` a" .
                        " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                        " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cat_id'";
                } else {
                    $q_total = "SELECT COUNT(*) FROM `fabrix_products` WHERE  pnumber is not null and pvisible = '1'";
                }
                break;
        }
        $res = mysql_query($q_total);
        $total = mysql_fetch_row($res)[0];
        return $total;
    }

    public function save($p_id, $New_Manufacturer,$post_new_color,$pattern_type,$post_weight_cat,$post_special,$post_curret_in, $post_dimens,$post_hide_prise,$post_st_nom,$post_p_yard,$post_width,$post_product_num,$post_vis,$post_fabric_5,$post_fabric_4,$post_fabric_3,$post_fabric_2,$post_fabric_1,$post_mkey,$post_desc,$post_Long_description,$post_tp_name,$post_short_desk,$best,$piece,$whole){
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

        $result = mysql_query($sql);

        if($result){
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
        }
        return $result;
    }

    public function get_total($search = null){
        if (!empty(_A_::$app->get('cat'))) {
            $cat_id = $this->validData(_A_::$app->get('cat'));
            $q_total = "SELECT COUNT(*) FROM `fabrix_products` a" .
                " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cat_id'";
            if (isset($search)) {
                $q_total .= " and (LOWER(a.pnumber) like '%" . $search . "%'" .
                    " or LOWER(a.pname) like '%" . $search . "%'";
            }
        } else {
            if (!empty(_A_::$app->get('ptrn'))) {
                $ptrn_id = $this->validData(_A_::$app->get('ptrn'));
                $q_total = "SELECT COUNT(*) FROM `fabrix_products` a" .
                    " LEFT JOIN fabrix_product_patterns b ON a.pid = b.prodid " .
                    " WHERE  a.pnumber is not null and a.pvisible = '1' and b.patternId='$ptrn_id'";

                if (isset($search)) {
                    $q_total .= " and (LOWER(a.pnumber) like '%" . $search . "%'" .
                        " or LOWER(a.pname) like '%" . $search . "%')";
                }

            } else {
                if (!empty(_A_::$app->get('mnf'))) {
                    $mnf_id = $this->validData(_A_::$app->get('mnf'));
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
        return $total;
    }

    public function get_products($start, $per_page, $res_count_rows = 0, $search = null){
        if (!empty(_A_::$app->get('cat'))) {
            $cat_id = $this->validData(_A_::$app->get('cat'));
            $q = "SELECT a.* FROM `fabrix_products` a" .
                " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
                " WHERE  a.pnumber IS NOT NULL AND a.pvisible = '1' and b.cid='$cat_id'";

            if (isset($search)) {
                $q .= " and (LOWER(a.pnumber) like '%" . $search . "%'" .
                    " or LOWER(a.pname) like '%" . $search . "%')";
            }

            $q .= " ORDER BY b.display_order LIMIT $start, $per_page";
        } else {
            if (!empty(_A_::$app->get('ptrn'))) {
                $ptrn_id = $this->validData(_A_::$app->get('ptrn'));
                $q = "SELECT a.* FROM `fabrix_products` a" .
                    " LEFT JOIN fabrix_product_patterns b ON a.pid = b.prodId " .
                    " WHERE  a.pnumber IS NOT NULL AND a.pvisible = '1' and b.patternId='$ptrn_id'";

                if (isset($search)) {
                    $q .= " and (LOWER(a.pnumber) like '%" . $search . "%'" .
                        " or LOWER(a.pname) like '%" . $search . "%')";
                }
                $q .= " ORDER BY a.dt DESC, a.pid DESC LIMIT $start, $per_page";

                $this->template->vars('ptrn_name', isset($ptrn_name) ? $ptrn_name : null);
            } else {
                if (!empty(_A_::$app->get('mnf'))) {
                    $mnf_id = $this->validData(_A_::$app->get('mnf'));
                    $q = "SELECT * FROM `fabrix_products` WHERE  pnumber IS NOT NULL AND pvisible = '1' AND manufacturerId = '$mnf_id'";
                    if (isset($search)) {
                        $q .= " and (LOWER(pnumber) like '%" . $search . "%'" .
                            " or LOWER(pname) like '%" . $search . "%')";
                    }
                    $q .= " ORDER BY dt DESC, pid DESC LIMIT $start,$per_page";

                    $this->template->vars('mnf_name', isset($mnf_name) ? $mnf_name : null);
                } else {

                    $q = "SELECT * FROM `fabrix_products` WHERE  pnumber IS NOT NULL AND pvisible = '1'";

                    if (isset($search)) {
                        $q .= " and (LOWER(pnumber) like '%" . $search . "%'" .
                            " or LOWER(pname) like '%" . $search . "%')";
                    }

                    $q .= " ORDER BY dt DESC, pid DESC LIMIT $start,$per_page";
                }
            }
        }
        $q = mysql_query($q);
        $res = [];
        $rows = null;
        if (is_resource($q)) {
            $res_count_rows = mysql_num_rows($q);
            while ($row = mysql_fetch_array($q)) {
                $res[] = $row;
            }
        }

        return $res;
    }
}