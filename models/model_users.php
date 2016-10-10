<?php

  Class Model_Users extends Model_Model {

    public static function get_total_count($filter = null) {
      $response = 0;
      $query = "SELECT COUNT(*) FROM fabrix_accounts";
      if(isset($filter)) {
        $query .= " WHERE";
      }
      if($result = mysql_query($query)) {
        $response = mysql_fetch_row($result)[0];
      }
      return $response;
    }

    public static function get_list($start, $limit, &$res_count_rows, $filter = null) {
      $response = null;
      $query = "SELECT * ";
      $query .= " FROM fabrix_accounts";
      if(isset($filter)) {
        $query .= " WHERE";
      }
      $query .= " LIMIT $start, $limit";

      if($result = mysql_query($query)) {
        $res_count_rows = mysql_num_rows($result);
        while($row = mysql_fetch_array($result)) {
          $response[] = $row;
        }
      }

      return $response;
    }

    public static function get_by_id($id) {
      $user = null;
      $strSQL = "select * from fabrix_accounts where aid = '" . $id . "'";
      $result = mysql_query($strSQL);
      if($result) {
        $user = mysql_fetch_assoc($result);
      }
      return $user;
    }

    public static function get_data($id) {
      $data = [
        'aid' => $id,
        'email' => '',
        'bill_firstname' => '',
        'bill_lastname' => '',
        'bill_organization' => '',
        'bill_address1' => '',
        'bill_address2' => '',
        'bill_province' => '',
        'bill_city' => '',
        'bill_country' => '',
        'bill_postal' => '',
        'bill_phone' => '',
        'bill_fax' => '',
        'bill_email' => '',
        'ship_firstname' => '',
        'ship_lastname' => '',
        'ship_organization' => '',
        'ship_address1' => '',
        'ship_address2' => '',
        'ship_city' => '',
        'ship_province' => '',
        'ship_country' => '',
        'ship_postal' => '',
        'ship_phone' => '',
        'ship_fax' => '',
        'ship_email' => ''
      ];
      if(isset($id)) {
        $data = self::get_by_id($id);
      }
      return $data;
    }

    public static function delete($id) {
      if(isset($id)) {
        $query = "select count(*) from fabrix_special_users where aid = $id";
        $res = mysql_query($query);
        if($res) {
          $amount = mysql_fetch_array($res)[0];
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
//        $query = "delete from fabrix_special_users WHERE aid = $id";
//        $res = mysql_query($query);
//        if(!$res) throw new Exception(mysql_error());
        $query = "DELETE FROM fabrix_accounts WHERE aid = $id";
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      }
    }

    public static function save($data) {
      extract($data);
      $timestamp = time();
      if(!isset($aid)) {
        $q = "INSERT INTO  `fabrix_accounts` (`email` , `password` , `bill_firstname` , `bill_lastname` ," .
          " `bill_organization` , `bill_address1` , `bill_address2` , `bill_province` ," .
          " `bill_city` , `bill_country` , `bill_postal` , `bill_phone` , `bill_fax` , `bill_email` , " .
          "`ship_firstname` , `ship_lastname` , `ship_organization` , `ship_address1` , `ship_address2` , " .
          "`ship_city` , `ship_province` , `ship_country` , `ship_postal` , " .
          "`ship_phone` , `ship_fax` , `ship_email` , `get_newsletter` , `date_registered` , `login_counter`)" .
          " VALUES ('$email', '$password', '$bill_firstname', '$bill_lastname'," .
          " '$bill_organization', '$bill_address1', '$bill_address2', '$bill_province', " .
          " '$bill_city', '$bill_country', '$bill_postal', '$bill_phone', '$bill_fax', '$bill_email', " .
          " '$ship_firstname', '$ship_lastname', '$ship_organization', '$ship_address1', '$ship_address2', " .
          " '$ship_city', '$ship_province', '$ship_country', '$ship_postal', " .
          " '$ship_phone', '$ship_fax', '$ship_email', '1', '$timestamp', '0')";
      } else {
        $q = "UPDATE `fabrix_accounts` SET " .
          " `email` = '" . $email .
          "',`bill_firstname` =  '" . $bill_firstname .
          "',`bill_lastname` =  '" . $bill_lastname .
          "',`bill_organization` =  '" . $bill_organization .
          "',`bill_address1` =  '" . $bill_address1.
          "',`bill_address2` =  '" . $bill_address2 .
          "',`bill_province` =  '" . $bill_province .
          "',`bill_city` =  '" . $bill_city .
          "',`bill_country` =  '" . $bill_country .
          "',`bill_postal` =  '" . $bill_postal .
          "',`bill_phone` =  '" . $bill_phone .
          "',`bill_fax` =  '" . $bill_fax .
          "',`bill_email` =  '" . $bill_email .
          "',`ship_firstname` =  '" . $ship_firstname .
          "',`ship_lastname` =  '" . $ship_lastname .
          "',`ship_organization` =  '" . $ship_organization .
          "',`ship_address1` =  '" . $ship_address1 .
          "',`ship_address2` =  '" . $ship_address2 .
          "',`ship_city` =  '" . $ship_city .
          "',`ship_province` =  '" . $ship_province .
          "',`ship_country` =  '" . $ship_country .
          "',`ship_postal` =  '" . $ship_postal .
          "',`ship_phone` =  '" . $ship_phone .
          "',`ship_fax` =  '" . $ship_fax .
          "',`ship_email` =  '" . $ship_email .
          "'WHERE  `aid` = $aid;";
      }
      $result = mysql_query($q);
      if(!$result) throw new Exception(mysql_error());
      if(!isset($aid)) {
        $id = mysql_insert_id();
      }
      return $aid;
    }

  }