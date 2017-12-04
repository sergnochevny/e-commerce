<?php

class Model_Blogcategory extends Model_Base{

  protected static $table = 'blog_groups';

  public static function get_by_id($id){
    $response = [
      'id' => '', 'name' => '',
    ];
    if(isset($id)) {
      $query = "SELECT * FROM blog_groups WHERE id = '$id'";
      $result = static::query($query);
      if($result) $response = static::fetch_assoc($result);
    }

    return $response;
  }

  public static function get_total_count($filter = null){
    $response = 0;
    $query = "SELECT COUNT(DISTINCT a.id) FROM " . self::$table . " a";
    $query .= " LEFT JOIN blog_group_posts b ON a.id = b.group_id";
    $query .= static::build_where($filter);
    if($result = static::query($query)) {
      $response = static::fetch_row($result)[0];
    }

    return $response;
  }

  public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null){
    $res = null;
    $q = "SELECT a.id, a.name, COUNT(b.group_id) AS amount ";
    $q .= " FROM " . self::$table . " a";
    $q .= " LEFT JOIN blog_group_posts b ON a.id = b.group_id";
    $q .= static::build_where($filter);
    $q .= " GROUP BY a.id, a.name";
    $q .= static::build_order($sort);
    if($limit != 0) $q .= " LIMIT $start, $limit";
    $result = static::query($q);
    if($result) {
      $res_count_rows = static::num_rows($result);
      while($row = static::fetch_array($result)) {
        $res[] = $row;
      }
    }

    return $res;
  }

  public static function delete($id){
    static::transaction();
    try {
      if(isset($id)) {
        $query = "SELECT COUNT(*) FROM blog_group_posts WHERE id = $id";
        $res = static::query($query);
        if($res) {
          $amount = static::fetch_array($res)[0];
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
        $query = "DELETE FROM blog_groups WHERE id = $id";
        $res = static::query($query);
        if(!$res) throw new Exception(static::error());
      }
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }
  }

  public static function save(&$data){
    extract($data);
    static::transaction();
    try {
      $name = static::escape($name);
      if(isset($id)) {
        $query = 'UPDATE blog_groups SET name = "' . $name . '" WHERE id = ' . $id;
        $res = static::query($query);
        if(!$res) throw new Exception(static::error());
      } else {
        $query = 'INSERT INTO blog_groups (name) VALUE ("' . $name . '")';
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

}