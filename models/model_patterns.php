<?php

  Class Model_Patterns extends Model_Base {

    protected static $table = 'fabrix_patterns';

    protected static function build_where(&$filter) {
      if (isset($filter['hidden']['view']) && $filter['hidden']['view']){
        $result = "";
        if(Controller_Admin::is_logged()) {
          if (!empty($filter["a.pattern"]))
            foreach (array_filter(explode(' ', $filter["a.pattern"])) as $item)
              if (!empty($item)) $result[] = "a.pattern LIKE '%" . static::escape( static::strip_data(static::sanitize($item))) . "%'";
        } else {
          if(isset($filter["a.pattern"])) $result[] = Model_Synonyms::build_synonyms_like("a.pattern", $filter["a.pattern"]);
        }
        if(isset($filter["a.id"])) $result[] = "a.id = '" . static::escape( static::strip_data(static::sanitize($filter["a.id"]))) . "'";
        if(!empty($result) && (count($result) > 0)) {
          if(strlen(trim(implode(" AND ", $result))) > 0) {
            $filter['active'] = true;
          }
        }
        if(isset($filter['hidden']['c.pvisible'])) $result[] = "c.pvisible = '" . static::escape( static::strip_data(static::sanitize($filter['hidden']["c.pvisible"]))) . "'";
        if(!empty($result) && (count($result) > 0)) {
          $result = implode(" AND ", $result);
          $result = (!empty($result) ? " WHERE " . $result : '');
        }
      } else {
        $result = parent::build_where($filter);
      }
      return $result;
    }

    public static function get_by_id($id) {
      $response = [
        'id' => $id,
        'pattern' => ''
      ];
      if(isset($id)) {
        $query = "SELECT * FROM " . static::$table . " WHERE id='$id'";
        $result = static::query( $query);
        if($result) $response = static::fetch_assoc($result);
      }
      return $response;
    }

    public static function get_total_count($filter = null) {
      $response = 0;
      $query = "SELECT COUNT(DISTINCT a.id) FROM " . static::$table . " a";
      $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view'])? " INNER" : " LEFT";
      $query .= " JOIN fabrix_product_patterns b ON b.patternId = a.id";
      $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER JOIN fabrix_products c ON c.pid = b.prodId" : '';
      $query .= static::build_where($filter);
      if($result = static::query( $query)) {
        $response = static::fetch_row($result)[0];
      }
      return $response;
    }

    public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null) {
      $response = null;
      $query = "SELECT a.id, a.pattern, count(b.prodId) AS amount";
      $query .= " FROM " . static::$table . " a";
      $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view'])? " INNER" : " LEFT";
      $query .= " JOIN fabrix_product_patterns b ON b.patternId = a.id";
      $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER JOIN fabrix_products c ON c.pid = b.prodId" : '';
      $query .= static::build_where($filter);
      $query .= " GROUP BY a.id, a.pattern";
      $query .= static::build_order($sort);
      if ( $limit != 0 ) $query .= " LIMIT $start, $limit";

      if($result = static::query( $query)) {
        $res_count_rows = static::num_rows($result);
        while($row = static::fetch_array($result)) {
          $response[] = $row;
        }
      }

      return $response;
    }

    public static function save(&$data) {
      extract($data);
      if(isset($id)) {
        $query = "UPDATE " . static::$table . " SET pattern ='" . $pattern . "' WHERE id =" . $id;
        $res = static::query( $query);
        if(!$res) throw new Exception(static::error());
      } else {
        $query = "INSERT INTO " . static::$table . " (pattern) VALUE ('" . $pattern . "')";
        $res = static::query( $query);
        if(!$res) throw new Exception(static::error());
        $id = static::last_id() ;
      }
      return $id;
    }

    public static function delete($id) {
      if(isset($id)) {
        $query = "select count(*) from fabrix_product_patterns where patternId = $id";
        $res = static::query( $query);
        if($res) {
          $amount = static::fetch_array($res)[0];
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
        $query = "DELETE FROM  " . static::$table . " WHERE id = $id";
        $res = static::query( $query);
        if(!$res) throw new Exception(static::error());
      }
    }

  }