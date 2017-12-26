<?php

namespace models;

use app\core\App;
use app\core\model\ModelBase;
use controllers\ControllerAdmin;
use Exception;

/**
 * Class ModelBlog
 * @package models
 */
class ModelBlog extends ModelBase{

  /**
   * @var string
   */
  protected static $table = 'blog_posts';

  /**
   * @param $filter
   * @param null $prms
   * @return array|string
   * @throws \Exception
   */
  public static function build_where(&$filter, &$prms = null){
    $result = "";
    $prms = [];
    if(ControllerAdmin::is_logged()) {
      if(!empty($filter["a.post_title"])) {
        foreach(array_filter(explode(' ', $filter["a.post_title"])) as $idx => $item) {
          if(!empty($item)) {
            $result[] = "a.post_title LIKE :a_post_title" . $idx . "";
            $prms['a_post_title' . $idx] = '%' . $item . '%';
          }
        }
      }
    } else {
      if(isset($filter["a.post_title"])) {
        $conditions[] = ModelSynonyms::build_synonyms_like_p("a.post_title", $filter["a.post_title"]);
        $conditions[] = ModelSynonyms::build_synonyms_like_p("c.name", $filter["a.post_title"]);
        $condition = '';
        foreach($conditions as $item) {
          if(!empty($condition)) $condition .= ' OR ';
          $condition .= $item[0];
          $prms = array_merge($prms, $item[1]);
        }
        $result[] = $condition;
      }
    }
    if(isset($filter["a.post_status"])) {
      $result[] = "a.post_status = :a_post_status";
      $prms['a_post_status'] = $filter["a.post_status"];
    }
    if(isset($filter["a.post_date"])) {
      $where = '';
      if(!empty($filter["a.post_date"]['from'])) {
        $where = "a.dt >= :a_pdt_from";
        $prms['a_pdt_from'] = $filter["a.post_date"]["from"];
      }
      if(!empty($filter["a.post_date"]['to'])) {
        $where .= " AND a.dt <= :a_pdt_to";
        $prms['a_pdt_to'] = $filter["a.post_date"]["to"];
      }
      if(strlen(trim($where)) > 0) $result[] = "(" . $where . ")";
    }
    if(isset($filter["b.group_id"])) {
      $result[] = "b.group_id = :b_group_id";
      $prms['b_group_id'] = $filter["b.group_id"];
    }
    if(!empty($result) && (count($result) > 0)) {
      $result = implode(" AND ", $result);
      if(strlen(trim($result)) > 0) {
        $result = " WHERE " . $result;
        $filter['active'] = true;
      }
    }

    return $result;
  }

  /**
   * @param $data
   * @throws \Exception
   */
  public static function get_filter_selected(&$data){
    $id = $data['id'];
    $filters = [];
    $categories = isset($data['categories']) ? array_keys($data['categories']) : [];
    if(isset($data['categories_select']) || isset($data['categories'])) {
      $select = implode(',', array_merge(isset($data['categories_select']) ? $data['categories_select'] : [], $categories));
      $categories = $data['categories'];
    } else {
      $data['categories'] = self::get_filter_selected_data($id);
      $select = implode(',', isset($data['categories']) ? array_keys($data['categories']) : []);
      $categories = isset($data['categories']) ? $data['categories'] : [];
      foreach($categories as $key => $val) {
        $categories[$key] = $val[1];
      }
    }
    if(strlen($select) <= 0) $select = '1';
    $results = static::query("select a.id, a.name, (max(b.order)+1) as pos from blog_groups a" . " left join blog_group_posts b on b.group_id = a.id" . " where a.id in ($select)" . " group by a.id, a.name" . " order by a.name");
    if($results) {
      while($row = static::fetch_array($results)) {
        $filters[$row['id']] = [$row['name'], isset($categories[$row['id']]) ? $categories[$row['id']] : $row['pos']];
      }
      static::free_result($results);
    }
    $data['categories'] = $filters;
  }

  /**
   * @param $id
   * @return array
   * @throws \Exception
   */
  public static function get_filter_selected_data($id){
    $data = [];
    $results = static::query(
      "SELECT a.id, a.name, b.order FROM blog_group_posts b" .
      " INNER JOIN blog_groups a ON b.group_id=a.id " .
      " WHERE b.post_id=:id" .
      " ORDER BY a.name",
      ['id' => $id]
    );
    if($results) {
      while($row = static::fetch_array($results)) {
        $data[$row['id']] = [$row['name'], $row['order']];
      }
      static::free_result($results);
    }

    return $data;
  }

  /**
   * @param $count
   * @param int $start
   * @param null $search
   * @return array|null
   * @throws \Exception
   */
  public static function get_filter_data(&$count, $start = 0, $search = null){
    $filter = null;
    $prms = [];
    $filter_limit = (!is_null(App::$app->keyStorage()->system_filter_amount) ?
      App::$app->keyStorage()->system_filter_amount : FILTER_LIMIT);
    $start = isset($start) ? $start : 0;
    $search = static::prepare_for_sql($search);
    $q = "SELECT count(id) FROM blog_groups";
    if(isset($search) && (strlen($search) > 0)) {
      $q .= " where name like :search";
      $prms['search'] = '%' . $search . '%';
    }
    $results = static::query($q, $prms);
    $row = static::fetch_array($results);
    $count = $row[0];
    $q = "SELECT * FROM blog_groups";
    if(isset($search) && (strlen($search) > 0)) {
      $q .= " where name like :search";
      $prms['search'] = '%' . $search . '%';
    }
    $q .= " order by name";
    $q .= " limit $start, $filter_limit";
    $results = static::query($q, $prms);
    if($results) {
      while($row = static::fetch_array($results)) {
        $filter[] = [$row['id'], $row['name']];
      }
      static::free_result($results);
    }

    return $filter;
  }

  /**
   * @param null $filter
   * @return int|null
   * @throws \Exception
   */
  public static function get_total_count($filter = null){
    $response = 0;
    $query = "SELECT COUNT(DISTINCT a.id) FROM " . static::$table . " a";
    $query .= " LEFT JOIN blog_group_posts b ON a.id = b.post_id ";
    $query .= " LEFT JOIN blog_groups c ON b.group_id = c.id ";
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
    $query = "SELECT DISTINCT a.* ";
    $query .= " FROM " . static::$table . " a";
    $query .= " LEFT JOIN blog_group_posts b ON a.id = b.post_id ";
    $query .= " LEFT JOIN blog_groups c ON b.group_id = c.id ";
    $query .= static::build_where($filter, $prms);
    $query .= static::build_order($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";

    if($result = static::query($query, $prms)) {
      $res_count_rows = static::num_rows($result);
      while($row = static::fetch_array($result)) {
        $response[] = $row;
      }
      static::free_result($result);
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
      'id' => $id, 'post_author' => '', 'post_date' => date('Y-m-d H:i:s', time()),
      'post_content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore" . " et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut " . " aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum " . "dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui " . "officia deserunt mollit anim id est laborum...",
      'post_title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...', 'post_status' => '',
    ];
    if(isset($id)) {
      $strSQL = "SELECT * FROM " . static::$table . " WHERE id = '" . $id . "'";
      $result = static::query($strSQL);
      if($result) {
        $data = static::fetch_assoc($result);
        static::free_result($result);
      }
    }

    return $data;
  }

  /**
   * @param $filename
   */
  public static function delete_img($filename){
    $filename = trim(str_replace('{base_url}', '', $filename), '/\\');
    if(!empty($filename)) {
      if($filename == basename($filename)) $filename = 'images/blog/' . $filename;
      if(file_exists(APP_PATH . '/web/' . $filename)) unlink(APP_PATH . '/web/' . $filename);
    }
  }

  /**
   * @param $id
   * @return null
   * @throws \Exception
   */
  public static function get_img($id){
    $filename = null;
    if(isset($id)) {
      $strSQL = "SELECT * FROM blog_post_img WHERE post_id = '" . $id . "'";
      $result = static::query($strSQL);
      if($result) {
        $data = static::fetch_assoc($result);
        $filename = $data['img'];
        static::free_result($result);
      }
    }

    return $filename;
  }

  /**
   * @param $id
   * @param $data
   * @return bool|mixed
   * @throws \Exception
   */
  public static function update_image($id, &$data){
    static::transaction();
    try {
      $result = false;
      $img = trim(str_replace('{base_url}', '', static::get_img($id)), '/\\');
      $filename = basename($data['img']);
      if(!empty($filename) && ($filename != basename($img))) {
        if(substr($filename, 0, 1) == 't') {
          static::delete_img($img);
          $filename = 'p' . $id . $filename;
          if(file_exists(APP_PATH . '/web/' . "images/blog/" . basename($data['img']))) {
            rename(
              APP_PATH . '/web/' . "images/blog/" . basename($data['img']),
              APP_PATH . '/web/' . "images/blog/" . $filename
            );
          }
          $data['img'] = $filename;
          $result = static::query("DELETE FROM blog_post_img WHERE post_id = '$id'");
          if($result) $result = static::query("INSERT INTO blog_post_img(post_id, img) values('$id', '$filename')");
        }
      }
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }

    return $result;
  }

  /**
   * @param $id
   * @throws \Exception
   */
  public static function delete($id){
    static::transaction();
    try {
      if(isset($id)) {
        $res = static::query("DELETE FROM " . static::$table . " WHERE id = :id", ['id' => $id]);
        if($res) $res = static::query("DELETE FROM blog_group_posts WHERE post_id = :id", ['id' => $id]);
        if($res) $res = static::query("DELETE FROM blog_post_keys_descriptions WHERE post_id = :id", ['id' => $id]);
        if($res) static::delete_img(static::get_img($id));
        if($res) $res = static::query("DELETE FROM blog_post_img WHERE post_id = :id", ['id' => $id]);
        if(!$res) throw new Exception(static::error());
      }
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }
  }

  /**
   * @param $data
   * @return mixed
   * @throws \Exception
   */
  public static function save(&$data){
    extract($data);

    static::transaction();
    try {
      if(!isset($id)) {
        $date['post_date'] = $post_date = date('Y-m-d H:i:s', time());
        $q = "INSERT INTO " . static::$table . " (post_author, post_date, post_content, post_title, post_status)";
        $q .= " VALUES (:post_author, :post_date, :post_content, :post_title, :post_status)";
        $prms = compact($post_author, $post_date, $post_content, $post_title, $post_status);
      } else {
        $q = "UPDATE " . static::$table . " SET ";
        $q .= " post_author = :post_author";
        $q .= ", post_content = :post_content";
        $q .= ", post_title = :post_title";
        $q .= ", post_status = :post_status";
        $q .= " WHERE id = :id";
        $prms = compact($post_author, $post_date, $post_content, $post_title, $post_status, $id);
      }
      $result = static::query($q, $prms);
      if($result && !isset($id)) $id = static::last_id();
      if($result) $result = static::query("DELETE FROM blog_group_posts WHERE post_id = :id", ['id' => $id]);
      if($result) {
        foreach($categories as $group) {
          if($result) $result = static::query(
            "INSERT INTO blog_group_posts(post_id, group_id) VALUES (:id, :group)", compact($id, $group)
          );
          if(!$result) break;
        }
      }
      if($result) $result = static::query("DELETE FROM blog_post_keys_descriptions WHERE post_id = :id", ['id' => $id]);
      if($result) $result = static::query(
        "INSERT INTO blog_post_keys_descriptions(post_id, keywords, description) VALUES(:id, :keywords, :description)",
        compact($id, $keywords, $description)
      );
      if($result) $result = static::update_image($id, $data);
      if(!$result) throw new Exception(static::error());
      static::commit();
    } catch(Exception $e) {
      static::rollback();
      throw $e;
    }

    return $id;
  }

  /**
   * @param $id
   * @return null
   * @throws \Exception
   */
  public static function get_desc_keys($id){
    $data = null;
    $res = static::query("SELECT * FROM blog_post_keys_descriptions WHERE post_id=:id", ['id' => $id]);
    if($res && static::num_rows($res) > 0) {
      $data = static::fetch_assoc($res);
      static::free_result($res);
    }

    return $data;
  }

}