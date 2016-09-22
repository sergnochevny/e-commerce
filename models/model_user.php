<?php

Class Model_User extends Model_Model
{
    public static function get_total_count_users()
    {
        $total = 0;
        $q_total = "SELECT COUNT(*) FROM fabrix_accounts";

        if ($res = mysql_query($q_total)) {
            $total = mysql_fetch_row($res)[0];
        }

        return $total;
    }

    public static function get_users_list($start, $limit)
    {
        $list = [];
        $q = "SELECT * FROM fabrix_accounts ORDER BY aid LIMIT " . $start . ", " . $limit;
        if ($res = mysql_query($q)) {
            while ($row = mysql_fetch_array($res)) {
                $list[] = $row;
            }
        }
        return $list;
    }

    public static function del_user($user_id)
    {
        $strSQL = "DELETE FROM fabrix_accounts WHERE aid = $user_id";
        mysql_query($strSQL);
    }

    public static function get_user_by_email($email)
    {
        $user = null;
        $strSQL = "select * from fabrix_accounts where email = '" . mysql_real_escape_string($email) . "'";
        $result = mysql_query($strSQL);
        if ($result) {
            $user = mysql_fetch_assoc($result);
        }
        return $user;
    }

    public static function set_remind_for_change_pass($remind, $date, $user_id)
    {
        $q = "update fabrix_accounts set remind = '" . mysql_real_escape_string($remind) . "', remind_time = '" . $date . "' where aid = " . $user_id;
        $res = mysql_query($q);
        return ($res && mysql_affected_rows());
    }

    public static function clean_remind($user_id)
    {
        $q = "update fabrix_accounts set remind = NULL, remind_time = NULL where aid = " . $user_id;
        $res = mysql_query($q);
        return ($res && mysql_affected_rows());
    }

    public static function user_exist($email=null, $id = null)
    {
        if(is_null($email) && is_null($id)){
            throw new ErrorException('Both parameters cannot be empty!');
        }

        $q = "select * from fabrix_accounts where";

        if (isset($email)) {
            $q .= "aid <> '$id'";
        }
        if (isset($id)){
            if(!isset($email)){
                $q .= "email = '" . mysql_real_escape_string($email) . "'";
            }else{
                $q .= "and email = '" . mysql_real_escape_string($email) . "'";
            }
        }

        $result = mysql_query($q);

        return (!$result || mysql_num_rows($result) > 0);
    }

    public static function remind_exist($remind)
    {
        $q = "select * from fabrix_accounts where remind = '" . mysql_real_escape_string($remind) . "'";
        $result = mysql_query($q);
        return (!$result || mysql_num_rows($result) > 0);
    }

    public static function get_user_by_remind($remind)
    {
        $user = null;
        $strSQL = "select * from fabrix_accounts where remind = '" . mysql_real_escape_string($remind) . "'";
        $result = mysql_query($strSQL);
        if ($result) {
            $user = mysql_fetch_assoc($result);
        }
        return $user;
    }

    public static function get_user_by_id($id)
    {
        $user = null;
        $strSQL = "select * from fabrix_accounts where aid = '" . $id . "'";
        $result = mysql_query($strSQL);
        if ($result) {
            $user = mysql_fetch_assoc($result);
        }
        return $user;
    }

    public static function update_password($password, $user_id)
    {
        $result = mysql_query("UPDATE `fabrix_accounts` SET `password` =  '$password' WHERE  `aid` =$user_id;");
        return $result;
    }

    public static function update_user_data($user_Same_as_billing, $user_email, $user_first_name, $user_last_name, $user_organization,
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

    public static function save($user_Same_as_billing, $user_email, $password, $user_first_name, $user_last_name, $user_organization,
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

    public static function get_user_data($user_id)
    {
        $rowsni = self::get_user_by_id($user_id);
        if(isset($rowsni)){
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
        return false;
    }

}