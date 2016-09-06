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
    public function del_discount($discounts_id)
    {

        $sSQL = sprintf("DELETE FROM fabrix_specials_products WHERE sid=%u", $discounts_id);
        mysql_query($sSQL);
        $sSQL = sprintf("DELETE FROM fabrix_specials_users WHERE sid=%u", $discounts_id);
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
}