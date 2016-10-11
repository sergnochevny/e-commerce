<?php

  Class Model_Admin extends Model_Model {

    public static function get_total_count($filter = null) {
      $response = 0;
      $query = "SELECT COUNT(*) FROM fabrix_admins";
      if(isset($filter)) {
        $query .= " WHERE";
      }
      if($result = mysql_query($query)) {
        $response = mysql_fetch_row($result)[0];
      }
      return $response;
    }

    public static function get_list($start, $limit, &$res_count_rows, $filter = null) {
      $response = null;
      $query = "SELECT * ";
      $query .= " FROM fabrix_admins";
      $query .= self::build_where($filter);
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
      $strSQL = "DELETE FROM fabrix_admins WHERE id = $id";
      mysql_query($strSQL);
    }

    public static function exist($login = null, $id = null) {
      if(is_null($login) && is_null($id)) {
        throw new ErrorException('Both parameters cannot be empty!');
      }
      $q = "select * from fabrix_admins where";
      if(isset($id)) $q .= " id <> '$id'";
      if(isset($login)) {
        if(isset($id)) $q .= " and";
        $q .= " login = '" . mysql_real_escape_string($login) . "'";
      }
      $result = mysql_query($q);

      return (!$result || mysql_num_rows($result) > 0);
    }

    public static function get_by_id($id) {
      $user = null;
      $strSQL = "select * from fabrix_admins where id = '" . $id . "'";
      $result = mysql_query($strSQL);
      if($result) {
        $user = mysql_fetch_assoc($result);
      }
      return $user;
    }

    public static function update_password($password, $id) {
      $result = mysql_query("UPDATE `fabrix_admins` SET `password` =  '$password' WHERE  `id` =$id;");
      if(!$result) throw new Exception(mysql_error());
    }

    public static function save($data) {
      extract($data);
      if(!isset($id)) {
        $q = "INSERT INTO  `fabrix_admins`" .
          "(`id` ,`login` ,`password`)" .
          "VALUES (NULL , '$login', '$password');";
      } else {
        $q = "UPDATE `fabrix_admins` SET" .
          " `login` = '" . $login;
        if(isset($password) && (strlen($password)>0)){
          $q .= "',`password` =  '" . $password;
        }
        $q .= "' WHERE  `id` = $id";
      }
      $result = mysql_query($q);
      if(!$result) throw new Exception(mysql_error());
      if(!isset($admin_id)) {
        $id = mysql_insert_id();
      }
      return $id;
    }

    public static function get_data($id) {
      $data = [
        'login' => '',
      ];
      if(isset($id)) {
        $rowsni = self::get_by_id($id);
        if(isset($rowsni)) {
          $data = [
            'login' => $rowsni['login'],
          ];
        }
      }
      return $data;
    }

  }