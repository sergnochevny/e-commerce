<?php

  Class Model_Shop extends Model_Base {

    public static function product_filter_list() {
      $x = 0;
      $results = mysql_query("select * from fabrix_categories");
      $category = [];
      while($row = mysql_fetch_array($results)) {
        $x++;
        $category[] = [$row[0], $row[1]];
      }
      return ['total_category_in_select' => $x, 'category_in_select' => $category];
    }

    public static function set_inventory($pid, $inventory = 0) {
      $q = "update fabrix_products set inventory=" . $inventory;
      $q .= ($inventory == 0) ? ", pvisible = 0" : "";
      $q .= " where pid=" . $pid;
      $res = mysql_query($q);
    }

    public static function get_product_params($pid) {

      $data = Model_Product::get_by_id($pid);
      $quatity = ($data['inventory'] > 1) ? 1 : $data['inventory'];
      if($data['piece'] == 1) $quatity = 1;

      return [
        'pid' => $data['pid'],
        'Product_name' => $data['pname'],
        'Product_number' => $data['pnumber'],
        'Price' => $data['priceyard'],
        'Stock_number' => $data['stock_number'],
        'quantity' => $quatity,
        'inventory' => $data['inventory'],
        'piece' => $data['piece'],
        'whole' => $data['whole'],
        'image1' => $data['image1']
      ];
    }

    public static function get_product($pid) {
      self::inc_popular($pid);
      return Model_Product::get_by_id($pid);
    }

    public static function inc_popular($pid) {
      mysql_query("update fabrix_products set popular = popular+1 WHERE pid='$pid'");
    }

    public static function get_widget_list_by_type($type, $start, $limit, &$res_row_count, &$image_suffix) {
      $q = "";
      $image_suffix = '';
      switch($type) {
        case 'new':
          $q = "SELECT * FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' ORDER BY  dt DESC, pid DESC LIMIT " . $start . "," . $limit;
          break;
        case 'carousel':
          $image_suffix = 'b_';
          $q = "SELECT * FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' ORDER BY  dt DESC, pid DESC LIMIT " . $start . "," . $limit;
          break;
        case 'best':
          $q = "SELECT * FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' and best = '1' ORDER BY pid DESC LIMIT " . $start . "," . $limit;
          break;
        case 'bsells':
          $q = "select n.*" .
            " from (SELECT a.pid, SUM(b.quantity) as s" .
            " FROM fabrix_products a" .
            " LEFT JOIN fabrix_order_details b ON a . pid = b . product_id" .
            " WHERE a . pnumber is not null and a . pvisible = '1'" .
            " GROUP BY a . pid" .
            " ORDER BY s DESC" .
            " LIMIT " . $start . "," . $limit . ") m" .
            " LEFT JOIN fabrix_products n ON m.pid = n.pid";
          break;
        case 'popular':
          $q = "SELECT * FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' ORDER BY popular DESC LIMIT " . $start . "," . $limit;
          break;
      }
      $rows = mysql_query($q);
      $res_row_count = mysql_num_rows($rows);
      if($rows) {
        $res = $rows;
        $rows = [];
        while($row = mysql_fetch_array($res)) {
          $rows[] = $row;
        }
      }
      return $rows;
    }

    public static function get_items_for_menu($type) {
      $res = [];
      $row_new_count = 50;
      switch($type) {
        case 'all':
          $q = "SELECT distinct a.*" .
            " FROM fabrix_categories a" .
            " LEFT JOIN fabrix_product_categories c on a.cid = c.cid" .
            " LEFT JOIN fabrix_products b ON b.pid = c.pid" .
            " WHERE b.pvisible = '1'" .
            " ORDER BY a.displayorder";
          break;
        case 'new':
          $q = "SELECT distinct a.*" .
            " FROM (SELECT pid FROM fabrix_products WHERE pvisible = '1' ORDER BY dt DESC LIMIT " . $row_new_count . ") b" .
            " LEFT JOIN fabrix_product_categories c ON b.pid = c.pid" .
            " LEFT JOIN fabrix_categories a on a.cid = c.cid" .
            " ORDER BY a.displayorder";
          break;
        case 'manufacturer':
          $q = "SELECT distinct a.*" .
            " FROM fabrix_products b " .
            " INNER JOIN fabrix_manufacturers a ON b.manufacturerId = a.id" .
            " WHERE b.pvisible = '1'" .
            " ORDER BY b.dt DESC";
          break;
        case 'patterns':
          $q = "SELECT distinct a.*" .
            " FROM  fabrix_patterns a" .
            " LEFT JOIN fabrix_product_patterns c on a.id = c.patternId" .
            " LEFT JOIN fabrix_products b ON  b.pid = c.prodId" .
            " WHERE b.pvisible = '1'";
          break;
        case 'blog_category':
          $q = "SELECT distinct a.*" .
            " FROM blog_groups a" .
            " LEFT JOIN blog_group_posts c on a.id = c.group_id" .
            " LEFT JOIN blog_posts b ON b.ID = c.object_id" .
            " WHERE b.post_status = 'publish'";
          break;
      }
      $result = mysql_query($q);
      while($row = mysql_fetch_assoc($result)) {
        $res[] = $row;
      }
      return $res;
    }

    public static function get_list_by_type($type = 'new', $start, $per_page, &$res_row_count = 0) {
      $q = "";
      switch($type) {
        case 'all':
          if(!empty(_A_::$app->get('cat'))) {
            $cid = static::validData(_A_::$app->get('cat'));
            $q = "SELECT a.* FROM fabrix_products a" .
              " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
//                " WHERE  a.pnumber is not null and b.cid='$cid' ORDER BY a.dt DESC, a.pid DESC LIMIT $start,$per_page";
              " WHERE  a.pnumber is not null and b.cid='" . $cid . "'" .
              " ORDER BY b.display_order ASC, a.dt DESC, a.pid DESC" .
              " LIMIT $start,$per_page";
          } else {
            $q = "SELECT * FROM fabrix_products WHERE pnumber is not null" .
              " ORDER BY pid DESC" .
              " LIMIT $start,$per_page";
          }
          break;
        case 'last':
          if(!empty(_A_::$app->get('cat'))) {
            $cid = static::validData(_A_::$app->get('cat'));
            $q = "SELECT a.* FROM fabrix_products a" .
              " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
              " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cid' ORDER BY a.dt DESC, a.pid DESC LIMIT $start,$per_page";
          } else {
            $q = "SELECT * FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' ORDER BY  dt DESC, pid DESC LIMIT $start,$per_page";
          }
          break;
        case 'best':
          if(!empty(_A_::$app->get('cat'))) {
            $cid = static::validData(_A_::$app->get('cat'));
            $q = "SELECT a.* FROM fabrix_products a" .
              " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
              " WHERE  a.pnumber is not null and a.pvisible = '1'  and a.best = '1' and b.cid='$cid' ORDER BY a.dt DESC, a.pid DESC LIMIT $start,$per_page";
          } else {
            $q = "SELECT * FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' and best = '1' ORDER BY dt DESC, pid DESC LIMIT $start,$per_page";
          }
          break;
        case 'specials':
          if(!empty(_A_::$app->get('cat'))) {
            $cid = static::validData(_A_::$app->get('cat'));
            $q = "SELECT a.* FROM fabrix_products a" .
              " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
              " WHERE  a.pnumber is not null and a.pvisible = '1' and a.specials='1' and b.cid='$cid'" .
              " ORDER BY a.dt DESC, a.pid DESC LIMIT $start,$per_page";
          } else {
            $q = "SELECT * FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' and specials='1'" .
              " ORDER BY  dt DESC, pid DESC LIMIT $start,$per_page";
          }
          break;
        case 'popular':
          if(!empty(_A_::$app->get('cat'))) {
            $cid = static::validData(_A_::$app->get('cat'));
            $q = "SELECT a.* FROM fabrix_products a" .
              " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
              " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cid' ORDER BY popular DESC LIMIT $start,$per_page";
          } else {
            $q = "SELECT * FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' ORDER BY popular DESC LIMIT $start,$per_page";
          }
          break;
        case 'bsells':
          if(!empty(_A_::$app->get('cat'))) {
            $cid = static::validData(_A_::$app->get('cat'));
            $q = "select n.*" .
              " from (SELECT a.pid, SUM(b.quantity) as s" .
              " FROM fabrix_products a" .
              " LEFT JOIN fabrix_order_details b ON a.pid = b.product_id" .
              " LEFT JOIN fabrix_product_categories pc ON a.pid = pc.pid and b.cid='$cid'" .
              " WHERE a.pnumber is not null and a.pvisible = '1'" .
              " GROUP BY a.pid" .
              " ORDER BY s DESC  LIMIT $start,$per_page) m" .
              " LEFT JOIN fabrix_products n ON m.pid = n.pid";
          } else {
            $q = "select n.*" .
              " from (SELECT a.pid, SUM(b.quantity) as s" .
              " FROM fabrix_products a" .
              " LEFT JOIN fabrix_order_details b ON a.pid = b.product_id" .
              " WHERE a.pnumber is not null and a.pvisible = '1'" .
              " GROUP BY a.pid" .
              " ORDER BY s DESC  LIMIT $start,$per_page) m" .
              " LEFT JOIN fabrix_products n ON m.pid = n.pid";
          }
          break;
      }
      $res = mysql_query($q);
      $rows = null;
      if($res) {
        $rows = mysql_query($q);
        $res_row_count = mysql_num_rows($rows);
        if($rows) {
          $res = $rows;
          $rows = [];
          while($row = mysql_fetch_array($res)) {
            $rows[] = $row;
          }
        }
      }
      return $rows;
    }

    public static function get_count_by_type($type) {
      switch($type) {
        case 'all':
          if(!empty(_A_::$app->get('cat'))) {
            $cid = static::validData(_A_::$app->get('cat'));
            $q_total = "SELECT COUNT(*) FROM fabrix_products a" .
              " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
              " WHERE  a.pnumber is not null and b.cid='$cid'";
          } else {
            $q_total = "SELECT COUNT(*) FROM fabrix_products WHERE pnumber is not null ";
          }
          break;
        case 'last':
          if(!empty(_A_::$app->get('cat'))) {
            $cid = static::validData(_A_::$app->get('cat'));
            $q_total = "SELECT COUNT(*) FROM fabrix_products a" .
              " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
              " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cid'";
          } else {
            $q_total = "SELECT COUNT(*) FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' ORDER BY dt DESC";
          }
          break;
        case 'best':
          if(!empty(_A_::$app->get('cat'))) {
            $cid = static::validData(_A_::$app->get('cat'));
            $q_total = "SELECT COUNT(*) FROM fabrix_products a" .
              " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
              " WHERE  a.pnumber is not null and a.best='1' and a.pvisible = '1' and b.cid='$cid'";
          } else {
            $q_total = "SELECT COUNT(*) FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' and best = '1'";
          }
          break;
        case 'specials':
          if(!empty(_A_::$app->get('cat'))) {
            $cid = static::validData(_A_::$app->get('cat'));
            $q_total = "SELECT COUNT(*) FROM fabrix_products a" .
              " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
              " WHERE  a.pnumber is not null and a.pvisible = '1' and a.specials='1' and b.cid='$cid'";
          } else {
            $q_total = "SELECT COUNT(*) FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' and specials='1' ORDER BY dt DESC";
          }
          break;
        case 'popular':
          if(!empty(_A_::$app->get('cat'))) {
            $cid = static::validData(_A_::$app->get('cat'));
            $q_total = "SELECT COUNT(*) FROM fabrix_products a" .
              " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
              " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cid'";
          } else {
            $q_total = "SELECT COUNT(*) FROM fabrix_products WHERE  pnumber is not null and pvisible = '1'";
          }
          break;
        case 'bsells':
          if(!empty(_A_::$app->get('cat'))) {
            $cid = static::validData(_A_::$app->get('cat'));
            $q_total = "select COUNT(n.pid)" .
              " from (SELECT a.pid, SUM(b.quantity) as s" .
              " FROM fabrix_products a" .
              " LEFT JOIN fabrix_order_details b ON a.pid = b.product_id" .
              " LEFT JOIN fabrix_product_categories pc ON a.pid = pc.pid and b.cid='$cid'" .
              " WHERE a.pnumber is not null and a.pvisible = '1'" .
              " GROUP BY a.pid" .
              " ORDER BY s DESC) m" .
              " LEFT JOIN fabrix_products n ON m.pid = n.pid";
          } else {
            $q_total = "select COUNT(n.pid)" .
              " from (SELECT a.pid, SUM(b.quantity) as s" .
              " FROM fabrix_products a" .
              " LEFT JOIN fabrix_order_details b ON a.pid = b.product_id" .
              " WHERE a.pnumber is not null and a.pvisible = '1'" .
              " GROUP BY a.pid" .
              " ORDER BY s DESC) m" .
              " LEFT JOIN fabrix_products n ON m.pid = n.pid";
          }
          break;
      }
      $res = mysql_query($q_total);
      $total = mysql_fetch_row($res)[0];
      return $total;
    }

    protected static function build_where(&$filter) {
      $result = "";
      if(isset($filter["a.pname"])) $result[] = "a.pname LIKE '%" . mysql_real_escape_string(static::validData($filter["a.pname"])) . "%'";
      if(isset($filter["a.pvisible"])) $result[] = "a.pvisible = '" . mysql_real_escape_string(static::validData($filter["a.pvisible"]))."'";
      if(isset($filter["a.piece"])) $result[] = "a.piece = '" . mysql_real_escape_string(static::validData($filter["a.piece"]))."'";
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
        $result = implode(" AND ", $result);
        if(strlen(trim($result)) > 0){
          $filter['active'] = true;
        }
      }
      $result = " a.pnumber is not null and a.pvisible = '1' AND " . $result;
      return $result;
    }

    public static function get_total_count($filter = null) {
      $response = 0;
      $query = "SELECT COUNT(DISTINCT a.pid) FROM " . static::$table . " a";
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
      $query .= " FROM " . static::$table . " a";
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
          $row['ldesc'] = substr($row['ldesc'], 0, 100);
          $filename = 'upload/upload/b_' . $row['image1'];
          if(!(file_exists($filename) && is_file($filename))) {
            $filename = 'upload/upload/not_image.jpg';
          }
          $row['filename'] = _A_::$app->router()->UrlTo($filename);

          $pid = $row['pid'];
          $price = $row['priceyard'];
          $inventory = $row['inventory'];
          $piece = $row['piece'];
          $format_price = '';
          $price = Model_Price::getPrintPrice($price, $format_price, $inventory, $piece);

          $discountIds = [];
          $saleprice = $row['priceyard'];
          $sDiscount = 0;
          $saleprice = Model_Price::calculateProductSalePrice($pid, $saleprice, $discountIds);
          $row['bProductDiscount'] = Model_Price::checkProductDiscount($pid, $sDiscount, $saleprice, $discountIds);
          $format_sale_price = '';
          $row['sDiscount'] = $sDiscount;
          $row['saleprice'] = Model_Price::getPrintPrice($saleprice, $format_sale_price, $inventory, $piece);
          $row['format_sale_price'] = $format_sale_price;
          $row['format_price'] = $format_price;
          $row['in_cart'] = in_array($row['pid'], $cart);
          $row['sys_hide_price'] = $sys_hide_price;
          $row['price'] = $price;

          $response[] = $row;
        }
      }
      return $response;
    }


    public static function get_total($search = null) {
      if(!empty(_A_::$app->get('cat'))) {
        $cid = static::validData(_A_::$app->get('cat'));
        $q_total = "SELECT COUNT(*) FROM fabrix_products a" .
          " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
          " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cid'";
        if(isset($search)) {
          $q_total .= " and (LOWER(a.pnumber) like '%" . $search . "%'" .
            " or LOWER(a.pname) like '%" . $search . "%'";
        }
      } else {
        if(!empty(_A_::$app->get('ptrn'))) {
          $ptrn_id = static::validData(_A_::$app->get('ptrn'));
          $q_total = "SELECT COUNT(*) FROM fabrix_products a" .
            " LEFT JOIN fabrix_product_patterns b ON a.pid = b.prodid " .
            " WHERE  a.pnumber is not null and a.pvisible = '1' and b.patternId='$ptrn_id'";

          if(isset($search)) {
            $q_total .= " and (LOWER(a.pnumber) like '%" . $search . "%'" .
              " or LOWER(a.pname) like '%" . $search . "%')";
          }
        } else {
          if(!empty(_A_::$app->get('mnf'))) {
            $mnf_id = static::validData(_A_::$app->get('mnf'));
            $q_total = "SELECT COUNT(*) FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' and manufacturerId = '$mnf_id'";
            if(isset($search)) {
              $q_total .= " and (LOWER(pnumber) like '%" . $search . "%'" .
                " or LOWER(pname) like '%" . $search . "%')";
            }
          } else {
            $q_total = "SELECT COUNT(*) FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' ";
            if(isset($search)) {
              $q_total .= " and (LOWER(pnumber) like '%" . $search . "%'" .
                " or LOWER(pname) like '%" . $search . "%')";
            }
          }
        }
      }

      $res = mysql_query($q_total);
      $total = mysql_fetch_row($res)[0];
      return $total;
    }

    public static function get_products($start, $per_page, &$res_count_rows, $search = null) {
      if(!empty(_A_::$app->get('cat'))) {
        $cid = static::validData(_A_::$app->get('cat'));
        $q = "SELECT a.* FROM fabrix_products a" .
          " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
          " WHERE  a.pnumber IS NOT NULL AND a.pvisible = '1' and b.cid='$cid'";

        if(isset($search)) {
          $q .= " and (LOWER(a.pnumber) like '%" . $search . "%'" .
            " or LOWER(a.pname) like '%" . $search . "%')";
        }

        $q .= " ORDER BY b.display_order LIMIT $start, $per_page";
      } else {
        if(!empty(_A_::$app->get('ptrn'))) {
          $ptrn_id = static::validData(_A_::$app->get('ptrn'));
          $q = "SELECT a.* FROM fabrix_products a" .
            " LEFT JOIN fabrix_product_patterns b ON a.pid = b.prodId " .
            " WHERE  a.pnumber IS NOT NULL AND a.pvisible = '1' and b.patternId='$ptrn_id'";

          if(isset($search)) {
            $q .= " and (LOWER(a.pnumber) like '%" . $search . "%'" .
              " or LOWER(a.pname) like '%" . $search . "%')";
          }
          $q .= " ORDER BY a.dt DESC, a.pid DESC LIMIT $start, $per_page";
        } else {
          if(!empty(_A_::$app->get('mnf'))) {
            $mnf_id = static::validData(_A_::$app->get('mnf'));
            $q = "SELECT * FROM fabrix_products WHERE  pnumber IS NOT NULL AND pvisible = '1' AND manufacturerId = '$mnf_id'";
            if(isset($search)) {
              $q .= " and (LOWER(pnumber) like '%" . $search . "%'" .
                " or LOWER(pname) like '%" . $search . "%')";
            }
            $q .= " ORDER BY dt DESC, pid DESC LIMIT $start,$per_page";
          } else {

            $q = "SELECT * FROM fabrix_products WHERE  pnumber IS NOT NULL AND pvisible = '1'";

            if(isset($search)) {
              $q .= " and (LOWER(pnumber) like '%" . $search . "%'" .
                " or LOWER(pname) like '%" . $search . "%')";
            }

            $q .= " ORDER BY dt DESC, pid DESC LIMIT $start, $per_page";
          }
        }
      }
      $q = mysql_query($q);
      $res = [];
      $res_count_rows = mysql_num_rows($q);
      if(is_resource($q)) {
        while($row = mysql_fetch_array($q)) {
          $res[] = $row;
        }
      }

      return $res;
    }

  }