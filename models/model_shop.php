<?php

  Class Model_Shop extends Model_Base {

    protected static $table = 'fabrix_products';

    public static function get_total_count($filter = null) {
      $response = 0;
      $query = "SELECT COUNT(*) FROM " . static::$table;
      $query .= static::build_where($filter);
      if($result = mysql_query($query)) {
        $response = mysql_fetch_row($result)[0];
      }
      return $response;
    }

    public static function get_list($start, $limit, &$res_count_rows, $filter = null) {
      $response = null;
      $query = "SELECT * ";
      $query .= " FROM " . static::$table;
      $query .= static::build_where($filter);
      $query .= " ORDER BY pid DESC";
      $query .= " LIMIT $start, $limit";

      if($result = mysql_query($query)) {
        $res_count_rows = mysql_num_rows($result);
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
            $row['format_price'] = sprintf('%s / piece', $price);
          } else {
            $row['price'] = "$" . number_format($price, 2);
            $row['format_price'] = sprintf('%s / yard', $price);
          }
          $response[] = $row;
        }
      }
      return $response;
    }

    public static function get_by_id($id) {
      $data = [
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
        $q = "select * from " . static::$table . " where pid = '" . $id . "'";
        $result = mysql_query($q);
        if($result) {
          $data = mysql_fetch_assoc($result);
        }
      }
      return $data;
    }

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

    public static function del_product($del_p_id) {
      $strSQL = "DELETE FROM fabrix_products WHERE pid = $del_p_id";
      mysql_query($strSQL);

      $strSQL = "DELETE FROM fabrix_product_categories WHERE pid = $del_p_id";
      mysql_query($strSQL);

      $strSQL = "DELETE FROM fabrix_product_colours WHERE prodId = $del_p_id";
      mysql_query($strSQL);

      $strSQL = "DELETE FROM fabrix_product_patterns WHERE prodId = $del_p_id";
      mysql_query($strSQL);

      $strSQL = "DELETE FROM fabrix_specials_products WHERE pid = $del_p_id";
      mysql_query($strSQL);
    }

    public static function set_inventory($pid, $inventory = 0) {
      $q = "update fabrix_products set inventory=" . $inventory;
      $q .= ($inventory == 0) ? ", pvisible = 0" : "";
      $q .= " where pid=" . $pid;
      $res = mysql_query($q);
    }

    public static function get_product_params($pid) {

      $data = self::get_by_id($pid);
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

    public static function update_field($bd_g, $pid) {
      $result = mysql_query("update fabrix_products set $bd_g=null WHERE pid ='$pid'");
    }

    public static function dbUpdateMainPhoto($bd_g, $rest, $p_id) {
      $result = mysql_query("update fabrix_products set $bd_g='$rest' WHERE pid ='$p_id'");
    }

    public static function dbUpdateMainNew($image2, $bd_g, $image1, $p_id) {
      $result = mysql_query("update fabrix_products set image1='$image2', $bd_g='$image1' WHERE pid ='$p_id'");
    }

    public static function getPrName($p_id) {
      self::inc_popular($p_id);
      $resulthatistim = mysql_query("select * from fabrix_products WHERE pid='$p_id'");
      $rowsni = mysql_fetch_array($resulthatistim);

      $price = $rowsni[5];
      $inventory = $rowsni[6];
      $piece = $rowsni[34];

      return [
        'pname' => $rowsni['pname'],
        'pnumber' => $rowsni['pnumber'],
        'width' => $rowsni['width'],
        'priceyard' => $price,
        'ldesc' => $rowsni['ldesc'],
        'sdesc' => $rowsni['sdesc'],

        'image1' => $rowsni['image1'],
        'image2' => $rowsni['image2'],
        'image3' => $rowsni['image3'],
        'image4' => $rowsni['image4'],
        'image5' => $rowsni['image5'],
        'inventory' => $rowsni[6],
        'piece' => $rowsni[34],
        'dimensions' => $rowsni['dimensions'],
        'vis_price' => $rowsni['hideprice']
        //
      ];
    }

    public static function inc_popular($pid) {
      mysql_query("update fabrix_products set popular = popular+1 WHERE pid='$pid'");
    }

    public static function getCatName($cat_id) {
      $resulthatistim = mysql_query("select * from fabrix_categories WHERE cid='$cat_id'");
      $rowsni = mysql_fetch_array($resulthatistim);
      return $rowsni['cname'];
    }

    public static function getMnfName($mnf_id) {
      $resulthatistim = mysql_query("select * from fabrix_manufacturers WHERE id='$mnf_id'");
      $rowsni = mysql_fetch_array($resulthatistim);
      return $rowsni['manufacturer'];
    }

    public static function getPtrnName($ptrn_id) {
      $resulthatistim = mysql_query("select * from fabrix_patterns WHERE id='$ptrn_id'");
      $rowsni = mysql_fetch_array($resulthatistim);
      return $rowsni['pattern'];
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
            $cat_id = static::validData(_A_::$app->get('cat'));
            $q = "SELECT a.* FROM fabrix_products a" .
              " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
//                " WHERE  a.pnumber is not null and b.cid='$cat_id' ORDER BY a.dt DESC, a.pid DESC LIMIT $start,$per_page";
              " WHERE  a.pnumber is not null and b.cid='" . $cat_id . "'" .
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
            $cat_id = static::validData(_A_::$app->get('cat'));
            $q = "SELECT a.* FROM fabrix_products a" .
              " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
              " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cat_id' ORDER BY a.dt DESC, a.pid DESC LIMIT $start,$per_page";
          } else {
            $q = "SELECT * FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' ORDER BY  dt DESC, pid DESC LIMIT $start,$per_page";
          }
          break;
        case 'best':
          if(!empty(_A_::$app->get('cat'))) {
            $cat_id = static::validData(_A_::$app->get('cat'));
            $q = "SELECT a.* FROM fabrix_products a" .
              " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
              " WHERE  a.pnumber is not null and a.pvisible = '1'  and a.best = '1' and b.cid='$cat_id' ORDER BY a.dt DESC, a.pid DESC LIMIT $start,$per_page";
          } else {
            $q = "SELECT * FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' and best = '1' ORDER BY dt DESC, pid DESC LIMIT $start,$per_page";
          }
          break;
        case 'specials':
          if(!empty(_A_::$app->get('cat'))) {
            $cat_id = static::validData(_A_::$app->get('cat'));
            $q = "SELECT a.* FROM fabrix_products a" .
              " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
              " WHERE  a.pnumber is not null and a.pvisible = '1' and a.specials='1' and b.cid='$cat_id'" .
              " ORDER BY a.dt DESC, a.pid DESC LIMIT $start,$per_page";
          } else {
            $q = "SELECT * FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' and specials='1'" .
              " ORDER BY  dt DESC, pid DESC LIMIT $start,$per_page";
          }
          break;
        case 'popular':
          if(!empty(_A_::$app->get('cat'))) {
            $cat_id = static::validData(_A_::$app->get('cat'));
            $q = "SELECT a.* FROM fabrix_products a" .
              " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
              " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cat_id' ORDER BY popular DESC LIMIT $start,$per_page";
          } else {
            $q = "SELECT * FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' ORDER BY popular DESC LIMIT $start,$per_page";
          }
          break;
        case 'bsells':
          if(!empty(_A_::$app->get('cat'))) {
            $cat_id = static::validData(_A_::$app->get('cat'));
            $q = "select n.*" .
              " from (SELECT a.pid, SUM(b.quantity) as s" .
              " FROM fabrix_products a" .
              " LEFT JOIN fabrix_order_details b ON a.pid = b.product_id" .
              " LEFT JOIN fabrix_product_categories pc ON a.pid = pc.pid and b.cid='$cat_id'" .
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
            $cat_id = static::validData(_A_::$app->get('cat'));
            $q_total = "SELECT COUNT(*) FROM fabrix_products a" .
              " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
              " WHERE  a.pnumber is not null and b.cid='$cat_id'";
          } else {
            $q_total = "SELECT COUNT(*) FROM fabrix_products WHERE pnumber is not null ";
          }
          break;
        case 'last':
          if(!empty(_A_::$app->get('cat'))) {
            $cat_id = static::validData(_A_::$app->get('cat'));
            $q_total = "SELECT COUNT(*) FROM fabrix_products a" .
              " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
              " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cat_id'";
          } else {
            $q_total = "SELECT COUNT(*) FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' ORDER BY dt DESC";
          }
          break;
        case 'best':
          if(!empty(_A_::$app->get('cat'))) {
            $cat_id = static::validData(_A_::$app->get('cat'));
            $q_total = "SELECT COUNT(*) FROM fabrix_products a" .
              " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
              " WHERE  a.pnumber is not null and a.best='1' and a.pvisible = '1' and b.cid='$cat_id'";
          } else {
            $q_total = "SELECT COUNT(*) FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' and best = '1'";
          }
          break;
        case 'specials':
          if(!empty(_A_::$app->get('cat'))) {
            $cat_id = static::validData(_A_::$app->get('cat'));
            $q_total = "SELECT COUNT(*) FROM fabrix_products a" .
              " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
              " WHERE  a.pnumber is not null and a.pvisible = '1' and a.specials='1' and b.cid='$cat_id'";
          } else {
            $q_total = "SELECT COUNT(*) FROM fabrix_products WHERE  pnumber is not null and pvisible = '1' and specials='1' ORDER BY dt DESC";
          }
          break;
        case 'popular':
          if(!empty(_A_::$app->get('cat'))) {
            $cat_id = static::validData(_A_::$app->get('cat'));
            $q_total = "SELECT COUNT(*) FROM fabrix_products a" .
              " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
              " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cat_id'";
          } else {
            $q_total = "SELECT COUNT(*) FROM fabrix_products WHERE  pnumber is not null and pvisible = '1'";
          }
          break;
        case 'bsells':
          if(!empty(_A_::$app->get('cat'))) {
            $cat_id = static::validData(_A_::$app->get('cat'));
            $q_total = "select COUNT(n.pid)" .
              " from (SELECT a.pid, SUM(b.quantity) as s" .
              " FROM fabrix_products a" .
              " LEFT JOIN fabrix_order_details b ON a.pid = b.product_id" .
              " LEFT JOIN fabrix_product_categories pc ON a.pid = pc.pid and b.cid='$cat_id'" .
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

    public static function get_total($search = null) {
      if(!empty(_A_::$app->get('cat'))) {
        $cat_id = static::validData(_A_::$app->get('cat'));
        $q_total = "SELECT COUNT(*) FROM fabrix_products a" .
          " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
          " WHERE  a.pnumber is not null and a.pvisible = '1' and b.cid='$cat_id'";
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
        $cat_id = static::validData(_A_::$app->get('cat'));
        $q = "SELECT a.* FROM fabrix_products a" .
          " LEFT JOIN fabrix_product_categories b ON a.pid = b.pid " .
          " WHERE  a.pnumber IS NOT NULL AND a.pvisible = '1' and b.cid='$cat_id'";

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