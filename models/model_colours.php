<?php

Class Model_Colours extends Model_Model
{
    public static function get_by_id($id)
    {
        $response = null;
        $query = "select * from fabrix_colour WHERE pid='$id'";
        $result = mysql_query($query);
        $response = mysql_fetch_assoc($result);
        return $response;
    }

    public static function amount(){
      $response = null;
      $query = "select COUNT(*) from fabrix_colour";
      if ($result = mysql_query($query)) {
        $response = mysql_fetch_row($result)[0];
      }
      return $response;
    }

    public static function get_sectioned_list($start, $limit, &$total)
    {
        $response = null;
        $query = "select * from fabrix_colour LIMIT " . $start . ", " . $limit;
        if ($result = mysql_query($query)) {
          $total = mysql_num_rows($result);
          while ($row = mysql_fetch_array($result)) {
            $response[] = $row;
          }
        }
        return $response;
    }

    public static function deleteById($id){
      $query = "DELETE FROM fabrix_colour WHERE id = $id";
      return mysql_query($query) ? true : false;
    }


}