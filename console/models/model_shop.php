<?php

  Class Model_Shop extends Model_Base {

    protected static $table = 'fabrix_products';

    protected static function build_where(&$filter) {
      $result_where = "";
      $fields = !empty($filter['fields']) ? $filter['fields'] : [];
      foreach($fields as $field => $condition) {
        if(is_array($condition)) {
          $clause = $field . " ";
          $clause .= $condition['condition'] . " ";
          if(is_null($condition["value"]) || (strtolower($condition["value"]) == 'null')) {
            $clause .= ($condition['not'] ? "not " : "") . "null";
            $condition['not'] = false;
          } elseif($condition["condition"] == 'in') {
            if(is_array($condition["value"])) {
              $clause .= "(" . implode(', ', array_walk($condition["value"],
                  function(&$value) { $value = "'" . static::escape(static::strip_data(static::sanitize($value))) . "'"; })) . ")";
            } else {
              $clause .= "(" . "'" . static::escape(static::strip_data(static::sanitize($condition["value"]))) . "'" . ")";
            }
          } else {
            $clause .= "'" . static::escape(static::strip_data(static::sanitize($condition["value"]))) . "'";
          }
          $clause = ($condition['not'] ? "not (" . $clause . ")" : $clause);
        } else {
          $clause = $field . " ";
          $clause .= (is_null($condition) ? "is" : "=") . " ";
          $clause .= (is_null($condition) ? "null" : "'" . static::escape(static::strip_data(static::sanitize($condition["value"]))) . "'");
        }
        $result[] = $clause;
      }
      if(!empty($result) && (count($result) > 0)) {
        $result_where = implode(" AND ", $result);
        $result_where = (!empty($result_where) ? " WHERE " . $result_where : '');
      }
      return $result_where;
    }

    public static function prepare_layout_product($row) {
      $pid = $row['pid'];
      $price = $row['priceyard'];
      $inventory = $row['inventory'];
      $piece = $row['piece'];
      $price = Model_Price::getPrintPrice($price, $inventory, $piece);

      $discountIds = [];
      $saleprice = $row['priceyard'];
      $saleprice = Model_Price::calculateProductSalePrice($pid, $saleprice, $discountIds);
      $row['bProductDiscount'] = Model_Price::checkProductDiscount($pid, $saleprice, $discountIds);
      $row['saleprice'] = Model_Price::getPrintPrice($saleprice, $inventory, $piece);
      $row['price'] = $price;
      $row['Discount'] = (round(($price - $saleprice) * 100) != 0);
      return $row;
    }

    public static function get_widget_list_by_type($type, $start, $limit, &$res_count_rows) {
      $response = null;
      $q = "";
      switch($type) {
        case 'new':
          $q = "SELECT pid, priceyard, inventory, piece FROM fabrix_products WHERE priceyard > 0 and pnumber is not null and pvisible = '1' and image1 is not null ORDER BY dt DESC, pid DESC LIMIT " . $start . "," . $limit;
          break;
        case 'carousel':
          $image_suffix = 'b_';
          $q = "SELECT pid, priceyard, inventory, piece FROM fabrix_products WHERE priceyard > 0 and pnumber is not null and pvisible = '1' and image1 is not null ORDER BY dt DESC, pid DESC LIMIT " . $start . "," . $limit;
          break;
        case 'best':
          $q = "SELECT pid, priceyard, inventory, piece FROM fabrix_products WHERE priceyard > 0 and pnumber is not null and pvisible = '1' and best = '1' and image1 is not null ORDER BY pid DESC LIMIT " . $start . "," . $limit;
          break;
        case 'bestsellers':
          $q = "select n.pid, n.priceyard, n.inventory, n.piece" .
            " from (SELECT a.pid, SUM(b.quantity) as s" .
            " FROM fabrix_products a" .
            " LEFT JOIN fabrix_order_details b ON a . pid = b . product_id" .
            " WHERE a.priceyard > 0 and a.pnumber is not null and a.pvisible = '1' and a.image1 is not null" .
            " GROUP BY a . pid" .
            " ORDER BY s DESC" .
            " LIMIT " . $start . "," . $limit . ") m" .
            " LEFT JOIN fabrix_products n ON m.pid = n.pid";
          break;
        case 'popular':
          $q = "SELECT pid, priceyard, inventory, piece FROM fabrix_products WHERE priceyard > 0 and pnumber is not null and pvisible = '1' and image1 is not null ORDER BY popular DESC LIMIT " . $start . "," . $limit;
          break;
      }
      if($result = static::query($q)) {
        $res_count_rows = static::num_rows($result);
        while($row = static::fetch_assoc($result)) {
          $response[] = self::prepare_layout_product($row);
        }
      }
      return $response;
    }

    public static function get_total_count($filter = null) {
      $response = 0;
      if(isset($filter['type']) && ($filter['type'] == 'bestsellers')) {
        $query = "select COUNT(n.pid) from (";
        $query .= "SELECT a.pid, SUM(k.quantity) as s FROM " . static::$table . " a";
        $query .= " LEFT JOIN fabrix_order_details k ON a.pid = k.product_id";
      } else {
        $query = "SELECT COUNT(DISTINCT a.pid) FROM " . static::$table . " a";
      }
      $query .= " LEFT JOIN fabrix_product_categories ON a.pid = fabrix_product_categories.pid";
      $query .= " LEFT JOIN fabrix_categories b ON fabrix_product_categories.cid = b.cid";
      $query .= " LEFT JOIN fabrix_product_colors ON a.pid = fabrix_product_colors.prodId";
      $query .= " LEFT JOIN fabrix_color c ON fabrix_product_colors.colorId = c.id";
      $query .= " LEFT JOIN fabrix_product_patterns ON a.pid = fabrix_product_patterns.prodId";
      $query .= " LEFT JOIN fabrix_patterns d ON d.id = fabrix_product_patterns.patternId";
      $query .= " LEFT JOIN fabrix_manufacturers e ON a.manufacturerId = e.id";
      $query .= static::build_where($filter);
      if(isset($filter['type']) && ($filter['type'] == 'bestsellers')) {
        $query .= " GROUP BY a.pid";
        $query .= " ORDER BY s DESC) m";
        $query .= " LEFT JOIN fabrix_products n ON m.pid = n.pid";
      }
      if($result = static::query($query)) {
        $response = static::fetch_row($result)[0];
      }
      return $response;
    }

    public static function get_list($prepare, $start, $limit, &$res_count_rows, &$filter = null, &$sort = null) {
      $response = null;
      if(isset($filter['type']) && ($filter['type'] == 'bestsellers')) {
        $query = "select n.pid, n.priceyard, n.inventory, n.piece from (";
        $query .= "SELECT a.pid, SUM(k.quantity) as s FROM " . static::$table . " a";
        $query .= " LEFT JOIN fabrix_order_details k ON a.pid = k.product_id";
      } else {
        $query = "SELECT DISTINCT a.pid, a.priceyard, a.inventory, a.piece FROM " . static::$table . " a";
      }
      $query .= " LEFT JOIN fabrix_product_categories ON a.pid = fabrix_product_categories.pid";
      $query .= " LEFT JOIN fabrix_categories b ON fabrix_product_categories.cid = b.cid";
      $query .= " LEFT JOIN fabrix_product_colors ON a.pid = fabrix_product_colors.prodId";
      $query .= " LEFT JOIN fabrix_color c ON fabrix_product_colors.colorId = c.id";
      $query .= " LEFT JOIN fabrix_product_patterns ON a.pid = fabrix_product_patterns.prodId";
      $query .= " LEFT JOIN fabrix_patterns d ON d.id = fabrix_product_patterns.patternId";
      $query .= " LEFT JOIN fabrix_manufacturers e ON a.manufacturerId = e.id";
      $query .= static::build_where($filter);
      if(isset($filter['type']) && ($filter['type'] == 'bestsellers')) {
        $query .= " GROUP BY a.pid";
      }
      $query .= static::build_order($sort);
      if($limit != 0) $query .= " LIMIT $start, $limit";
      if(isset($filter['type']) && ($filter['type'] == 'bestsellers')) {
        $query .= ") m";
        $query .= " LEFT JOIN fabrix_products n ON m.pid = n.pid";
      }
      if($result = static::query($query)) {
        $res_count_rows = static::num_rows($result);
        while($row = static::fetch_assoc($result)) {
          if($prepare) {
            $response[$row['pid']] = self::prepare_layout_product($row);
          } else {
            $response[$row['pid']] = $row['pid'];
          }
        }
      }
      return $response;
    }

  }