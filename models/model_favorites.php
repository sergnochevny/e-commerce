<?php

class Model_Favorites extends Model_Base{

  protected static $table = 'fabrix_product_favorites';

  protected static function build_where(&$filter, &$prms = null){
    $result = "";
    if(Controller_Admin::is_logged()) {
      if(!empty($filter["a.pname"])) foreach(array_filter(explode(' ', $filter["a.pname"])) as $item) if(!empty($item)) $result[] = "a.pname LIKE '%" . static::prepare_for_sql($item) . "%'";
    } else {
      if(isset($filter["a.pname"])) $result[] = Model_Synonyms::build_synonyms_like("a.pname", $filter["a.pname"]);
    }
    if(isset($filter["a.pvisible"])) $result[] = "a.pvisible = '" . static::prepare_for_sql($filter["a.pvisible"]) . "'";
    if(isset($filter["a.piece"])) $result[] = "a.piece = '" . static::prepare_for_sql($filter["a.piece"]) . "'";
    if(isset($filter["a.dt"])) {
      $where = (!empty($filter["a.dt"]['from']) ? "a.dt >= '" . static::prepare_for_sql($filter["a.dt"]["from"]) . "'" : "") . (!empty($filter["a.dt"]['to']) ? " AND a.dt <= '" . static::prepare_for_sql($filter["a.dt"]["to"]) . "'" : "");
      if(strlen(trim($where)) > 0) $result[] = "(" . $where . ")";
    }
    if(isset($filter["a.pnumber"])) $result[] = "a.pnumber LIKE '%" . static::prepare_for_sql($filter["a.pnumber"]) . "%'";
    if(isset($filter["a.best"])) $result[] = "a.best = '" . static::prepare_for_sql($filter["a.best"]) . "'";
    if(isset($filter["a.specials"])) $result[] = "a.specials = '" . static::prepare_for_sql($filter["a.specials"]) . "'";
    if(isset($filter["b.cid"])) $result[] = "b.cid = '" . static::prepare_for_sql($filter["b.cid"]) . "'";
    if(isset($filter["c.id"])) $result[] = "c.id = '" . static::prepare_for_sql($filter["c.id"]) . "'";
    if(isset($filter["d.id"])) $result[] = "d.id = '" . static::prepare_for_sql($filter["d.id"]) . "'";
    if(isset($filter["e.id"])) $result[] = "e.id = '" . static::prepare_for_sql($filter["e.id"]) . "'";
    if(!empty($result) && (count($result) > 0)) {
      if(strlen(trim(implode(" AND ", $result))) > 0) {
        $filter['active'] = true;
      }
    }
    if(isset($filter['hidden']["z.aid"])) $result[] = "z.aid = '" . static::prepare_for_sql($filter['hidden']["z.aid"]) . "'";
    if(!empty($result) && (count($result) > 0)) {
      $result = implode(" AND ", $result);
    }
    $result = " WHERE a.pnumber is not null " . (!empty($result) ? ' AND ' . $result : '');

    return $result;
  }

  public static function get_by_id($pid, $aid){
    $data = null;
    $q = "SELECT * FROM " . self::$table;
    $q .= " where pid = '$pid' and aid = '$aid'";
    $res = static::query($q);
    if($res) {
      $data = static::fetch_assoc($res);
    } else {
      throw new Exception(static::error());
    }

    return $data;
  }

  public static function get_total_count($filter = null){
    $response = 0;
    $query = "SELECT COUNT(DISTINCT a.pid) FROM " . static::$table . " z";
    $query .= " LEFT JOIN fabrix_products a ON a.pid = z.pid";
    $query .= " LEFT JOIN fabrix_product_categories ON a.pid = fabrix_product_categories.pid";
    $query .= " LEFT JOIN fabrix_categories b ON fabrix_product_categories.cid = b.cid";
    $query .= " LEFT JOIN fabrix_product_colors ON a.pid = fabrix_product_colors.prodId";
    $query .= " LEFT JOIN fabrix_color c ON fabrix_product_colors.colorId = c.id";
    $query .= " LEFT JOIN fabrix_product_patterns ON a.pid = fabrix_product_patterns.prodId";
    $query .= " LEFT JOIN fabrix_patterns d ON d.id = fabrix_product_patterns.patternId";
    $query .= " LEFT JOIN fabrix_manufacturers e ON a.manufacturerId = e.id";
    $query .= static::build_where($filter);
    if($result = static::query($query)) {
      $response = static::fetch_value($result);
      static::free_result($result);
    }

    return $response;
  }

  public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null){
    $response = null;
    $query = "SELECT DISTINCT z.id, a.* FROM " . static::$table . " z";
    $query .= " LEFT JOIN fabrix_products a ON a.pid = z.pid";
    $query .= " LEFT JOIN fabrix_product_categories ON a.pid = fabrix_product_categories.pid";
    $query .= " LEFT JOIN fabrix_categories b ON fabrix_product_categories.cid = b.cid";
    $query .= " LEFT JOIN fabrix_product_colors ON a.pid = fabrix_product_colors.prodId";
    $query .= " LEFT JOIN fabrix_color c ON fabrix_product_colors.colorId = c.id";
    $query .= " LEFT JOIN fabrix_product_patterns ON a.pid = fabrix_product_patterns.prodId";
    $query .= " LEFT JOIN fabrix_patterns d ON d.id = fabrix_product_patterns.patternId";
    $query .= " LEFT JOIN fabrix_manufacturers e ON a.manufacturerId = e.id";
    $query .= static::build_where($filter);
    $query .= static::build_order($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";
    if($result = static::query($query)) {
      $res_count_rows = static::num_rows($result);
      $sys_hide_price = Model_Price::sysHideAllRegularPrices();
      $cart_items = isset(_A_::$app->session('cart')['items']) ? _A_::$app->session('cart')['items'] : [];
      $cart = array_keys($cart_items);
      while($row = static::fetch_array($result)) {
        $response[] = Model_Shop::prepare_layout_product($row, $cart, $sys_hide_price);
      }
    }

    return $response;
  }

  public static function save(&$data){
    static::transaction();
    try {
      extract($data);
      $query = "REPLACE INTO " . static::$table . " (aid, pid) VALUE ('" . $aid . "','" . $pid . "')";
      $res = static::query($query);
      if(!$res) throw new Exception(static::error());
      $id = static::last_id();
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
        $query = "DELETE FROM  " . static::$table . " WHERE id = $id";
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