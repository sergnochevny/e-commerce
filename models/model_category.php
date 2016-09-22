<?php

Class Model_Category extends Model_Model
{

    public static function get_all($prms = null)
    {
        $q = "select * from fabrix_categories";
        if (isset($prms)) {
            $where = isset($prms['where']) ? $prms['where'] : '';
            $order = isset($prms['order']) ? $prms['order'] : '';
            $q .= ' ' . $where . ' ' . $order;
            $q = trim($q);
        }

        $results = mysql_query($q);
        $rows = null;
        if ($results) {
            while ($row = mysql_fetch_array($results)) {
                if ($row[4] == 1) {
                    $row[4] = "Yes";
                } else {
                    $row[4] = "No";
                }
                if ($row[5] == 1) {
                    $row[5] = "Yes";
                } else {
                    $row[5] = "No";
                }
                $rows[] = $row;
            }
        }
        return $rows;
    }

    public static function del($id)
    {
        if (!empty($id)) {
            $strSQL = "update fabrix_products set cid = NULL WHERE cid = $id";
            mysql_query($strSQL);

            $strSQL = "DELETE FROM fabrix_categories WHERE cid = $id";
            mysql_query($strSQL);
        }
    }

    public static function get_category($id)
    {
        $row = null;
        $resul = mysql_query("select * from fabrix_categories WHERE cid='$id' LIMIT 1");
        if ($resul) {
            $row = mysql_fetch_array($resul);
        }
        return $row;
    }

    public static function insert($post_category_name, $post_category_seo, $post_display_order, $post_category_ListStyle, $post_category_ListNewItem)
    {
        $strSQL = "INSERT INTO fabrix_categories(cname,seo,displayorder,isStyle,isNew) VALUES ('$post_category_name','$post_category_seo','$post_display_order','$post_category_ListStyle','$post_category_ListNewItem')";
        $res = mysql_query($strSQL);
        if ($res) {
            $category_id = mysql_insert_id();
            return $category_id;
        }
        return null;
    }

    public static function update($post_category_name,$post_category_seo,$post_display_order,$post_category_ListStyle,$post_category_ListNewItem,$category_id){
        if (!empty($category_id)) {

            $res = mysql_query("select * from fabrix_categories WHERE cid='$category_id'");
            $row = mysql_fetch_array($res);
            $displayorder = $row['displayorder'];
            $res = mysql_query("select * from fabrix_categories WHERE displayorder='$post_display_order'");
            $row = mysql_fetch_array($res);
            $cid = $row['cid'];
            mysql_query("update fabrix_categories set displayorder='$displayorder' WHERE cid ='$cid'");

            return mysql_query("update fabrix_categories set cname='$post_category_name', seo='$post_category_seo', displayorder='$post_display_order', isStyle='$post_category_ListStyle',  isNew='$post_category_ListNewItem' WHERE cid ='$category_id'");
        }
        return false;
    }

}