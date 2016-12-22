<?php

  Class Model_Tools extends Model_Base {

    public static function get_items_for_menu($type) {
      $res = [];
      $row_new_count = 50;
      switch($type) {
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
          $q = "SELECT distinct a.*, c.group_id" .
            " FROM blog_groups a" .
            " LEFT JOIN blog_group_posts c on a.id = c.group_id" .
            " LEFT JOIN blog_posts b ON b.id = c.post_id" .
            " WHERE b.post_status = 'publish'";
          break;
      }
      $result = mysql_query($q);
      while($row = mysql_fetch_assoc($result)) {
        $res[] = $row;
      }
      return $res;
    }

    public static function meta_page() {
      $description = '';
      $keywords = '';
      $title = '';

      if(empty($title) && empty($description) && empty($keywords)) {
        $q = "SELECT * FROM page_meta WHERE controller = '" . _A_::$app->router()->controller . "'";
        if(!empty(_A_::$app->router()->action) && (_A_::$app->router()->controller !== _A_::$app->router()->action))
          $q .= " AND action = '" . _A_::$app->router()->action . "'";
        else $q .= " AND action is null";
        $result = mysql_query($q);
        $row = mysql_fetch_array($result);
        if(!empty($row['id'])) {
          $title = $row['title'];
          $description = $row['description'];
          $keywords = $row['keywords'];
        }
      }

      if(empty($title)) $title = _A_::$app->keyStorage()->system_site_name;
      if(empty($description)) $description = _A_::$app->keyStorage()->system_site_name;
      if(empty($keywords)) {
        $keywords = array_filter(explode(' ', strtolower(_A_::$app->keyStorage()->system_site_name)));
        array_unshift($keywords, strtolower(_A_::$app->keyStorage()->system_site_name));
        $keywords = implode(',', $keywords);
      }
      return ['keywords' => $keywords, 'description' => $description, 'title' => $title];
    }

  }