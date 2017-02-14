<?php

  Class Model_Blogcategory extends Model_Base {

    protected static $table = 'blog_groups';

    public static function get_by_id($id) {
      $response = [
        'id' => '',
        'name' => '',
      ];
      if(isset($id)) {
        $query = "SELECT * FROM blog_groups WHERE id = '$id'";
        $result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query);
        if($result) $response = mysqli_fetch_assoc($result);
      }
      return $response;
    }

    public static function get_total_count($filter = null) {
      $response = 0;
      $query = "SELECT COUNT(DISTINCT a.id) FROM " . self::$table . " a";
      $query .= " LEFT JOIN blog_group_posts b ON a.id = b.group_id";
      $query .= static::build_where($filter);
      if($result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query)) {
        $response = mysqli_fetch_row($result)[0];
      }
      return $response;
    }

    public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null) {
      $res = null;
      $q = "SELECT a.id, a.name, COUNT(b.group_id) AS amount ";
      $q .= " FROM " . self::$table . " a";
      $q .= " LEFT JOIN blog_group_posts b ON a.id = b.group_id";
      $q .= static::build_where($filter);
      $q .= " GROUP BY a.id, a.name";
      $q .= static::build_order($sort);
      if($limit != 0) $q .= " LIMIT $start, $limit";
      $result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q);
      if($result) {
        $res_count_rows = mysqli_num_rows($result);
        while($row = mysqli_fetch_array($result)) {
          $res[] = $row;
        }
      }
      return $res;
    }

    public static function delete($id) {
      if(isset($id)) {
        $query = "SELECT COUNT(*) FROM blog_group_posts WHERE id = $id";
        $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query);
        if($res) {
          $amount = mysqli_fetch_array($res)[0];
          if(isset($amount) && ($amount > 0)) {
            throw new Exception('Can not delete. There are dependent data.');
          }
        }
        $query = "DELETE FROM blog_groups WHERE id = $id";
        $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query);
        if(!$res) throw new Exception(mysqli_error(_A_::$app->getDBConnection('iluvfabrix')));
      }
    }

    public static function save(&$data) {
      extract($data);
      $name = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $name);
      if(isset($id)) {
        $query = 'UPDATE blog_groups SET name = "' . $name . '" WHERE id = ' . $id;
        $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query);
        if(!$res) throw new Exception(mysqli_error(_A_::$app->getDBConnection('iluvfabrix')));
      } else {
        $query = 'INSERT INTO blog_groups (name) VALUE ("' . $name . '")';
        $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query);
        if(!$res) throw new Exception(mysqli_error(_A_::$app->getDBConnection('iluvfabrix')));
        $id = mysqli_insert_id(_A_::$app->getDBConnection('iluvfabrix')) ;
      }
      return $id;
    }

  }