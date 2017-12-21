<?php

namespace models;

use app\core\model\ModelBase;

/**
 * Class ModelAddress
 * @package models
 */
class ModelAddress extends ModelBase{

  /**
   * @return array|mixed
   * @throws \Exception
   */
  public static function get_countries_all(){
    $list = [];
    $q = "SELECT * FROM countries ORDER BY display_order, name";
    if($res = static::query($q)) {
      $list = static::fetch_array_all($res);
      static::free_result($res);
    }

    return $list;
  }

  /**
   * @return array|mixed
   * @throws \Exception
   */
  public static function get_province_all(){
    $list = [];
    $q = "SELECT * FROM state ORDER BY name";
    if($res = static::query($q)) {
      $list = static::fetch_array_all($res);
      static::free_result($res);
    }

    return $list;
  }

  /**
   * @param $country
   * @return array|mixed
   * @throws \Exception
   */
  public static function get_country_state($country){
    $list = [];
    $q = "SELECT * FROM state WHERE country = :country ORDER BY name";
    if($res = static::query($q, ['country' => $country])) {
      $list = static::fetch_array_all($res);
      static::free_result($res);
    }

    return $list;
  }

  /**
   * @param $id
   * @return string
   * @throws \Exception
   */
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

  /**
   * @param $id
   * @return string
   * @throws \Exception
   */
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