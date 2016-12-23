<?php

  Class Model_Clearance extends Model_Base {

    protected static $table = 'fabrix_clearance';

    protected static function build_where(&$filter) {
      $result = "";
      if(Controller_Admin::is_logged()) {
        if(isset($filter["a.pname"])) $result[] = "a.pname LIKE '%" . mysql_real_escape_string(static::strip_data(static::sanitize($filter["a.pname"]))) . "%'";
      } else {
        if(isset($filter["a.pname"])) $result[] = Model_Synonyms::build_synonyms_like("a.pname", $filter["a.pname"]);
      }
      if(isset($filter["a.pvisible"])) $result[] = "a.pvisible = '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter["a.pvisible"]))) . "'";
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
      if(isset($filter['scenario']) && ($filter['scenario'] == 'add')){
        $query .= " FROM fabrix_products a";
        $query .= " LEFT JOIN " . static::$table .  " z ON a.pid = z.pid";
      } else {
        $query .= " FROM " . static::$table . " z";
        $query .= " LEFT JOIN fabrix_products a ON a.pid = z.pid";
      }
      $query .= " LEFT JOIN fabrix_product_categories ON a.pid = fabrix_product_categories.pid";
      $query .= " LEFT JOIN fabrix_categories b ON fabrix_product_categories.cid = b.cid";
      $query .= " LEFT JOIN fabrix_product_colors ON a.pid = fabrix_product_colors.prodId";
      $query .= " LEFT JOIN fabrix_color c ON fabrix_product_colors.colorId = c.id";
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
      $query = "SELECT DISTINCT z.id, a.* ";
      if(isset($filter['scenario']) && ($filter['scenario'] == 'add')){
        $query .= " FROM fabrix_products a";
        $query .= " LEFT JOIN " . static::$table .  " z ON a.pid = z.pid";
      } else {
        $query .= " FROM " . static::$table . " z";
        $query .= " LEFT JOIN fabrix_products a ON a.pid = z.pid";
      }
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

      if($result = mysql_query($query)) {
        $res_count_rows = mysql_num_rows($result);

        if(isset($filter['hidden']['view']) && $filter['hidden']['view']) {
          $sys_hide_price = Model_Price::sysHideAllRegularPrices();
          $cart_items = isset(_A_::$app->session('cart')['items']) ? _A_::$app->session('cart')['items'] : [];
          $cart = array_keys($cart_items);
          while($row = mysql_fetch_array($result)) {
            $response[] = Model_Shop::prepare_layout_product($row, $cart, $sys_hide_price);
          }
        } else {
          while($row = mysql_fetch_array($result)) {
            $filename = 'upload/upload/b_' . $row['image1'];
            if(!(file_exists($filename) && is_file($filename))) {
              $filename = 'upload/upload/not_image.jpg';
            }
            $row['filename'] = _A_::$app->router()->UrlTo($filename);

            $price = $row['priceyard'];
            $inventory = $row['inventory'];
            $piece = $row['piece'];
            if($piece == 1 && $inventory > 0) {
              $price = $price * $inventory;
              $row['price'] = "$" . number_format($price, 2);
              $row['format_price'] = sprintf('%s <sup>per piece</sup>', $price);
            } else {
              $row['price'] = "$" . number_format($price, 2);
              $row['format_price'] = sprintf('%s <sup>per yard</sup>', $price);
            }
            $response[] = $row;
          }
        }
      }

      return $response;
    }

    public static function get_by_id($id) {
      $data = [
        'id' => $id,
        'pid' => null,
        'metadescription' => '',
        'metakeywords' => '',
        'metatitle' => '',
        'pname' => '',
        'pnumber' => '',
        'width' => '',
        'inventory' => '0.00',
        'priceyard' => '0.00',
        'hideprice' => 0,
        'dimensions' => '',
        'weight' => 0,
        'manufacturerId' => '',
        'sdesc' => '',
        'ldesc' => '',
        'weight_id' => '',
        'specials' => 0,
        'pvisible' => 0,
        'best' => 0,
        'piece' => 0,
        'whole' => 0,
        'stock_number' => '',
        'image1' => '',
        'image2' => '',
        'image3' => '',
        'image4' => '',
        'image5' => ''
      ];
      if(isset($id)) {
        $q = "select z.id, a.* from " . static::$table . " z";
        $q .= " left join fabrix_products a on z.pid = a.pid";
        $q .= " where z.id = '" . $id . "'";
        $result = mysql_query($q);
        if($result) {
          $data = mysql_fetch_assoc($result);
        }
      }
      return $data;
    }

    public static function save(&$data) {
      extract($data);
      if(isset($pid) & isset($id)) {
        $sql = "update " . static::$table . " set";
        $sql .= " pid='$pid'";
        $sql .= " where id ='$id'";
        $result = mysql_query($sql);
      } else {
        $sql = "insert into " . static::$table . " set";
        $sql .= " pid='$pid'";
        $result = mysql_query($sql);
        if($result) $id = mysql_insert_id();
      }
      if(!$result) throw new Exception(mysql_error());
      return $id;
    }

    public static function delete($id) {
      if(isset($id)) {
        $query = "DELETE FROM " . static::$table . " WHERE id = $id";
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      }
    }

  }