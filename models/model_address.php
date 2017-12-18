<?php

class Model_Address extends Model_Base{

  public static function get_countries_all(){
    $list = [];
    $q = "SELECT * FROM countries ORDER BY display_order, name";
    if($res = static::query($q)) {
      $list[] = static::fetch_array_all($res);
      static::free_result($res);
    }

    return $list;
  }

  public static function get_province_all(){
    $list = [];
    $q = "SELECT * FROM state ORDER BY name";
    if($res = static::query($q)) {
      $list[] = static::fetch_array_all($res);
      static::free_result($res);
    }

    return $list;
  }

  public static function get_country_state($country){
    $list = [];
    $q = "SELECT * FROM state WHERE country = :country ORDER BY name";
    if($res = static::query($q, ['country' => $country])) {
      $list[] = static::fetch_array_all($res);
      static::free_result($res);
    }

    return $list;
  }

  public static function get_country_by_id($id){
    $country = '';
    $q = "SELECT * FROM countries WHERE id = :id";
    if($res = static::query($q, ['id' => $id])) {
      $row = static::fetch_array($res);
      $country = trim($row['name']);
      static::free_result($res);
    }

    return $country;
  }

  public static function get_province_by_id($id){
    $province = '';
    $q = "SELECT * FROM state WHERE id = :id";
    if($res = static::query($q, ['id' => $id])) {
      $row = static::fetch_array($res);
      $province = trim($row['name']);
      static::free_result($res);
    }

    return $province;
  }

}