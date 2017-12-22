<?php

namespace models;

use app\core\App;
use app\core\model\ModelBase;
use Exception;

/**
 * Class ModelDiscount
 * @package models
 */
class ModelDiscount extends ModelBase{

  /**
   * @var string
   */
  protected static $table = 'shop_specials';

  /**
   * @param $filter
   * @param null $prms
   * @return array|string
   */
  public static function build_where(&$filter, &$prms = null){
    $result = "";
    if(isset($filter["scenario"]) && ($filter["scenario"] == 'orders')) {
      if(isset($filter['hidden']["c.sid"])) $result[] = "c.sid = '" . static::prepare_for_sql($filter['hidden']["c.sid"]) . "'";
      if(!empty($result) && (count($result) > 0)) {
        $result = implode(" AND ", $result);
        $result = (!empty($result) ? " WHERE " . $result : '');
      }
    } else {
      if(isset($filter["sid"])) $result[] = "sid = '" . static::prepare_for_sql($filter["sid"]) . "'";
      if(isset($filter["promotion_type"])) $result[] = "promotion_type = '" . static::prepare_for_sql($filter["promotion_type"]) . "'";
      if(isset($filter["user_type"])) $result[] = "user_type = '" . static::prepare_for_sql($filter["user_type"]) . "'";
      if(isset($filter["discount_type"])) $result[] = "discount_type = '" . static::prepare_for_sql($filter["discount_type"]) . "'";
      if(isset($filter["product_type"])) $result[] = "product_type = '" . static::prepare_for_sql($filter["product_type"]) . "'";
      if(isset($filter["coupon_code"])) $result[] = "coupon_code LIKE '%" . implode('%', array_filter(explode(' ', static::prepare_for_sql($filter["coupon_code"])))) . "%'";
      if(isset($filter["date_start"])) $result[] = (!empty($filter["date_start"]) ? "date_start >= '" . strtotime(static::prepare_for_sql($filter['date_start'])) . "'" : "");
      if(isset($filter["date_end"])) $result[] = (!empty($filter["date_end"]) ? "date_end <= '" . strtotime(static::prepare_for_sql($filter['date_end'])) . "'" : "");
      if(!empty($result) && (count($result) > 0)) {
        $result = implode(" AND ", $result);
        if(strlen(trim($result)) > 0) {
          $result = " WHERE " . $result;
          $filter['active'] = true;
        }
      }
    }

    return $result;
  }

  /**
   * @param $sid
   * @return string
   * @throws \Exception
   */
  public static function generateCouponCode($sid){
    $sCde = "";
    $possible = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    for($i = 0; $i < 10; $i++) {
      $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
      $sCde .= $char;
    }
    while(self::checkCouponCode($sid, $sCde)) {
      $sCde = self::generateCouponCode($sid);
    }

    return $sCde;
  }

  /**
   * @param $sid
   * @param $cde
   * @return bool
   * @throws \Exception
   */
  public static function checkCouponCode($sid, $cde){
    if(!isset($sid)) $sid = 0;
    $iCnt = 0;
    $sSQL = sprintf("SELECT sid FROM " . static::$table . " WHERE coupon_code='%s';", $cde);
    $result = static::query($sSQL) or die(static::error());
    $iCnt = static::num_rows($result);
    if($iCnt == 1) { #verify that it is not this record with the same coupon code
      $rs = static::fetch_value($result);
      if($sid == $rs) {
        $iCnt = 0;
      }
    }
    static::free_result($result);

    if($iCnt > 0) return true;

    return false;
  }

  /**
   * @param $id
   * @return array|null
   * @throws \Exception
   */
  public static function get_by_id($id){
    $prms = [];
    $data = [
      'sid' => $id, 'discount_comment1' => '', 'discount_comment2' => '', 'discount_comment3' => '',
      'discount_amount' => '0.00', 'coupon_code' => '', 'allow_multiple' => 0,
      'date_start' => mktime(0, 0, 0, date('m'), date('d'), date('y')),
      'date_end' => mktime(0, 0, 0, date('m'), date('d') + 1, date('y')), 'enabled' => 1, 'filter_products' => null,
      'filter_type' => null, 'users' => null, 'countdown' => '', 'product_type' => 1, 'user_type' => 1,
      'required_amount' => '0.00', 'promotion_type' => 0, 'discount_type' => 1, 'required_type' => 0,
      'discount_amount_type' => 0
    ];
    if(isset($id)) {
      $q = "SELECT * FROM " . static::$table . " WHERE sid = '" . $id . "'";
      $result = static::query($q, $prms);
      if($result) {
        $data = static::fetch_assoc($result);
      }
    }

    return $data;
  }

  /**
   * @param null $filter
   * @return int
   * @throws \Exception
   */
  public static function get_total_count($filter = null){
    $res = 0;
    $prms = [];
    if(isset($filter['scenario']) && ($filter['scenario'] == 'orders')) {
      $q = "SELECT COUNT(DISTINCT a.oid)";
      $q .= " from shop_orders a";
      $q .= " left join accounts b on a.aid = b.aid";
      $q .= " left join shop_specials_usage c on a.oid = c.oid";
    } else $q = "SELECT COUNT(sid) FROM " . static::$table;
    $q .= self::build_where($filter);
    $result = static::query($q, $prms);
    if($result) {
      $row = static::fetch_array($result);
      $res = $row[0];
    }

    return $res;
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
    $res = null;
    $prms = [];
    if(isset($filter['scenario']) && ($filter['scenario'] == 'orders')) {
      $q = "select";
      $q .= " DISTINCT a.*, CONCAT(b.bill_firstname,' ',b.bill_lastname) as username";
      $q .= " from shop_orders a";
      $q .= " left join accounts b on a.aid = b.aid";
      $q .= " left join shop_specials_usage c on a.oid = c.oid";
    } else $q = "SELECT * FROM " . static::$table;
    $q .= self::build_where($filter);
    $q .= static::build_order($sort);
    if($limit != 0) $q .= " LIMIT $start, $limit";
    $result = static::query($q, $prms);
    if($result) {
      $res_count_rows = static::num_rows($result);
      while($row = static::fetch_assoc($result)) {
        $res[] = $row;
      }
    }

    return $res;
  }

  /**
   * @param $data
   * @return mixed
   * @throws \Exception
   */
  public static function save(&$data){
    static::transaction();
    $prms = [];
    try {
      extract($data);
      if(isset($sid)) {
        $q = "UPDATE " . static::$table . " SET" . " coupon_code='$coupon_code'," . " discount_amount='$discount_amount'," . " discount_amount_type='$discount_amount_type'," . " discount_type='$discount_type'," . " user_type='$user_type'," . " shipping_type='$shipping_type'," . " product_type='$product_type'," . " promotion_type='$promotion_type'," . " required_amount='$required_amount'," . " required_type='$required_type'," . " allow_multiple='$allow_multiple'," . " enabled='$enabled'," . " countdown='$countdown'," . " discount_comment1='$discount_comment1'," . " discount_comment2='$discount_comment2'," . " discount_comment3='$discount_comment3'," . " date_start='$date_start'," . " date_end='$date_end'" . " WHERE sid ='$sid'";
        $res = static::query($q, $prms);
      } else {
        $q = "INSERT INTO " . static::$table . " SET" . " coupon_code='$coupon_code'," . " discount_amount='$discount_amount'," . " discount_amount_type='$discount_amount_type'," . " discount_type='$discount_type'," . " user_type='$user_type'," . " shipping_type='$shipping_type'," . " product_type='$product_type'," . " promotion_type='$promotion_type'," . " required_amount='$required_amount'," . " required_type='$required_type'," . " allow_multiple='$allow_multiple'," . " enabled='$enabled'," . " countdown='$countdown'," . " discount_comment1='$discount_comment1'," . " discount_comment2='$discount_comment2'," . " discount_comment3='$discount_comment3'," . " date_start='$date_start'," . " date_end='$date_end'";

        $res = static::query($q, $prms);
        if($res) $sid = static::last_id();
      }
      if($res) {
        $res = static::query("DELETE FROM shop_specials_users WHERE sid ='$sid'");
        if($res && ($user_type == 4)) {
          foreach($users as $aid) {
            $res = static::query("INSERT INTO  shop_specials_users (sid ,aid)VALUES('$sid',  '$aid')");
            if(!$res) break;
          }
        }
      }
      if($res) {
        $res = static::query("DELETE FROM shop_specials_products WHERE sid='$sid'");
        if($res && isset($product_type) && ($product_type > 1)) {
          foreach($filter_products as $pid) {
            $res = static::query("INSERT INTO  shop_specials_products (sid ,pid, stype) VALUES ('$sid',  '$pid', '$product_type')");
            if(!$res) break;
          }
        }
      }
      if(!$res) throw new Exception(static::error());
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }

    return $sid;
  }

  /**
   * @param $type
   * @param $data
   * @throws \Exception
   */
  public static function get_filter_selected($type, &$data){
    $id = isset($data['sid']) ? $data['sid'] : null;
    if($type == 'users') {
      $users = [];
      $user_type = $data['user_type'];
      if(isset($data['users']) || isset($data['users_select'])) $select = implode(',', array_merge(isset($data['users']) ? $data['users'] : [], isset($data['users_select']) ? $data['users_select'] : [])); else {
        $data['users_select'] = self::get_filter_selected_data($type, $id);
        $select = implode(',', isset($data['users_select']) ? array_keys($data['users_select']) : []);
      }
      if($user_type == '4') {
        if(strlen($select > 1)) {
          $results = static::query("select * from accounts" . " where aid in($select)" . " order by email, bill_firstname, bill_lastname");
          while($row = static::fetch_array($results)) {
            $users[$row[0]] = $row[1] . '-' . $row[3] . ' ' . $row[4];
          }
        }
      }
      $data['users'] = $users;
    } elseif($type == 'filter_products') {
      $product_type = $data['product_type'];
      $filter_type = null;
      $filter_products = [];
      switch($product_type) {
        case 2:
          $filter_type = 'prod';
          if(isset($data['prod_select']) || isset($data['filter_products'])) $select = implode(',', array_merge(isset($data['prod_select']) ? $data['prod_select'] : [], isset($data['filter_products']) ? $data['filter_products'] : [])); else {
            $data['prod_select'] = self::get_filter_selected_data($filter_type, $id);
            $select = implode(',', isset($data['prod_select']) ? array_keys($data['prod_select']) : []);
          }
          if(strlen($select) > 0) {
            $results = static::query("select * from shop_products" . " where pid in ($select)" . " order by pnumber, pname");
            while($row = static::fetch_array($results)) {
              $filter_products[$row[0]] = $row[2] . '-' . $row[1];
            }
          }
          break;
        case 4:
          $filter_type = 'mnf';
          if(isset($data['mnf_select']) || isset($data['filter_products'])) $select = implode(',', array_merge(isset($data['mnf_select']) ? $data['mnf_select'] : [], isset($data['filter_products']) ? $data['filter_products'] : [])); else {
            $data['mnf_select'] = self::get_filter_selected_data($filter_type, $id);
            $select = implode(',', isset($data['mnf_select']) ? array_keys($data['mnf_select']) : []);
          }
          if(strlen($select) > 0) {
            $results = static::query("select * from shop_manufacturers" . " where id in ($select)" . " order by manufacturer");
            while($row = static::fetch_array($results)) {
              $filter_products[$row[0]] = $row[1];
            }
          }
          break;
        case 3:
          $filter_type = 'cat';
          if(isset($data['cat_select']) || isset($data['filter_products'])) $select = implode(',', array_merge(isset($data['cat_select']) ? $data['cat_select'] : [], isset($data['filter_products']) ? $data['filter_products'] : [])); else {
            $data['cat_select'] = self::get_filter_selected_data($filter_type, $id);
            $select = implode(',', isset($data['cat_select']) ? array_keys($data['cat_select']) : []);
          }
          if(strlen($select) > 0) {
            $results = static::query("select * from shop_categories " . " where cid in ($select)" . " order by cname");
            while($row = static::fetch_array($results)) {
              $filter_products[$row[0]] = $row[1];
            }
          }
          break;
      }
      $data['filter_products'] = $filter_products;
      $data['filter_type'] = $filter_type;
    }
  }

  /**
   * @param $type
   * @param $id
   * @return array
   * @throws \Exception
   */
  public static function get_filter_selected_data($type, $id){
    $data = [];
    switch($type) {
      case 'users':
        $results = static::query("select a.* from shop_specials_users b" . " inner join accounts a on b.aid=a.aid " . " where sid='$id'" . " order by a.email, a.bill_firstname, a.bill_lastname");
        if($results) while($row = static::fetch_array($results)) {
          $data[$row[0]] = $row[1] . '-' . $row[3] . ' ' . $row[4];
        }
        break;
      case 'prod':
        $results = static::query("select a.* from shop_specials_products b" . " inner join shop_products a on b.pid=a.pid " . " where b.sid='$id' and b.stype = 2" . " order by a.pnumber, a.pname");
        if($results) while($row = static::fetch_array($results)) {
          $data[$row[0]] = $row[2] . '-' . $row[1];
        }
        break;
      case 'mnf':
        $results = static::query("select a.* from shop_specials_products b" . " inner join shop_manufacturers a on b.pid=a.id " . " where b.sid='$id' and b.stype = 4" . " order by a.manufacturer");
        if($results) while($row = static::fetch_array($results)) {
          $data[$row[0]] = $row[1];
        }
        break;
      case 'cat':
        $results = static::query("select a.* from shop_specials_products b" . " inner join shop_categories a on b.pid=a.cid " . " where b.sid='$id' and b.stype = 3" . " order by a.cname");
        if($results) while($row = static::fetch_array($results)) {
          $data[$row[0]] = $row[1];
        }
        break;
    }

    return $data;
  }

  /**
   * @param $type
   * @param $count
   * @param int $start
   * @param null $search
   * @return array|null
   * @throws \Exception
   */
  public static function get_filter_data($type, &$count, $start = 0, $search = null){
    $filter = null;
    $filter_limit = (!is_null(App::$app->keyStorage()->system_filter_amount) ? App::$app->keyStorage()->system_filter_amount : FILTER_LIMIT);
    $start = isset($start) ? $start : 0;
    $search = self::sanitize($search);
    switch($type) {
      case 'users':
        $q = "SELECT count(aid) FROM accounts";
        if(isset($search) && (strlen($search) > 0)) {
          $q .= " where bill_firstname like '%$search%'";
          $q .= " or bill_lastname like '%$search%'";
          $q .= " or email like '%$search%'";
        }
        $results = static::query($q);
        $row = static::fetch_array($results);
        $count = $row[0];
        $q = "SELECT * FROM accounts";
        if(isset($search) && (strlen($search) > 0)) {
          $q .= " where bill_firstname like '%$search%'";
          $q .= " or bill_lastname like '%$search%'";
          $q .= " or email like '%$search%'";
        }
        $q .= " order by email, bill_firstname, bill_lastname";
        $q .= " limit $start, $filter_limit";
        $results = static::query($q);
        while($row = static::fetch_array($results)) {
          $filter[] = [$row[0], $row[1] . ' - ' . $row[3] . ' ' . $row[4]];
        }
        break;
      case 'prod':
        $q = "SELECT count(pid) FROM shop_products";
        if(isset($search) && (strlen($search) > 0)) {
          $q .= " where pnumber like '%$search%'";
          $q .= " or pname like '%$search%'";
        }
        $results = static::query($q);
        $row = static::fetch_array($results);
        $count = $row[0];
        $q = "SELECT * FROM shop_products";
        if(isset($search) && (strlen($search) > 0)) {
          $q .= " where pnumber like '%$search%'";
          $q .= " or pname like '%$search%'";
        }
        $q .= " order by pnumber, pname";
        $q .= " limit $start, $filter_limit";
        $results = static::query($q);
        while($row = static::fetch_array($results)) {
          $filter[] = [$row[0], $row[2] . ' - ' . $row[1]];
        }
        break;
      case 'mnf':
        $q = "SELECT count(id) FROM shop_manufacturers";
        if(isset($search) && (strlen($search) > 0)) {
          $q .= " where manufacturer like '%$search%'";
        }
        $results = static::query($q);
        $row = static::fetch_array($results);
        $count = $row[0];
        $q = "SELECT * FROM shop_manufacturers";
        if(isset($search) && (strlen($search) > 0)) {
          $q .= " where manufacturer like '%$search%'";
        }
        $q .= " order by manufacturer";
        $q .= " limit $start, $filter_limit";
        $results = static::query($q, $prms);
        while($row = static::fetch_array($results)) {
          $filter[] = [$row[0], $row[1]];
        }
        break;
      case 'cat':
        $q = "SELECT count(cid) FROM shop_categories";
        if(isset($search) && (strlen($search) > 0)) {
          $q .= " where cname like '%$search%'";
        }
        $results = static::query($q);
        $row = static::fetch_array($results);
        $count = $row[0];
        $q = "SELECT * FROM shop_categories";
        if(isset($search) && (strlen($search) > 0)) {
          $q .= " where cname like '%$search%'";
        }
        $q .= " order by cname";
        $q .= " limit $start, $filter_limit";
        $results = static::query($q);
        while($row = static::fetch_array($results)) {
          $filter[] = [$row[0], $row[1]];
        }
    }

    return $filter;
  }

  /**
   * @param $id
   * @throws \Exception
   */
  public static function delete($id){
    static::transaction();
    try {
      static::query("DELETE FROM shop_specials_products WHERE sid='$id'");
      static::query("DELETE FROM shop_specials_users WHERE sid='$id'");
      static::query("DELETE FROM shop_specials_usage WHERE sid='$id'");
      static::query("DELETE FROM " . static::$table . " WHERE sid = '$id'");
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }
  }
}