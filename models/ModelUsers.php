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
  public static function BuildWhere(&$filter, &$prms = null){
    $return = "";
    if(isset($filter["email"])) $result[] = "email LIKE '%" . implode('%', array_filter(explode(' ', static::PrepareForSql($filter["email"])))) . "%'";
    if(!empty($filter["full_name"]))
      foreach(array_filter(explode(' ', $filter["full_name"])) as $item)
        if(!empty($item)) $result[] = "CONCAT(bill_firstname, ' ', bill_lastname) LIKE '%" . static::PrepareForSql($item) . "%'";
    if(!empty($filter["organization"]))
      foreach(array_filter(explode(' ', $filter["organization"])) as $item)
        if(!empty($item)) $result[] = "bill_organization LIKE '%" . static::PrepareForSql($item) . "%'";
    if(isset($filter["postal"])) $result[] = "bill_postal LIKE '%" . implode('%', array_filter(explode(' ', static::PrepareForSql($filter["postal"])))) . "%'";
    if(isset($filter["phone"])) $result[] = "bill_phone LIKE '%" . implode('%', array_filter(explode(' ', static::PrepareForSql($filter["phone"])))) . "%'";
    if(isset($filter["city"])) $result[] = "bill_city LIKE '%" . implode('%', array_filter(explode(' ', static::PrepareForSql($filter["city"])))) . "%'";
    if(isset($filter["address"]))
      $result[] = "(bill_address1 LIKE '%" . static::PrepareForSql($filter["address"]) . "%'" .
        "OR bill_address2 LIKE '%" . static::PrepareForSql($filter["address"]) . "%')";
    if(isset($filter["registered"])) {
      $where = (!empty($filter["registered"]['from']) ? "date_registered >= STR_TO_DATE('" . static::PrepareForSql($filter["registered"]["from"]) . "', '%m/%d/%Y')" : "") .
        (!empty($filter["registered"]['to']) ? " AND date_registered <= STR_TO_DATE('" . static::PrepareForSql($filter["registered"]["to"]) . "', '%m/%d/%Y')" : "");
      if(strlen(trim($where)) > 0) $result[] = "(" . $where . ")";
    }
    if(isset($filter["country"])) $result[] = "bill_country = '" . static::PrepareForSql($filter["country"]) . "'";
    if(isset($filter["province"])) $result[] = "bill_province = '" . static::PrepareForSql($filter["province"]) . "'";
    if(!empty($result) && (count($result) > 0)) {
      $return = implode(" AND ", $result);
      if(strlen(trim($return)) > 0) {
        $return = " WHERE " . $return;
        $filter['active'] = true;
      }
    }

    return $return;
  }

  /**
   * @param null $filter
   * @return int|null
   * @throws \Exception
   */
  public static function get_total_count($filter = null){
    $response = 0;
    $query = "SELECT COUNT(*) FROM " . static::$table;
    $query .= static::BuildWhere($filter, $prms);
    if($result = static::Query($query, $prms)) {
      $response = static::FetchValue($result);
      static::FreeResult($result);
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
    $response = [];
    $query = "SELECT * , CONCAT(bill_firstname, ' ', bill_lastname) as full_name";
    $query .= " FROM " . static::$table;
    $query .= static::BuildWhere($filter, $prms);
    $query .= static::BuildOrder($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";

    if($result = static::Query($query, $prms)) {
      $res_count_rows = static::getNumRows($result);
      while($row = static::FetchArray($result)) {
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
      $result = static::Query($strSQL, ['id' => $id]);
      if($result) {
        $data = static::FetchAssoc($result);
      }
    }

    if ($data === false){
      throw new Exception('Data set is empty!');
    }

    return $data;
  }

  /**
   * @param $id
   * @throws \Exception
   */
  public static function Delete($id){
    static::BeginTransaction();
    try {
      if(isset($id)) {
        $query = "SELECT count(*) FROM shop_specials_users WHERE aid = :id";
        $res = static::Query($query, ['id' => $id]);
        if($res) {
          $amount = static::FetchValue($res);
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
//        $query = "DELETE FROM shop_specials_users WHERE aid = :id";
//        $res = static::Query($query, ['id' => $id]);
//        if(!$res) throw new Exception(static::Error());
        $query = "DELETE FROM " . static::$table . " WHERE aid = :id";
        $res = static::Query($query, ['id' => $id]);
        if(!$res) throw new Exception(static::Error());
      }
      static::Commit();
    } catch(Exception $e) {
      static::RollBack();
      throw $e;
    }
  }

  /**
   * @param $data
   * @return mixed
   * @throws \Exception
   */
  public static function Save(&$data){
    static::BeginTransaction();
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
      $result = static::Query($q, $prms);
      if(!$result) throw new Exception(static::Error());
      if(!isset($aid)) {
        $aid = static::LastId();
      }
      static::Commit();
    } catch(Exception $e) {
      static::RollBack();
      throw $e;
    }

    return $aid;
  }

}