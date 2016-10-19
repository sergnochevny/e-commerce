<?php

  Class Model_Product extends Model_Base {

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

    public static function convert_image($uploaddir, $imagename) {

      $size = getimagesize($uploaddir . $imagename);
      $imgWidth = $size[0];
      $imgHeight = $size[1];

      $imagefrom = imagecreatefromjpeg($uploaddir . $imagename);

      $imagetovbig = imagecreatetruecolor(760, 569);
      imagecopyresampled($imagetovbig, $imagefrom, 0, 0, 0, 0, 760, 569, $imgWidth, $imgHeight);
      imagejpeg($imagetovbig, $uploaddir . "/v_" . $imagename, 85);
      imagedestroy($imagetovbig);

      $imagetobig = imagecreatetruecolor(230, 170);
      imagecopyresampled($imagetobig, $imagefrom, 0, 0, 0, 0, 230, 170, $imgWidth, $imgHeight);
      imagejpeg($imagetobig, $uploaddir . "/b_" . $imagename, 85);
      imagedestroy($imagetobig);

      $imagetosmall = imagecreatetruecolor(100, 70);
      imagecopyresampled($imagetosmall, $imagefrom, 0, 0, 0, 0, 100, 70, $imgWidth, $imgHeight);
      imagejpeg($imagetosmall, $uploaddir . "/" . $imagename, 85);
      imagedestroy($imagefrom);
    }

    public static function update_images($pid, &$data) {
      $fields_idx = [1, 2, 3, 4, 5];
      foreach($fields_idx as $idx) {
        $filename = $data['image' . $idx];
        if(!empty($filename)) {
          if(substr($filename, 0, strlen($pid) + 1) !== 'p' . $pid) {
            $filename = 'p' . $pid . $filename;
            if(file_exists("upload/upload/" . $data['image' . $idx])) {
              rename("upload/upload/" . $data['image' . $idx], "upload/upload/$filename");
            }
            if(file_exists("upload/upload/b_" . $data['image' . $idx])) {
              rename("upload/upload/b_" . $filename, "upload/upload/b_" . $filename);
            }
            if(file_exists("upload/upload/v_" . $data['image' . $idx])) {
              rename("upload/upload/v_" . $data['image' . $idx], "upload/upload/v_" . $filename);
            }
            $data['image' . $idx] = $filename;
          }
        }
      }
      extract($data);
      $q = "update ".static::$table." set image1='$image1', image2='$image2', image3='$image3', image4='$image4',image5='$image5'";
      return mysql_query($q);
    }

    public static function save($data) {
      extract($data);
      if(isset($pid)) {
        $sql = "update " . static::$table . " set" .
          " manufacturerId='$manufacturerId', weight_id='$weight_id', specials='$specials', inventory='$inventory'," .
          " dimensions='$dimensions', hideprice='$hideprice', stock_number='$stock_number', priceyard='$priceyard'," .
          " width='$width', pnumber='$pnumber', pvisible='$pvisible', metakeywords='$metakeywords'," .
          " metadescription='$metadescription', ldesc='$ldesc', pname='$pname', sdesc='$sdesc', best='$best'," .
          " piece='$piece', whole = '$whole'  WHERE pid ='$pid'";
        $result = mysql_query($sql);
      } else {
        $sql = "insert into " . static::$table . " set" .
          " manufacturerId='$manufacturerId', weight_id='$weight_id', specials='$specials', inventory='$inventory'," .
          " dimensions='$dimensions', hideprice='$hideprice', stock_number='$stock_number', priceyard='$priceyard'," .
          " width='$width', pnumber='$pnumber', pvisible='$pvisible', metakeywords='$metakeywords'," .
          " metadescription='$metadescription', ldesc='$ldesc', pname='$pname', sdesc='$sdesc', best='$best'," .
          " piece='$piece', whole = '$whole'";
        $result = mysql_query($sql);
        if($result) $pid = mysql_insert_id();
      }

      if($result) {
        if(!(isset($categories) && is_array($categories) && count($categories) > 0)) {
          $categories = ['1' => null];
        }
        $res = true;
        if(count($categories) > 0) {
          $res = mysql_query("select * from fabrix_product_categories  where pid='$pid'");
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
            foreach($categories as $cid => $category) {
              $res = $res && mysql_query("update fabrix_product_categories SET display_order=display_order+1 where display_order >= " . $category . " and cid='$cid'");
              $res = $res && mysql_query("REPLACE INTO fabrix_product_categories SET pid='$pid', cid='$cid', display_order = '$category'");
              if(!$res) break;
            }
          }
        }

        if($res && (count($colours) > 0)) {
          $res = $res && mysql_query("DELETE FROM fabrix_product_colours WHERE prodID='$pid'");
          foreach($colours as $colourId) {
            $res = $res && mysql_query("REPLACE INTO fabrix_product_colours SET prodID='$pid', colourId='$colourId'");
            if(!$res) break;
          }
        }

        if($res && (count($patterns) > 0)) {
          $res = $res && mysql_query("DELETE FROM fabrix_product_patterns WHERE prodID='$pid'");
          foreach($patterns as $patternId) {
            $res = $res && mysql_query("REPLACE INTO fabrix_product_patterns SET prodID='$pid', patternId='$patternId'");
            if(!$res) break;
          }
        }
      }
      $result = $result && $res;
      if(!$result) throw new Exception(mysql_error());
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