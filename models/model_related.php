<?php

  Class Model_Related extends Model_Base {

    protected static $table = 'fabrix_product_related';

    protected static function build_where(&$filter) {
      $result = "";
      if(isset($filter['hidden']['b.pvisible'])) $result[] = "b.pvisible = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter['hidden']["b.pvisible"]))) . "'";
      if(isset($filter['hidden']["b.pnumber"])) $result[] = "b.pnumber is not null";
      if(isset($filter['hidden']["b.image1"])) $result[] = "b.image1 is not null";
      if(isset($filter['hidden']["a.pid"])) $result[] = "a.pid = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter['hidden']["a.pid"]))) . "'";
      if(!empty($result) && (count($result) > 0)) {
        $result = implode(" AND ", $result);
      }
      $result = " WHERE b.pnumber is not null and b.pvisible = '1'  and b.image1 is not null" . (!empty($result) ? ' AND ' . $result : '');
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
        $result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query);
        if($result) $response = mysqli_fetch_assoc($result);
      }
      return $response;
    }

    public static function get_total_count($filter = null) {
      $response = 0;
      $query = "SELECT COUNT(DISTINCT a.id) FROM " . static::$table . " a";
      $query .= " LEFT JOIN fabrix_products b ON b.pid = a.r_pid";
      $query .= " LEFT JOIN fabrix_products c ON c.pid = a.pid";
      $query .= static::build_where($filter);
      if($result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query)) {
        $response = mysqli_fetch_row($result)[0];
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

      if($result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query)) {
        $res_count_rows = mysqli_num_rows($result);
        $sys_hide_price = Model_Price::sysHideAllRegularPrices();
        $cart_items = isset(_A_::$app->session('cart')['items']) ? _A_::$app->session('cart')['items'] : [];
        $cart = array_keys($cart_items);
        while($row = mysqli_fetch_array($result)) {
          $response[] = Model_Shop::prepare_layout_product($row, $cart, $sys_hide_price);
        }
      }
      return $response;
    }

    public static function save(&$data) {
      extract($data);
      $query = "REPLACE INTO " . static::$table . " (pid, r_pid) VALUE ('" . $pid . "', '" . $r_pid . "')";
      $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query);
      if(!$res) throw new Exception(mysqli_error(_A_::$app->getDBConnection('iluvfabrix')));
      $id = mysqli_insert_id(_A_::$app->getDBConnection('iluvfabrix')) ;
      return $id;
    }

    public static function delete($id) {
      if(isset($id)) {
        $query = "DELETE FROM  " . static::$table . " WHERE id = $id";
        $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query);
        if(!$res) throw new Exception(mysqli_error(_A_::$app->getDBConnection('iluvfabrix')));
      }
    }

  }