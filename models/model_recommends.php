<?php

  Class Model_Recommends extends Model_Base {

    protected static $table = 'fabrix_products';

    protected static function build_where(&$filter) {
      $result = "";
      if(Controller_Admin::is_logged()) {
        if(isset($filter["a.pname"])) $result[] = "a.pname LIKE '%" . mysql_real_escape_string(static::strip_data(static::sanitize($filter["a.pname"]))) . "%'";
      } else {
        if(isset($filter["a.pname"])) $result[] = Model_Synonyms::build_synonyms_like("a.pname", $filter["a.pname"]);
      }
      if(isset($filter["a.piece"])) $result[] = "a.piece = '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter["a.piece"]))) . "'";
      if(isset($filter["a.dt"])) {
        $where = (!empty($filter["a.dt"]['from']) ? "a.dt >= '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter["a.dt"]["from"]))) . "'" : "") .
          (!empty($filter["a.dt"]['to']) ? " AND a.dt <= '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter["a.dt"]["to"]))) . "'" : "");
        if(strlen(trim($where)) > 0) $result[] = "(" . $where . ")";
      }
      if(isset($filter["a.pnumber"])) $result[] = "a.pnumber LIKE '%" . mysql_real_escape_string(static::strip_data(static::sanitize($filter["a.pnumber"]))) . "%'";
      if(isset($filter["a.best"])) $result[] = "a.best = '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter["a.best"]))) . "'";
      if(isset($filter["a.specials"])) $result[] = "a.specials = '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter["a.specials"]))) . "'";
      if(isset($filter["b.cid"])) $result[] = "b.cid = '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter["b.cid"]))) . "'";
      if(isset($filter["c.id"])) $result[] = "c.id = '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter["c.id"]))) . "'";
      if(isset($filter["d.id"])) $result[] = "d.id = '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter["d.id"]))) . "'";
      if(isset($filter["e.id"])) $result[] = "e.id = '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter["e.id"]))) . "'";
      if(isset($filter["a.priceyard"]['from']) && !empty((float)$filter["a.priceyard"]['from'])) $result[] = "a.priceyard > '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter["a.priceyard"]['from']))) . "'";
      if(isset($filter["a.priceyard"]['to']) && !empty((float)$filter["a.priceyard"]['to'])) $result[] = "a.priceyard <= '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter["a.priceyard"]['to']))) . "'";
      if(!empty($result) && (count($result) > 0)) {
        if(strlen(trim(implode(" AND ", $result))) > 0) {
          $filter['active'] = true;
        }
      }

      if(isset($filter['hidden']["fabrix_orders.aid"])) $result[] = "fabrix_orders.aid = '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter['hidden']["fabrix_orders.aid"]))) . "'";
      if(isset($filter['hidden']['a.priceyard']) && !is_array($filter['hidden']['a.priceyard'])) $result[] = "a.priceyard > '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter['hidden']["a.priceyard"]))) . "'";
      if(isset($filter['hidden']['a.pvisible'])) $result[] = "a.pvisible = '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter['hidden']["a.pvisible"]))) . "'";
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
      $query .= " LEFT JOIN fabrix_product_colours ON a.pid = fabrix_product_colours.prodId";
      $query .= " LEFT JOIN fabrix_colour c ON fabrix_product_colours.colourId = c.id";
      $query .= " LEFT JOIN fabrix_product_patterns ON a.pid = fabrix_product_patterns.prodId";
      $query .= " LEFT JOIN fabrix_patterns d ON d.id = fabrix_product_patterns.patternId";
      $query .= " LEFT JOIN fabrix_manufacturers e ON a.manufacturerId = e.id";
      $query .= static::build_where($filter);
      if($result = mysql_query($query)) {
        $response = mysql_fetch_row($result)[0];
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
      $query .= " LEFT JOIN fabrix_product_colours ON a.pid = fabrix_product_colours.prodId";
      $query .= " LEFT JOIN fabrix_colour c ON fabrix_product_colours.colourId = c.id";
      $query .= " LEFT JOIN fabrix_product_patterns ON a.pid = fabrix_product_patterns.prodId";
      $query .= " LEFT JOIN fabrix_patterns d ON d.id = fabrix_product_patterns.patternId";
      $query .= " LEFT JOIN fabrix_manufacturers e ON a.manufacturerId = e.id";
      $query .= static::build_where($filter);
      $query .= static::build_order($sort);
      if($limit != 0) $query .= " LIMIT $start, $limit";
      if($result = mysql_query($query)) {
        $res_count_rows = mysql_num_rows($result);
        $sys_hide_price = Model_Price::sysHideAllRegularPrices();
        $cart_items = isset(_A_::$app->session('cart')['items']) ? _A_::$app->session('cart')['items'] : [];
        $cart = array_keys($cart_items);
        while($row = mysql_fetch_array($result)) {
          $response[] = Model_Shop::prepare_layout_product($row, $cart, $sys_hide_price);
        }
      }
      return $response;
    }

  }