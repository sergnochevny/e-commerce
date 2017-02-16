<?php

  Class Model_Admin extends Model_Base {

    protected static $table = 'fabrix_admins';

    public static function get_total_count($filter = null) {
      $response = 0;
      $query = "SELECT COUNT(*) FROM " . static::$table;
      $query .= static::build_where($filter);
      if($result = static::query( $query)) {
        $response = static::fetch_row($result)[0];
      }
      return $response;
    }

    public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null) {
      $response = null;
      $query = "SELECT * ";
      $query .= " FROM " . static::$table;
      $query .= static::build_where($filter);
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

    public static function delete($id) {
      $strSQL = "DELETE FROM " . static::$table . " WHERE id = $id";
      static::query( $strSQL);
    }

    public static function exist($login = null, $id = null) {
      if(is_null($login) && is_null($id)) {
        throw new ErrorException('Both parameters cannot be empty!');
      }
      $q = "select * from " . static::$table . " where";
      if(isset($id)) $q .= " id <> '$id'";
      if(isset($login)) {
        if(isset($id)) $q .= " and";
        $q .= " login = '" . static::escape( $login) . "'";
      }
      $result = static::query( $q);

      return (!$result || static::num_rows($result) > 0);
    }

    public static function get_by_id($id) {
      $data = [
        'id' => $id,
        'login' => ''
      ];
      if(isset($id)) {
        $strSQL = "select * from " . static::$table . " where id = '" . $id . "'";
        $result = static::query( $strSQL);
        if($result) {
          $data = static::fetch_assoc($result);
        }
      }
      return $data;
    }

    public static function update_password($password, $id) {
      $result = static::query( "UPDATE " . static::$table . " SET password =  '$password' WHERE  id =$id;");
      if(!$result) throw new Exception(static::error());
    }

    public static function save(&$data) {
      extract($data);
      /**
       * @var string $login
       * @var string $password
       */
      if(!isset($id)) {
        $q = "INSERT INTO  " . static::$table .
          "(id ,login ,password)" .
          "VALUES (NULL , '$login', '$password');";
      } else {
        $q = "UPDATE " . static::$table . " SET" .
          " login = '" . $login;
        if(isset($password) && (strlen($password) > 0)) {
          $q .= "',password = '" . $password;
        }
        $q .= "' WHERE  id = $id";
      }
      $result = static::query( $q);
      if(!$result) throw new Exception(static::error());
      if(!isset($admin_id)) {
        $id = static::last_id() ;
      }
      return $id;
    }

  }