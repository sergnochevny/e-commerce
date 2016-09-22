<?php

Class Model_Blog extends Model_Model
{

    public static function blog_category_is_empty($group_id)
    {
        $q = "select * from blog_group_posts where group_id = '$group_id'";
        $res = mysql_query($q);
        return ($res && (mysql_num_rows($res) < 1));
    }

    public static function del_blog_category($group_id)
    {
        $q = "delete from blog_group_posts where group_id = '$group_id'";
        $res = mysql_query($q);
        if ($res) {
            $q = "delete from blog_groups where group_id = '$group_id'";
            $res = mysql_query($q);
        }
    }

    public static function get_blog_categories()
    {
        $res = null;
        $q = "select * from blog_groups";
        $result = mysql_query($q);
        if ($result) {
            while ($row = mysql_fetch_assoc($result)) {
                $res[] = $row;
            }
        }
        return $res;
    }

    public static function get_blog_post_by_post_name($post_name)
    {
        $result = null;
        $q = "select * from blog_posts where post_name = '$post_name'";
        $res = mysql_query($q);
        if ($res && mysql_num_rows($res) > 0) {
            $result = mysql_fetch_assoc($res);
        }
        return $result;
    }

    public static function get_blog_post_by_post_id($post_id)
    {
        $result = null;
        $q = "select * from blog_posts where id = '$post_id'";
        $res = mysql_query($q);
        if ($res && mysql_num_rows($res) > 0) {
            $result = mysql_fetch_assoc($res);
        }
        return $result;
    }

    public static function get_post_categories_by_post_id($post_id)
    {
        $result = [];
        $q = "select group_id from blog_group_posts where object_id = '$post_id'";
        $res = mysql_query($q);
        if ($res && mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $result[] = $row['group_id'];
            }
        }
        return $result;
    }

    public static function get_blog_category($group_id)
    {
        $result = mysql_query("select * from blog_groups WHERE group_id='$group_id'");
        $row = mysql_fetch_array($result);

        return array(
            'id' => $row['name'],
            'name' => $row['pnumber'],
            'slug' => $row['group_id']
        );
    }

    public function del_post($post_id)
    {
        $strSQL = "DELETE FROM blog_group_posts WHERE object_id = $post_id";
        mysql_query($strSQL);
        $strSQL = "DELETE FROM blog_post_img WHERE post_id = $post_id";
        mysql_query($strSQL);
        $strSQL = "DELETE FROM blog_post_keys_descriptions WHERE post_id = $post_id";
        mysql_query($strSQL);
        $strSQL = "DELETE FROM blog_posts WHERE id = $post_id";
        mysql_query($strSQL);
    }

    public static function getPostImg($post_id)
    {
        $resulthatistim = mysql_query("select * from blog_post_img WHERE post_id='$post_id'");
        $res = null;
        if ($resulthatistim && mysql_num_rows($resulthatistim) > 0) {
            $rowsni = mysql_fetch_array($resulthatistim);
            $res = $rowsni['img'];
        }
        return $res;
    }

    public static function getPostDescKeys($post_id)
    {
        $resulthatistim = mysql_query("select * from blog_post_keys_descriptions WHERE post_id='$post_id'");
        $res = null;
        if ($resulthatistim && mysql_num_rows($resulthatistim) > 0) {
            $rowsni = mysql_fetch_assoc($resulthatistim);
            $res = $rowsni;
        }
        return $res;
    }

    public static function save_new_post($title, $keywords, $description, $name, $img, $content, $status, $categories)
    {

        $q = "insert into blog_posts" .
            "(post_date, post_content, post_title, post_status,post_name, post_modified, post_type,post_excerpt,post_content_filtered,pinged,to_ping)" .
            " values(NOW(), '$content', '$title', '$status', '$name', NOW(), 'post','','','','')";

        $res = mysql_query($q);
        if ($res) {
            $post_id = mysql_insert_id();

            $q = "delete from blog_group_posts where post_id = '$post_id'";
            $res = mysql_query($q);

            foreach ($categories as $group) {
                $q = "insert into blog_group_posts(object_id, group_id) values ('$post_id', '$group')";
                $res = mysql_query($q);
            }

            $q = "delete from blog_post_keys_descriptions where post_id = '$post_id'";
            $res = mysql_query($q);

            $q = "insert into blog_post_keys_descriptions(post_id, keywords, description) values('$post_id', '$keywords', '$description')";
            $res = mysql_query($q);

            $q = "delete from blog_post_img where post_id = '$post_id'";
            $res = mysql_query($q);

            $q = "insert into blog_post_img(post_id, img) values('$post_id', '$img')";
            $res = mysql_query($q);
        }
    }

    public static function save_edit_post($post_id, $title, $keywords, $description, $name, $img, $content, $status, $categories)
    {

        $q = "update blog_posts" .
            " set post_content = '$content', post_title = '$title', post_status = '$status' ,post_name = '$name'," .
            " post_modified = NOW()" .
            " WHERE id = '$post_id'";

        $res = mysql_query($q);
        if ($res) {
            $q = "delete from blog_group_posts where object_id = '$post_id'";
            $res = mysql_query($q);

            foreach ($categories as $group) {
                $q = "insert into blog_group_posts(object_id, group_id) values ('$post_id', '$group')";
                $res = mysql_query($q);
            }

            $q = "delete from blog_post_keys_descriptions where post_id = '$post_id'";
            $res = mysql_query($q);

            $q = "insert into blog_post_keys_descriptions(post_id, keywords, description) values ('$post_id', '$keywords', '$description')";
            $res = mysql_query($q);

            $q = "delete from blog_post_img where post_id = '$post_id'";
            $res = mysql_query($q);

            $q = "insert into blog_post_img(post_id, img) values('$post_id', '$img')";
            $res = mysql_query($q);
        }
    }

    public static function getPostCatName($cat_id)
    {
        $resulthatistim = mysql_query("select * from blog_groups WHERE group_id='$cat_id'");
        $rowsni = mysql_fetch_array($resulthatistim);
        $res = null;
        if (mysql_num_rows($resulthatistim) > 0) {
            $res = $rowsni['name'];
        }
        return $res;
    }

    public static function insert_blog_category($post_category_name, $slug)
    {
        return mysql_query("insert into blog_groups set name='$post_category_name', slug='$slug'");
    }

    public static function update_blog_category($post_category_name, $group_id)
    {
        return mysql_query("update blog_groups set name='$post_category_name' WHERE group_id ='$group_id'");
    }

    public static function get_blog_categories_list()
    {
        $q = "select a.group_id, a.name, count(b.group_id) as amount from blog_groups a " .
            " left join blog_group_posts b on a.group_id=b.group_id" .
            " group by a.group_id, a.name";
        $results = mysql_query($q);
        $categories = [];
        if ($results) {
            while ($row = mysql_fetch_assoc($results)) {
                $categories[] = $row;
            }
        }
        return $categories;
    }

    public static function get_count_publish_posts($cid = null)
    {
        if (!is_null($cid)) {
            $q_total = "SELECT COUNT(*) FROM `blog_posts` a" .
                " LEFT JOIN blog_group_posts b ON a.ID = b.object_id " .
                " WHERE a.post_status = 'publish' and b.group_id='$cid'";
        } else {
            $q_total = "SELECT COUNT(*) FROM `blog_posts` WHERE  post_status = 'publish'";
        }
        $res = mysql_query($q_total);
        $total = mysql_fetch_row($res);
        return $total[0];
    }

    public static function get_publish_post_list($cat_id, $start, $per_page, &$res_count_rows)
    {
        if (!is_null($cat_id)) {
            $q = "SELECT a.* FROM `blog_posts` a" .
                " LEFT JOIN blog_group_posts b ON a.ID = b.object_id " .
                " WHERE a.post_status = 'publish' and b.group_id='$cat_id' ORDER BY a.post_date DESC, a.ID DESC LIMIT $start,$per_page";
        } else {
            $q = "SELECT * FROM `blog_posts` WHERE post_status = 'publish' ORDER BY post_date DESC, ID DESC LIMIT $start,$per_page";
        }
        $res = mysql_query($q);
        if ($res) {
            $res_count_rows = mysql_num_rows($res);
            $rows = [];
            while ($row = mysql_fetch_assoc($res)) {
                $rows[] = $row;
            }
            return $rows;
        }
        return false;

    }

    public static function get_count_posts($cid = null)
    {
        if (!is_null($cid)) {
            $q_total = "SELECT COUNT(*) FROM `blog_posts` a" .
                " LEFT JOIN blog_group_posts b ON a.ID = b.object_id " .
                " WHERE post_type = 'post' and b.group_id='$cid'";
        } else {
            $q_total = "SELECT COUNT(*) FROM `blog_posts` WHERE post_type = 'post'";
        }
        $res = mysql_query($q_total);
        return mysql_fetch_row($res)[0];
    }

    public static function get_post_list($cat_id, $start, $per_page, &$res_count_rows)
    {
        if (!is_null($cat_id)) {
            $q = "SELECT a.* FROM `blog_posts` a" .
                " LEFT JOIN blog_group_posts b ON a.ID = b.object_id " .
                " WHERE post_type = 'post' and b.group_id='$cat_id' ORDER BY a.post_date DESC, a.ID DESC LIMIT $start,$per_page";
        } else {
            $q = "SELECT * FROM `blog_posts` WHERE post_type = 'post' ORDER BY post_date DESC, ID DESC LIMIT $start,$per_page";
        }
        $res = mysql_query($q);
        if ($res) {
            $res_count_rows = mysql_num_rows($res);
            $rows = [];
            while ($row = mysql_fetch_assoc($res)) {
                $rows[] = $row;
            }
            return $rows;
        }
        return false;

    }
}