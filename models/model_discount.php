<?php

Class Model_Discount extends Model_Model
{

    public static function generateCouponCode($sid)
    {
        $sCde = "";
        $possible = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        for ($i = 0; $i < 10; $i++) {
            $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
            $sCde .= $char;
        }
        while (self::checkCouponCode($sid, $sCde)) {
            $sCde = self::generateCouponCode();
        }
        return $sCde;
    }

    public static function checkCouponCode($sid, $cde)
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

        if ($iCnt > 0) return true;
        return false;
    }

    public static function getFabrixSpecialsIds()
    {
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

    public static function getFabrixSpecialsByID($id)
    {
        $res = null;
        $q = "select * from fabrix_specials WHERE sid='" . (integer)$id . "'";
        $result = mysql_query($q);
        if ($result) {
            $res = mysql_fetch_assoc($result);
        }
        return $res;
    }

    public static function getFabrixSpecialsUsageById($id)
    {
        $res = null;
        $q = "select * from fabrix_specials_usage WHERE specialId='" . (integer)$id . "'";
        $result = mysql_query($q);
        if ($result) {
            $res = mysql_fetch_assoc($result);
        }
        return $res;
    }

    public static function getFabrixOrdersById($id)
    {
        $res = null;
        $q = "select * from fabrix_orders WHERE oid='" . $id . "'";
        $result = mysql_query($q);
        if ($result) {
            $res = mysql_fetch_assoc($result);
        }
        return $res;
    }

    public static function getFabrixAccountByOrderId($id)
    {
        $res = null;
        $q = "select * from fabrix_accounts WHERE aid='" . (integer)$id . "'";
        $result = mysql_query($q);
        if ($result) {
            $res = mysql_fetch_assoc($result);
        }
        return $res;
    }

    public static function saveFabrixSpecialsUser($id, $users_check, $users)
    {
        $res = mysql_query("DELETE FROM fabrix_specials_users WHERE sid ='" . (integer)$id . "'");
        if ($res && ($users_check == "4")) {
            foreach ($users as $user_id) {
                $res = mysql_query("INSERT INTO  `fabrix_specials_users` (`sid` ,`aid`)VALUES('" . (integer)$id . "',  '" . (integer)$user_id . "')");
                if (!$res) break;
            }
        }
        if(!$res) throw new Exception(mysql_error());
    }

    public static function saveFabrixSpecialsProducts($id, $filters, $filter_type)
    {
        $res = mysql_query("DELETE FROM `fabrix_specials_products` WHERE `sid`='" . (integer)$id . "'");
        if ($res && isset($filter_type)) {
            foreach ($filters as $f_id) {
                $res = mysql_query("INSERT INTO  fabrix_specials_products (sid ,pid, stype)VALUES('" . (integer)$id . "',  '" . (integer)$f_id . "',  '" . (integer)$filter_type . "')");
                if (!$res) break;
            }
        }
        if(!$res) throw new Exception(mysql_error());
    }

    public static function saveFabrixSpecial($id, $coupon_code, $discount_amount, $iAmntType, $iDscntType, $users_check, $shipping_type, $sel_fabrics, $iType, $restrictions, $iReqType, $allow_multiple, $enabled, $countdown, $discount_comment1, $discount_comment2, $discount_comment3, $start_date, $date_end)
    {
        if (isset($id)) {
            $res = mysql_query("UPDATE fabrix_specials SET coupon_code='$coupon_code',discount_amount='$discount_amount',discount_amount_type='$iAmntType',discount_type='$iDscntType',user_type='$users_check',shipping_type='$shipping_type',product_type='$sel_fabrics',promotion_type='$iType',required_amount='$restrictions',required_type='$iReqType',allow_multiple='$allow_multiple',enabled='$enabled',countdown='$countdown',discount_comment1='$discount_comment1',discount_comment2='$discount_comment2',discount_comment3='$discount_comment3',date_start='$start_date', date_end='$date_end' WHERE sid ='$id'");
        } else {
            $res = mysql_query("INSERT INTO fabrix_specials set coupon_code='$coupon_code',discount_amount='$discount_amount',discount_amount_type='$iAmntType',discount_type='$iDscntType',user_type='$users_check', shipping_type='$shipping_type', product_type='$sel_fabrics',promotion_type='$iType',required_amount='$restrictions',required_type='$iReqType',allow_multiple='$allow_multiple',enabled='$enabled',countdown='$countdown',discount_comment1='$discount_comment1',discount_comment2='$discount_comment2',discount_comment3='$discount_comment3',date_start='$start_date', date_end='$date_end', date_added = 'CURRENT_TIMESTAMP'");
            if ($res) $id = mysql_insert_id();
        }
        if(!$res) throw new Exception(mysql_error());
        return $res ? $id : $res;
    }

    public static function del_discount($id)
    {

        $sSQL = sprintf("DELETE FROM fabrix_specials_products WHERE sid=%u", $id);
        mysql_query($sSQL);
        $sSQL = sprintf("DELETE FROM fabrix_specials_users WHERE sid=%u", $id);
        mysql_query($sSQL);
        $strSQL = "DELETE FROM fabrix_specials WHERE sid = $id";
        mysql_query($strSQL);

    }

    public static function get_filter_selected($type, &$data, $id)
    {
        if ($type == 'users') {
            $users = [];
            $users_check = $data['users_check'];
            if (isset($data['users']) || isset($data['users_select']))
                $select = implode(',', array_merge(isset($data['users']) ? $data['users'] : [],
                    isset($data['users_select']) ? $data['users_select'] : []));
            else {
                $data['users_select'] = self::get_filter_selected_data($type, $id);
                $select = implode(',', isset($data['users_select']) ? array_keys($data['users_select']) : []);
            }
            if ($users_check == '4') {
                if (strlen($select > 1)) {
                    $results = mysql_query(
                        "select * from fabrix_accounts" .
                        " where aid in($select)" .
                        " order by email, bill_firstname, bill_lastname"
                    );
                    while ($row = mysql_fetch_array($results)) {
                        $users[$row[0]] = $row[1] . '-' . $row[3] . ' ' . $row[4];
                    }
                }
            }
            $data['users'] = $users;
        } elseif ($type == 'filter_products') {
            $sel_fabrics = $data['sel_fabrics'];
            $filter_products = [];
            switch ($sel_fabrics) {
                case 2:
                    $filter_type = 'prod';
                    if (isset($data['prod_select']) || isset($data['filter_products']))
                        $select = implode(',', array_merge(isset($data['prod_select']) ? $data['prod_select'] : [],
                            isset($data['filter_products']) ? $data['filter_products'] : []));
                    else {
                        $data['prod_select'] = self::get_filter_selected_data($filter_type, $id);
                        $select = implode(',', isset($data['prod_select']) ? array_keys($data['prod_select']) : []);
                    }
                    if (strlen($select) > 0) {
                        $results = mysql_query(
                            "select * from fabrix_products" .
                            " where pid in ($select)" .
                            " order by pnumber, pname"
                        );
                        while ($row = mysql_fetch_array($results)) {
                            $filter_products[$row[0]] = $row[2] . '-' . $row[1];
                        }
                    }
                    break;
                case 4:
                    $filter_type = 'mnf';
                    if (isset($data['mnf_select']) || isset($data['filter_products']))
                        $select = implode(',', array_merge(isset($data['mnf_select']) ? $data['mnf_select'] : 0,
                            isset($data['filter_products']) ? $data['filter_products'] : []));
                    else {
                        $data['mnf_select'] = self::get_filter_selected_data($filter_type, $id);
                        $select = implode(',', isset($data['mnf_select']) ? array_keys($data['mnf_select']) : []);
                    }
                    if (strlen($select) > 0) {
                        $results = mysql_query(
                            "select * from fabrix_manufacturers" .
                            " where id in ($select)" .
                            " order by manufacturer"
                        );
                        while ($row = mysql_fetch_array($results)) {
                            $filter_products[$row[0]] = $row[1];
                        }
                    }
                    break;
                case 3:
                    $filter_type = 'cat';
                    if (isset($data['cat_select']) || isset($data['filter_products']))
                        $select = implode(',', array_merge(isset($data['cat_select']) ? $data['cat_select'] : 0,
                            isset($data['filter_products']) ? $data['filter_products'] : []));
                    else {
                        $data['cat_select'] = self::get_filter_selected_data($filter_type, $id);
                        $select = implode(',', isset($data['cat_select']) ? array_keys($data['cat_select']) : []);
                    }
                    if (strlen($select) > 0) {
                        $results = mysql_query(
                            "select * from fabrix_categories " .
                            " where cid in ($select)" .
                            " order by cname"
                        );
                        while ($row = mysql_fetch_array($results)) {
                            $filter_products[$row[0]] = $row[1];
                        }
                    }
                    break;
            }
            $data['filter_products'] = $filter_products;
            $data['filter_type'] = $filter_type;
        }
    }

    public static function get_filter_selected_data($type, $id)
    {
        $data = [];
        switch ($type) {
            case 'users':
                $results = mysql_query(
                    "select a.* from fabrix_specials_users b" .
                    " inner join fabrix_accounts a on b.uid=a.uid " .
                    " where sid='$id'" .
                    " order by email, bill_firtname, bill_lastname"
                );
                if ($results)
                    while ($row = mysql_fetch_array($results)) {
                        $data[$row[0]] = $row[1] . '-' . $row[3] . ' ' . $row[4];
                    }
                break;
            case 'prod':
                $results = mysql_query(
                    "select a.* from fabrix_specials_products b" .
                    " inner join fabrix_products a on b.pid=a.pid " .
                    " where b.sid='$id' and b.stype = 1" .
                    " order by a.pnumber, a.pname"
                );
                if ($results)
                    while ($row = mysql_fetch_array($results)) {
                        $data[$row[0]] = $row[2] . '-' . $row[1];
                    }
                break;
            case 'mnf':
                $results = mysql_query(
                    "select a.* from fabrix_specials_products b" .
                    " inner join fabrix_manufacturers a on b.pid=a.id " .
                    " where b.sid='$id' and b.stype = 2" .
                    " order by a.manufacturer"
                );
                if ($results)
                    while ($row = mysql_fetch_array($results)) {
                        $data[$row[0]] = $row[1];
                    }
                break;
            case 'cat':
                $results = mysql_query(
                    "select a.* from fabrix_specials_products b" .
                    " inner join fabrix_categories a on b.pid=a.cid " .
                    " where b.sid='$id' and b.stype = 3" .
                    " order by a.cname"
                );
                if ($results)
                    while ($row = mysql_fetch_array($results)) {
                        $data[$row[0]] = $row[1];
                    }
                break;
        }
        return $data;
    }

    public static function get_filter_data($type, &$count, $start = 0, $search = null)
    {
        $filter = null;
        $FILTER_LIMIT = FILTER_LIMIT;
        $start = isset($start) ? $start : 0;
        $search = mysql_escape_string(self::validData($search));
        switch ($type) {
            case 'users':
                $q = "select count(aid) from fabrix_accounts";
                if (isset($search) && (strlen($search) > 0)) {
                    $q .= " where bill_firstname like '%$search%'";
                    $q .= " or bill_lastname like '%$search%'";
                    $q .= " or email like '%$search%'";
                }
                $results = mysql_query($q);
                $row = mysql_fetch_array($results);
                $count = $row[0];
                $q = "select * from fabrix_accounts";
                if (isset($search) && (strlen($search) > 0)) {
                    $q .= " where bill_firstname like '%$search%'";
                    $q .= " or bill_lastname like '%$search%'";
                    $q .= " or email like '%$search%'";
                }
                $q .= " order by email, bill_firstname, bill_lastname";
                $q .= " limit $start, $FILTER_LIMIT";
                $results = mysql_query($q);
                while ($row = mysql_fetch_array($results)) {
                    $filter[] = [$row[0], $row[1] . ' - ' . $row[3] . ' ' . $row[4]];
                }
                break;
            case 'prod':
                $q = "select count(pid) from fabrix_products";
                if (isset($search) && (strlen($search) > 0)) {
                    $q .= " where pnumber like '%$search%'";
                    $q .= " or pname like '%$search%'";
                }
                $results = mysql_query($q);
                $row = mysql_fetch_array($results);
                $count = $row[0];
                $q = "select * from fabrix_products";
                if (isset($search) && (strlen($search) > 0)) {
                    $q .= " where pnumber like '%$search%'";
                    $q .= " or pname like '%$search%'";
                }
                $q .= " order by pnumber, pname";
                $q .= " limit $start, $FILTER_LIMIT";
                $results = mysql_query($q);
                while ($row = mysql_fetch_array($results)) {
                    $filter[] = [$row[0], $row[2] . ' - ' . $row[1]];
                }
                break;
            case 'mnf':
                $q = "select count(id) from fabrix_manufacturers";
                if (isset($search) && (strlen($search) > 0)) {
                    $q .= " where manufacturer like '%$search%'";
                }
                $results = mysql_query($q);
                $row = mysql_fetch_array($results);
                $count = $row[0];
                $q = "select * from fabrix_manufacturers";
                if (isset($search) && (strlen($search) > 0)) {
                    $q .= " where manufacturer like '%$search%'";
                }
                $q .= " order by manufacturer";
                $q .= " limit $start, $FILTER_LIMIT";
                $results = mysql_query($q);
                while ($row = mysql_fetch_array($results)) {
                    $filter[] = [$row[0], $row[1]];
                }
                break;
            case 'cat':
                $q = "select count(cid) from fabrix_categories";
                if (isset($search) && (strlen($search) > 0)) {
                    $q .= " where cname like '%$search%'";
                }
                $results = mysql_query($q);
                $row = mysql_fetch_array($results);
                $count = $row[0];
                $q = "select * from fabrix_categories";
                if (isset($search) && (strlen($search) > 0)) {
                    $q .= " where cname like '%$search%'";
                }
                $q .= " order by cname";
                $q .= " limit $start, $FILTER_LIMIT";
                $results = mysql_query($q);
                while ($row = mysql_fetch_array($results)) {
                    $filter[] = [$row[0], $row[1]];
                }
        }
        return $filter;
    }

    public static function get_discounts_data($id = null, $data = null)
    {
        $filter_types = [1 => null, 2 => 'prod', 3 => 'mnf', 4 => 'cat'];
        if (isset($id)) {
            if (isset($data)) {


            } else {
                $result = mysql_query("select * from fabrix_specials WHERE sid='$id'");
                $row = mysql_fetch_array($result);

                $date_start = date("m/d/Y", $row['date_start']);
                $date_endb = date("m/d/Y", $row['date_end']);

                $sel_fabrics = $row['product_type'];
                $filter_products = null;
                $filter_type = $filter_types[$sel_fabrics];
                if (in_array($filter_type, array_filter(array_values($filter_types)))) {
                    $filter_products = self::get_filter_selected_data($filter_type, $id);
                }

                $users_check = $row['user_type'];
                $users = null;
                if ($users_check == '4') {
                    $users = self::get_filter_selected_data('users', $id);
                }
                return array(
                    'discount_comment1' => $row['discount_comment1'],
                    'discount_comment2' => $row['discount_comment2'],
                    'discount_comment3' => $row['discount_comment3'],
                    'discount_amount' => $row['discount_amount'],
                    'coupon_code' => $row['coupon_code'],
                    'allow_multiple' => $row['allow_multiple'],
                    'date_start' => $date_start,
                    'date_end' => $date_endb,
                    'enabled' => $row['enabled'],
                    'filter_products' => $filter_products,
                    'filter_type' => $filter_type,
                    'users' => $users,
                    'countdown' => $row['countdown'],
                    'sel_fabrics' => $sel_fabrics,
                    'users_check' => $users_check,
                    'required_amount' => $row['required_amount'],
                    'promotion_type' => $row['promotion_type'],
                    'discount_type' => $row['discount_type'],
                    'required_type' => $row['required_type'],
                    'discount_amount_type' => $row['discount_amount_type'],
                    'iShippingType' => $row['shipping_type'],
                    'shipping_type' => $row['shipping_type']
                );
            }
        } else {
            if (isset($data)) return $data;
            return array(
                'discount_comment1' => '',
                'discount_comment2' => '',
                'discount_comment3' => '',
                'discount_amount' => '0.00',
                'coupon_code' => '',
                'allow_multiple' => 0,
                'date_start' => date("m/d/Y"),
                'date_end' => date("m/d/Y"),
                'enabled' => 1,
                'filter_products' => null,
                'filter_type' => null,
                'users' => null,
                'countdown' => '',
                'sel_fabrics' => 1,
                'users_check' => 1,
                'required_amount' => '0.00',
                'promotion_type' => 0,
                'discount_type' => 1,
                'required_type' => 0,
                'discount_amount_type' => 0
            );
        }
    }

}