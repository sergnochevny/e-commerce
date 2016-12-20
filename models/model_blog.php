<?php

  Class Model_Blog extends Model_Base {

    protected static $table = 'blog_posts';

    protected static function build_where(&$filter) {
      $result = "";
      if(Controller_Admin::is_logged()) {
        if(isset($filter["a.post_title"])) $result[] = "a.post_title LIKE '%" . implode('%', array_filter(explode(' ', mysql_real_escape_string(static::strip_data(static::sanitize($filter["a.post_title"])))))) . "%'";
      } else {
        if(isset($filter["a.post_title"])) $result[] = Model_Synonyms::build_synonyms_like("a.post_title", $filter["a.post_title"]);
      }
      if(isset($filter["a.post_status"])) $result[] = "a.post_status = '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter["a.post_status"]))) . "'";
      if(isset($filter["a.post_date"])) {
        $where = (!empty($filter["a.post_date"]['from']) ? "a.post_date >= '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter["a.post_date"]["from"]))) . "'" : "") .
          (!empty($filter["a.post_date"]['to']) ? " AND a.post_date <= '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter["a.post_date"]["to"]))) . "'" : "");
        if(strlen(trim($where)) > 0) $result[] = "(" . $where . ")";
      }
      if(isset($filter["b.group_id"])) $result[] = "b.group_id = '" . mysql_real_escape_string(static::strip_data(static::sanitize($filter["b.group_id"]))) . "'";
      if(!empty($result) && (count($result) > 0)) {
        $result = implode(" AND ", $result);
        if(strlen(trim($result)) > 0) {
          $result = " WHERE " . $result;
          $filter['active'] = true;
        }
      }
      return $result;
    }

    public static function get_filter_selected(&$data) {
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
      $results = mysql_query(
        "select a.id, a.name, (max(b.order)+1) as pos from blog_groups a" .
        " left join blog_group_posts b on b.group_id = a.id" .
        " where a.id in ($select)" .
        " group by a.id, a.name" .
        " order by a.name"
      );
      while($row = mysql_fetch_array($results)) {
        $filters[$row['id']] = [$row['name'], isset($categories[$row['id']]) ? $categories[$row['id']] : $row['pos']];
      }
      $data['categories'] = $filters;
    }

    public static function get_filter_selected_data($id) {
      $data = [];
      $results = mysql_query(
        "select a.id, a.name, b.order from blog_group_posts b" .
        " inner join blog_groups a on b.group_id=a.id " .
        " where b.post_id='$id'" .
        " order by a.name"
      );
      if($results)
        while($row = mysql_fetch_array($results)) {
          $data[$row['id']] = [$row['name'], $row['order']];
        }
      return $data;
    }

    public static function get_filter_data(&$count, $start = 0, $search = null) {
      $filter = null;
      $filter_limit = (!is_null(_A_::$app->keyStorage()->system_filter_amount) ? _A_::$app->keyStorage()->system_filter_amount : FILTER_LIMIT);
      $start = isset($start) ? $start : 0;
      $search = mysql_real_escape_string(static::strip_data(static::sanitize($search)));
      $q = "select count(id) from blog_groups";
      if(isset($search) && (strlen($search) > 0)) {
        $q .= " where name like '%$search%'";
      }
      $results = mysql_query($q);
      $row = mysql_fetch_array($results);
      $count = $row[0];
      $q = "select * from blog_groups";
      if(isset($search) && (strlen($search) > 0)) {
        $q .= " where name like '%$search%'";
      }
      $q .= " order by name";
      $q .= " limit $start, $filter_limit";
      $results = mysql_query($q);
      while($row = mysql_fetch_array($results)) {
        $filter[] = [$row['id'], $row['name']];
      }
      return $filter;
    }

    public static function get_total_count($filter = null) {
      $response = 0;
      $query = "SELECT COUNT(DISTINCT a.id) FROM " . static::$table . " a";
      $query .= " LEFT JOIN blog_group_posts b ON a.id = b.post_id ";
      $query .= static::build_where($filter);
      if($result = mysql_query($query)) {
        $response = mysql_fetch_row($result)[0];
      }
      return $response;
    }

    public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null) {
      $response = null;
      $query = "SELECT * ";
      $query .= " FROM " . static::$table . " a";
      $query .= " LEFT JOIN blog_group_posts b ON a.id = b.post_id ";
      $query .= static::build_where($filter);
      $query .= static::build_order($sort);
      if($limit != 0) $query .= " LIMIT $start, $limit";

      if($result = mysql_query($query)) {
        $res_count_rows = mysql_num_rows($result);
        while($row = mysql_fetch_array($result)) {
          $response[] = $row;
        }
      }

      return $response;
    }

    public static function get_by_id($id) {
      $data = [
        'id' => $id,
        'post_author' => '',
        'post_date' => '',
        'post_content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore" .
          " et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut " .
          " aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum " .
          "dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui " .
          "officia deserunt mollit anim id est laborum...",
        'post_title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
        'post_status' => '',
      ];
      if(isset($id)) {
        $strSQL = "select * from " . static::$table . " where id = '" . $id . "'";
        $result = mysql_query($strSQL);
        if($result) {
          $data = mysql_fetch_assoc($result);
        }
      }
      return $data;
    }

    public static function delete_img($filename) {
      $filename = trim(str_replace('{base_url}', '', $filename), '/\\');
      if(!empty($filename)) {
        if($filename == basename($filename)) $filename = 'img/blog/' . $filename;
        if(file_exists($filename)) unlink($filename);
      }
    }

    public static function get_img($id) {
      $filename = null;
      if(isset($id)) {
        $strSQL = "select * from blog_post_img where post_id = '" . $id . "'";
        $result = mysql_query($strSQL);
        if($result) {
          $data = mysql_fetch_assoc($result);
          $filename = $data['img'];
        }
      }
      return $filename;
    }

    public static function update_image($id, &$data) {
      $img = trim(str_replace('{base_url}', '', static::get_img($id)), '/\\');
      $filename = basename($data['img']);
      if(!empty($filename) && ($filename != basename($img))) {
        if(substr($filename, 0, 1) == 't') {
          static::delete_img($img);
          $filename = 'p' . $id . $filename;
          if(file_exists("img/blog/" . basename($data['img']))) {
            rename("img/blog/" . basename($data['img']), "img/blog/" . $filename);
          }
          $data['img'] = $filename;
          $result = mysql_query("DELETE FROM blog_post_img WHERE post_id = '$id'");
          if($result) $result = mysql_query("INSERT INTO blog_post_img(post_id, img) values('$id', '$filename')");
          return $result;
        }
      }
      return true;
    }

    public static function delete($id) {
      if(isset($id)) {
        $res = mysql_query("DELETE FROM " . static::$table . " WHERE aid = $id");
        if($res) $res = mysql_query("delete from blog_group_posts where object_id = $id");
        if($res) $res = mysql_query("delete from blog_post_keys_descriptions where post_id = $id");
        if($res) static::delete_img(static::get_img($id));
        if($res) $res = mysql_query("delete from blog_post_img where post_id = $id");
        if(!$res) throw new Exception(mysql_error());
      }
    }

    public static function save(&$data) {
      extract($data);

      $post_title = mysql_real_escape_string($post_title);
      $keywords = mysql_real_escape_string($keywords);
      $description = mysql_real_escape_string($description);
      $post_content = mysql_real_escape_string($post_content);

      if(!isset($id)) {
        $date['post_date'] = $post_date = time();
        $q = "INSERT INTO " . static::$table . " (post_author, post_date, post_content, post_title, post_status)" .
          " VALUES ('$post_author', '$post_date', '$post_content', '$post_title', '$post_status')";
      } else {
        $q = "UPDATE " . static::$table . " SET ";
        $q .= " post_author = '" . $post_author;
        $q .= "', post_content = '" . $post_content;
        $q .= "', post_title = '" . $post_title;
        $q .= "', post_status = '" . $post_status;
        $q .= "' WHERE id = $id;";
      }
      $result = mysql_query($q);
      if($result) $result = mysql_query("DELETE FROM blog_group_posts WHERE post_id = '$id'");
      if($result) {
        foreach($categories as $group) {
          if($result) $result = mysql_query("INSERT INTO blog_group_posts(post_id, group_id) values ('$id', '$group')");
          if(!$result) break;
        }
      }
      if($result) $result = mysql_query("DELETE FROM blog_post_keys_descriptions WHERE post_id = '$id'");
      if($result) $result = mysql_query("INSERT INTO blog_post_keys_descriptions(post_id, keywords, description) values('$id', '$keywords', '$description')");
      if($result) $result = static::update_image($id, $data);
      if(!$result) throw new Exception(mysql_error());
      if(!isset($id)) $id = mysql_insert_id();
      return $id;
    }

    public static function get_desc_keys($id) {
      $data = null;
      $res = mysql_query("SELECT * FROM blog_post_keys_descriptions WHERE post_id='$id'");
      if($res && mysql_num_rows($res) > 0) $data = mysql_fetch_assoc($res);
      return $data;
    }

  }