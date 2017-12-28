<?php

namespace models;

use app\core\model\ModelBase;
use Exception;

/**
 * Class ModelUsers
 * @package models
 */
class ModelUsers extends ModelBase{

  protected static $table = 'accounts';

  /**
   * @param $filter
   * @param null $prms
   * @return array|string
   */
  public static function build_where(&$filter, &$prms = null){
    $result = "";
    if(isset($filter["email"])) $result[] = "email LIKE '%" . implode('%', array_filter(explode(' ', static::prepare_for_sql($filter["email"])))) . "%'";
    if(!empty($filter["full_name"]))
      foreach(array_filter(explode(' ', $filter["full_name"])) as $item)
        if(!empty($item)) $result[] = "CONCAT(bill_firstname, ' ', bill_lastname) LIKE '%" . static::prepare_for_sql($item) . "%'";
    if(!empty($filter["organization"]))
      foreach(array_filter(explode(' ', $filter["organization"])) as $item)
        if(!empty($item)) $result[] = "bill_organization LIKE '%" . static::prepare_for_sql($item) . "%'";
    if(isset($filter["postal"])) $result[] = "bill_postal LIKE '%" . implode('%', array_filter(explode(' ', static::prepare_for_sql($filter["postal"])))) . "%'";
    if(isset($filter["phone"])) $result[] = "bill_phone LIKE '%" . implode('%', array_filter(explode(' ', static::prepare_for_sql($filter["phone"])))) . "%'";
    if(isset($filter["city"])) $result[] = "bill_city LIKE '%" . implode('%', array_filter(explode(' ', static::prepare_for_sql($filter["city"])))) . "%'";
    if(isset($filter["address"]))
      $result[] = "(bill_address1 LIKE '%" . static::prepare_for_sql($filter["address"]) . "%'" .
        "OR bill_address2 LIKE '%" . static::prepare_for_sql($filter["address"]) . "%')";
    if(isset($filter["registered"])) {
      $where = (!empty($filter["registered"]['from']) ? "date_registered >= STR_TO_DATE('" . static::prepare_for_sql($filter["registered"]["from"]) . "', '%m/%d/%Y')" : "") .
        (!empty($filter["registered"]['to']) ? " AND date_registered <= STR_TO_DATE('" . static::prepare_for_sql($filter["registered"]["to"]) . "', '%m/%d/%Y')" : "");
      if(strlen(trim($where)) > 0) $result[] = "(" . $where . ")";
    }
    if(isset($filter["country"])) $result[] = "bill_country = '" . static::prepare_for_sql($filter["country"]) . "'";
    if(isset($filter["province"])) $result[] = "bill_province = '" . static::prepare_for_sql($filter["province"]) . "'";
    if(!empty($result) && (count($result) > 0)) {
      $result = implode(" AND ", $result);
      if(strlen(trim($result)) > 0) {
        $result = " WHERE " . $result;
        $filter['active'] = true;
      }
    }

    return $result;
  }

  /**
   * @param null $filter
   * @return int|null
   * @throws \Exception
   */
  public static function get_total_count($filter = null){
    $response = 0;
    $query = "SELECT COUNT(*) FROM " . static::$table;
    $query .= static::build_where($filter, $prms);
    if($result = static::query($query, $prms)) {
      $response = static::fetch_value($result);
      static::free_result($result);
    }

    return $response;
  }

  /**
   * @param $start
   * @param $limit
   * @param $res_count_rows
   * @param null $filter
   * @param null $sort
   * @return array|null
   * @throws \Exception
   */
  public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null){
    $response = null;
    $query = "SELECT * , CONCAT(bill_firstname, ' ', bill_lastname) as full_name";
    $query .= " FROM " . static::$table;
    $query .= static::build_where($filter, $prms);
    $query .= static::build_order($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";

    if($result = static::query($query, $prms)) {
      $res_count_rows = static::num_rows($result);
      while($row = static::fetch_array($result)) {
        $response[] = $row;
      }
    }

    return $response;
  }

  /**
   * @param $id
   * @return array|null
   * @throws \Exception
   */
  public static function get_by_id($id){
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
      $strSQL = "SELECT * FROM " . static::$table . " WHERE aid = :id";
      $result = static::query($strSQL, ['id' => $id]);
      if($result) {
        $data = static::fetch_assoc($result);
      }
    }

    return $data;
  }

  /**
   * @param $id
   * @throws \Exception
   */
  public static function delete($id){
    static::transaction();
    try {
      if(isset($id)) {
        $query = "SELECT count(*) FROM shop_specials_users WHERE aid = :id";
        $res = static::query($query, ['id' => $id]);
        if($res) {
          $amount = static::fetch_value($res);
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
//        $query = "DELETE FROM shop_specials_users WHERE aid = :id";
//        $res = static::query($query, ['id' => $id]);
//        if(!$res) throw new Exception(static::error());
        $query = "DELETE FROM " . static::$table . " WHERE aid = :id";
        $res = static::query($query, ['id' => $id]);
        if(!$res) throw new Exception(static::error());
      }
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }
  }

  /**
   * @param $data
   * @return mixed
   * @throws \Exception
   */
  public static function save(&$data){
    static::transaction();
    try {
      extract($data);
      /**
       * @var string $email
       * @var string $password
       * @var string $bill_firstname
       * @var string $bill_lastname
       * @var string $bill_organization
       * @var string $bill_address1
       * @var string $bill_address2
       * @var string $bill_province
       * @var string $bill_city
       * @var string $bill_country
       * @var string $bill_postal
       * @var string $bill_phone
       * @var string $bill_fax
       * @var string $bill_email
       * @var string $ship_firstname
       * @var string $ship_lastname
       * @var string $ship_organization
       * @var string $ship_address1
       * @var string $ship_address2
       * @var string $ship_city
       * @var string $ship_province
       * @var string $ship_country
       * @var string $ship_postal
       * @var string $ship_phone
       * @var string $ship_fax
       * @var string $ship_email
       */
      if(isset($data['scenario']) && ($data['scenario'] !== 'short')) {
        $prms = [
          'email' => $email,
          'bill_firstname' => $bill_firstname,
          'bill_lastname' => $bill_lastname,
          'bill_organization' => $bill_organization,
          'bill_address1' => $bill_address1,
          'bill_address2' => $bill_address2,
          'bill_province' => $bill_province,
          'bill_city' => $bill_city,
          'bill_country' => $bill_country,
          'bill_postal' => $bill_postal,
          'bill_phone' => $bill_phone,
          'bill_fax' => $bill_fax,
          'bill_email' => $bill_email,
          'ship_firstname' => $ship_firstname,
          'ship_lastname' => $ship_lastname,
          'ship_organization' => $ship_organization,
          'ship_address1' => $ship_address1,
          'ship_address2' => $ship_address2,
          'ship_city' => $ship_city,
          'ship_province' => $ship_province,
          'ship_country' => $ship_country,
          'ship_postal' => $ship_postal,
          'ship_phone' => $ship_phone,
          'ship_fax' => $ship_fax,
          'ship_email' => $ship_email
        ];
        if(isset($password) && (strlen($password) > 0)) {
          $prms['password'] = $password;
        }
        if(!isset($aid)) {
          $q = "INSERT INTO " . static::$table . " (email, password, bill_firstname, bill_lastname," .
            " bill_organization, bill_address1, bill_address2, bill_province," .
            " bill_city, bill_country, bill_postal, bill_phone, bill_fax, bill_email," .
            " ship_firstname, ship_lastname, ship_organization, ship_address1, ship_address2," .
            " ship_city, ship_province, ship_country, ship_postal," .
            " ship_phone, ship_fax, ship_email, get_newsletter, login_counter)" .
            " VALUES (:email, :password, :bill_firstname, :bill_lastname," .
            " :bill_organization, :bill_address1, :bill_address2, :bill_province, " .
            " :bill_city, :bill_country, :bill_postal, :bill_phone, :bill_fax, :bill_email, " .
            " :ship_firstname, :ship_lastname, :ship_organization, :ship_address1, :ship_address2, " .
            " :ship_city, :ship_province, :ship_country, :ship_postal, " .
            " :ship_phone, :ship_fax, :ship_email, 1, 0)";
        } else {
          $q = "UPDATE " . static::$table . " SET " .
            " email = :email" .
            ", bill_firstname = :bill_firstname" .
            ", bill_lastname = :bill_lastname" .
            ", bill_organization = :bill_organization" .
            ", bill_address1 = :bill_address1" .
            ", bill_address2 = :bill_address2" .
            ", bill_province = :bill_province" .
            ", bill_city = :bill_city" .
            ", bill_country = :bill_country" .
            ", bill_postal = :bill_postal" .
            ", bill_phone = :bill_phone" .
            ", bill_fax = :bill_fax" .
            ", bill_email = :bill_email" .
            ", ship_firstname = :ship_firstname" .
            ", ship_lastname = :ship_lastname" .
            ", ship_organization = :ship_organization" .
            ", ship_address1 = :ship_address1" .
            ", ship_address2 = :ship_address2" .
            ", ship_city = :ship_city" .
            ", ship_province = :ship_province" .
            ", ship_country = :ship_country" .
            ", ship_postal = :ship_postal" .
            ", ship_phone = :ship_phone" .
            ", ship_fax = :ship_fax" .
            ", ship_email = :ship_email";
          if(isset($password) && (strlen($password) > 0)) {
            $q .= ", password = :password";
          }
          $q .= " WHERE aid = :aid;";
          $prms['aid'] = $aid;
        }
      } else {
        if(!isset($aid)) {
          $q = "INSERT INTO " . static::$table . " (email , password , bill_firstname , bill_lastname)" .
            " VALUES (:email, :password, :bill_firstname, :bill_lastname)";
          $prms = [
            'email' => $email,
            'bill_firstname' => $bill_firstname,
            'bill_lastname' => $bill_lastname,
            'password' => $password
          ];
        } else {
          $q = "UPDATE " . static::$table . " SET " .
            " email = :email" .
            ", bill_firstname = :bill_firstname" .
            ", bill_lastname =  :bill_lastname";
          $prms = ['email' => $email, 'bill_firstname' => $bill_firstname, 'bill_lastname' => $bill_lastname];
          if(isset($password) && (strlen($password) > 0)) {
            $q .= ", password = :password";
            $prms['password'] = $password;
          }
          $q .= " WHERE aid = :aid";
          $prms['aid'] = $aid;
        }
      }
      $result = static::query($q, $prms);
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