<?php

  class Model_Orders extends Model_Base {

    protected static $table = 'fabrix_orders';

    protected static function build_where(&$filter) {
      $result = "";
      if(isset($filter["a.aid"])) $result[] = "a.aid = '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter['a.aid'])))."'";
      if(isset($filter['username'])) $result[] = "CONCAT(b.bill_firstname,' ',b.bill_lastname) LIKE '%" . implode('% %',array_filter(explode(' ',mysql_real_escape_string(static::strip_data(static::sanitize($filter["username"])))))) . "%'";
      if(isset($filter["a.status"])) $result[] = "a.status = '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter["a.status"])))."'";
      if(isset($filter["a.order_date"])) {
        $where = (!empty($filter["a.order_date"]['from']) ? "a.order_date >= '" . strtotime(mysql_real_escape_string(static::strip_data(static::sanitize($filter["a.order_date"]["from"])))) . "'" : "") .
          (!empty($filter["a.order_date"]['to']) ? " AND a.order_date <= '" . strtotime(mysql_real_escape_string(static::strip_data(static::sanitize($filter["a.order_date"]["to"])))) . "'" : "");
        if(strlen(trim($where)) > 0) $result[] = "(" . $where . ")";
      }
      if(isset($filter["a.trid"])) $result[] = "a.trid LIKE '%" . implode('%',array_filter(explode(' ',mysql_real_escape_string(static::strip_data(static::sanitize($filter["a.trid"])))))) . "%'";
      if(isset($filter["c.sid"])) $result[] = "c.sid = '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter["c.sid"]))) . "'";

      if(!empty($result) && (count($result) > 0)) {
        if(strlen(trim(implode(" AND ", $result))) > 0) {
          $filter['active'] = true;
        }
      }
      if(isset($filter['hidden']["a.aid"])) $result[] = "a.aid = '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter['hidden']['a.aid'])))."'";
      if(isset($filter['hidden']["c.sid"])) $result[] = "c.sid = '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter['hidden']["c.sid"]))) . "'";

      if(!empty($result) && (count($result) > 0)) {
        $result = implode(" AND ", $result);
        if(strlen(trim($result)) > 0){
          $result = " WHERE " . $result;
        }
      }
      return $result;
    }

    public static function getOrderDetailInfo($arr) {
      if(isset($arr) && count($arr) === 1) {
        $result = null;

        $query = '
               SELECT
                fod.*,
                fo.*
                  
                FROM
                    fabrix_order_details fod
                LEFT JOIN
                    fabrix_orders fo
                ON
                    fod.order_id = fo.oid
                WHERE
                    fo.oid = ' . $arr['oid'] . '
            ';

        $res = mysql_query($query);
        if($res) {
          while($row = mysql_fetch_assoc($res)) {
            $result[] = $row;
          }
        }
        return $result;
      }
      return false;
    }

    public static function save(&$data) {
      extract($data);
      if(isset($oid)) {
        $query = "UPDATE " . static::$table .
          " SET status = '" . $status . "'," .
          " track_code = '" . $track_code . "'," .
          " end_date = STR_TO_DATE('" . $end_date . "', '%m/%d/%Y')" .
          " WHERE oid = '" . $oid . "'";
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      }
      return $oid;
    }

    public static function get_by_id($id) {
      $response = [
        'oid' => $id,
        'track_code' => '',
        'status' => '',
        'order_date' => '',
        'end_date' => '',
      ];
      if(isset($id)) {
        $query = "SELECT * FROM " . static::$table . " WHERE oid='$id'";
        $result = mysql_query($query);
        if($result) $response = mysql_fetch_assoc($result);
      }
      return $response;
    }

    public static function get_list_by_discount_id($id) {
      if(isset($id)) {
        $query = "SELECT orders.*, CONCAT(users.bill_firstname,' ',users.bill_lastname) AS username FROM fabrix_specials_usage spec_usage ";
        $query .= "LEFT JOIN fabrix_orders orders ON spec_usage.oid = orders.oid ";
        $query .= "LEFT JOIN fabrix_accounts users ON orders.aid = users.aid ";
        $query .= "WHERE spec_usage.sid = '$id'";
        if($result = mysql_query($query)) {
          $rows = [];
          while($row = mysql_fetch_array($result)) {
            $rows[] = $row;
          }
          return $rows;
        }
      }
      return null;
    }

    public static function get_total_count($filter = null) {
      $response = 0;
      $query = "SELECT COUNT(DISTINCT a.oid)";
      $query .= " from fabrix_orders a";
      $query .= " left join fabrix_accounts b on a.aid = b.aid";
      $query .= " left join fabrix_specials_usage c on a.oid = c.oid";
      $query .= static::build_where($filter);
      if($result = mysql_query($query)) {
        $response = mysql_fetch_row($result)[0];
      }
      return $response;
    }

    public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null) {
      $response = null;
      $query = "select";
      $query .= " DISTINCT a.*, CONCAT(b.bill_firstname,' ',b.bill_lastname) as username";
      $query .= " from fabrix_orders a";
      $query .= " left join fabrix_accounts b on a.aid = b.aid";
      $query .= " left join fabrix_specials_usage c on a.oid = c.oid";
      $query .= static::build_where($filter);
      $query .= static::build_order($sort);
      if ( $limit != 0 ) $query .= " LIMIT $start, $limit";

      if($result = mysql_query($query)) {
        $res_count_rows = mysql_num_rows($result);
        while($row = mysql_fetch_array($result)) {
          $response[] = $row;
        }
      }
      return $response;
    }

    public function register_order($aid, $trid, $shipping_type, $shipping_cost, $on_roll,
      $express_samples, $handling, $shipping_discount,
      $coupon_discount, $total_discount, $taxes, $total) {

      $rate_handling = (!is_null(_A_::$app->keyStorage()->shop_rate_handling) ? _A_::$app->keyStorage()->shop_rate_handling : RATE_HANDLING);

      $q = "insert into fabrix_orders (" .
        "aid, trid, shipping_type, shipping_cost, on_roll," .
        " roll_cost, express_samples, on_handling, handling, shipping_discount," .
        " coupon_discount, total_discount, taxes, total, order_date," .
        " samples_express_cost, samples_single_cost, samples_multiple_cost," .
        " samples_additional_cost, samples_products_cost, samples_min_qty," .
        " samples_max_qty)" .
        " values (%u, '%s', %u, %01.2f, %u," .
        " %01.2f, %u, %u, %01.2f, %01.2f," .
        " %01.2f, %01.2f, %01.2f, %01.2f, %u," .
        " %01.2f, %01.2f, %01.2f," .
        " %01.2f, %01.2f, %01.2f," .
        " %01.2f)";

      $sSQL = sprintf($q, $aid, $trid, $shipping_type, str_replace(",", "", $shipping_cost), $on_roll, str_replace(",", "", RATE_ROLL),
                      str_replace(",", "", $express_samples), $handling, str_replace(",", "", $rate_handling), str_replace(",", "", $shipping_discount),
                      str_replace(",", "", $coupon_discount), str_replace(",", "", $total_discount), str_replace(",", "", $taxes),
                      str_replace(",", "", $total), time(),
        (!is_null(_A_::$app->keyStorage()->shop_samples_price_express_shipping) ? _A_::$app->keyStorage()->shop_samples_price_express_shipping : SAMPLES_PRICE_EXPRESS_SHIPPING),
        (!is_null(_A_::$app->keyStorage()->shop_samples_price_single) ? _A_::$app->keyStorage()->shop_samples_price_single : SAMPLES_PRICE_SINGLE),
        (!is_null(_A_::$app->keyStorage()->shop_samples_price_multiple) ? _A_::$app->keyStorage()->shop_samples_price_multiple : SAMPLES_PRICE_MULTIPLE),
        (!empty($data['shop_samples_price_additional']) ? $data['shop_samples_price_additional'] : SAMPLES_PRICE_ADDITIONAL),
        (!empty($data['shop_samples_price_with_products']) ? $data['shop_samples_price_with_products'] : SAMPLES_PRICE_WITH_PRODUCTS),
        (!empty($data['shop_samples_qty_multiple_min']) ? $data['shop_samples_qty_multiple_min'] : SAMPLES_QTY_MULTIPLE_MIN),
        (!empty($data['shop_samples_qty_multiple_max']) ? $data['shop_samples_qty_multiple_max'] : SAMPLES_QTY_MULTIPLE_MAX));

      $res = mysql_query($sSQL);
      if($res) return mysql_insert_id();
      return null;
    }

    public static function insert_order_detail($order_id, $product_id, $product_number, $product_name,
      $quantity, $price, $discount, $sale_price, $is_sample = 0) {
      $q = "insert into  fabrix_order_details " .
        "(order_id, product_id, product_number, product_name, quantity, price, discount, sale_price, is_sample)" .
        " VALUES (%u, %u,'%s', '%s', '%s','%s', '%s', '%s', %u);";
      $sql = sprintf($q, $order_id, $product_id, $product_number, $product_name,
                     $quantity, $price, $discount, $sale_price, $is_sample);
      $res = mysql_query($sql);
      return $res;
    }

    public static function save_discount_usage($discountIds, $oid) {
      if(isset($discountIds) && is_array($discountIds) && (count($discountIds) > 0)) {
        $discounts = array_unique($discountIds, SORT_NUMERIC);
        $delete = sprintf("DELETE from fabrix_specials_usage WHERE oid = %u", $oid);
        $res = mysql_query($delete);
        foreach($discounts as $sid) {
          $sSQL = sprintf("INSERT INTO fabrix_specials_usage (sid, oid) values (%u, %u)", $sid, $oid);
          mysql_query($sSQL);
        }
      }
    }

    public static function get_order_details($oid) {
      $results = mysql_query("select * from fabrix_order_details WHERE order_id='$oid'");
      if($results) {
        $rows = [];
        while($row = mysql_fetch_array($results)) {
          $rows[] = $row;
        }
        return $rows;
      }
      return false;
    }

    public static function update_order_detail_info($status, $status, $track_code, $end_date, $order_id) {
      $request = "UPDATE fabrix_orders SET 
                    status = '" . $status . "', 
                    track_code = '" . $track_code . "', 
                    end_date = STR_TO_DATE('" . $end_date . "', '%m/%d/%Y') WHERE oid = '" . $order_id . "'";
      return mysql_query($request);
    }

    public static function get_user_by_order($order_id) {
      return mysql_query('SELECT aid FROM fabrix_orders WHERE oid =' . $order_id);
    }

  }