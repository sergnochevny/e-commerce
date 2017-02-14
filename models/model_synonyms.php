<?php

  Class Model_Synonyms extends Model_Base {

    protected static $table = 'keywords_synonyms';

    public static function build_synonyms_like($field, $value) {
      $res_count_rows = 0;
      $synonyms = null;
      if(!empty($value)) {
        $filter = [
          'keywords' => [0 => 'like', 1 => $value],
        ];
        $synonyms_rows = static::get_list(0, 0, $res_count_rows, $filter);
        if($res_count_rows > 0) {
          foreach($synonyms_rows as $row) {
            $keywords = array_filter(explode(',', $row['keywords']), function($item) use ($value) { return ($item == $value); });
            if(isset($keywords) && (count($keywords) > 0)) {
              if(isset($synonyms)) $synonyms = array_merge($synonyms, explode(',', $row['synonyms']));
              else $synonyms = explode(',', $row['synonyms']);
            }
          }
        }
      }
      $result = $field . " LIKE '%" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($value))) . "%'";
      if(isset($synonyms)) {
        foreach($synonyms as $synonym) {
          $result .= " OR " . $field . " LIKE '%" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($synonym))) . "%'";
        }
      }
      $result = "(" . $result . ")";
      return $result;
    }

    public static function get_total_count($filter = null) {
      $response = 0;
      $query = "SELECT COUNT(DISTINCT id) FROM " . self::$table;
      $query .= static::build_where($filter);
      if($result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query)) {
        $response = mysqli_fetch_row($result)[0];
      }
      return $response;
    }

    public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null) {
      $response = null;
      $query = "SELECT * FROM " . self::$table;
      $query .= static::build_where($filter);
      $query .= static::build_order($sort);
      if($limit != 0) $query .= " LIMIT $start, $limit";

      if($result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query)) {
        $res_count_rows = mysqli_num_rows($result);
        while($row = mysqli_fetch_assoc($result)) {
          $response[] = $row;
        }
      }

      return $response;
    }

    public static function get_by_id($id) {
      $data = [
        'id' => $id,
        'keywords' => '',
        'synonyms' => ''
      ];
      if(!empty($id)) {
        $result = mysqli_query("select * from " . self::$table . " WHERE id='$id'");
        if($result) {
          $data = mysqli_fetch_assoc($result);
        }
      }
      return $data;
    }

    public static function save(&$data) {
      extract($data);
      /**
       * @var string $keywords
       * @var string $synonyms
       * @var $keywords
       */
      if(isset($id)) {
        $query = "UPDATE " . static::$table . " SET keywords ='" . $keywords . "', synonyms ='" . $synonyms . "'  WHERE id = " . $id;
        $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query);
        if(!$res) throw new Exception(mysqli_error(_A_::$app->getDBConnection('iluvfabrix')));
      } else {
        $query = "INSERT INTO " . static::$table . " (keywords, synonyms) VALUE ('" . $keywords . "','" . $synonyms . "')";
        $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query);
        if(!$res) throw new Exception(mysqli_error(_A_::$app->getDBConnection('iluvfabrix')));
        $id = mysqli_insert_id(_A_::$app->getDBConnection('iluvfabrix'));
      }
      return $id;
    }

    public static function delete($id) {
      if(isset($id)) {
        $query = "DELETE FROM " . static::$table . " WHERE id = $id";
        $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query);
        if(!$res) throw new Exception(mysqli_error(_A_::$app->getDBConnection('iluvfabrix')));
      }
    }
  }