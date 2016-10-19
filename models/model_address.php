<?php

  Class Model_Address extends Model_Base {

    public static function get_countries_all() {
      $list = [];
      $q = "SELECT * FROM fabrix_countries ORDER BY display_order, name";
      if($res = mysql_query($q)) {
        while($row = mysql_fetch_array($res)) {
          $list[] = $row;
        }
      }

      return $list;
    }

    public static function get_province_all() {
      $list = [];
      $q = "SELECT * FROM fabrix_state ORDER BY name";
      if($res = mysql_query($q)) {
        while($row = mysql_fetch_array($res)) {
          $list[] = $row;
        }
      }

      return $list;
    }

    public static function get_country_state($country) {
      $list = [];
      $q = "SELECT * FROM fabrix_state WHERE country = '$country' ORDER BY name";
      if($res = mysql_query($q)) {
        while($row = mysql_fetch_array($res)) {
          $list[] = $row;
        }
      }

      return $list;
    }

    public static function get_country_by_id($id) {
      $country = '';
      $q = "SELECT * FROM fabrix_countries WHERE id = '$id'";
      if($res = mysql_query($q)) {
        $row = mysql_fetch_array($res);
        $country = trim($row['name']);
      }
      return $country;
    }

    public static function get_province_by_id($id) {
      $province = '';
      $q = "SELECT * FROM fabrix_state WHERE id = '$id'";
      if($res = mysql_query($q)) {
        $row = mysql_fetch_array($res);
        $province = trim($row['name']);
      }
      return $province;
    }

  }