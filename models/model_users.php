<?php

  Class Model_Users extends Model_Base {

    protected static $table = 'fabrix_accounts';

    protected static function build_where(&$filter) {
      $result = "";
      if(isset($filter["email"])) $result[] = "email LIKE '%" . implode('%',array_filter(explode(' ',mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["email"])))))) . "%'";
      if (!empty($filter["full_name"]))
        foreach (array_filter(explode(' ', $filter["full_name"])) as $item)
          if (!empty($item)) $result[] = "CONCAT(bill_firstname, ' ', bill_lastname) LIKE '%" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($item))) . "%'";
      if (!empty($filter["organization"]))
        foreach (array_filter(explode(' ', $filter["organization"])) as $item)
          if (!empty($item)) $result[] = "bill_organization LIKE '%" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($item))) . "%'";
      if(isset($filter["postal"])) $result[] = "bill_postal LIKE '%" . implode('%',array_filter(explode(' ',mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["postal"])))))) . "%'";
      if(isset($filter["phone"])) $result[] = "bill_phone LIKE '%" . implode('%',array_filter(explode(' ',mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["phone"])))))) . "%'";
      if(isset($filter["city"])) $result[] = "bill_city LIKE '%" . implode('%',array_filter(explode(' ',mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["city"])))))) . "%'";
      if(isset($filter["address"]))
        $result[] = "(bill_address1 LIKE '%" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["address"]))) . "%'" .
          "OR bill_address2 LIKE '%" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["address"]))) . "%')";
      if(isset($filter["registered"])) {
        $where = (!empty($filter["registered"]['from']) ? "date_registered >= STR_TO_DATE('" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["registered"]["from"]))) . "', '%m/%d/%Y')" : "") .
          (!empty($filter["registered"]['to']) ? " AND date_registered <= STR_TO_DATE('" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["registered"]["to"]))) . "', '%m/%d/%Y')" : "");
        if(strlen(trim($where)) > 0) $result[] = "(" . $where . ")";
      }
      if(isset($filter["country"])) $result[] = "bill_country = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["country"]))) . "'";
      if(isset($filter["province"])) $result[] = "bill_province = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["province"]))) . "'";
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
      if($result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query)) {
        $response = mysqli_fetch_row($result)[0];
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

      if($result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query)) {
        $res_count_rows = mysqli_num_rows($result);
        while($row = mysqli_fetch_array($result)) {
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
        $result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $strSQL);
        if($result) {
          $data = mysqli_fetch_assoc($result);
        }
      }
      return $data;
    }

    public static function delete($id) {
      if(isset($id)) {
        $query = "select count(*) from fabrix_special_users where aid = $id";
        $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query);
        if($res) {
          $amount = mysqli_fetch_array($res)[0];
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
//        $query = "delete from fabrix_special_users WHERE aid = $id";
//        $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query);
//        if(!$res) throw new Exception(mysqli_error(_A_::$app->getDBConnection('iluvfabrix')));
        $query = "DELETE FROM " . static::$table . " WHERE aid = $id";
        $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query);
        if(!$res) throw new Exception(mysqli_error(_A_::$app->getDBConnection('iluvfabrix')));
      }
    }

    public static function save(&$data) {
      extract($data);
      if(isset($data['scenario']) && ($data['scenario'] !== 'short')){
        $email = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $email);
        $bill_firstname = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $bill_firstname);
        $bill_lastname = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $bill_lastname);
        $bill_organization = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $bill_organization);
        $bill_address1 = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $bill_address1);
        $bill_address2 = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $bill_address2);
        $bill_province = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $bill_province);
        $bill_city = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $bill_city);
        $bill_country = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $bill_country);
        $bill_postal = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $bill_postal);
        $bill_phone = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $bill_phone);
        $bill_fax = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $bill_fax);
        $bill_email = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $bill_email);
        $ship_firstname = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $ship_firstname);
        $ship_lastname = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $ship_lastname);
        $ship_organization = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $ship_organization);
        $ship_address1 = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $ship_address1);
        $ship_address2 = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $ship_address2);
        $ship_city = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $ship_city);
        $ship_province = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $ship_province);
        $ship_country = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $ship_country);
        $ship_postal = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $ship_postal);
        $ship_phone = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $ship_phone);
        $ship_fax = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $ship_fax);
        $ship_email = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $ship_email);

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
        $email = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $email);
        $bill_firstname = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $bill_firstname);
        $bill_lastname = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $bill_lastname);

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
      $result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q);
      if(!$result) throw new Exception(mysqli_error(_A_::$app->getDBConnection('iluvfabrix')));
      if(!isset($aid)) {
        $aid = mysqli_insert_id(_A_::$app->getDBConnection('iluvfabrix')) ;
      }
      return $aid;
    }

  }