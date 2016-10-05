<?php

  class Model_Order extends Model_Model {

    public static function getOrderDetailInfo($arr) {
      if(isset($arr) && count($arr) === 1) {
        $result = null;

        $query = '
               SELECT
                `fod`.*,
                `fo`.*
                  
                FROM
                    `fabrix_order_details` `fod`
                LEFT JOIN
                    `fabrix_orders` `fo`
                ON
                    `fod`.`order_id` = `fo`.`oid`
                WHERE
                    `fo`.`oid` = ' . $arr['oid'] . '
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

    public function register_order($aid, $trid, $shipping_type, $shipping_cost, $on_roll,
                                   $express_samples, $handling, $shipping_discount,
                                   $coupon_discount, $total_discount, $taxes, $total) {
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
        str_replace(",", "", $express_samples), $handling, str_replace(",", "", RATE_HANDLING), str_replace(",", "", $shipping_discount),
        str_replace(",", "", $coupon_discount), str_replace(",", "", $total_discount), str_replace(",", "", $taxes),
        str_replace(",", "", $total), time(), SAMPLES_PRICE_EXPRESS_SHIPPING, SAMPLES_PRICE_SINGLE,
        SAMPLES_PRICE_MULTIPLE, SAMPLES_PRICE_ADDITIONAL, SAMPLES_PRICE_WITH_PRODUCTS, SAMPLES_QTY_MULTIPLE_MIN,
        SAMPLES_QTY_MULTIPLE_MAX);

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

    public static function get_order($order_id) {
      $result = mysql_query("SELECT * FROM fabrix_orders WHERE oid = '$order_id'");
      return mysql_fetch_array($result);
    }

    public static function get_count_orders($user_id, $like = null) {

      $q = "select";
      $q .= " COUNT(`order`.`oid`)";
      $q .= " from `fabrix_orders` `order`";
      $q .= " left join `fabrix_accounts` `user` on `order`.`aid` = `user`.`aid`";
      $q .= (isset($user_id) || isset($like)) ? " where" : '';
      $q .= isset($user_id) ? " `order`.aid='$user_id'" : '';
      if(isset($like)) {
        $q .= isset($user_id) ? " and" : '';
        $q .= " (`order`.`trid` like '%$like%'";
        $q .= " or `user`.`bill_firstname` like '%$like%'";
        $q .= " or `user`.`bill_lastname`  like '%$like%')";
      }
      $result = mysql_query($q);
      if($result) {
        $myrow = mysql_fetch_array($result);
        return $myrow[0];
      }
      return false;
    }

    public static function get_orders($user_id, $start, $per_page, &$res_count_rows, $like = null) {

      $q = "select";
      $q .= " o.*, CONCAT(user.bill_firstname,' ',user.bill_lastname) as username";
      $q .= " from fabrix_orders o";
      $q .= " left join fabrix_accounts user on o.aid = user.aid";
      $q .= (isset($user_id) || isset($like)) ? " where" : '';
      $q .= isset($user_id) ? " o.aid='$user_id'" : '';
      if(isset($like)) {
        $q .= isset($user_id) ? " and" : '';
        $q .= " (o.trid like '%$like%'";
        $q .= " or user.bill_firstname like '%$like%'";
        $q .= " or user.bill_lastname  like '%$like%')";
      }
      $q .= " order by o.order_date desc limit $start,$per_page";

      $res = mysql_query($q);
      if($res) {
        $rows = [];
        $res_count_rows = mysql_num_rows($res);
        while($row = mysql_fetch_array($res)) {
          $rows[] = $row;
        }
        return $rows;
      }
      return false;
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