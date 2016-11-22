<?php

  Class Model_Prices extends Model_Base {

    protected static $table = 'fabrix_products';

    protected static function build_where(&$filter) {
      if(isset($filter['hidden']['view']) && $filter['hidden']['view']) {
        $result = "";
        if(isset($filter['hidden']['a.priceyard'])) $result[] = "a.priceyard > '" . mysql_real_escape_string(static::sanitize($filter['hidden']["a.priceyard"])) . "'";
        if(isset($filter['hidden']['a.pvisible'])) $result[] = "a.pvisible = '" . mysql_real_escape_string(static::sanitize($filter['hidden']["a.pvisible"])) . "'";
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
      $query = "SELECT COUNT(a.pid) as count";
      $query .= " FROM " . static::$table . " a";
      $query .= static::build_where($filter);
      $query .= static::build_order($sort);

      $res_count_rows = PRICE_GROUPS_COUNT;

      if($result = mysql_query($query)) {
        $row = mysql_fetch_array($result);
        $count = $row['count'];
        $step = ceil($count / $res_count_rows);
        $limit = $limit + $start;
        if($limit > $res_count_rows) $limit = $res_count_rows;
//      true - Over UNION SELECT;
        if(true) {
          $query = '';
          while($start < $limit) {
            $from = $start++ * $step;
            if(!empty($query)) $query .= " UNION ";
            $query .= "SELECT MIN(s.priceyard) as min_price, MAX(s.priceyard) as max_price";
            $query .= " FROM (";
            $query .= "SELECT * FROM " . static::$table . " a";
            $query .= static::build_where($filter);
            $query .= " ORDER BY a.priceyard";
            $query .= " LIMIT " . $from . "," . $step;
            $query .= ") s";
          }
          if($result = mysql_query($query)) {
            while($row = mysql_fetch_array($result)) {
              $min_price = round($row['min_price']);
              $max_price = round($row['max_price']);
              $response[] = ['min_price' => $min_price, 'max_price' => $max_price];
            }
          }
        } else {
          while($start < $limit) {
            $from = (int)$start++ * $step;
            $query = "SELECT MIN(s.priceyard) as min_price, MAX(s.priceyard) as max_price";
            $query .= " FROM (";
            $query .= "SELECT * FROM " . static::$table . " a";
            $query .= static::build_where($filter);
            $query .= " ORDER BY a.priceyard";
            $query .= " LIMIT " . $from . "," . $step;
            $query .= ") s";
            if($result = mysql_query($query)) {
              $row = mysql_fetch_array($result);
              $response[] = ['min_price' => $row['min_price'], 'max_price' => $row['max_price']];
            }
          }
        }
      }
      return $response;
    }

  }