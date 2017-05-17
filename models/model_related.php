<?php

  Class Model_Related extends Model_Base {

    protected static $table = 'fabrix_product_related';

    protected static function build_where(&$filter) {
      $result = "";
      if(isset($filter['hidden']['b.pvisible'])) $result[] = "b.pvisible = '" . static::escape( static::strip_data(static::sanitize($filter['hidden']["b.pvisible"]))) . "'";
      if(isset($filter['hidden']["b.pnumber"])) $result[] = "b.pnumber is not null";
      if(isset($filter['hidden']["b.image1"])) $result[] = "b.image1 is not null";
      if(isset($filter['hidden']["a.pid"])) $result[] = "a.pid = '" . static::escape( static::strip_data(static::sanitize($filter['hidden']["a.pid"]))) . "'";
      if(!empty($result) && (count($result) > 0)) {
        $result = implode(" AND ", $result);
      }
      $result = " WHERE b.priceyard > 0 and b.pnumber is not null and b.pvisible = '1'  and b.image1 is not null" . (!empty($result) ? ' AND ' . $result : '');
      return $result;
    }

    public static function get_by_id($id) {
      $response = [
        'id' => $id,
        'pid' => '',
        'r_pid' => ''
      ];
      if(isset($id)) {
        $query = "SELECT * FROM " . static::$table . " WHERE id='$id'";
        $result = static::query( $query);
        if($result) $response = static::fetch_assoc($result);
      }
      return $response;
    }

    public static function get_total_count($filter = null) {
      $response = 0;
      $query = "SELECT COUNT(DISTINCT a.id) FROM " . static::$table . " a";
      $query .= " LEFT JOIN fabrix_products b ON b.pid = a.r_pid";
      $query .= " LEFT JOIN fabrix_products c ON c.pid = a.pid";
      $query .= static::build_where($filter);
      if($result = static::query( $query)) {
        $response = static::fetch_row($result)[0];
      }
      return $response;
    }

    public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null) {
      $response = null;
      $query = "SELECT DISTINCT c.pid as cpid, c.pname as cpname, b.* FROM " . static::$table . " a";
      $query .= " LEFT JOIN fabrix_products b ON b.pid = a.r_pid";
      $query .= " LEFT JOIN fabrix_products c ON c.pid = a.pid";
      $query .= static::build_where($filter);
      $query .= static::build_order($sort);
      if($limit != 0) $query .= " LIMIT $start, $limit";

      if($result = static::query( $query)) {
        $res_count_rows = static::num_rows($result);
        $sys_hide_price = Model_Price::sysHideAllRegularPrices();
        $cart_items = isset(_A_::$app->session('cart')['items']) ? _A_::$app->session('cart')['items'] : [];
        $cart = array_keys($cart_items);
        while($row = static::fetch_array($result)) {
          $response[] = Model_Shop::prepare_layout_product($row, $cart, $sys_hide_price);
        }
      }
      return $response;
    }

    public static function save(&$data) {
      extract($data);
      /**
       * @var integer $pid
       * @var integer $r_pid
       */
      $query = "REPLACE INTO " . static::$table . " (pid, r_pid) VALUE ('" . $pid . "', '" . $r_pid . "')";
      $res = static::query( $query);
      if(!$res) throw new Exception(static::error());
      $id = static::last_id() ;
      return $id;
    }

    public static function delete($id) {
      if(isset($id)) {
        $query = "DELETE FROM  " . static::$table . " WHERE id = $id";
        $res = static::query( $query);
        if(!$res) throw new Exception(static::error());
      }
    }

  }