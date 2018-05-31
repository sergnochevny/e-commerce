<?php

namespace models;

use app\core\model\ModelBase;
use Exception;

/**
 * Class ModelInfo
 * @package models
 */
class ModelInfo extends ModelBase{

  /**
   * @var string
   */
  protected static $table = 'info_messages';

  /**
   * @param $filter
   * @param null $prms
   * @return string
   */
  public static function BuildWhere(&$filter, &$prms = null){
    $return = '';
    if(isset($filter['hidden']['id']) && !is_array($filter['hidden']['priceyard'])) $result[] = "a.id = '" . static::PrepareForSql($filter['hidden']["id"]) . "'";
    if(isset($filter['hidden']['visible'])) $result[] = "visible = '" . static::PrepareForSql($filter['hidden']["visible"]) . "'";
    if(isset($filter['hidden']["f1"])) $result[] = "f1 = '" . static::PrepareForSql($filter['hidden']["f1"]) . "'";
    if(isset($filter['hidden']["f2"])) $result[] = "f2 = '" . static::PrepareForSql($filter['hidden']["f2"]) . "'";
    if(!empty($result) && (count($result) > 0)) {
      $return = implode(" AND ", $result);
      $return = (!empty($return) ? " WHERE " . $return : '');
    }

    return $return;
  }

  /**
   * @param $filter
   * @return null
   * @throws \Exception
   */
  public static function get_by_f1($filter){
    $data = null;
    $q = "SELECT * FROM " . static::$table;
    $q .= self::BuildWhere($filter);
    $q .= ' LIMIT 1';
    $result = static::Query($q);
    if($result) $data = static::FetchAssoc($result);

    return $data;
  }

  /**
   * @param $id
   * @return null
   * @throws \Exception
   */
  public static function get_by_id($id){
    $data = null;
    if(isset($id)) {
      $q = "SELECT * FROM " . static::$table . " WHERE id = '" . $id . "'";
      $result = static::Query($q);
      if($result) {
        $data = static::FetchAssoc($result);
      }
    }

    if ($data === false){
      throw new Exception('Data set is empty!');
    }

    return $data;
  }

  /**
   * @param null $filter
   * @return int
   * @throws \Exception
   */
  public static function get_total_count($filter = null){
    $res = 0;
    $q = "SELECT COUNT(DISTINCT a.id) FROM " . static::$table;
    $q .= self::BuildWhere($filter);
    $result = static::Query($q);
    if($result) {
      $row = static::FetchArray($result);
      $res = $row[0];
    }

    return $res;
  }

  /**
   * @param $start
   * @param $limit
   * @param $res_count_rows
   * @param null $filter
   * @param null $sort
   * @return array|null
   * @throws \Exception
   */
  public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null){
    $res = null;
    $q = "SELECT * FROM " . static::$table;
    $q .= self::BuildWhere($filter);
    $q .= static::BuildOrder($sort);
    if($limit != 0) $q .= " LIMIT $start, $limit";
    $result = static::Query($q);
    if($result) {
      $res_count_rows = static::getNumRows($result);
      while($row = static::FetchAssoc($result)) {
        $res[] = $row;
      }
    }

    return $res;
  }

  /**
   * @param $data
   * @return mixed
   * @throws \Exception
   */
  public static function Save(&$data){
    static::BeginTransaction();
    try {
      extract($data);
      if(isset($f1)) {
        $q = "UPDATE " . static::$table . " SET" . " title='$title'," . " message='$message'," . " visible='$visible'," . " f2='$f2'" . " WHERE f1 ='$f1'";
        $res = static::Query($q);
      } else {
        $q = "INSERT INTO " . static::$table . " SET" . " title='$title'," . " message='$message'," . " visible='$visible'," . " f1='$f1'";
        " f2='$f2'";

        $res = static::Query($q);
      }
      if(!$res) throw new Exception(static::Error());
      static::Commit();
    } catch(Exception $e) {
      static::RollBack();
      throw $e;
    }

    return $f1;
  }

  /**
   * @param $id
   * @throws \Exception
   */
  public static function Delete($id){
    static::BeginTransaction();
    try {
      static::Query("DELETE FROM " . static::$table . " WHERE id = '$id'");
      static::Commit();
    } catch(Exception $e) {
      static::RollBack();
      throw $e;
    }
  }

}