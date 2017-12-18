<?php

class Model_Console extends Model_Base{

  protected static function build_where(&$filter, &$prms = null){
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
                function(&$value){
                  $value = "'" . static::prepare_for_sql($value) . "'";
                })) . ")";
          } else {
            $clause .= "(" . "'" . static::prepare_for_sql($condition["value"]) . "'" . ")";
          }
        } else {
          $clause .= "'" . static::prepare_for_sql($condition["value"]) . "'";
        }
        $clause = ($condition['not'] ? "not (" . $clause . ")" : $clause);
      } else {
        $clause = $field . " ";
        $clause .= (is_null($condition) ? "is" : "=") . " ";
        $clause .= (is_null($condition) ? "null" : "'" . static::prepare_for_sql($condition["value"]) . "'");
      }
      $result[] = $clause;
    }
    if(!empty($result) && (count($result) > 0)) {
      $result_where = implode(" AND ", $result);
      $result_where = (!empty($result_where) ? " WHERE " . $result_where : '');
    }

    return $result_where;
  }

  public static function get_total_count($filter = null){
    $response = 0;
    $query = "SELECT COUNT(*) FROM " . static::$table;
    if(!empty($filter)) $query .= static::build_where($filter);
    if($result = static::query($query)) {
      $response = static::fetch_value($result);
      static::free_result($result);
    } else {
      throw new Exception(static::error());
    }

    return $response;
  }

  public static function get_one($filter){
    $data = null;
    if(!empty($filter)) {
      $query = "SELECT * FROM " . static::$table;
      $query .= static::build_where($filter);
      $query .= static::build_order($sort);
      $result = static::query($query);
      if($result) {
        $data = static::fetch_assoc($result);
      } else {
        throw new Exception(static::error());
      }
    }

    return $data;
  }

  public static function get_list($prepare, $start, $limit, &$res_count_rows, &$filter = null, &$sort = null){
    $response = null;
    $query = "SELECT * FROM " . static::$table;
    $query .= static::build_where($filter);
    $query .= static::build_order($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";
    if($result = static::query($query)) {
      $res_count_rows = static::num_rows($result);
      while($row = static::fetch_assoc($result)) {
        $response[] = $row;
      }
    } else {
      throw new Exception(static::error());
    }

    return $response;
  }

  public static function save($data){
    $res = false;
    if(!empty($data)) {
      $query = "REPLACE INTO `" . static::$table . "`";
      $fields = '';
      $values = '';
      foreach($data as $field => $value) {
        $fields .= (strlen($fields) ? ", " : "") . "`" . $field . "`";
        $values .= (strlen($values) ? ", " : "") . "'" . static::prepare_for_sql($value) . "'";
      }
      $query .= "(" . $fields . ") VALUES(" . $values . ")";
      if(!static::query($query)) throw new Exception(static::error());
    }

    return $res;
  }

  public static function delete($where){
    $query = "DELETE FROM " . static::$table;
    $query .= static::build_where($where);
    if(!($res = static::query($query))) throw new Exception(static::error());

    return $res;
  }

}