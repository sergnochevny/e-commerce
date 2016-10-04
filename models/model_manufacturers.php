<?php

Class Model_Manufacturers extends Model_Model
{
    public static function get_by_id($id)
    {
        $response = null;
        $query = "SELECT * FROM fabrix_manufacturers WHERE id='$id'";
        $result = mysql_query($query);
        $response = mysql_fetch_assoc($result);
        return $response;
    }

    public static function amount(){
      $response = null;
      $query = "SELECT COUNT(*) FROM fabrix_manufacturers";
      if ($result = mysql_query($query)) {
        $response = mysql_fetch_row($result)[0];
      }
      return $response;
    }

    public static function create($name){
      $query = 'INSERT INTO fabrix_manufacturers (manufacturer) VALUE ("'.$name.'")';
      return mysql_query($query) ? true : false;
    }

    public static function update($id, $name){
      $query = 'UPDATE fabrix_manufacturers SET manufacturer ="'.$name.'" WHERE id ='.$id;
      return mysql_query($query) ? true : false;
    }

    public static function get_sectioned_list($start, $limit, &$total)
    {
        $response = null;
        $query = "
            SELECT a.id, a.manufacturer, count(b.manufacturerId)
              AS amount
            FROM
              fabrix_manufacturers a
              LEFT JOIN
              fabrix_products b
                ON b.manufacturerId = a.id
            GROUP BY a.id, a.manufacturer
            LIMIT " . $start . ", " . $limit;

        if ($result = mysql_query($query)) {
          $total = mysql_num_rows($result);
          while ($row = mysql_fetch_array($result)) {
            $response[] = $row;
          }
        }

        return $response;
    }

    public static function deleteById($id){
      $query = "DELETE FROM fabrix_manufacturers WHERE id = $id";
      return mysql_query($query) ? true : false;
    }


}