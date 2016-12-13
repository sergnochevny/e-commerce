<?php

  Class Model_Discount extends Model_Base {

    protected static $table = 'fabrix_specials';

    protected static function build_where(&$filter) {
      $result = "";
      if(isset($filter["sid"])) $result[] = "sid = '" . mysql_real_escape_string(static::sanitize($filter["sid"])) . "'";
      if(isset($filter["promotion_type"])) $result[] = "promotion_type = '" . mysql_real_escape_string(static::sanitize($filter["promotion_type"])) . "'";
      if(isset($filter["user_type"])) $result[] = "user_type = '" . mysql_real_escape_string(static::sanitize($filter["user_type"])) . "'";
      if(isset($filter["discount_type"])) $result[] = "discount_type = '" . mysql_real_escape_string(static::sanitize($filter["discount_type"])) . "'";
      if(isset($filter["product_type"])) $result[] = "product_type = '" . mysql_real_escape_string(static::sanitize($filter["product_type"])) . "'";
      if(isset($filter["coupon_code"])) $result[] = "coupon_code LIKE '%" . implode('%', array_filter(explode(' ', mysql_real_escape_string(static::sanitize($filter["coupon_code"]))))) . "%'";
      if(isset($filter["date_start"])) $result[] = (!empty($filter["date_start"]) ? "date_start >= '" . strtotime(mysql_real_escape_string(static::sanitize($filter['date_start']))) . "'" : "");
      if(isset($filter["date_end"])) $result[] = (!empty($filter["date_end"]) ? "date_end <= '" . strtotime(mysql_real_escape_string(static::sanitize($filter['date_end']))) . "'" : "");
      if(!empty($result) && (count($result) > 0)) {
        $result = implode(" AND ", $result);
        if(strlen(trim($result)) > 0) {
          $result = " WHERE " . $result;
          $filter['active'] = true;
        }
      }
      return $result;
    }

    public static function generateCouponCode($sid) {
      $sCde = "";
      $possible = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
      for($i = 0; $i < 10; $i++) {
        $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
        $sCde .= $char;
      }
      while(self::checkCouponCode($sid, $sCde)) {
        $sCde = self::generateCouponCode();
      }
      return $sCde;
    }

    public static function checkCouponCode($sid, $cde) {
      if(!isset($sid)) $sid = 0;
      $iCnt = 0;
      $sSQL = sprintf("SELECT sid FROM " . static::$table . " WHERE coupon_code='%s';", $cde);
      $result = mysql_query($sSQL) or die(mysql_error());
      $iCnt = mysql_num_rows($result);
      if($iCnt == 1) { #verify that it is not this record with the same coupon code
        $rs = mysql_fetch_row($result);
        if($sid == $rs[0]) {
          $iCnt = 0;
        }
      }
      mysql_free_result($result);

      if($iCnt > 0) return true;
      return false;
    }

    public static function get_by_id($id) {
      $data = [
        'sid' => $id,
        'discount_comment1' => '',
        'discount_comment2' => '',
        'discount_comment3' => '',
        'discount_amount' => '0.00',
        'coupon_code' => '',
        'allow_multiple' => 0,
        'date_start' => mktime(0, 0, 0, date('m'), date('d'), date('y')),
        'date_end' => mktime(0, 0, 0, date('m'), date('d') + 1, date('y')),
        'enabled' => 1,
        'filter_products' => null,
        'filter_type' => null,
        'users' => null,
        'countdown' => '',
        'product_type' => 1,
        'user_type' => 1,
        'required_amount' => '0.00',
        'promotion_type' => 0,
        'discount_type' => 1,
        'required_type' => 0,
        'discount_amount_type' => 0
      ];
      if(isset($id)) {
        $q = "select * from " . static::$table . " where sid = '" . $id . "'";
        $result = mysql_query($q);
        if($result) {
          $data = mysql_fetch_assoc($result);
        }
      }
      return $data;
    }

    public static function get_total_count($filter = null) {
      $res = 0;
      $q = "SELECT COUNT(sid) FROM " . static::$table;
      $q .= self::build_where($filter);
      $result = mysql_query($q);
      if($result) {
        $row = mysql_fetch_array($result);
        $res = $row[0];
      }
      return $res;
    }

    public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null) {
      $res = null;
      $q = "SELECT * FROM " . static::$table;
      $q .= self::build_where($filter);
      $q .= static::build_order($sort);
      if($limit != 0) $q .= " LIMIT $start, $limit";
      $result = mysql_query($q);
      if($result) {
        $res_count_rows = mysql_num_rows($result);
        while($row = mysql_fetch_assoc($result)) {
          $res[] = $row;
        }
      }
      return $res;
    }

    public static function save(&$data) {
      extract($data);
      $discount_comment1 = mysql_real_escape_string($discount_comment1);
      $discount_comment2 = mysql_real_escape_string($discount_comment2);
      $discount_comment3 = mysql_real_escape_string($discount_comment3);
      if(isset($sid)) {
        $q = "UPDATE " . static::$table .
          " SET" .
          " coupon_code='$coupon_code'," .
          " discount_amount='$discount_amount'," .
          " discount_amount_type='$discount_amount_type'," .
          " discount_type='$discount_type'," .
          " user_type='$user_type'," .
          " shipping_type='$shipping_type'," .
          " product_type='$product_type'," .
          " promotion_type='$promotion_type'," .
          " required_amount='$required_amount'," .
          " required_type='$required_type'," .
          " allow_multiple='$allow_multiple'," .
          " enabled='$enabled'," .
          " countdown='$countdown'," .
          " discount_comment1='$discount_comment1'," .
          " discount_comment2='$discount_comment2'," .
          " discount_comment3='$discount_comment3'," .
          " date_start='$date_start'," .
          " date_end='$date_end'" .
          " WHERE sid ='$sid'";
        $res = mysql_query($q);
      } else {
        $q = "INSERT INTO " . static::$table .
          " SET" .
          " coupon_code='$coupon_code'," .
          " discount_amount='$discount_amount'," .
          " discount_amount_type='$discount_amount_type'," .
          " discount_type='$discount_type'," .
          " user_type='$user_type'," .
          " shipping_type='$shipping_type'," .
          " product_type='$product_type'," .
          " promotion_type='$promotion_type'," .
          " required_amount='$required_amount'," .
          " required_type='$required_type'," .
          " allow_multiple='$allow_multiple'," .
          " enabled='$enabled'," .
          " countdown='$countdown'," .
          " discount_comment1='$discount_comment1'," .
          " discount_comment2='$discount_comment2'," .
          " discount_comment3='$discount_comment3'," .
          " date_start='$date_start'," .
          " date_end='$date_end'";

        $res = mysql_query($q);
        if($res) $sid = mysql_insert_id();
      }
      if($res) {
        $res = mysql_query("DELETE FROM fabrix_specials_users WHERE sid ='$sid'");
        if($res && ($user_type == 4)) {
          foreach($users as $aid) {
            $res = mysql_query("INSERT INTO  fabrix_specials_users (sid ,aid)VALUES('$sid',  '$aid')");
            if(!$res) break;
          }
        }
      }
      if($res) {
        $res = mysql_query("DELETE FROM fabrix_specials_products WHERE sid='$sid'");
        if($res && isset($product_type) && ($product_type > 1)) {
          foreach($filter_products as $pid) {
            $res = mysql_query("INSERT INTO  fabrix_specials_products (sid ,pid, stype) VALUES ('$sid',  '$pid', '$product_type')");
            if(!$res) break;
          }
        }
      }
      if(!$res) throw new Exception(mysql_error());
      return $sid;
    }

    public static function get_filter_selected($type, &$data) {
      $id = isset($data['sid']) ? $data['sid'] : null;
      if($type == 'users') {
        $users = [];
        $user_type = $data['user_type'];
        if(isset($data['users']) || isset($data['users_select']))
          $select = implode(',', array_merge(isset($data['users']) ? $data['users'] : [],
                                             isset($data['users_select']) ? $data['users_select'] : []));
        else {
          $data['users_select'] = self::get_filter_selected_data($type, $id);
          $select = implode(',', isset($data['users_select']) ? array_keys($data['users_select']) : []);
        }
        if($user_type == '4') {
          if(strlen($select > 1)) {
            $results = mysql_query(
              "select * from fabrix_accounts" .
              " where aid in($select)" .
              " order by email, bill_firstname, bill_lastname"
            );
            while($row = mysql_fetch_array($results)) {
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
            if(isset($data['prod_select']) || isset($data['filter_products']))
              $select = implode(',', array_merge(isset($data['prod_select']) ? $data['prod_select'] : [],
                                                 isset($data['filter_products']) ? $data['filter_products'] : []));
            else {
              $data['prod_select'] = self::get_filter_selected_data($filter_type, $id);
              $select = implode(',', isset($data['prod_select']) ? array_keys($data['prod_select']) : []);
            }
            if(strlen($select) > 0) {
              $results = mysql_query(
                "select * from fabrix_products" .
                " where pid in ($select)" .
                " order by pnumber, pname"
              );
              while($row = mysql_fetch_array($results)) {
                $filter_products[$row[0]] = $row[2] . '-' . $row[1];
              }
            }
            break;
          case 4:
            $filter_type = 'mnf';
            if(isset($data['mnf_select']) || isset($data['filter_products']))
              $select = implode(',', array_merge(isset($data['mnf_select']) ? $data['mnf_select'] : [],
                                                 isset($data['filter_products']) ? $data['filter_products'] : []));
            else {
              $data['mnf_select'] = self::get_filter_selected_data($filter_type, $id);
              $select = implode(',', isset($data['mnf_select']) ? array_keys($data['mnf_select']) : []);
            }
            if(strlen($select) > 0) {
              $results = mysql_query(
                "select * from fabrix_manufacturers" .
                " where id in ($select)" .
                " order by manufacturer"
              );
              while($row = mysql_fetch_array($results)) {
                $filter_products[$row[0]] = $row[1];
              }
            }
            break;
          case 3:
            $filter_type = 'cat';
            if(isset($data['cat_select']) || isset($data['filter_products']))
              $select = implode(',', array_merge(isset($data['cat_select']) ? $data['cat_select'] : [],
                                                 isset($data['filter_products']) ? $data['filter_products'] : []));
            else {
              $data['cat_select'] = self::get_filter_selected_data($filter_type, $id);
              $select = implode(',', isset($data['cat_select']) ? array_keys($data['cat_select']) : []);
            }
            if(strlen($select) > 0) {
              $results = mysql_query(
                "select * from fabrix_categories " .
                " where cid in ($select)" .
                " order by cname"
              );
              while($row = mysql_fetch_array($results)) {
                $filter_products[$row[0]] = $row[1];
              }
            }
            break;
        }
        $data['filter_products'] = $filter_products;
        $data['filter_type'] = $filter_type;
      }
    }

    public static function get_filter_selected_data($type, $id) {
      $data = [];
      switch($type) {
        case 'users':
          $results = mysql_query(
            "select a.* from fabrix_specials_users b" .
            " inner join fabrix_accounts a on b.aid=a.aid " .
            " where sid='$id'" .
            " order by a.email, a.bill_firstname, a.bill_lastname"
          );
          if($results)
            while($row = mysql_fetch_array($results)) {
              $data[$row[0]] = $row[1] . '-' . $row[3] . ' ' . $row[4];
            }
          break;
        case 'prod':
          $results = mysql_query(
            "select a.* from fabrix_specials_products b" .
            " inner join fabrix_products a on b.pid=a.pid " .
            " where b.sid='$id' and b.stype = 2" .
            " order by a.pnumber, a.pname"
          );
          if($results)
            while($row = mysql_fetch_array($results)) {
              $data[$row[0]] = $row[2] . '-' . $row[1];
            }
          break;
        case 'mnf':
          $results = mysql_query(
            "select a.* from fabrix_specials_products b" .
            " inner join fabrix_manufacturers a on b.pid=a.id " .
            " where b.sid='$id' and b.stype = 4" .
            " order by a.manufacturer"
          );
          if($results)
            while($row = mysql_fetch_array($results)) {
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
          if($results)
            while($row = mysql_fetch_array($results)) {
              $data[$row[0]] = $row[1];
            }
          break;
      }
      return $data;
    }

    public static function get_filter_data($type, &$count, $start = 0, $search = null) {
      $filter = null;
      $filter_limit = (!is_null(_A_::$app->keyStorage()->system_filter_amount) ? _A_::$app->keyStorage()->system_filter_amount : FILTER_LIMIT);
      $start = isset($start) ? $start : 0;
      $search = mysql_escape_string(self::sanitize($search));
      switch($type) {
        case 'users':
          $q = "select count(aid) from fabrix_accounts";
          if(isset($search) && (strlen($search) > 0)) {
            $q .= " where bill_firstname like '%$search%'";
            $q .= " or bill_lastname like '%$search%'";
            $q .= " or email like '%$search%'";
          }
          $results = mysql_query($q);
          $row = mysql_fetch_array($results);
          $count = $row[0];
          $q = "select * from fabrix_accounts";
          if(isset($search) && (strlen($search) > 0)) {
            $q .= " where bill_firstname like '%$search%'";
            $q .= " or bill_lastname like '%$search%'";
            $q .= " or email like '%$search%'";
          }
          $q .= " order by email, bill_firstname, bill_lastname";
          $q .= " limit $start, $filter_limit";
          $results = mysql_query($q);
          while($row = mysql_fetch_array($results)) {
            $filter[] = [$row[0], $row[1] . ' - ' . $row[3] . ' ' . $row[4]];
          }
          break;
        case 'prod':
          $q = "select count(pid) from fabrix_products";
          if(isset($search) && (strlen($search) > 0)) {
            $q .= " where pnumber like '%$search%'";
            $q .= " or pname like '%$search%'";
          }
          $results = mysql_query($q);
          $row = mysql_fetch_array($results);
          $count = $row[0];
          $q = "select * from fabrix_products";
          if(isset($search) && (strlen($search) > 0)) {
            $q .= " where pnumber like '%$search%'";
            $q .= " or pname like '%$search%'";
          }
          $q .= " order by pnumber, pname";
          $q .= " limit $start, $filter_limit";
          $results = mysql_query($q);
          while($row = mysql_fetch_array($results)) {
            $filter[] = [$row[0], $row[2] . ' - ' . $row[1]];
          }
          break;
        case 'mnf':
          $q = "select count(id) from fabrix_manufacturers";
          if(isset($search) && (strlen($search) > 0)) {
            $q .= " where manufacturer like '%$search%'";
          }
          $results = mysql_query($q);
          $row = mysql_fetch_array($results);
          $count = $row[0];
          $q = "select * from fabrix_manufacturers";
          if(isset($search) && (strlen($search) > 0)) {
            $q .= " where manufacturer like '%$search%'";
          }
          $q .= " order by manufacturer";
          $q .= " limit $start, $filter_limit";
          $results = mysql_query($q);
          while($row = mysql_fetch_array($results)) {
            $filter[] = [$row[0], $row[1]];
          }
          break;
        case 'cat':
          $q = "select count(cid) from fabrix_categories";
          if(isset($search) && (strlen($search) > 0)) {
            $q .= " where cname like '%$search%'";
          }
          $results = mysql_query($q);
          $row = mysql_fetch_array($results);
          $count = $row[0];
          $q = "select * from fabrix_categories";
          if(isset($search) && (strlen($search) > 0)) {
            $q .= " where cname like '%$search%'";
          }
          $q .= " order by cname";
          $q .= " limit $start, $filter_limit";
          $results = mysql_query($q);
          while($row = mysql_fetch_array($results)) {
            $filter[] = [$row[0], $row[1]];
          }
      }
      return $filter;
    }

    public static function delete($id) {
      mysql_query("DELETE FROM fabrix_specials_products WHERE sid='$id'");
      mysql_query("DELETE FROM fabrix_specials_users WHERE sid='$id'");
      mysql_query("DELETE FROM fabrix_specials_usage WHERE sid='$id'");
      mysql_query("DELETE FROM " . static::$table . " WHERE sid = '$id'");
    }

  }