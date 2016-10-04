<?php

  Class Model_Admin extends Model_Model {

    public static function get_total_count() {
      $total = 0;
      $q_total = "SELECT COUNT(*) FROM fabrix_admins";

      if($res = mysql_query($q_total)) {
        $total = mysql_fetch_row($res)[0];
      }

      return $total;
    }

    public static function get_list($start, $limit) {
      $list = [];
      $q = "SELECT * FROM fabrix_admins ORDER BY id LIMIT " . $start . ", " . $limit;
      if($res = mysql_query($q)) {
        while($row = mysql_fetch_array($res)) {
          $list[] = $row;
        }
      }
      return $list;
    }

    public static function del($admin_id) {
      $strSQL = "DELETE FROM fabrix_admins WHERE id = $admin_id";
      mysql_query($strSQL);
    }

    public static function is_exist($login = null, $id = null) {
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

    public static function update_password($password, $admin_id) {
      $result = mysql_query("UPDATE `fabrix_admins` SET `password` =  '$password' WHERE  `id` =$admin_id;");
      if(!$result) throw new Exception(mysql_error());
    }

    public static function save($login, $password, $admin_id) {
      if(!isset($admin_id)) {
        $q = "INSERT INTO  `fabrix_admins`" .
          "(`id` ,`login` ,`password`)" .
          "VALUES (NULL , '$login', '$password');";
      } else {
        $q = "UPDATE `fabrix_admins` SET" .
          " `login` = '" . $login .
          "' WHERE  `id` = $admin_id;";
      }
      $result = mysql_query($q);
      if(!$result) throw new Exception(mysql_error());
      if(!isset($admin_id)) {
        $admin_id = mysql_insert_id();
      }
      return $admin_id;
    }

    public static function get_admin_data($admin_id) {
      if(isset($admin_id)) {
        $rowsni = self::get_by_id($admin_id);
        if(isset($rowsni)) {
          $data = [
            'login' => $rowsni['login'],
          ];
        }
      } else {
        $data = [
          'login' => '',
        ];
      }
      return $data;
    }

  }