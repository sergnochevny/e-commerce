<?php

  Class Model_Blog extends Model_Base {

    protected static $table = 'blog_posts';

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
        $filters[$row[0]] = [$row[1], isset($categories[$row[0]]) ? $categories[$row[0]] : $row[2]];
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
          $data[$row[0]] = [$row[1], $row[2]];
        }
      return $data;
    }

    public static function get_filter_data(&$count, $start = 0, $search = null) {
      $filter = null;
      $FILTER_LIMIT = FILTER_LIMIT;
      $start = isset($start) ? $start : 0;
      $search = mysql_escape_string(static::validData($search));
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
          $q .= " limit $start, $FILTER_LIMIT";
          $results = mysql_query($q);
          while($row = mysql_fetch_array($results)) {
            $filter[] = [$row[0], $row[1]];
          }
      return $filter;
    }

    public static function get_total_count($filter = null) {
      $response = 0;
      $query = "SELECT COUNT(*) FROM " . static::$table;
      $query .= static::build_where($filter);
      if($result = mysql_query($query)) {
        $response = mysql_fetch_row($result)[0];
      }
      return $response;
    }

    public static function get_list($start, $limit, &$res_count_rows, $filter = null) {
      $response = null;
      $query = "SELECT * ";
      $query .= " FROM " . static::$table;
      $query .= static::build_where($filter);
      $query .= " ORDER BY post_date DESC";
      $query .= " LIMIT $start, $limit";

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
        'post_content' => '',
        'post_title' => '',
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
      $filename = str_replace('{base_url}', '', $filename);
      if(!empty($filename)) {
        if(file_exists($filename)) {
          unlink($filename);
        }
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
          if($result) $result = mysql_query("INSERT INTO blog_group_posts(object_id, group_id) values ('$id', '$group')");
          if(!$result) break;
        }
      }
      if($result) $result = mysql_query("DELETE FROM blog_post_keys_descriptions WHERE post_id = '$id'");
      if($result) $result = mysql_query("INSERT INTO blog_post_keys_descriptions(post_id, keywords, description) values('$id', '$keywords', '$description')");
      if($result) $result = mysql_query("DELETE FROM blog_post_img WHERE post_id = '$id'");
      if($result) $result = mysql_query("INSERT INTO blog_post_img(post_id, img) values('$id', '$img')");

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

    public static function get_count_publish_posts($cid = null) {
      if(!is_null($cid)) {
        $q_total = "SELECT COUNT(*) FROM blog_posts a" .
          " LEFT JOIN blog_group_posts b ON a.ID = b.object_id " .
          " WHERE a.post_status = 'publish' and b.group_id='$cid'";
      } else {
        $q_total = "SELECT COUNT(*) FROM blog_posts WHERE  post_status = 'publish'";
      }
      $res = mysql_query($q_total);
      $total = mysql_fetch_row($res);
      return $total[0];
    }

    public static function get_publish_post_list($cat_id, $start, $per_page, &$res_count_rows) {
      if(!is_null($cat_id)) {
        $q = "SELECT a.* FROM blog_posts a" .
          " LEFT JOIN blog_group_posts b ON a.ID = b.object_id " .
          " WHERE a.post_status = 'publish' AND b.group_id='$cat_id' ORDER BY a.post_date DESC, a.ID DESC LIMIT $start,$per_page";
      } else {
        $q = "SELECT * FROM blog_posts WHERE post_status = 'publish' ORDER BY post_date DESC, ID DESC LIMIT $start,$per_page";
      }
      $res = mysql_query($q);
      if($res) {
        $res_count_rows = mysql_num_rows($res);
        $rows = [];
        while($row = mysql_fetch_assoc($res)) {
          $rows[] = $row;
        }
        return $rows;
      }
      return false;
    }

    public static function get_count_posts($cid = null) {
      if(!is_null($cid)) {
        $q_total = "SELECT COUNT(*) FROM blog_posts a" .
          " LEFT JOIN blog_group_posts b ON a.ID = b.object_id " .
          " WHERE post_type = 'post' AND b.group_id='$cid'";
      } else {
        $q_total = "SELECT COUNT(*) FROM blog_posts WHERE post_type = 'post'";
      }
      $res = mysql_query($q_total);
      return mysql_fetch_row($res)[0];
    }

    public static function get_post_list($cat_id, $start, $per_page, &$res_count_rows) {
      if(!is_null($cat_id)) {
        $q = "SELECT a.* FROM blog_posts a" .
          " LEFT JOIN blog_group_posts b ON a.ID = b.object_id " .
          " WHERE post_type = 'post' AND b.group_id='$cat_id' ORDER BY a.post_date DESC, a.ID DESC LIMIT $start,$per_page";
      } else {
        $q = "SELECT * FROM blog_posts WHERE post_type = 'post' ORDER BY post_date DESC, ID DESC LIMIT $start,$per_page";
      }
      $res = mysql_query($q);
      if($res) {
        $res_count_rows = mysql_num_rows($res);
        $rows = [];
        while($row = mysql_fetch_assoc($res)) {
          $rows[] = $row;
        }
        return $rows;
      }
      return false;
    }
  }