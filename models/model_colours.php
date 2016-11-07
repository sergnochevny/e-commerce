<?php

  Class Model_Colours extends Model_Base {

    protected static $table = 'fabrix_colour';

    protected static function build_order(&$sort) {
      if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
        $sort = ['a.colour' => 'asc'];
      }
      return parent::build_order($sort);
    }

    public static function get_by_id($id) {
      $response = [
        'id' => $id,
        'colour' => ''
      ];
      if(isset($id)) {
        $query = "SELECT * FROM " . static::$table . " WHERE id='$id'";
        $result = mysql_query($query);
        if($result) $response = mysql_fetch_assoc($result);
      }
      return $response;
    }

    public static function get_total_count($filter = null) {
      $response = 0;
      $query = "SELECT COUNT(DISTINCT a.id) FROM " . static::$table;
      $query .= " LEFT JOIN fabrix_product_colours b ON b.colourId = a.id";
      $query .= static::build_where($filter);
      if($result = mysql_query($query)) {
        $response = mysql_fetch_row($result)[0];
      }
      return $response;
    }

    public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null) {
      $response = null;
      $query = "SELECT a.id, a.colour, count(b.prodId) AS amount";
      $query .= " FROM " . static::$table . " a";
      $query .= " LEFT JOIN fabrix_product_colours b ON b.colourId = a.id";
      $query .= static::build_where($filter);
      $query .= " GROUP BY a.id, a.colour";
      $query .= static::build_order($sort);
      if ( $limit != 0 ) $query .= " LIMIT $start, $limit";

      if($result = mysql_query($query)) {
        $res_count_rows = mysql_num_rows($result);
        while($row = mysql_fetch_array($result)) {
          $response[] = $row;
        }
      }

      return $response;
    }

    public static function save(&$data) {
      extract($data);
      if(isset($id)) {
        $query = 'UPDATE ' . static::$table . ' SET colour ="' . $colour . '" WHERE id =' . $id;
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      } else {
        $query = 'INSERT INTO ' . static::$table . '(colour) VALUE ("' . $colour . '")';
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
        $id = mysql_insert_id();
      }
      return $id;
    }

    public static function delete($id) {
      if(isset($id)) {
        $query = "SELECT COUNT(*) FROM fabrix_product_colours WHERE colourId = $id";
        $res = mysql_query($query);
        if($res) {
          $amount = mysql_fetch_array($res)[0];
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
        $query = "DELETE FROM " . static::$table . " WHERE id = $id";
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      }
    }

  }