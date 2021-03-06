<?php

namespace models;

use app\core\App;
use app\core\model\ModelBase;
use classes\helpers\AdminHelper;
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
  public static function BuildWhere(&$filter, &$prms = null){
    $return = "";
    $prms = [];
    if(AdminHelper::is_logged()) {
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
    if(isset($filter["a.post_status"])) {
      $result[] = "a.post_status = :a_post_status";
      $prms['a_post_status'] = $filter["a.post_status"];
    }

    if(!empty($result) && (count($result) > 0)) {
      if(strlen(trim(implode(" AND ", $result))) > 0) {
        $filter['active'] = true;
      }
    }
    if(isset($filter['hidden']["a.post_status"])) {
      $result[] = "a.post_status = :ha_post_status";
      $prms['ha_post_status'] = $filter['hidden']["a.post_status"];
    }
    if(!empty($result) && (count($result) > 0)) {
      $return = implode(" AND ", $result);
      $return = (!empty($return) ? " WHERE " . $return : '');
    }

    return $return;
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
      $select = implode(',', array_merge(isset($data['categories_select']) ?
          $data['categories_select'] : [], $categories)
      );
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
    $results = static::Query(
      "select a.id, a.name, (max(b.order)+1) as pos from blog_groups a" .
      " left join blog_group_posts b on b.group_id = a.id" .
      " where a.id in ($select)" .
      " group by a.id, a.name" .
      " order by a.name"
    );
    if($results) {
      while($row = static::FetchArray($results)) {
        $filters[$row['id']] = [$row['name'], isset($categories[$row['id']]) ? $categories[$row['id']] : $row['pos']];
      }
      static::FreeResult($results);
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
    $results = static::Query(
      "SELECT a.id, a.name, b.order FROM blog_group_posts b" .
      " INNER JOIN blog_groups a ON b.group_id=a.id " .
      " WHERE b.post_id=:id" .
      " ORDER BY a.name",
      ['id' => $id]
    );
    if($results) {
      while($row = static::FetchArray($results)) {
        $data[$row['id']] = [$row['name'], $row['order']];
      }
      static::FreeResult($results);
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
    $filter_limit = !is_null(App::$app->KeyStorage()->system_filter_amount) ?
      App::$app->KeyStorage()->system_filter_amount : FILTER_LIMIT;
    $start = isset($start) ? $start : 0;
    $search = static::PrepareForSql($search);
    $q = "SELECT count(id) FROM blog_groups";
    if(isset($search) && (strlen($search) > 0)) {
      $q .= " where name like :search";
      $prms['search'] = '%' . $search . '%';
    }
    $results = static::Query($q, $prms);
    $row = static::FetchArray($results);
    $count = $row[0];
    $q = "SELECT * FROM blog_groups";
    if(isset($search) && (strlen($search) > 0)) {
      $q .= " where name like :search";
      $prms['search'] = '%' . $search . '%';
    }
    $q .= " order by name";
    $q .= " limit $start, $filter_limit";
    $results = static::Query($q, $prms);
    if($results) {
      while($row = static::FetchArray($results)) {
        $filter[] = [$row['id'], $row['name']];
      }
      static::FreeResult($results);
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
    $query = "SELECT DISTINCT a.* ";
    $query .= " FROM " . static::$table . " a";
    $query .= " LEFT JOIN blog_group_posts b ON a.id = b.post_id ";
    $query .= " LEFT JOIN blog_groups c ON b.group_id = c.id ";
    $query .= static::BuildWhere($filter, $prms);
    $query .= static::BuildOrder($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";

    if($result = static::Query($query, $prms)) {
      $res_count_rows = static::getNumRows($result);
      while($row = static::FetchArray($result)) {
        $response[] = $row;
      }
      static::FreeResult($result);
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
      'id' => $id,
      'post_author' => '',
      'post_date' => date('Y-m-d H:i:s', time()),
      'post_content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore" .
        " et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut " .
        " aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum " .
        "dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui " .
        "officia deserunt mollit anim id est laborum...",
      'post_title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
      'post_status' => '',
    ];
    if(isset($id)) {
      $strSQL = "SELECT * FROM " . static::$table . " WHERE id = :id";
      $result = static::Query($strSQL, ['id' => $id]);
      if($result) {
        $data = static::FetchAssoc($result);
        static::FreeResult($result);
      }
    }

    if ($data === false){
      throw new Exception('Data set is empty!');
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
      $strSQL = "SELECT * FROM blog_post_img WHERE post_id = :id";
      $result = static::Query($strSQL, ['id' => $id]);
      if($result) {
        $data = static::FetchAssoc($result);
        $filename = $data['img'];
        static::FreeResult($result);
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
    static::BeginTransaction();
    try {
      $result = true;
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
          $result = static::Query("DELETE FROM blog_post_img WHERE post_id = :id", ['id' => $id]);
          if($result) {
            $result = static::Query(
              "INSERT INTO blog_post_img(post_id, img) VALUES(:id, :filename)",
              ['id' => $id, 'filename' => $filename]
            );
          }
        }
      }
      static::Commit();
    } catch(Exception $e) {
      static::RollBack();
      throw $e;
    }

    return $result;
  }

  /**
   * @param $id
   * @throws \Exception
   */
  public static function Delete($id){
    static::BeginTransaction();
    try {
      if(isset($id)) {
        $res = static::Query("DELETE FROM " . static::$table . " WHERE id = :id", ['id' => $id]);
        if($res) $res = static::Query("DELETE FROM blog_group_posts WHERE post_id = :id", ['id' => $id]);
        if($res) $res = static::Query("DELETE FROM blog_post_keys_descriptions WHERE post_id = :id", ['id' => $id]);
        if($res) static::delete_img(static::get_img($id));
        if($res) $res = static::Query("DELETE FROM blog_post_img WHERE post_id = :id", ['id' => $id]);
        if(!$res) throw new Exception(static::Error());
      }
      static::Commit();
    } catch(Exception $e) {
      static::RollBack();
      throw $e;
    }
  }

  /**
   * @param $data
   * @return mixed
   * @throws \Exception
   */
  public static function Save(&$data){
    /**
     * @var string $post_author
     * @var string $post_date
     * @var string $post_content
     * @var string $post_title
     * @var string $post_status
     * @var array $categories
     * @var string $keywords
     * @var string $description
     * @var integer $id
     */
    static::BeginTransaction();
    try {
      extract($data);
      if(!isset($id)) {
        $date['post_date'] = $post_date = date('Y-m-d H:i:s', time());
        $q = 'INSERT INTO ' . static::$table;
        $q .= ' (post_author, post_date, post_content, post_title, post_status)';
        $q .= ' VALUES (:post_author, :post_date, :post_content, :post_title, :post_status)';
        $prms = [
          'post_author' => $post_author, 'post_date' => $post_date, 'post_content' => $post_content,
          'post_title' => $post_title, 'post_status' => $post_status
        ];
      } else {
        $q = "UPDATE " . static::$table . " SET ";
        $q .= "post_author = :post_author, ";
        $q .= "post_content = :post_content, ";
        $q .= "post_title = :post_title, ";
        $q .= "post_status = :post_status ";
        $q .= "WHERE id = :id";
        $prms = [
          'post_author' => $post_author, 'post_content' => $post_content,
          'post_title' => $post_title, 'post_status' => $post_status, 'id' => $id
        ];
      }
      $result = static::Query($q, $prms);
      if($result && !isset($id)) $id = static::LastId();
      if($result) $result = static::Query("DELETE FROM blog_group_posts WHERE post_id = :id", ['id' => $id]);
      if($result) {
        foreach($categories as $group => $order) {
          if($result) $result = static::Query(
            "INSERT INTO blog_group_posts(`post_id`, `group_id`, `order`) VALUES (:id, :group, :order)",
            ['id' => $id, 'group' => $group, 'order' => $order]
          );
          if(!$result) break;
        }
      }
      if($result) $result = static::Query("DELETE FROM blog_post_keys_descriptions WHERE post_id = :id", ['id' => $id]);
      if($result) $result = static::Query(
        "INSERT INTO blog_post_keys_descriptions(post_id, keywords, description) VALUES(:id, :keywords, :description)",
        ['id' => $id, 'keywords' => $keywords, 'description' => $description]
      );
      if($result) $result = static::update_image($id, $data);
      if(!$result) throw new Exception(static::Error());
      static::Commit();
    } catch(Exception $e) {
      static::RollBack();
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
    $data = ['description' => null, 'keywords' => null];
    $res = static::Query(
      "SELECT description, keywords FROM blog_post_keys_descriptions WHERE post_id=:id",
      ['id' => $id]
    );
    if($res && static::getNumRows($res) > 0) {
      $data = static::FetchAssoc($res);
      static::FreeResult($res);
    }

    return $data;
  }

}