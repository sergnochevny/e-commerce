<?php

class Model_Colors extends Model_Base{

  protected static $table = 'shop_color';

  protected static function build_where(&$filter, &$prms = null){
    if(isset($filter['hidden']['view']) && $filter['hidden']['view']) {
      $result = "";
      if(Controller_Admin::is_logged()) {
        if(!empty($filter["a.color"])) foreach(array_filter(explode(' ', $filter["a.color"])) as $item) if(!empty($item)) $result[] = "a.color LIKE '%" . static::prepare_for_sql($item) . "%'";
      } else {
        if(isset($filter["a.color"])) $result[] = Model_Synonyms::build_synonyms_like("a.color", $filter["a.color"]);
      }
      if(isset($filter["a.id"])) $result[] = "a.id = '" . static::prepare_for_sql($filter["a.id"]) . "'";
      if(!empty($result) && (count($result) > 0)) {
        if(strlen(trim(implode(" AND ", $result))) > 0) {
          $filter['active'] = true;
        }
      }
      if(isset($filter['hidden']['c.pvisible'])) $result[] = "c.pvisible = '" . static::prepare_for_sql($filter['hidden']["c.pvisible"]) . "'";
      if(!empty($result) && (count($result) > 0)) {
        $result = implode(" AND ", $result);
        $result = (!empty($result) ? " WHERE " . $result : '');
      }
    } else {
      $result = parent::build_where($filter);
    }

    return $result;
  }

  public static function get_by_id($id){
    $response = [
      'id' => $id, 'color' => ''
    ];
    if(isset($id)) {
      $query = "SELECT * FROM " . static::$table . " WHERE id='$id'";
      $result = static::query($query);
      if($result) $response = static::fetch_assoc($result);
    }

    return $response;
  }

  public static function get_total_count($filter = null){
    $response = 0;
    $query = "SELECT COUNT(DISTINCT a.id) FROM " . static::$table . " a";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER" : " LEFT";
    $query .= " JOIN shop_product_colors b ON b.colorId = a.id";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER JOIN shop_products c ON c.pid = b.prodId" : '';
    $query .= static::build_where($filter);
    if($result = static::query($query)) {
      $response = static::fetch_value($result);
      static::free_result($result);
    }

    return $response;
  }

  public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null){
    $response = null;
    $query = "SELECT a.id, a.color, count(b.prodId) AS amount";
    $query .= " FROM " . static::$table . " a";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER" : " LEFT";
    $query .= " JOIN shop_product_colors b ON b.colorId = a.id";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER JOIN shop_products c ON c.pid = b.prodId" : '';
    $query .= static::build_where($filter);
    $query .= " GROUP BY a.id, a.color";
    $query .= static::build_order($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";

    if($result = static::query($query)) {
      $res_count_rows = static::num_rows($result);
      while($row = static::fetch_array($result)) {
        $response[] = $row;
      }
    }

    return $response;
  }

  public static function save(&$data){
    static::transaction();
    try {
      extract($data);
      if(isset($id)) {
        $query = 'UPDATE ' . static::$table . ' SET color ="' . $color . '" WHERE id =' . $id;
        $res = static::query($query);
        if(!$res) throw new Exception(static::error());
      } else {
        $query = 'INSERT INTO ' . static::$table . '(color) VALUE ("' . $color . '")';
        $res = static::query($query);
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

  public static function delete($id){
    static::transaction();
    try {
      if(isset($id)) {
        $query = "SELECT COUNT(*) FROM shop_product_colors WHERE colorId = $id";
        $res = static::query($query);
        if($res) {
          $amount = static::fetch_array($res)[0];
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
        $query = "DELETE FROM " . static::$table . " WHERE id = $id";
        $res = static::query($query);
        if(!$res) throw new Exception(static::error());
      }
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }
  }

}