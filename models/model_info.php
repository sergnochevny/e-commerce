<?php

  Class Model_Info extends Model_Base {

    protected static $table = 'info_messages';

    protected static function build_where(&$filter) {
      $result = "";
      if(isset($filter['hidden']['id']) && !is_array($filter['hidden']['priceyard'])) $result[] = "a.id = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter['hidden']["id"]))) . "'";
      if(isset($filter['hidden']['visible'])) $result[] = "visible = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter['hidden']["visible"]))) . "'";
      if(isset($filter['hidden']["f1"])) $result[] = "f1 = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter['hidden']["f1"]))) . "'";
      if(isset($filter['hidden']["f2"])) $result[] = "f2 = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter['hidden']["f2"]))) . "'";
      if(!empty($result) && (count($result) > 0)) {
        $result = implode(" AND ", $result);
        $result = (!empty($result) ? " WHERE " . $result : '');
      }
      return $result;
    }

    public static function get_by_f1($filter) {
      $data = null;
      $q = "SELECT * FROM " . static::$table;
      $q .= self::build_where($filter);
      $q .= ' LIMIT 1';
      $result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q);
      if($result) $data = mysqli_fetch_assoc($result);
      return $data;
    }

    public static function get_by_id($id) {
      $data = null;
      if(isset($id)) {
        $q = "select * from " . static::$table . " where id = '" . $id . "'";
        $result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q);
        if($result) {
          $data = mysqli_fetch_assoc($result);
        }
      }
      return $data;
    }

    public static function get_total_count($filter = null) {
      $res = 0;
      $q = "SELECT COUNT(a.id) FROM " . static::$table;
      $q .= self::build_where($filter);
      $result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q);
      if($result) {
        $row = mysqli_fetch_array($result);
        $res = $row[0];
      }
      return $res;
    }

    public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null) {
      $res = null;
      $q = "SELECT * FROM " . static::$table;
      $q .= self::build_where($filter);
      $q .= static::build_order($sort);
      if($limit != 0) $q .= " LIMIT $start, $limit";
      $result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q);
      if($result) {
        $res_count_rows = mysqli_num_rows($result);
        while($row = mysqli_fetch_assoc($result)) {
          $res[] = $row;
        }
      }
      return $res;
    }

    public static function save(&$data) {
      extract($data);
      $title = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $title);
      $message = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $message);
      if(isset($f1)) {
        $q = "UPDATE " . static::$table .
          " SET" .
          " title='$title'," .
          " message='$message'," .
          " visible='$visible'," .
          " f2='$f2'" .
          " WHERE f1 ='$f1'";
        $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q);
      } else {
        $q = "INSERT INTO " . static::$table .
          " SET" .
          " title='$title'," .
          " message='$message'," .
          " visible='$visible'," .
          " f1='$f1'";
        " f2='$f2'";

        $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q);
      }
      if(!$res) throw new Exception(mysqli_error(_A_::$app->getDBConnection('iluvfabrix')));
      return $f1;
    }

    public static function delete($id) {
      mysqli_query("DELETE FROM " . static::$table . " WHERE id = '$id'");
    }

  }