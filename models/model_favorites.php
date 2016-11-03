<?php

  Class Model_Favorites extends Model_Base {

    protected static $table = 'fabrix_product_favorites';

    protected static function build_order(&$sort) {
      if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
        $sort = ['z.dt' => 'desc'];
        $sort = ['a.pid' => 'desc'];
      }
      return parent::build_order($sort);
    }

    protected static function build_where(&$filter) {
      $result = "";
      if(isset($filter["a.pname"])) $result[] = "a.pname LIKE '%" . mysql_real_escape_string(static::validData($filter["a.pname"])) . "%'";
      if(isset($filter["a.pvisible"])) $result[] = "a.pvisible = '" . mysql_real_escape_string(static::validData($filter["a.pvisible"])) . "'";
      if(isset($filter["a.piece"])) $result[] = "a.piece = '" . mysql_real_escape_string(static::validData($filter["a.piece"])) . "'";
      if(isset($filter["a.dt"])) {
        $where = (!empty($filter["a.dt"]['from']) ? "a.dt >= '" . mysql_real_escape_string(static::validData($filter["a.dt"]["from"])) . "'" : "") .
          (!empty($filter["a.dt"]['to']) ? " AND a.dt <= '" . mysql_real_escape_string(static::validData($filter["a.dt"]["to"])) . "'" : "");
        if(strlen(trim($where)) > 0) $result[] = "(" . $where . ")";
      }
      if(isset($filter["a.pnumber"])) $result[] = "a.pnumber LIKE '%" . mysql_real_escape_string(static::validData($filter["a.pnumber"])) . "%'";
      if(isset($filter["a.best"])) $result[] = "a.best = '" . mysql_real_escape_string(static::validData($filter["a.best"])) . "'";
      if(isset($filter["a.specials"])) $result[] = "a.specials = '" . mysql_real_escape_string(static::validData($filter["a.specials"])) . "'";
      if(isset($filter["b.cid"])) $result[] = "b.cid = '" . mysql_real_escape_string(static::validData($filter["b.cid"])) . "'";
      if(isset($filter["c.id"])) $result[] = "c.id = '" . mysql_real_escape_string(static::validData($filter["c.id"])) . "'";
      if(isset($filter["d.id"])) $result[] = "d.id = '" . mysql_real_escape_string(static::validData($filter["d.id"])) . "'";
      if(isset($filter["e.id"])) $result[] = "e.id = '" . mysql_real_escape_string(static::validData($filter["e.id"])) . "'";
      if(!empty($result) && (count($result) > 0)) {
        if(strlen(trim(implode(" AND ", $result))) > 0) {
          $filter['active'] = true;
        }
      }
      if(isset($filter['hidden']["z.aid"])) $result[] = "a.aid = '" . mysql_real_escape_string(static::validData($filter['hidden']["z.zid"])) . "'";
      if(!empty($result) && (count($result) > 0)) {
        $result = implode(" AND ", $result);
      }
      $result = " WHERE a.pnumber is not null and a.pvisible = '1'" . (!empty($result) ? ' AND ' . $result : '');
      return $result;
    }

    public static function get_total_count($filter = null) {
      $response = 0;
      $query = "SELECT COUNT(DISTINCT a.pid) FROM " . static::$table . " z";
      $query .= " LEFT JOIN fabrix_products a ON a.pid = z.pid";
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
      $query = "SELECT DISTINCT a.* FROM " . static::$table . " z";
      $query .= " LEFT JOIN fabrix_products a ON a.pid = z.pid";
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

    public static function save($data) {
      extract($data);
      $query = "REPLACE INTO " . static::$table . " (aid, pid) VALUE ('" . $aid . "','".$pid."')";
      $res = mysql_query($query);
      if(!$res) throw new Exception(mysql_error());
      $id = mysql_insert_id();
      return $id;
    }

    public static function delete($id) {
      if(isset($id)) {
        $query = "DELETE FROM  " . static::$table . " WHERE id = $id";
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      }
    }

  }