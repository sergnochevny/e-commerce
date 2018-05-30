<?php

namespace models;

use app\core\model\ModelBase;
use Exception;

/**
 * Class ModelSynonyms
 * @package models
 */
class ModelSynonyms extends ModelBase{

  protected static $table = 'keywords_synonyms';

  /**
   * @param $field
   * @param $value
   * @return array
   * @throws \Exception
   */
  public static function build_synonyms_like_p($field, $value){
    $res_count_rows = 0;
    $prms = [];
    $synonyms = null;
    if(!empty($value)) {
      $filter = [
        'keywords' => [0 => 'like', 1 => $value],
      ];
      $synonyms_rows = static::get_list(0, 0, $res_count_rows, $filter);
      if($res_count_rows > 0) {
        foreach($synonyms_rows as $row) {
          $keywords = array_filter(explode(',', $row['keywords']), function($item) use ($value){
            return ($item == $value);
          });
          if(isset($keywords) && (count($keywords) > 0)) {
            if(isset($synonyms)) $synonyms = array_merge($synonyms, explode(',', $row['synonyms'])); else $synonyms = explode(',', $row['synonyms']);
          }
        }
      }
    }
    $result = '';
    $field_key = str_replace('.', '', $field);
    if(!empty($value)) {
      foreach(array_filter(explode(' ', $value)) as $key => $item) {
        if(!empty($item)) {
          $result .= (!empty($result) ? " AND " : "") . $field . " LIKE :" . $field_key . $key;
          $prms[$field_key . $key] = '%' . $item . '%';
        }
      }
    }

    $field_key .= 's';
    if(isset($synonyms)) {
      foreach($synonyms as $key => $item) {
        $result = (!empty($result) ? " OR " : "") . $field . " LIKE :" . $field_key . $key;
        $prms[$field_key . $key] = '%' . $item . '%';
      }
    }
    $result = "(" . $result . ")";

    return [$result, $prms];
  }

  /**
   * @param $field
   * @param $value
   * @return string
   * @throws \Exception
   */
  public static function build_synonyms_like($field, $value){
    $res_count_rows = 0;
    $synonyms = null;
    if(!empty($value)) {
      $filter = [
        'keywords' => [0 => 'like', 1 => $value],
      ];
      $synonyms_rows = static::get_list(0, 0, $res_count_rows, $filter);
      if($res_count_rows > 0) {
        foreach($synonyms_rows as $row) {
          $keywords = array_filter(explode(',', $row['keywords']), function($item) use ($value){
            return ($item == $value);
          });
          if(isset($keywords) && (count($keywords) > 0)) {
            if(isset($synonyms)) $synonyms = array_merge($synonyms, explode(',', $row['synonyms'])); else $synonyms = explode(',', $row['synonyms']);
          }
        }
      }
    }
    $result = '';
    if(!empty($value)) foreach(array_filter(explode(' ', $value)) as $item) {
      if(!empty($item)) {
        $result .= (!empty($result) ? " AND " : "") . $field . " LIKE '%" . static::PrepareForSql($item) . "%'";
      }
    }

    if(isset($synonyms)) {
      foreach($synonyms as $synonym) {
        $result = (!empty($result) ? " OR " : "") . $field . " LIKE '%" . static::PrepareForSql($synonym) . "%'";
      }
    }
    $result = "(" . $result . ")";

    return $result;
  }

  /**
   * @param null $filter
   * @return int|null
   * @throws \Exception
   */
  public static function get_total_count($filter = null){
    $response = 0;
    $query = "SELECT COUNT(DISTINCT id) FROM " . self::$table;
    $query .= static::BuildWhere($filter, $prms);
    if($result = static::Query($query, $prms)) {
      $response = static::FetchValue($result);
      static::FreeResult($result);
    }

    return $response;
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
    $response = [];
    $query = "SELECT * FROM " . self::$table;
    $query .= static::BuildWhere($filter, $prms);
    $query .= static::BuildOrder($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";

    if($result = static::Query($query, $prms)) {
      $res_count_rows = static::getNumRows($result);
      while($row = static::FetchAssoc($result)) {
        $response[] = $row;
      }
    }

    return $response;
  }

  /**
   * @param $id
   * @return array|null
   * @throws \Exception
   */
  public static function get_by_id($id){
    $data = [
      'id' => $id, 'keywords' => '', 'synonyms' => ''
    ];
    if(!empty($id)) {
      $result = static::Query("SELECT * FROM " . self::$table . " WHERE id=:id", ['id' => $id]);
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
   * @param $data
   * @return mixed
   * @throws \Exception
   */
  public static function Save(&$data){
    static::BeginTransaction();
    try {
      extract($data);
      /**
       * @var string $keywords
       * @var string $synonyms
       * @var $keywords
       */
      if(isset($id)) {
        $query = "UPDATE " . static::$table . " SET keywords = :keywords, synonyms = :synonyms WHERE id = :id";
        $res = static::Query($query, ['keywords' => $keywords, 'synonyms' => $synonyms, 'id' => $id]);
        if(!$res) throw new Exception(static::Error());
      } else {
        $query = "INSERT INTO " . static::$table . " (keywords, synonyms) VALUE (:keywords, :synonyms)";
        $res = static::Query($query, ['keywords' => $keywords, 'synonyms' => $synonyms]);
        if(!$res) throw new Exception(static::Error());
        $id = static::LastId();
      }
      static::Commit();
    } catch(Exception $e) {
      static::RollBack();
      throw $e;
    }

    return $id;
  }

  /**
   * @param $id
   * @throws \Exception
   */
  public static function Delete($id){
    static::BeginTransaction();
    try {
      if(isset($id)) {
        $query = "DELETE FROM " . static::$table . " WHERE id = :id";
        $res = static::Query($query, ['id' => $id]);
        if(!$res) throw new Exception(static::Error());
      }
      static::Commit();
    } catch(Exception $e) {
      static::RollBack();
      throw $e;
    }
  }

}