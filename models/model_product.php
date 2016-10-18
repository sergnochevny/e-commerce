<?php

  Class Model_Product extends Model_Model {

    protected static $table = 'fabrix_products';

    public static function get_filter_selected($type, &$data) {
      $id = $data['pid'];
      $filters = [];
      switch($type) {
        case 'colours':
          $colours = isset($data['colours']) ? array_keys($data['colours']) : [];
          if(isset($data['colours_select']) || isset($data['colours']))
            $select = implode(',', array_merge(isset($data['colours_select']) ? $data['colours_select'] : [], $colours));
          else {
            $data['colours'] = self::get_filter_selected_data($type, $id);
            $select = implode(',', isset($data['colours']) ? array_keys($data['colours']) : []);
          }
          if(strlen($select) > 0) {
            $results = mysql_query(
              "select * from fabrix_colour" .
              " where id in ($select)" .
              " order by colour"
            );
            while($row = mysql_fetch_array($results)) {
              $filters[$row[0]] = $row[1];
            }
          }
          break;
        case 'patterns':
          $patterns = isset($data['patterns']) ? array_keys($data['patterns']) : [];
          if(isset($data['patterns_select']) || isset($data['patterns']))
            $select = implode(',', array_merge(isset($data['patterns_select']) ? $data['patterns_select'] : [], $patterns));
          else {
            $data['patterns'] = self::get_filter_selected_data($type, $id);
            $select = implode(',', isset($data['patterns']) ? array_keys($data['patterns']) : []);
          }
          if(strlen($select) > 0) {
            $results = mysql_query(
              "select * from fabrix_patterns" .
              " where id in ($select)" .
              " order by pattern"
            );
            while($row = mysql_fetch_array($results)) {
              $filters[$row[0]] = $row[1];
            }
          }
          break;
        case 'categories':
          $categories = isset($data['categories']) ? array_keys($data['categories']) : [];
          if(isset($data['categories_select']) || isset($data['categories'])) {
            $select = implode(',', array_merge(isset($data['categories_select']) ? $data['categories_select'] : [], $categories));
            $categories = $data['categories'];
          } else {
            $data['categories'] = self::get_filter_selected_data($type, $id);
            $select = implode(',', isset($data['categories']) ? array_keys($data['categories']) : []);
            $categories = isset($data['categories']) ? $data['categories'] : [];
            foreach($categories as $key => $val) {
              $categories[$key] = $val[1];
            }
          }
          if(strlen($select) <= 0) $select = '1';
          $results = mysql_query(
            "select a.cid, a.cname, (max(b.display_order)+1) as pos from fabrix_categories a" .
            " left join fabrix_product_categories b on b.cid = a.cid" .
            " where a.cid in ($select)" .
            " group by a.cid, a.cname" .
            " order by a.cname"
          );
          while($row = mysql_fetch_array($results)) {
            $filters[$row[0]] = [$row[1], isset($categories[$row[0]]) ? $categories[$row[0]] : $row[2]];
          }
          break;
      }
      $data[$type] = $filters;
    }

    public static function get_filter_selected_data($type, $id) {
      $data = [];
      switch($type) {
        case 'patterns':
          $results = mysql_query(
            "select a.* from fabrix_product_patterns b" .
            " inner join fabrix_patterns a on b.patternId=a.id " .
            " where b.prodId='$id'" .
            " order by a.pattern"
          );
          if($results)
            while($row = mysql_fetch_array($results)) {
              $data[$row[0]] = $row[1];
            }
          break;
        case 'colours':
          $results = mysql_query(
            "select a.* from fabrix_product_colours b" .
            " inner join fabrix_colour a on b.colourId=a.id " .
            " where b.prodId='$id'" .
            " order by a.colour"
          );
          if($results)
            while($row = mysql_fetch_array($results)) {
              $data[$row[0]] = $row[1];
            }
          break;
        case 'categories':
          $results = mysql_query(
            "select a.cid, a.cname, b.display_order from fabrix_product_categories b" .
            " inner join fabrix_categories a on b.cid=a.cid " .
            " where b.pid='$id'" .
            " order by a.cname"
          );
          if($results)
            while($row = mysql_fetch_array($results)) {
              $data[$row[0]] = [$row[1], $row[2]];
            }
          break;
        case 'manufacturers':
          $results = mysql_query(
            "select a.cid, a.manufacturer" .
            " from fabrix_manufacturers a" .
            " order by a.manufacturer"
          );
          if($results)
            while($row = mysql_fetch_array($results)) {
              $data[$row[0]] = $row[1];
            }
          break;
      }
      return $data;
    }

    public static function get_filter_data($type, &$count, $start = 0, $search = null) {
      $filter = null;
      $FILTER_LIMIT = FILTER_LIMIT;
      $start = isset($start) ? $start : 0;
      $search = mysql_escape_string(static::validData($search));
      switch($type) {
        case 'colours':
          $q = "select count(id) from fabrix_colour";
          if(isset($search) && (strlen($search) > 0)) {
            $q .= " where colour like '%$search%'";
            $q .= " or colour like '%$search%'";
          }
          $results = mysql_query($q);
          $row = mysql_fetch_array($results);
          $count = $row[0];
          $q = "select * from fabrix_colour";
          if(isset($search) && (strlen($search) > 0)) {
            $q .= " where colour like '%$search%'";
            $q .= " or colour like '%$search%'";
          }
          $q .= " order by colour";
          $q .= " limit $start, $FILTER_LIMIT";
          $results = mysql_query($q);
          while($row = mysql_fetch_array($results)) {
            $filter[] = [$row[0], $row[1]];
          }
          break;
        case 'patterns':
          $q = "select count(id) from fabrix_patterns";
          if(isset($search) && (strlen($search) > 0)) {
            $q .= " where pattern like '%$search%'";
          }
          $results = mysql_query($q);
          $row = mysql_fetch_array($results);
          $count = $row[0];
          $q = "select * from fabrix_patterns";
          if(isset($search) && (strlen($search) > 0)) {
            $q .= " where pattern like '%$search%'";
          }
          $q .= " order by pattern";
          $q .= " limit $start, $FILTER_LIMIT";
          $results = mysql_query($q);
          while($row = mysql_fetch_array($results)) {
            $filter[] = [$row[0], $row[1]];
          }
          break;
        case 'categories':
          $q = "select count(cid) from fabrix_categories";
          if(isset($search) && (strlen($search) > 0)) {
            $q .= " where cname like '%$search%'";
          }
          $results = mysql_query($q);
          $row = mysql_fetch_array($results);
          $count = $row[0];
          $q = "select * from fabrix_categories";
          if(isset($search) && (strlen($search) > 0)) {
            $q .= " where cname like '%$search%'";
          }
          $q .= " order by cname";
          $q .= " limit $start, $FILTER_LIMIT";
          $results = mysql_query($q);
          while($row = mysql_fetch_array($results)) {
            $filter[] = [$row[0], $row[1]];
          }
      }
      return $filter;
    }

    public static function get_manufacturers() {
      $data = [];
      $q = "select * from fabrix_manufacturers order by manufacturer";
      $results = mysql_query($q);
      while($row = mysql_fetch_array($results)) {
        $data[$row[0]] = $row[1];
      }
      return $data;
    }

    public static function get_info(&$data = null) {
      if(isset($data)) {
        $pid = $data['pid'];
        if(isset($pid)) {
          $manufacturerId = $data['manufacturerId'];
          if(empty($manufacturerId)) {
            $manufacturerId = "0";
          }
          $data['manufacturers'] = self::get_manufacturers();
          $categories = isset($data['categories']) ? $data['categories'] : [];

          if(count($categories) < 1) {
            $result = mysql_query(
              "select a.cname, max(b.display_order)+1" .
              " from fabrix_categories a" .
              " left join fabrix_product_categories b on a.cid = b.cid" .
              " WHERE a.cid=1"
            );
            $row = mysql_fetch_array($result, MYSQL_NUM);
            $categories['1'] = [$row[0], $row[1]];
          }
          $data['categories'] = $categories;
        }
      }
    }

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

    public static function images($pid) {
      $res = mysql_query("select * from fabrix_products WHERE pid='$pid'");
      $data = mysql_fetch_assoc($res);
      return ['image1' => $data['image1'], 'image2' => $data['image2'], 'image3' => $data['image3'], 'image4' => $data['image4'], 'image5' => $data['image5']];
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
      self::PopularPlus($p_id);
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

    public static function PopularPlus($p_id) {
      mysql_query("update fabrix_products set popular = popular+1 WHERE pid='$p_id'");
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
            " LEFT JOIN blog_group_posts c on a.group_id = c.group_id" .
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

    public static function save($p_id, $post_categories, $patterns, $colors, $post_manufacturer, $New_Manufacturer, $post_new_color, $pattern_type, $post_weight_cat, $post_special, $post_curret_in, $post_dimens, $post_hide_prise, $post_st_nom, $post_p_yard, $post_width, $post_product_num, $post_vis, $post_mkey, $post_desc, $post_Long_description, $post_tp_name, $post_short_desk, $best, $piece, $whole) {
      if(!empty($New_Manufacturer)) {
        $result = mysql_query("INSERT INTO fabrix_manufacturers set manufacturer='$New_Manufacturer'");
        if($result) $post_manufacturer = mysql_insert_id();
      }
      if(!empty($post_new_color)) {
        $result = mysql_query("INSERT INTO fabrix_colour set colour='$post_new_color'");
        if($result) $colors[] = mysql_insert_id();
      }
      if(!empty($pattern_type)) {
        $result = mysql_query("INSERT INTO fabrix_patterns SET pattern='$pattern_type'");
        if($result) $patterns[] = mysql_insert_id();
      }

      $sql = "update fabrix_products set manufacturerId='$post_manufacturer', weight_id='$post_weight_cat', specials='$post_special', inventory='$post_curret_in', dimensions='$post_dimens', hideprice='$post_hide_prise', stock_number='$post_st_nom', priceyard='$post_p_yard', width='$post_width', pnumber='$post_product_num', pvisible='$post_vis', metakeywords='$post_mkey', metadescription='$post_desc', ldesc='$post_Long_description', pname='$post_tp_name', sdesc='$post_short_desk', best = '$best', piece='$piece', whole = '$whole'  WHERE pid ='$p_id'";

      $result = mysql_query($sql);

      if($result) {
        if(!(isset($post_categories) && is_array($post_categories) && count($post_categories) > 0)) {
          $post_categories = ['1' => null];
        }
        $res = true;
        if(count($post_categories) > 0) {
          $res = mysql_query("select * from fabrix_product_categories  where pid='$p_id'");
          if($res) {
            $result = $res;
            while($category = mysql_fetch_assoc($res)) {
              $result = $result && mysql_query("DELETE FROM fabrix_product_categories WHERE pid = " . $category['pid'] . " and cid = " . $category['cid']);
              $result = $result && mysql_query("update fabrix_product_categories SET display_order=display_order-1 where display_order > " . $category['display_order'] . " and cid=" . $category['cid']);
              if(!$result) {
                $res = $result;
                break;
              }
            }
          }
          if($res) {
            foreach($post_categories as $cid => $category) {
              $res = $res && mysql_query("update fabrix_product_categories SET display_order=display_order+1 where display_order >= " . $category . " and cid='$cid'");
              $res = $res && mysql_query("REPLACE INTO fabrix_product_categories SET pid='$p_id', cid='$cid', display_order = '$category'");
              if(!$res) break;
            }
          }
        }

        if($res && (count($colors) > 0)) {
          $res = $res && mysql_query("DELETE FROM fabrix_product_colours WHERE prodID='$p_id'");
          foreach($colors as $colourId) {
            $res = $res && mysql_query("REPLACE INTO fabrix_product_colours SET prodID='$p_id', colourId='$colourId'");
            if(!$res) break;
          }
        }

        if($res && (count($patterns) > 0)) {
          $res = $res && mysql_query("DELETE FROM fabrix_product_patterns WHERE prodID='$p_id'");
          foreach($patterns as $patternId) {
            $res = $res && mysql_query("REPLACE INTO fabrix_product_patterns SET prodID='$p_id', patternId='$patternId'");
            if(!$res) break;
          }
        }
      }
      $result = $result && $res;
      if(!$result) throw new Exception(mysql_error());
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

    public static function delete($id) {
      if(isset($id)) {
        $query = "DELETE FROM " . static::$table . " WHERE pid = $id";
        $res = mysql_query($query);
        $query = "DELETE FROM fabrix_product_categories WHERE pid = $id";
        if($res) $res = mysql_query($query);
        $query = "DELETE FROM fabrix_product_colours WHERE prodId = $id";
        if($res) $res = mysql_query($query);
        $query = "DELETE FROM fabrix_product_patterns WHERE prodId = $id";
        if($res) $res = mysql_query($query);
        $query = "DELETE FROM fabrix_specials_products WHERE pid = $id";
        if($res) $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      }
    }

  }