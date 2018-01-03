<?php

namespace models;

use app\core\model\ModelBase;
use controllers\ControllerAdmin;
use Exception;

/**
 * Class ModelManufacturers
 * @package models
 */
class ModelManufacturers extends ModelBase{

  /**
   * @var string
   */
  protected static $table = 'shop_manufacturers';

  /**
   * @param $filter
   * @param null $prms
   * @return array|string
   * @throws \Exception
   */
  public static function build_where(&$filter, &$prms = null){
    if(isset($filter['hidden']['view']) && $filter['hidden']['view']) {
      $result = "";
      if(!empty($filter["a.manufacturer"])) {
        if(!empty($filter["a.manufacturer"])) {
          if(ControllerAdmin::is_logged()) {
            foreach(array_filter(explode(' ', $filter["a.manufacturer"])) as $idx => $item) {
              if(!empty($item)) {
                $result[] = "a.manufacturer LIKE :a_manufacturer" . $idx . "";
                $prms['a_manufacturer' . $idx] = '%' . $item . '%';
              }
            }
          } else {
            list($result[], $prms) = ModelSynonyms::build_synonyms_like_p("a.manufacturer", $filter["a.manufacturer"]);
          }
        }
      }
      if(isset($filter["a.id"])) {
        $result[] = "a.id = :a_id";
        $prms['a_id'] = $filter["a.id"];
      }
      if(!empty($result) && (count($result) > 0)) {
        if(strlen(trim(implode(" AND ", $result))) > 0) {
          $filter['active'] = true;
        }
      }
      if(isset($filter['hidden']['c.pvisible'])) {
        $result[] = "c.pvisible = :hc_pvisible";
        $prms['hc_pvisible'] = $filter['hidden']["c.pvisible"];
      }
      if(!empty($result) && (count($result) > 0)) {
        $result = implode(" AND ", $result);
        $result = (!empty($result) ? " WHERE " . $result : '');
      }
    } else {
      $result = parent::build_where($filter, $prms);
    }

    return $result;
  }

  /**
   * @param $id
   * @return array|null
   * @throws \Exception
   */
  public static function get_by_id($id){
    $response = [
      'id' => $id, 'manufacturer' => ''
    ];
    if(isset($id)) {
      $query = "SELECT * FROM " . static::$table . " WHERE id=:id";
      $result = static::query($query, ['id' => $id]);
      if($result) $response = static::fetch_assoc($result);
    }

    if ($response === false){
      throw new Exception('Data set is empty!');
    }
    return $response;
  }

  /**
   * @param null $filter
   * @return int|null
   * @throws \Exception
   */
  public static function get_total_count($filter = null){
    $response = 0;
    $query = "SELECT COUNT(DISTINCT a.id) FROM " . static::$table . " a";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER" : " LEFT";
    $query .= " JOIN shop_products b ON b.manufacturerId = a.id";
    $query .= static::build_where($filter, $prms);
    if($result = static::query($query, $prms)) {
      $response = static::fetch_value($result);
      static::free_result($result);
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
    $response = null;
    $query = "SELECT a.id, a.manufacturer, count(b.pid) AS amount";
    $query .= " FROM " . static::$table . " a";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER" : " LEFT";
    $query .= " JOIN shop_products b ON b.manufacturerId = a.id";
    $query .= static::build_where($filter, $prms);
    $query .= " GROUP BY a.id, a.manufacturer";
    $query .= static::build_order($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";

    if($result = static::query($query, $prms)) {
      $res_count_rows = static::num_rows($result);
      while($row = static::fetch_array($result)) {
        $response[] = $row;
      }
    }

    return $response;
  }

  /**
   * @param $data
   * @return mixed
   * @throws \Exception
   */
  public static function save(&$data){
    static::transaction();
    try {
      extract($data);
      /**
       * @var string $manufacturer
       * @var integer $id
       */
      if(isset($id)) {
        $query = "UPDATE " . static::$table . " SET manufacturer = :manufacturer WHERE id = :id";
        $res = static::query($query, ['id' => $id, 'manufacturer' => $manufacturer]);
        if(!$res) throw new Exception(static::error());
      } else {
        $query = "INSERT INTO " . static::$table . "(manufacturer) VALUE (:manufacturer)";
        $res = static::query($query, ['manufacturer' => $manufacturer]);
        if(!$res) throw new Exception(static::error());
        $id = static::last_id();
      }
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }

    return $id;
  }

  /**
   * @param $id
   * @throws \Exception
   */
  public static function delete($id){
    static::transaction();
    try {
      if(isset($id)) {
        $query = "SELECT count(*) FROM shop_products WHERE manufacturerId = :id";
        $res = static::query($query, ['id' => $id]);
        if($res) {
          $amount = static::fetch_array($res)[0];
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
        $query = "DELETE FROM " . static::$table . " WHERE id = :id";
        $res = static::query($query, ['id' => $id]);
        if(!$res) throw new Exception(static::error());
      }
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }
  }

}