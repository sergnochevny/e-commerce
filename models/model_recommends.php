<?php

  Class Model_Recommends extends Model_Base {

    protected static $table = 'fabrix_products';

    protected static function build_where(&$filter) {
      $result = "";
      if(Controller_Admin::is_logged()) {
        if (!empty($filter["a.pname"]))
          foreach (array_filter(explode(' ', $filter["a.pname"])) as $item)
            if (!empty($item)) $result[] = "a.pname LIKE '%" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($item))) . "%'";
      } else {
        if(isset($filter["a.pname"])) $result[] = Model_Synonyms::build_synonyms_like("a.pname", $filter["a.pname"]);
      }
      if(isset($filter["a.piece"])) $result[] = "a.piece = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["a.piece"]))) . "'";
      if(isset($filter["a.dt"])) {
        $where = (!empty($filter["a.dt"]['from']) ? "a.dt >= '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["a.dt"]["from"]))) . "'" : "") .
          (!empty($filter["a.dt"]['to']) ? " AND a.dt <= '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["a.dt"]["to"]))) . "'" : "");
        if(strlen(trim($where)) > 0) $result[] = "(" . $where . ")";
      }
      if(isset($filter["a.pnumber"])) $result[] = "a.pnumber LIKE '%" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["a.pnumber"]))) . "%'";
      if(isset($filter["a.best"])) $result[] = "a.best = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["a.best"]))) . "'";
      if(isset($filter["a.specials"])) $result[] = "a.specials = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["a.specials"]))) . "'";
      if(isset($filter["b.cid"])) $result[] = "b.cid = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["b.cid"]))) . "'";
      if(isset($filter["c.id"])) $result[] = "c.id = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["c.id"]))) . "'";
      if(isset($filter["d.id"])) $result[] = "d.id = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["d.id"]))) . "'";
      if(isset($filter["e.id"])) $result[] = "e.id = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["e.id"]))) . "'";
      if(isset($filter["a.priceyard"]['from']) && !empty((float)$filter["a.priceyard"]['from'])) $result[] = "a.priceyard > '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["a.priceyard"]['from']))) . "'";
      if(isset($filter["a.priceyard"]['to']) && !empty((float)$filter["a.priceyard"]['to'])) $result[] = "a.priceyard <= '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["a.priceyard"]['to']))) . "'";
      if(!empty($result) && (count($result) > 0)) {
        if(strlen(trim(implode(" AND ", $result))) > 0) {
          $filter['active'] = true;
        }
      }

      if(isset($filter['hidden']["fabrix_orders.aid"])) $result[] = "fabrix_orders.aid = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter['hidden']["fabrix_orders.aid"]))) . "'";
      if(isset($filter['hidden']['a.priceyard']) && !is_array($filter['hidden']['a.priceyard'])) $result[] = "a.priceyard > '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter['hidden']["a.priceyard"]))) . "'";
      if(isset($filter['hidden']['a.pvisible'])) $result[] = "a.pvisible = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter['hidden']["a.pvisible"]))) . "'";
      if(isset($filter['hidden']["a.pnumber"])) $result[] = "a.pnumber is not null";
      if(isset($filter['hidden']["a.image1"])) $result[] = "a.image1 is not null";
      if(!empty($result) && (count($result) > 0)) {
        $result = implode(" AND ", $result);
        $result = (!empty($result) ? " WHERE " . $result : '');
      }
      return $result;
    }

    public static function get_total_count($filter = null) {
      $response = 0;
      $query = "SELECT COUNT(DISTINCT a.pid) ";
      $query .= " FROM fabrix_product_related ";
      $query .= " LEFT JOIN fabrix_order_details ON fabrix_product_related.pid = fabrix_order_details.product_id";
      $query .= " LEFT JOIN fabrix_orders ON fabrix_order_details.order_id = fabrix_orders.oid";
      $query .= " LEFT JOIN " . static::$table . " a ON fabrix_product_related.r_pid = a.pid";
      $query .= " LEFT JOIN fabrix_product_categories ON a.pid = fabrix_product_categories.pid";
      $query .= " LEFT JOIN fabrix_categories b ON fabrix_product_categories.cid = b.cid";
      $query .= " LEFT JOIN fabrix_product_colors ON a.pid = fabrix_product_colors.prodId";
      $query .= " LEFT JOIN fabrix_color c ON fabrix_product_colors.colorId = c.id";
      $query .= " LEFT JOIN fabrix_product_patterns ON a.pid = fabrix_product_patterns.prodId";
      $query .= " LEFT JOIN fabrix_patterns d ON d.id = fabrix_product_patterns.patternId";
      $query .= " LEFT JOIN fabrix_manufacturers e ON a.manufacturerId = e.id";
      $query .= static::build_where($filter);
      if($result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query)) {
        $response = mysqli_fetch_row($result)[0];
      }
      return $response;
    }

    public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null) {
      $response = null;
      $query = "SELECT DISTINCT a.* ";
      $query .= " FROM fabrix_product_related ";
      $query .= " LEFT JOIN fabrix_order_details ON fabrix_product_related.pid = fabrix_order_details.product_id";
      $query .= " LEFT JOIN fabrix_orders ON fabrix_order_details.order_id = fabrix_orders.oid";
      $query .= " LEFT JOIN " . static::$table . " a ON fabrix_product_related.r_pid = a.pid";
      $query .= " LEFT JOIN fabrix_product_categories ON a.pid = fabrix_product_categories.pid";
      $query .= " LEFT JOIN fabrix_categories b ON fabrix_product_categories.cid = b.cid";
      $query .= " LEFT JOIN fabrix_product_colors ON a.pid = fabrix_product_colors.prodId";
      $query .= " LEFT JOIN fabrix_color c ON fabrix_product_colors.colorId = c.id";
      $query .= " LEFT JOIN fabrix_product_patterns ON a.pid = fabrix_product_patterns.prodId";
      $query .= " LEFT JOIN fabrix_patterns d ON d.id = fabrix_product_patterns.patternId";
      $query .= " LEFT JOIN fabrix_manufacturers e ON a.manufacturerId = e.id";
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

  }