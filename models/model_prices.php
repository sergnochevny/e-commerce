<?php

  Class Model_Prices extends Model_Base {

    protected static $table = 'fabrix_products';

    protected static function build_where(&$filter) {
      if(isset($filter['hidden']['view']) && $filter['hidden']['view']) {
        $result = "";
        if(isset($filter["colour"])) $result[] = "a.colour LIKE '%" . mysql_real_escape_string(static::sanitize($filter["a.colour"])) . "%'";
        if(isset($filter["id"])) $result[] = "a.id = '" . mysql_real_escape_string(static::sanitize($filter["a.id"])) . "'";
        if(!empty($result) && (count($result) > 0)) {
          if(strlen(trim(implode(" AND ", $result))) > 0) {
            $filter['active'] = true;
          }
        }
        if(isset($filter['hidden']['c.pvisible'])) $result[] = "c.pvisible = '" . mysql_real_escape_string(static::sanitize($filter['hidden']["c.pvisible"])) . "'";
        if(!empty($result) && (count($result) > 0)) {
          $result = implode(" AND ", $result);
          $result = (!empty($result) ? " WHERE " . $result : '');
        }
      } else {
        $result = parent::build_where($filter);
      }
      return $result;
    }

    public static function get_total_count($filter = null) {
      $response = PRICE_GROUPS_COUNT;
      return $response;
    }

    public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null) {
      $response = null;
      $query = "SELECT MAX(a.priceyard) as max_price";
      $query .= " FROM " . static::$table . " a";
      $query .= static::build_where($filter);
      $query .= static::build_order($sort);

      $res_count_rows = PRICE_GROUPS_COUNT;

      if($result = mysql_query($query)) {
        $row = mysql_fetch_array($result);
        $max_price = $row['max_price'];
        $min_price = 0.00;
        $step = ($max_price - $min_price) / ($res_count_rows - 1);
        $limit = $limit + $start;
        if($limit > $res_count_rows) $limit = $res_count_rows;
        while($start < $limit) {
          $min_price = round($start++ * $step, 2);
          $max_price = round($start * $step, 2);
          $response[] = ['min_price' => $min_price, 'max_price' => $max_price];
        }
      }

      return $response;
    }
  }