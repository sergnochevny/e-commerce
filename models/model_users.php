<?php

  Class Model_Users extends Model_Base {

    protected static $table = 'fabrix_accounts';

    protected static function build_order(&$sort) {
      if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
        $sort = ['full_name' => 'ASC'];
      }
      return parent::build_order($sort);
    }

    protected static function build_where(&$filter) {
      $result = "";
      if(isset($filter["email"])) $result[] = "email LIKE '%" . implode('%',array_filter(explode(' ',mysql_real_escape_string(static::validData($filter["email"]))))) . "%'";
      if(isset($filter["full_name"])) $result[] = "CONCAT(bill_firstname, ' ', bill_lastname) LIKE '%" . implode('% %',array_filter(explode(' ',mysql_real_escape_string(static::validData($filter["full_name"]))))) . "%'";
      if(isset($filter["organization"])) $result[] = "bill_organization LIKE '%" . implode('%',array_filter(explode(' ',mysql_real_escape_string(static::validData($filter["organization"]))))) . "%'";
      if(isset($filter["postal"])) $result[] = "bill_postal LIKE '%" . implode('%',array_filter(explode(' ',mysql_real_escape_string(static::validData($filter["postal"]))))) . "%'";
      if(isset($filter["phone"])) $result[] = "bill_phone LIKE '%" . implode('%',array_filter(explode(' ',mysql_real_escape_string(static::validData($filter["phone"]))))) . "%'";
      if(isset($filter["city"])) $result[] = "bill_city LIKE '%" . implode('%',array_filter(explode(' ',mysql_real_escape_string(static::validData($filter["city"]))))) . "%'";
      if(isset($filter["address"]))
        $result[] = "(bill_address1 LIKE '%" . mysql_real_escape_string(static::validData($filter["address"])) . "%'" .
          "OR bill_address2 LIKE '%" . mysql_real_escape_string(static::validData($filter["address"])) . "%')";
      if(isset($filter["registered"])) {
        $where = (!empty($filter["registered"]['from']) ? "date_registered >= '" . mysql_real_escape_string(static::validData($filter["registered"]["from"])) . "'" : "") .
          (!empty($filter["registered"]['to']) ? " AND date_registered <= '" . mysql_real_escape_string(static::validData($filter["registered"]["to"])) . "'" : "");
        if(strlen(trim($where)) > 0) $result[] = "(" . $where . ")";
      }
      if(isset($filter["country"])) $result[] = "bill_country = '" . mysql_real_escape_string(static::validData($filter["country"])) . "'";
      if(isset($filter["province"])) $result[] = "bill_province = '" . mysql_real_escape_string(static::validData($filter["province"])) . "'";
      if(!empty($result) && (count($result) > 0)) {
        $result = implode(" AND ", $result);
        if(strlen(trim($result)) > 0) {
          $result = " WHERE " . $result;
          $filter['active'] = true;
        }
      }
      return $result;
    }

    public static function get_total_count($filter = null) {
      $response = 0;
      $query = "SELECT COUNT(*) FROM " . static::$table;
      $query .= static::build_where($filter);
      if($result = mysql_query($query)) {
        $response = mysql_fetch_row($result)[0];
      }
      return $response;
    }

    public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null) {
      $response = null;
      $query = "SELECT * , CONCAT(bill_firstname, ' ', bill_lastname) as full_name";
      $query .= " FROM " . static::$table;
      $query .= static::build_where($filter);
      $query .= static::build_order($sort);
      if($limit != 0) $query .= " LIMIT $start, $limit";

      if($result = mysql_query($query)) {
        $res_count_rows = mysql_num_rows($result);
        while($row = mysql_fetch_array($result)) {
          $response[] = $row;
        }
      }

      return $response;
    }

    public static function get_by_id($id) {
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
        $strSQL = "select * from " . static::$table . " where aid = '" . $id . "'";
        $result = mysql_query($strSQL);
        if($result) {
          $data = mysql_fetch_assoc($result);
        }
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
        $query = "DELETE FROM " . static::$table . " WHERE aid = $id";
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      }
    }

    public static function save($data) {
      extract($data);

      $email = mysql_real_escape_string($email);
      $bill_firstname = mysql_real_escape_string($bill_firstname);
      $bill_lastname = mysql_real_escape_string($bill_lastname);
      $bill_organization = mysql_real_escape_string($bill_organization);
      $bill_address1 = mysql_real_escape_string($bill_address1);
      $bill_address2 = mysql_real_escape_string($bill_address2);
      $bill_province = mysql_real_escape_string($bill_province);
      $bill_city = mysql_real_escape_string($bill_city);
      $bill_country = mysql_real_escape_string($bill_country);
      $bill_postal = mysql_real_escape_string($bill_postal);
      $bill_phone = mysql_real_escape_string($bill_phone);
      $bill_fax = mysql_real_escape_string($bill_fax);
      $bill_email = mysql_real_escape_string($bill_email);
      $ship_firstname = mysql_real_escape_string($ship_firstname);
      $ship_lastname = mysql_real_escape_string($ship_lastname);
      $ship_organization = mysql_real_escape_string($ship_organization);
      $ship_address1 = mysql_real_escape_string($ship_address1);
      $ship_address2 = mysql_real_escape_string($ship_address2);
      $ship_city = mysql_real_escape_string($ship_city);
      $ship_province = mysql_real_escape_string($ship_province);
      $ship_country = mysql_real_escape_string($ship_country);
      $ship_postal = mysql_real_escape_string($ship_postal);
      $ship_phone = mysql_real_escape_string($ship_phone);
      $ship_fax = mysql_real_escape_string($ship_fax);
      $ship_email = mysql_real_escape_string($ship_email);

      $timestamp = time();
      if(!isset($aid)) {
        $q = "INSERT INTO " . static::$table . " (email , password , bill_firstname , bill_lastname ," .
          " bill_organization , bill_address1 , bill_address2 , bill_province ," .
          " bill_city , bill_country , bill_postal , bill_phone , bill_fax , bill_email , " .
          "ship_firstname , ship_lastname , ship_organization , ship_address1 , ship_address2 , " .
          "ship_city , ship_province , ship_country , ship_postal , " .
          "ship_phone , ship_fax , ship_email , get_newsletter , date_registered , login_counter)" .
          " VALUES ('$email', '$password', '$bill_firstname', '$bill_lastname'," .
          " '$bill_organization', '$bill_address1', '$bill_address2', '$bill_province', " .
          " '$bill_city', '$bill_country', '$bill_postal', '$bill_phone', '$bill_fax', '$bill_email', " .
          " '$ship_firstname', '$ship_lastname', '$ship_organization', '$ship_address1', '$ship_address2', " .
          " '$ship_city', '$ship_province', '$ship_country', '$ship_postal', " .
          " '$ship_phone', '$ship_fax', '$ship_email', '1', '$timestamp', '0')";
      } else {
        $q = "UPDATE " . static::$table . " SET " .
          " email = '" . $email .
          "',bill_firstname =  '" . $bill_firstname .
          "',bill_lastname =  '" . $bill_lastname .
          "',bill_organization =  '" . $bill_organization .
          "',bill_address1 =  '" . $bill_address1 .
          "',bill_address2 =  '" . $bill_address2 .
          "',bill_province =  '" . $bill_province .
          "',bill_city =  '" . $bill_city .
          "',bill_country =  '" . $bill_country .
          "',bill_postal =  '" . $bill_postal .
          "',bill_phone =  '" . $bill_phone .
          "',bill_fax =  '" . $bill_fax .
          "',bill_email =  '" . $bill_email .
          "',ship_firstname =  '" . $ship_firstname .
          "',ship_lastname =  '" . $ship_lastname .
          "',ship_organization =  '" . $ship_organization .
          "',ship_address1 =  '" . $ship_address1 .
          "',ship_address2 =  '" . $ship_address2 .
          "',ship_city =  '" . $ship_city .
          "',ship_province =  '" . $ship_province .
          "',ship_country =  '" . $ship_country .
          "',ship_postal =  '" . $ship_postal .
          "',ship_phone =  '" . $ship_phone .
          "',ship_fax =  '" . $ship_fax .
          "',ship_email =  '" . $ship_email;
        if(isset($password) && (strlen($password) > 0)) {
          $q .= "',password =  '" . $password;
        }
        $q .= "' WHERE  aid = $aid;";
      }
      $result = mysql_query($q);
      if(!$result) throw new Exception(mysql_error());
      if(!isset($aid)) {
        $aid = mysql_insert_id();
      }
      return $aid;
    }

  }