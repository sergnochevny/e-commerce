<?php

Class Model_Tools extends Model_Base
{

    public static function get_items_for_menu($type)
    {
        $res = [];
        $row_new_count = 50;
        switch ($type) {
            case 'all':
                $q = "SELECT distinct a.*" .
                    " FROM fabrix_categories a" .
                    " LEFT JOIN fabrix_product_categories c on a.cid = c.cid" .
                    " LEFT JOIN fabrix_products b ON b.pid = c.pid" .
                    " WHERE b.pvisible = '1'" .
                    " ORDER BY a.displayorder";
                break;
            case 'new':
                $q = "SELECT distinct a.*" .
                    " FROM (SELECT pid FROM fabrix_products WHERE pvisible = '1' ORDER BY dt DESC LIMIT " . $row_new_count . ") b" .
                    " LEFT JOIN fabrix_product_categories c ON b.pid = c.pid" .
                    " LEFT JOIN fabrix_categories a on a.cid = c.cid" .
                    " ORDER BY a.displayorder";
                break;
            case 'manufacturer':
                $q = "SELECT distinct a.*" .
                    " FROM fabrix_products b " .
                    " INNER JOIN fabrix_manufacturers a ON b.manufacturerId = a.id" .
                    " WHERE b.pvisible = '1'" .
                    " ORDER BY b.dt DESC";
                break;
            case 'patterns':
                $q = "SELECT distinct a.*" .
                    " FROM  fabrix_patterns a" .
                    " LEFT JOIN fabrix_product_patterns c on a.id = c.patternId" .
                    " LEFT JOIN fabrix_products b ON  b.pid = c.prodId" .
                    " WHERE b.pvisible = '1'";
                break;
            case 'blog_category':
                $q = "SELECT distinct a.*" .
                    " FROM blog_groups a" .
                    " LEFT JOIN blog_group_posts c on a.id = c.group_id" .
                    " LEFT JOIN blog_posts b ON b.id = c.post_id" .
                    " WHERE b.post_status = 'publish'";
                break;
        }
        $result = mysql_query($q);
        while ($row = mysql_fetch_assoc($result)) {
            $res[] = $row;
        }
        return $res;
    }

    public static function meta_page($route_control)
    {
        $page_Description = '';
        $page_KeyWords = '';
        $page_Name = '';

        $route_control = explode('/', $route_control)[0];
        if (_A_::$app->router()->controller == 'blog' && _A_::$app->router()->action=='post') {
            $post_id = !is_null(_A_::$app->get('post_id')) ? _A_::$app->get('post_id') : null;
            if (isset($post_id)) {
                $result = mysql_query("select post_title from blog_posts WHERE id='$post_id'");
                if ($result && mysql_num_rows($result) > 0) {
                    $row = mysql_fetch_assoc($result);
                    $page_Name = $row['post_title'];
                }
                $result = mysql_query("select * from blog_post_keys_descriptions WHERE post_id='$post_id'");
                if ($result && mysql_num_rows($result) > 0) {
                    $row = mysql_fetch_assoc($result);
                    $page_Description = stripslashes($row['description']);
                    $page_KeyWords = stripslashes($row['keywords']);
                }
            }
        } elseif ($route_control == "product") {
            $p_id = _A_::$app->get('pid');
            $result = mysql_query("select * from fabrix_products WHERE pid='$p_id'");
            $row = mysql_fetch_array($result);
            $page_Description = $row['metadescription'];
            $page_KeyWords = $row['metakeywords'];
            $page_Name = $row['pname'];
        } else {
            $result = mysql_query("SELECT * FROM page_title WHERE control LIKE '$route_control'");
            $row = mysql_fetch_array($result);
            if (!empty($row['id'])) {
                $page_Name = $row['name_page'];
                $page_Description = $row['m_desc'];
                $page_KeyWords = $row['m_key'];
            }
        }

        if (empty($page_Name{0})) {
            $page_Name = "Upholstery Fabric";
        }
        if (empty($page_Description{0})) {
            $page_Description = "Upholstery Fabric";
        }
        if (empty($page_KeyWords{0})) {
            $page_KeyWords = "Upholstery Fabric";
        }
        return array('page_KeyWords' => $page_KeyWords, 'page_Description' => $page_Description, 'page_Name' => $page_Name);
    }

}