<?php

  Class Model_Users extends Model_Base {

    protected static $table = 'fabrix_accounts';

    protected static function build_where(&$filter) {
      $result = "";
      if(isset($filter["email"])) $result[] = "email LIKE '%" . implode('%', array_filter(explode(' ', static::escape(static::strip_data(static::sanitize($filter["email"])))))) . "%'";
      if(!empty($filter["full_name"]))
        foreach(array_filter(explode(' ', $filter["full_name"])) as $item)
          if(!empty($item)) $result[] = "CONCAT(bill_firstname, ' ', bill_lastname) LIKE '%" . static::escape(static::strip_data(static::sanitize($item))) . "%'";
      if(!empty($filter["organization"]))
        foreach(array_filter(explode(' ', $filter["organization"])) as $item)
          if(!empty($item)) $result[] = "bill_organization LIKE '%" . static::escape(static::strip_data(static::sanitize($item))) . "%'";
      if(isset($filter["postal"])) $result[] = "bill_postal LIKE '%" . implode('%', array_filter(explode(' ', static::escape(static::strip_data(static::sanitize($filter["postal"])))))) . "%'";
      if(isset($filter["phone"])) $result[] = "bill_phone LIKE '%" . implode('%', array_filter(explode(' ', static::escape(static::strip_data(static::sanitize($filter["phone"])))))) . "%'";
      if(isset($filter["city"])) $result[] = "bill_city LIKE '%" . implode('%', array_filter(explode(' ', static::escape(static::strip_data(static::sanitize($filter["city"])))))) . "%'";
      if(isset($filter["address"]))
        $result[] = "(bill_address1 LIKE '%" . static::escape(static::strip_data(static::sanitize($filter["address"]))) . "%'" .
          "OR bill_address2 LIKE '%" . static::escape(static::strip_data(static::sanitize($filter["address"]))) . "%')";
      if(isset($filter["registered"])) {
        $where = (!empty($filter["registered"]['from']) ? "date_registered >= STR_TO_DATE('" . static::escape(static::strip_data(static::sanitize($filter["registered"]["from"]))) . "', '%m/%d/%Y')" : "") .
          (!empty($filter["registered"]['to']) ? " AND date_registered <= STR_TO_DATE('" . static::escape(static::strip_data(static::sanitize($filter["registered"]["to"]))) . "', '%m/%d/%Y')" : "");
        if(strlen(trim($where)) > 0) $result[] = "(" . $where . ")";
      }
      if(isset($filter["country"])) $result[] = "bill_country = '" . static::escape(static::strip_data(static::sanitize($filter["country"]))) . "'";
      if(isset($filter["province"])) $result[] = "bill_province = '" . static::escape(static::strip_data(static::sanitize($filter["province"]))) . "'";
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
      if($result = static::query($query)) {
        $response = static::fetch_row($result)[0];
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

      if($result = static::query($query)) {
        $res_count_rows = static::num_rows($result);
        while($row = static::fetch_array($result)) {
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
        $result = static::query($strSQL);
        if($result) {
          $data = static::fetch_assoc($result);
        }
      }
      return $data;
    }

    public static function delete($id) {
      static::transaction();
      try {
        if(isset($id)) {
          $query = "select count(*) from fabrix_special_users where aid = $id";
          $res = static::query($query);
          if($res) {
            $amount = static::fetch_array($res)[0];
            if(isset($amount) && ($amount > 0)) {
              throw new Exception('Can not delete. There are dependent data.');
            }
          }
//        $query = "delete from fabrix_special_users WHERE aid = $id";
//        $res = static::query( $query);
//        if(!$res) throw new Exception(static::error());
          $query = "DELETE FROM " . static::$table . " WHERE aid = $id";
          $res = static::query($query);
          if(!$res) throw new Exception(static::error());
        }
        static::commit();
      } catch(Exception $e) {
        static::rollback();
        throw $e;
      }
    }

    public static function save(&$data) {
      static::transaction();
      try {
        extract($data);
        if(isset($data['scenario']) && ($data['scenario'] !== 'short')) {
          $email = static::escape($email);
          $bill_firstname = static::escape($bill_firstname);
          $bill_lastname = static::escape($bill_lastname);
          $bill_organization = static::escape($bill_organization);
          $bill_address1 = static::escape($bill_address1);
          $bill_address2 = static::escape($bill_address2);
          $bill_province = static::escape($bill_province);
          $bill_city = static::escape($bill_city);
          $bill_country = static::escape($bill_country);
          $bill_postal = static::escape($bill_postal);
          $bill_phone = static::escape($bill_phone);
          $bill_fax = static::escape($bill_fax);
          $bill_email = static::escape($bill_email);
          $ship_firstname = static::escape($ship_firstname);
          $ship_lastname = static::escape($ship_lastname);
          $ship_organization = static::escape($ship_organization);
          $ship_address1 = static::escape($ship_address1);
          $ship_address2 = static::escape($ship_address2);
          $ship_city = static::escape($ship_city);
          $ship_province = static::escape($ship_province);
          $ship_country = static::escape($ship_country);
          $ship_postal = static::escape($ship_postal);
          $ship_phone = static::escape($ship_phone);
          $ship_fax = static::escape($ship_fax);
          $ship_email = static::escape($ship_email);

          if(!isset($aid)) {
            $q = "INSERT INTO " . static::$table . " (email , password , bill_firstname , bill_lastname ," .
              " bill_organization , bill_address1 , bill_address2 , bill_province ," .
              " bill_city , bill_country , bill_postal , bill_phone , bill_fax , bill_email , " .
              "ship_firstname , ship_lastname , ship_organization , ship_address1 , ship_address2 , " .
              "ship_city , ship_province , ship_country , ship_postal , " .
              "ship_phone , ship_fax , ship_email , get_newsletter , login_counter)" .
              " VALUES ('$email', '$password', '$bill_firstname', '$bill_lastname'," .
              " '$bill_organization', '$bill_address1', '$bill_address2', '$bill_province', " .
              " '$bill_city', '$bill_country', '$bill_postal', '$bill_phone', '$bill_fax', '$bill_email', " .
              " '$ship_firstname', '$ship_lastname', '$ship_organization', '$ship_address1', '$ship_address2', " .
              " '$ship_city', '$ship_province', '$ship_country', '$ship_postal', " .
              " '$ship_phone', '$ship_fax', '$ship_email', '1', '0')";
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
        } else {
          $email = static::escape($email);
          $bill_firstname = static::escape($bill_firstname);
          $bill_lastname = static::escape($bill_lastname);

          if(!isset($aid)) {
            $q = "INSERT INTO " . static::$table . " (email , password , bill_firstname , bill_lastname)" .
              " VALUES ('$email', '$password', '$bill_firstname', '$bill_lastname')";
          } else {
            $q = "UPDATE " . static::$table . " SET " .
              " email = '" . $email .
              "',bill_firstname =  '" . $bill_firstname .
              "',bill_lastname =  '" . $bill_lastname;
            if(isset($password) && (strlen($password) > 0)) {
              $q .= "',password =  '" . $password;
            }
            $q .= "' WHERE  aid = $aid;";
          }
        }
        $result = static::query($q);
        if(!$result) throw new Exception(static::error());
        if(!isset($aid)) {
          $aid = static::last_id();
        }
        static::commit();
      } catch(Exception $e) {
        static::rollback();
        throw $e;
      }
      return $aid;
    }

  }