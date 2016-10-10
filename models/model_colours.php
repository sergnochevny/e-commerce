<?php

  Class Model_Colours extends Model_Model {

    public static function get_by_id($id) {
      $response = [
        'colour' => ''
      ];
      if(isset($id)){
        $query = "SELECT * FROM fabrix_colour WHERE id='$id'";
        $result = mysql_query($query);
        if($result) $response = mysql_fetch_assoc($result);
      }
      return $response;
    }

    public static function get_total_count($filter = null) {
      $response = null;
      $query = "SELECT COUNT(*) FROM fabrix_colour";
      if(isset($filter)){
        $query .= " WHERE";
      }
      if($result = mysql_query($query)) {
        $response = mysql_fetch_row($result)[0];
      }
      return $response;
    }

    public static function save($data) {
      extract($data);
      if(isset($id)){
        $query = 'UPDATE fabrix_colour SET colour ="' . $colour . '" WHERE id =' . $id;
        $res = mysql_query($query);
        if (!$res) throw new Exception(mysql_error());

      } else {
        $query = 'INSERT INTO fabrix_colour (colour) VALUE ("' . $colour . '")';
        $res = mysql_query($query);
        if (!$res) throw new Exception(mysql_error());
        $id = mysql_insert_id();
      }
      return $id;
    }

    public static function get_list($start, $limit, &$res_count_rows, $filter = null) {
      $response = null;
      $query = "SELECT a.id, a.colour, count(b.prodId) AS amount";
      $query .= " FROM fabrix_colour a";
      $query .= " LEFT JOIN";
      $query .= " fabrix_product_colours b ON b.colourId = a.id";
      if(isset($filter)){
        $query .= " WHERE";
      }
      $query .= " GROUP BY a.id, a.colour";
      $query .= " ORDER BY a.colour";
      $query .= " LIMIT $start, $limit";

      if($result = mysql_query($query)) {
        $res_count_rows = mysql_num_rows($result);
        while($row = mysql_fetch_array($result)) {
          $response[] = $row;
        }
      }

      return $response;
    }

    public static function delete($id) {
      if(isset($id)){
        $query = "select count(*) from fabrix_product_colours where colourId = $id";
        $res = mysql_query($query);
        if ($res){
          $amount = mysql_fetch_array($res)[0];
          if(isset($amount) && ($amount > 0 )){
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
        $query = "DELETE FROM fabrix_colour WHERE id = $id";
        $res = mysql_query($query);
        if(!$res) throw new Exception(mysql_error());
      }
    }

  }