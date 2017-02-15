<?php

Class Model_Categories extends Model_Base
{

  protected static $table = 'fabrix_categories';

  protected static function build_where(&$filter)
  {
    if (isset($filter['hidden']['view']) && $filter['hidden']['view']) {
      $result = "";
      if (Controller_Admin::is_logged()) {
        if (!empty($filter["a.cname"]))
          foreach (array_filter(explode(' ', $filter["a.cname"])) as $item)
            if (!empty($item)) $result[] = "a.cname LIKE '%" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($item))) . "%'";
      } else {
        if (isset($filter["a.cname"])) $result[] = Model_Synonyms::build_synonyms_like("a.cname", $filter["a.cname"]);
      }
      if (isset($filter["a.cid"])) $result[] = "a.cid = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter["a.cid"]))) . "'";
      if (!empty($result) && (count($result) > 0)) {
        if (strlen(trim(implode(" AND ", $result))) > 0) {
          $filter['active'] = true;
        }
      }
      if (isset($filter['hidden']['c.pvisible'])) $result[] = "c.pvisible = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), static::strip_data(static::sanitize($filter['hidden']["c.pvisible"]))) . "'";
      if (!empty($result) && (count($result) > 0)) {
        $result = implode(" AND ", $result);
        $result = (!empty($result) ? " WHERE " . $result : '');
      }
    } else {
      $result = parent::build_where($filter);
    }
    return $result;
  }

  public static function get_total_count($filter = null)
  {
    $response = 0;
    $query = "SELECT COUNT(DISTINCT a.cid) FROM " . self::$table . " a";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER" : " LEFT";
    $query .= " JOIN fabrix_product_categories b ON b.cid = a.cid";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER JOIN fabrix_products c ON c.pid = b.pid" : '';
    $query .= static::build_where($filter);
    if ($result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query)) {
      $response = mysqli_fetch_row($result)[0];
    }
    return $response;
  }

  public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null)
  {
    $response = null;
    $query = "SELECT DISTINCT a.*, count(b.pid) AS amount";
    $query .= " FROM fabrix_categories a";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER" : " LEFT";
    $query .= " JOIN fabrix_product_categories b ON b.cid = a.cid";
    $query .= (isset($filter['hidden']['view']) && $filter['hidden']['view']) ? " INNER JOIN fabrix_products c ON c.pid = b.pid" : '';
    $query .= static::build_where($filter);
    $query .= " GROUP BY a.cid, a.cname";
    $query .= static::build_order($sort);
    if ($limit != 0) $query .= " LIMIT $start, $limit";

    if ($result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query)) {
      $res_count_rows = mysqli_num_rows($result);
      while ($row = mysqli_fetch_array($result)) {
        $response[] = $row;
      }
    }

    return $response;
  }

  public static function get_by_id($id)
  {
    $data = [
      'cid' => $id,
      'cname' => '',
      'displayorder' => ''
    ];
    if (!isset($id)) {
      $result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), "select max(displayorder)+1 from fabrix_categories");
      if ($result) {
        $row = mysqli_fetch_array($result);
        $data['displayorder'] = $row[0];
      }
    } else {
      $result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), "select * from fabrix_categories WHERE cid='$id'");
      if ($result) {
        $data = mysqli_fetch_array($result);
      }
    }
    return $data;
  }

  public static function save(&$data)
  {
    extract($data);
    $cname = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $cname);
    if (!empty($cid)) {
      $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), "select * from fabrix_categories WHERE cid='$cid'");
      if ($res) {
        $row = mysqli_fetch_array($res);
        $_displayorder = $row['displayorder'];
        if ($_displayorder != $displayorder) {
          if ($res) $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), "update fabrix_categories set displayorder=displayorder-1 WHERE displayorder > $_displayorder");
          if ($res) $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), "update fabrix_categories set displayorder=displayorder+1 WHERE displayorder >= $displayorder");
        }
        if ($res) $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), "update fabrix_categories set cname='$cname', displayorder='$displayorder' WHERE cid ='$cid'");
      }
    } else {
      $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), "update fabrix_categories set displayorder=displayorder+1 WHERE displayorder >= $displayorder");
      if ($res) $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), "insert fabrix_categories set cname='$cname', displayorder='$displayorder'");
      if ($res) $cid = mysqli_insert_id(_A_::$app->getDBConnection('iluvfabrix'));
    }
    if (!$res) throw new Exception(mysqli_error(_A_::$app->getDBConnection('iluvfabrix')));

    return $cid;
  }

  public static function delete($id)
  {
    if (isset($id)) {
      $query = "select count(*) from fabrix_product_categories where cid = $id";
      $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query);
      if ($res) {
        $amount = mysqli_fetch_array($res)[0];
        if (isset($amount) && ($amount > 0)) {
          throw new Exception('Can not delete. There are dependent data.');
        }
      }
      $query = "delete from fabrix_product_categories WHERE cid = $id";
      $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query);
      if (!$res) throw new Exception(mysqli_error(_A_::$app->getDBConnection('iluvfabrix')));
      $query = "DELETE FROM fabrix_categories WHERE cid = $id";
      $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $query);
      if (!$res) throw new Exception(mysqli_error(_A_::$app->getDBConnection('iluvfabrix')));
    }
  }
}