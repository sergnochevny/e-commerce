<?php

Class Model_Discount extends Model_Model
{

    function generateCouponCode($sid)
    {

        $sCde = "";
        $possible = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        for ($i = 0; $i < 10; $i++) {
            $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
            $sCde .= $char;
        }

        #ensure that the code is unique (keep getting a new one until it is)
        while ($this->checkCouponCode($sid, $sCde)) {
            $sCde = $this->generateCouponCode();
        }

        return $sCde;

    }

    public static function getFabrixSpecialsIds(){
        $res = null;
        $q = "SELECT * FROM fabrix_specials ORDER BY fabrix_specials.sid DESC";
        $result = mysql_query($q);
        if ($result) {
            while ($row = mysql_fetch_assoc($result)) {
                $res[] = $row;
            }
        }
        return $res;
    }

    public static function getFabrixSpecialsByID($id){
        $res = null;
        $q = mysql_query("select * from fabrix_specials WHERE sid='" . (integer) $id . "'");
        $result = mysql_query($q);
        if ($result) {
            while ($row = mysql_fetch_assoc($result)) {
                $res[] = $row;
            }
        }
        return $res;
    }

    public static function getFabrixSpecialsUsageById($id){
        $res = null;
        $q = "select * from fabrix_specials_usage WHERE specialId='" . (integer) $id . "'";
        $result = mysql_query($q);
        if ($result) {
            while ($row = mysql_fetch_assoc($result)) {
                $res[] = $row;
            }
        }
        return $res;
    }

    public static function getFabrixOrdersById($id){
        $res = null;
        $q = mysql_query("select * from fabrix_orders WHERE oid='" . (integer) $id . "'");
        $result = mysql_query($q);
        if ($result) {
            while ($row = mysql_fetch_assoc($result)) {
                $res[] = $row;
            }
        }
        return $res;
    }

    public static function getFabrixAccountByOrderId($id){
        $res = null;
        $q = mysql_query("select * from fabrix_accounts WHERE aid='" . (integer) $id . "'");
        $result = mysql_query($q);
        if ($result) {
            while ($row = mysql_fetch_assoc($result)) {
                $res[] = $row;
            }
        }
        return $res;
    }

    public function deleteFabrixSpecialsUserById($id){
        $q = mysql_query("DELETE FROM fabrix_specials_users WHERE sid ='" . (integer) $id . "'");
        return mysql_query($q);
    }

    public function saveFabrixSpecialsUser($discount_id, $user_id){
        $q = mysql_query("INSERT INTO  `fabrix_specials_users` (`sid` ,`aid`)VALUES('" . (integer) $discount_id . "',  '" . (integer) $user_id . "');");
        return mysql_query($q);
    }


    public function deleteFabrixSpecialsProductById($id){
        $q = mysql_query("DELETE FROM `fabrix_specials_products` WHERE `sid`='" . (integer) $id . "'");
        return mysql_query($q);
    }

    public function saveFabrixSpecialsProducts($discount_id, $fabric_id){
        $q = mysql_query("INSERT INTO  `fabrix_specials_products` (`sid` ,`pid`)VALUES('" . (integer) $discount_id . "',  '" . (integer) $fabric_id . "');");
        return mysql_query($q);
    }


    public function updateFabrixSpecials($coupon_code, $discount_amount, $iAmntType, $iDscntType, $users_check, $shipping_type, $sel_fabrics, $iType, $restrictions, $iReqType, $allow_multiple, $enabled, $countdown, $discount_comment1, $discount_comment2, $discount_comment3, $start_date, $date_end, $discount_id){
        $q = mysql_query("UPDATE fabrix_specials SET coupon_code='$coupon_code',discount_amount='$discount_amount',discount_amount_type='$iAmntType',discount_type='$iDscntType',user_type='$users_check',shipping_type='$shipping_type',product_type='$sel_fabrics',promotion_type='$iType',required_amount='$restrictions',required_type='$iReqType',allow_multiple='$allow_multiple',enabled='$enabled',countdown='$countdown',discount_comment1='$discount_comment1',discount_comment2='$discount_comment2',discount_comment3='$discount_comment3',date_start='$start_date', date_end='$date_end' WHERE sid ='$discount_id'");
        return mysql_query($q);
    }

    public function saveFabrixSpecial($coupon_code, $discount_amount, $iAmntType, $iDscntType, $users_check, $shipping_type, $sel_fabrics, $iType, $restrictions, $iReqType, $allow_multiple, $enabled, $countdown, $discount_comment1, $discount_comment2, $discount_comment3, $start_date, $date_end){
        $q = mysql_query("INSERT INTO fabrix_specials set coupon_code='$coupon_code',discount_amount='$discount_amount',discount_amount_type='$iAmntType',discount_type='$iDscntType',user_type='$users_check', shipping_type='$shipping_type', product_type='$sel_fabrics',promotion_type='$iType',required_amount='$restrictions',required_type='$iReqType',allow_multiple='$allow_multiple',enabled='$enabled',countdown='$countdown',discount_comment1='$discount_comment1',discount_comment2='$discount_comment2',discount_comment3='$discount_comment3',date_start='$start_date', date_end='$date_end', date_added = 'CURRENT_TIMESTAMP'");
        return mysql_query($q);
    }


    public function updateSpecials($discount_id, $user_id){
        $q = mysql_query("INSERT INTO  `fabrix_specials_users` (`sid` ,`aid`)VALUES('" . (integer) $discount_id . "',  '" . (integer) $user_id . "');");
        return mysql_query($q);
    }


    function checkCouponCode($sid, $cde)
    {

        $iCnt = 0;
        $sSQL = sprintf("SELECT sid FROM fabrix_specials WHERE coupon_code='%s';", $cde);
        $result = mysql_query($sSQL) or die(mysql_error());
        $iCnt = mysql_num_rows($result);
        if ($iCnt == 1) { #verify that it is not this record with the same coupon code
            $rs = mysql_fetch_row($result);
            if ($sid == $rs[0]) {
                $iCnt = 0;
            }
        }
        mysql_free_result($result);

        if ($iCnt > 0) {
            return true;
        } else {
            return false;
        }

    }
    public function del_discount($id)
    {

        $sSQL = sprintf("DELETE FROM fabrix_specials_products WHERE sid=%u", $id);
        mysql_query($sSQL);
        $sSQL = sprintf("DELETE FROM fabrix_specials_users WHERE sid=%u", $id);
        mysql_query($sSQL);
        $strSQL = "DELETE FROM fabrix_specials WHERE sid = $id";
        mysql_query($strSQL);

    }

    public function get_edit_discounts_data($id)
    {
        $resulthatistim = mysql_query("select * from fabrix_specials WHERE sid='$id'");
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
            $result = mysql_query("SELECT pid FROM fabrix_specials_products WHERE pid='$row[0]' && sid='$id'");
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
            $result = mysql_query("SELECT aid FROM fabrix_specials_users WHERE aid='$row[0]' && sid='$id'");
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
}