<?php

  class Model_Comments extends Model_Model {

    protected static $table = 'fabrix_comments';

    public function get($ID) {
      $query = sprintf("select * from fabrix_comments where ID = %d", $ID);
      $res = mysql_query($query);
      if(!$res) {
        return null;
      }
      $data = mysql_fetch_array($res);

      return $data;
    }

    public function add($comment) {
      $query = sprintf("insert into fabrix_comments(id, title, data, userid, moderated) values (null, '%s', '%s',%d, %d)",
                       $comment->getTitle(), $comment->getData(), $comment->getUserID(), $comment->getModerated());
      $res = mysql_query($query);
      if(!$res) {
        return false;
      }
      return true;
    }

    public function delete($ID) {
      $query = sprintf("delete from fabrix_comments where ID = %d", $ID);
      $res = mysql_query($query);
      if(!$res) {
        return false;
      }

      return true;
    }

    public function update($comment) {
      $query = sprintf("update fabrix_comments set Title='%s', Data='%s', Dt='{$comment->getDate()}', UserID='%d', Moderated='%d' where ID = %d",
                       $comment->getTitle(), $comment->getData(), $comment->getUserID(), $comment->getModerated(), $comment->getID());

      //echo "Query from update: $query";

      $res = mysql_query($query);
      if(!$res) {
        return false;
      }

      return true;
    }

    public static function getAll(&$total, $begin = -1, $count = -1, $moderated = -1) {

      $query = "select * from fabrix_comments";
      if($moderated > -1) {
        $query .= sprintf(" where Moderated = %d", $moderated);
      }
      if($begin > -1 && $count > -1) {
        $query .= sprintf(" LIMIT %d, %d", $begin, $count);
      }
      $res = mysql_query($query);
      if(!$res) {
        return null;
      }

      $data = [];
      $total = mysql_num_rows($res);
      for($i = 0; $row = mysql_fetch_assoc($res); $i++) {
        $name = self::getUserName($row['userid']);

        if(!empty($name)) {
          $row['username'] = $name;
        }
        $data[$i] = $row;
      }

      return $data;
    }

    public static function getUserName($ID) {
      $query = sprintf("select bill_firstname, bill_lastname from fabrix_accounts where aid = %d", $ID);
      $res = mysql_query($query);

      if(!$res) {
        return false;
      }

      $data = mysql_fetch_assoc($res);
      if(empty($data)) return "Guest";

      return $data['bill_firstname'] . " " . $data['bill_lastname'];
    }

    public function getUserEmail($ID) {
      $query = sprintf("select email from fabrix_accounts where aid = %d", $ID);
      $res = mysql_query($query);
      if(!$res) {
        return false;
      }

      $data = mysql_fetch_assoc($res);

      return $data['email'];
    }

    public function getTotalCountComments($moderated = -1) {
      $total = 0;
      $query = "SELECT COUNT(*) FROM fabrix_comments";
      if($moderated > -1)
        $query .= sprintf(" WHERE Moderated = %d", $moderated);

      if($res = mysql_query($query)) {
        $total = mysql_fetch_row($res)[0];
      }
      return $total;
    }

  }