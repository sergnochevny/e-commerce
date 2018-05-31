<?php

namespace models;

use app\core\App;
use app\core\model\ModelBase;
use Exception;

/**
 * Class ModelProduct
 * @package models
 */
class ModelProduct extends ModelBase{

  /**
   * @var string
   */
  protected static $table = 'shop_products';

  /**
   * @param $filter
   * @param null $prms
   * @return array|string
   */
  public static function BuildWhere(&$filter, &$prms = null){
    $return = "";
    if(isset($filter["a.pname"])) {
      foreach(array_filter(explode(' ', $filter["a.pname"])) as $idx => $item) {
        if(!empty($item)) {
          $result[] = "a.pname LIKE :a_pname" . $idx . "";
          $prms['a_pname' . $idx] = '%' . $item . '%';
        }
      }
    }
    if(isset($filter['a.pvisible'])) {
      $result[] = "a.pvisible = :apvisible";
      $prms['apvisible'] = $filter["a.pvisible"];
    }
    if(isset($filter["a.pnumber"])) {
      $result[] = "a.pnumber LIKE :apnumber";
      $prms['apnumber'] = '%' . $filter["a.pnumber"] . '%';
    }
    if(isset($filter["a.dt"])) {
      $where = '';
      if(!empty($filter["a.dt"]['from'])) {
        $where = "a.dt >= :adt_from";
        $prms['adt_from'] = $filter["a.dt"]["from"];
      }
      if(!empty($filter["a.dt"]['to'])) {
        $where .= " AND a.dt <= :adt_to";
        $prms['adt_to'] = $filter["a.dt"]["to"];
      }
      if(strlen(trim($where)) > 0) $result[] = "(" . $where . ")";
    }

    if(isset($filter["b.cid"])) {
      $result[] = "b.cid = :bcid";
      $prms['bcid'] = $filter["b.cid"];
    }
    if(isset($filter["c.id"])) {
      $result[] = "c.id = :cid";
      $prms['cid'] = $filter["c.id"];
    }
    if(isset($filter["d.id"])) {
      $result[] = "d.id = :did";
      $prms['did'] = $filter["d.id"];
    }
    if(isset($filter["e.id"])) {
      $result[] = "e.id = :eid";
      $prms['eid'] = $filter["e.id"];
    }
    if(isset($filter["a.best"])) {
      $result[] = "a.best = :abest";
      $prms['abest'] = $filter["a.best"];
    }
    if(isset($filter["a.specials"])) {
      $result[] = "a.specials = :aspecials";
      $prms['aspecials'] = $filter["a.specials"];
    }
    if(isset($filter["a.priceyard"]['from']) && !empty((float)$filter["a.priceyard"]['from'])) {
      $result[] = "a.priceyard > :apriceyard_from";
      $prms['apriceyard_from'] = $filter["a.priceyard"]['from'];
    }
    if(isset($filter["a.priceyard"]['to']) && !empty((float)$filter["a.priceyard"]['to'])) {
      $result[] = "a.priceyard <= :apriceyard_to";
      $prms['apriceyard_to'] = $filter["a.priceyard"]['to'];
    }

    if(isset($filter['a.piece'])) {
      $result[] = "a.piece = :apiece";
      $prms['apiece'] = $filter["a.piece"];
    }

    if(!empty($result) && (count($result) > 0)) {
      $return = implode(" AND ", $result);
      if(strlen(trim($return)) > 0) {
        $return = " WHERE " . $return;
        $filter['active'] = true;
      }
    }

    return $return;
  }

  /**
   * @param $filename
   */
  public static function delete_img($filename){
    if(!empty($filename)) {
      if(file_exists(APP_PATH . '/web/images/products/' . $filename)) {
        unlink(APP_PATH . '/web/images/products/' . $filename);
      }
      if(file_exists(APP_PATH . '/web/images/products/b_' . $filename)) {
        unlink(APP_PATH . '/web/images/products/b_' . $filename);
      }
      if(file_exists(APP_PATH . '/web/images/products/v_' . $filename)) {
        unlink(APP_PATH . '/web/images/products/v_' . $filename);
      }
    }
  }

  /**
   * @param $type
   * @param $data
   * @throws \Exception
   */
  public static function get_filter_selected($type, &$data){
    $id = $data['pid'];
    $filters = [];
    switch($type) {
      case 'colors':
        $colors = isset($data['colors']) ? array_keys($data['colors']) : [];
        if(isset($data['colors_select']) || isset($data['colors'])) $select = implode(',', array_merge(isset($data['colors_select']) ? $data['colors_select'] : [], $colors)); else {
          $data['colors'] = self::get_filter_selected_data($type, $id);
          $select = implode(',', isset($data['colors']) ? array_keys($data['colors']) : []);
        }
        if(strlen($select) > 0) {
          if($results = static::Query("select * from shop_color where id in ($select) order by color")) {
            while($row = static::FetchArray($results)) {
              $filters[$row['id']] = $row['color'];
            }
            static::FreeResult($results);
          }
        }
        break;
      case 'patterns':
        $patterns = isset($data['patterns']) ? array_keys($data['patterns']) : [];
        if(isset($data['patterns_select']) || isset($data['patterns'])) $select = implode(',', array_merge(isset($data['patterns_select']) ? $data['patterns_select'] : [], $patterns)); else {
          $data['patterns'] = self::get_filter_selected_data($type, $id);
          $select = implode(',', isset($data['patterns']) ? array_keys($data['patterns']) : []);
        }
        if(strlen($select) > 0) {
          if($results = static::Query(
            "select * " .
            "from shop_patterns" .
            " where id in ($select)" .
            " order by pattern"
          )) {
            while($row = static::FetchArray($results)) {
              $filters[$row['id']] = $row['pattern'];
            }
          }
          static::FreeResult($results);
        }
        break;
      case 'categories':
        $categories = isset($data['categories']) ? array_keys($data['categories']) : [];
        if(isset($data['categories_select']) || isset($data['categories'])) {
          $select = implode(',', array_merge(isset($data['categories_select']) ? $data['categories_select'] : [], $categories));
          $categories = $data['categories'];
        } else {
          $data['categories'] = self::get_filter_selected_data($type, $id);
          $select = implode(',', isset($data['categories']) ? array_keys($data['categories']) : []);
          $categories = isset($data['categories']) ? $data['categories'] : [];
          foreach($categories as $key => $val) {
            $categories[$key] = $val[1];
          }
        }
        if(strlen($select) <= 0) $select = '1';
        if($results = static::Query(
          "select a.cid, a.cname, (max(b.display_order)+1) as pos " .
          "from shop_categories a" .
          " left join shop_product_categories b on b.cid = a.cid" .
          " where a.cid in ($select)" .
          " group by a.cid, a.cname" .
          " order by a.cname"
        )) {
          while($row = static::FetchArray($results)) {
            $filters[$row['cid']] = [
              $row['cname'], isset($categories[$row['cid']]) ? $categories[$row['cid']] : $row['pos']
            ];
          }
          static::FreeResult($results);
        }
        break;
    }
    $data[$type] = $filters;
  }

  /**
   * @param $type
   * @param $id
   * @return array
   * @throws \Exception
   */
  public static function get_filter_selected_data($type, $id){
    $data = [];
    switch($type) {
      case 'patterns':
        $results = static::Query(
          "select a.* " .
          "from shop_product_patterns b" .
          " inner join shop_patterns a on b.patternId=a.id " .
          " where b.prodId=:id" .
          " order by a.pattern",
          ['id' => $id]
        );
        if($results) {
          while($row = static::FetchArray($results)) {
            $data[$row['id']] = $row['pattern'];
          }
          static::FreeResult($results);
        }
        break;
      case 'colors':
        $results = static::Query(
          "select a.* " .
          "from shop_product_colors b" .
          " inner join shop_color a on b.colorId=a.id " .
          " where b.prodId=:id" .
          " order by a.color",
          ['id' => $id]
        );
        if($results) {
          while($row = static::FetchArray($results)) {
            $data[$row['id']] = $row['color'];
          }
          static::FreeResult($results);
        }
        break;
      case 'categories':
        $results = static::Query(
          "select a.cid, a.cname, b.display_order " .
          "from shop_product_categories b" .
          " inner join shop_categories a on b.cid=a.cid " .
          " where b.pid=:id" .
          " order by a.cname",
          ['id' => $id]
        );
        if($results) {
          while($row = static::FetchArray($results)) {
            $data[$row['cid']] = [$row['cname'], $row['display_order']];
          }
          static::FreeResult($results);
        }
        break;
      case 'manufacturers':
        $results = static::Query(
          "select a.cid, a.manufacturer" .
          " from shop_manufacturers a" .
          " order by a.manufacturer"
        );
        if($results) {
          while($row = static::FetchArray($results)) {
            $data[$row['id']] = $row['manufacturer'];
          }
          static::FreeResult($results);
        }
        break;
    }

    return $data;
  }

  /**
   * @param $type
   * @param $count
   * @param int $start
   * @param null $search
   * @return array|null
   * @throws \Exception
   */
  public static function get_filter_data($type, &$count, $start = 0, $search = null){
    $filter = null;
    $filter_limit = !is_null(App::$app->KeyStorage()->system_filter_amount) ?
      App::$app->KeyStorage()->system_filter_amount : FILTER_LIMIT;
    $start = isset($start) ? $start : 0;
    $search = static::sanitize($search);
    switch($type) {
      case 'colors':
        $q = "SELECT count(id) FROM shop_color";
        if(isset($search) && (strlen($search) > 0)) {
          $q .= " where color like :search";
        }
        $results = static::Query($q, ['search' => '%' . $search . '%']);
        $count = static::FetchValue($results);
        $q = "SELECT * FROM shop_color";
        if(isset($search) && (strlen($search) > 0)) {
          $q .= " where color like :search";
        }
        $q .= " order by color";
        $q .= " limit $start, $filter_limit";
        if($results = static::Query($q, ['search' => '%' . $search . '%'])) {
          while($row = static::FetchArray($results)) {
            $filter[] = [$row['id'], $row['color']];
          }
          static::FreeResult($results);
        }
        break;
      case 'patterns':
        $q = "SELECT count(id) FROM shop_patterns";
        if(isset($search) && (strlen($search) > 0)) {
          $q .= " where pattern like :search";
        }
        $results = static::Query($q, ['search' => '%' . $search . '%']);
        $count = static::FetchValue($results);
        $q = "SELECT * FROM shop_patterns";
        if(isset($search) && (strlen($search) > 0)) {
          $q .= " where pattern like :search";
        }
        $q .= " order by pattern";
        $q .= " limit $start, $filter_limit";
        if($results = static::Query($q, ['search' => '%' . $search . '%'])) {
          while($row = static::FetchArray($results)) {
            $filter[] = [$row['id'], $row['pattern']];
          }
          static::FreeResult($results);
        }
        break;
      case 'categories':
        $q = "SELECT count(cid) FROM shop_categories";
        if(isset($search) && (strlen($search) > 0)) {
          $q .= " where cname like :search";
        }
        $results = static::Query($q, ['search' => '%' . $search . '%']);
        $count = static::FetchValue($results);
        $q = "SELECT * FROM shop_categories";
        if(isset($search) && (strlen($search) > 0)) {
          $q .= " where cname like :search";
        }
        $q .= " order by cname";
        $q .= " limit $start, $filter_limit";
        if($results = static::Query($q, ['search' => '%' . $search . '%'])) {
          while($row = static::FetchArray($results)) {
            $filter[] = [$row['cid'], $row['cname']];
          }
          static::FreeResult($results);
        }
    }

    return $filter;
  }

  /**
   * @return array
   * @throws \Exception
   */
  public static function get_manufacturers(){
    $data = [];
    $filter = null;
    $sort = ['a.manufacturer' => 'asc'];
    $rows = ModelManufacturers::get_list(0, 0, $res_count, $filter, $sort);
    foreach($rows as $row) {
      $data[$row['id']] = $row['manufacturer'];
    }

    return $data;
  }

  /**
   * @param null $filter
   * @return int|null
   * @throws \Exception
   */
  public static function get_total_count($filter = null){
    $response = 0;
    $query = "SELECT COUNT(DISTINCT a.pid) FROM " . static::$table . " a";
    $query .= " LEFT JOIN shop_product_categories ON a.pid = shop_product_categories.pid";
    $query .= " LEFT JOIN shop_categories b ON shop_product_categories.cid = b.cid";
    $query .= " LEFT JOIN shop_product_colors ON a.pid = shop_product_colors.prodId";
    $query .= " LEFT JOIN shop_color c ON shop_product_colors.colorId = c.id";
    $query .= " LEFT JOIN shop_product_patterns ON a.pid = shop_product_patterns.prodId";
    $query .= " LEFT JOIN shop_patterns d ON d.id = shop_product_patterns.patternId";
    $query .= " LEFT JOIN shop_manufacturers e ON a.manufacturerId = e.id";
    $query .= static::BuildWhere($filter, $prms);
    if($result = static::Query($query, $prms)) {
      $response = static::FetchValue($result);
      static::FreeResult($result);
    }

    return $response;
  }

  /**
   * @param $start
   * @param $limit
   * @param $res_count_rows
   * @param null $filter
   * @param null $sort
   * @return array|null
   * @throws \Exception
   */
  public static function get_list($start, $limit, &$res_count_rows, &$filter = null, &$sort = null){
    $response = [];
    $query = "SELECT DISTINCT a.* ";
    $query .= " FROM " . static::$table . " a";
    $query .= " LEFT JOIN shop_product_categories ON a.pid = shop_product_categories.pid";
    $query .= " LEFT JOIN shop_categories b ON shop_product_categories.cid = b.cid";
    $query .= " LEFT JOIN shop_product_colors ON a.pid = shop_product_colors.prodId";
    $query .= " LEFT JOIN shop_color c ON shop_product_colors.colorId = c.id";
    $query .= " LEFT JOIN shop_product_patterns ON a.pid = shop_product_patterns.prodId";
    $query .= " LEFT JOIN shop_patterns d ON d.id = shop_product_patterns.patternId";
    $query .= " LEFT JOIN shop_manufacturers e ON a.manufacturerId = e.id";
    $query .= static::BuildWhere($filter, $prms);
    $query .= static::BuildOrder($sort);
    if($limit != 0) $query .= " LIMIT $start, $limit";

    if($result = static::Query($query, $prms)) {
      $res_count_rows = static::getNumRows($result);
      while($row = static::FetchArray($result)) {
        $filename = 'images/products/b_' . $row['image1'];
        if(!(file_exists(APP_PATH . '/web/' . $filename) && is_file(APP_PATH . '/web/' . $filename))) {
          $filename = 'images/not_image.jpg';
        }
        $row['filename'] = App::$app->router()->UrlTo($filename);

        $price = $row['priceyard'];
        $inventory = $row['inventory'];
        $piece = $row['piece'];
        $row['price'] = ModelPrice::getPrintPrice($price, $format_price, $inventory, $piece);
        $row['format_price'] = $format_price;
        $response[] = $row;
      }
      static::FreeResult($result);
    }

    return $response;
  }

  /**
   * @param $id
   * @return array|null
   * @throws \Exception
   */
  public static function get_by_id($id){
    $data = [
      'pid' => null, 'metadescription' => '', 'metakeywords' => '', 'metatitle' => '', 'pname' => '', 'pnumber' => '',
      'width' => '', 'inventory' => '0.00', 'priceyard' => '0.00', 'hideprice' => 0, 'dimensions' => '', 'weight' => 0,
      'manufacturerId' => '', 'sdesc' => '', 'ldesc' => '', 'weight_id' => '', 'specials' => 0, 'pvisible' => 0,
      'best' => 0, 'piece' => 0, 'whole' => 0, 'stock_number' => '', 'image1' => '', 'image2' => '', 'image3' => '',
      'image4' => '', 'image5' => ''
    ];
    if(isset($id)) {
      $q = "SELECT * FROM " . static::$table . " WHERE pid = :pid";
      $result = static::Query($q, ['pid' => $id]);
      if($result) {
        $data = static::FetchAssoc($result);
        static::FreeResult($result);
      }
    }

    if ($data === false){
      throw new Exception('Data set is empty!');
    }

    return $data;
  }

  /**
   * @param $uploaddir
   * @param $imagename
   */
  public static function convert_image($uploaddir, $imagename){

    $size = getimagesize($uploaddir . $imagename);
    $imgWidth = $size[0];
    $imgHeight = $size[1];

    $imagefrom = imagecreatefromjpeg($uploaddir . $imagename);

    $imagetovbig = imagecreatetruecolor(760, 569);
    imagecopyresampled($imagetovbig, $imagefrom, 0, 0, 0, 0, 760, 569, $imgWidth, $imgHeight);
    imagejpeg($imagetovbig, $uploaddir . "/v_" . $imagename, 85);
    imagedestroy($imagetovbig);

    $imagetobig = imagecreatetruecolor(230, 170);
    imagecopyresampled($imagetobig, $imagefrom, 0, 0, 0, 0, 230, 170, $imgWidth, $imgHeight);
    imagejpeg($imagetobig, $uploaddir . "/b_" . $imagename, 85);
    imagedestroy($imagetobig);

    $imagetosmall = imagecreatetruecolor(100, 70);
    imagecopyresampled($imagetosmall, $imagefrom, 0, 0, 0, 0, 100, 70, $imgWidth, $imgHeight);
    imagejpeg($imagetosmall, $uploaddir . "/" . $imagename, 85);
    imagedestroy($imagefrom);
  }

  /**
   * @param $pid
   * @param $data
   * @return mixed
   * @throws \Exception
   */
  public static function update_images($pid, &$data){
    $images = static::get_by_id($pid);
    $fields_idx = [1, 2, 3, 4, 5];
    foreach($fields_idx as $idx) {
      $filename = $data['image' . $idx];
      if(!empty($filename)) {
        if(substr($filename, 0, strlen($pid) + 1) !== 'p' . $pid) {
          static::delete_img($images['image' . $idx]);
          $filename = 'p' . $pid . $filename;
          if(file_exists(APP_PATH . '/web/images/products/' . $data['image' . $idx])) {
            rename(APP_PATH . '/web/images/products/' . $data['image' . $idx],
              APP_PATH . '/web/images/products/' . $filename);
          }
          if(file_exists(APP_PATH . '/web/images/products/b_' . $data['image' . $idx])) {
            rename(APP_PATH . '/web/images/products/b_' . $data['image' . $idx],
              APP_PATH . '/web/images/products/b_' . $filename);
          }
          if(file_exists(APP_PATH . '/web/images/products/v_' . $data['image' . $idx])) {
            rename(APP_PATH . '/web/images/products/v_' . $data['image' . $idx],
              APP_PATH . '/web/images/products/v_' . $filename);
          }
          $data['image' . $idx] = $filename;
        }
      }
    }
    extract($data);
    /**
     * @var string $image1
     * @var string $image2
     * @var string $image3
     * @var string $image4
     * @var string $image5
     */
    $q = "update " . static::$table .
      " set" .
      " image1=:image1, image2=:image2, image3=:image3," .
      " image4=:image4, image5=:image5 where pid = :pid";

    return static::Query($q, [
      'image1' => $image1, 'image2' => $image2, 'image3' => $image3,
      'image4' => $image4, 'image5' => $image5, 'pid' => $pid
    ]);
  }

  /**
   * @param $data
   */
  public static function delete_images(&$data){
    $fields_idx = [1, 2, 3, 4, 5];
    foreach($fields_idx as $idx) {
      self::delete_img($data['image' . $idx]);
    }
  }

  /**
   * @param $data
   * @return mixed
   * @throws \Exception
   */
  public static function Save(&$data){
    static::BeginTransaction();
    try {
      extract($data);
      /**
       * @var integer $pid
       * @var string $weight_id
       * @var string $manufacturerId
       * @var string $specials
       * @var string $inventory
       * @var string $dimensions
       * @var string $hideprice
       * @var string $stock_number
       * @var string $priceyard
       * @var string $width
       * @var string $pnumber
       * @var string $pvisible
       * @var string $metatitle
       * @var string $metakeywords
       * @var string $metadescription
       * @var string $ldesc
       * @var string $pname
       * @var string $sdesc
       * @var string $best
       * @var string $piece
       * @var string $whole
       * @var array $categories
       * @var array $colors
       * @var array $patterns
       * @var array $related
       */
      $prms = [
        'specials' => $specials, 'inventory' => $inventory,
        'dimensions' => $dimensions, 'hideprice' => $hideprice, 'stock_number' => $stock_number,
        'priceyard' => $priceyard, 'width' => $width, 'pnumber' => $pnumber, 'pvisible' => $pvisible,
        'metatitle' => $metatitle, 'metakeywords' => $metakeywords, 'metadescription' => $metadescription,
        'ldesc' => $ldesc, 'pname' => $pname, 'sdesc' => $sdesc, 'best' => $best, "piece" => $piece,
        'whole' => $whole
      ];
      if(isset($pid)) {
        $prms['pid'] = $pid;
        $sql = "UPDATE " . static::$table . " SET";
        if(!empty($manufacturerId) && ($manufacturerId != 0)) {
          $sql .= " manufacturerId=:manufacturerId,";
          $prms['manufacturerId'] = $manufacturerId;
        }
        if(!empty($weight_id) && ($weight_id != 0)) {
          $sql .= " weight_id=:weight_id,";
          $prms['weight_id'] = $weight_id;
        }
        $sql .= " specials=:specials, inventory=:inventory,";
        $sql .= " dimensions=:dimensions, hideprice=:hideprice, stock_number=:stock_number, priceyard=:priceyard,";
        $sql .= " width=:width, pnumber=:pnumber, pvisible=:pvisible, metatitle=:metatitle, metakeywords=:metakeywords,";
        $sql .= " metadescription=:metadescription, ldesc=:ldesc, pname=:pname, sdesc=:sdesc, best=:best,";
        $sql .= " piece=:piece, whole = :whole  WHERE pid =:pid";
        $result = static::Query($sql, $prms);
      } else {
        $sql = "INSERT INTO " . static::$table . " SET";
        if(!empty($manufacturerId) && ($manufacturerId != 0)) {
          $sql .= " manufacturerId=:manufacturerId,";
          $prms['manufacturerId'] = $manufacturerId;
        }
        if(!empty($weight_id) && ($weight_id != 0)) {
          $sql .= " weight_id=:weight_id,";
          $prms['weight_id'] = $weight_id;
        }
        $sql .= " specials=:specials, inventory=:inventory,";
        $sql .= " dimensions=:dimensions, hideprice=:hideprice, stock_number=:stock_number, priceyard=:priceyard,";
        $sql .= " width=:width, pnumber=:pnumber, pvisible=:pvisible, metatitle=:metatitle, metakeywords=:metakeywords,";
        $sql .= " metadescription=:metadescription, ldesc=:ldesc, pname=:pname, sdesc=:sdesc, best=:best,";
        $sql .= " piece=:piece, whole = :whole  WHERE pid =:pid";
        $result = static::Query($sql, $prms);
        if($result) {
          $pid = static::LastId();
          $data['pid'] = $pid;
        }
      }
      if($result) {
        $result = static::update_images($pid, $data);
      }
      if($result) {
        $res = true;
        if($res && (count($categories) > 0)) {
          $res = static::Query("SELECT * FROM shop_product_categories  WHERE pid=:pid", ['pid' => $pid]);
          if($res) {
            $result = $res;
            while($category = static::FetchAssoc($res)) {
              $result = $result && static::Query(
                  "DELETE FROM shop_product_categories WHERE pid = :pid AND cid = :cid",
                  ['pid' => $category['pid'], 'cid' => $category['cid']]
                );
              $result = $result && static::Query(
                  "UPDATE shop_product_categories SET display_order=display_order-1 " .
                  "WHERE display_order > :display_order AND cid=:cid",
                  ['display_order' => $category['display_order'], 'cid' => $category['cid']]
                );
              if(!$result) {
                $res = $result;
                break;
              }
            }
          }
        } elseif($res) {
          if(!(isset($categories) && is_array($categories) && count($categories) > 0)) {
            static::Query("DELETE FROM shop_product_categories WHERE pid = :pid", ['pid' => $pid]);
            $q = "select a.cid, if(b.display_order is null, 1, (max(b.display_order)+1)) as pos" .
              " from shop_categories a" .
              " left join shop_product_categories b on a.cid = b.cid" .
              " where a.cid = 1";
            $res = static::Query($q);
            if($res) {
              $row = static::FetchArray($res, MYSQLI_NUM);
              $categories = [$row['cid'] => $row['pos']];
              $data['categories'] = $categories;
            }
          }
        }
        if($res) {
          foreach($categories as $cid => $category) {
            $res = $res && static::Query(
                "UPDATE shop_product_categories SET display_order=display_order+1 " .
                "WHERE display_order >= :display_order AND cid=:cid",
                ['display_order' => $category, "cid" => $cid]
              );
            $res = $res && static::Query(
                'REPLACE INTO shop_product_categories SET pid=:pid, cid=:cid, display_order = :display_order',
                ['pid' => $pid, 'cid' => $cid, 'display_order' => $category]
              );
            if(!$res) break;
          }
        }
        if($res) $res = $res && static::Query(
            'DELETE FROM shop_product_colors WHERE prodID=:pid',
            ['pid' => $pid]
          );
        if($res && (count($colors) > 0)) {
          foreach($colors as $colorId) {
            $res = $res && static::Query(
                'REPLACE INTO shop_product_colors SET prodID=:pid, colorId=:cid',
                ['pid' => $pid, 'cid' => $colorId]
              );
            if(!$res) break;
          }
        }
        if($res) $res = $res && static::Query(
            'DELETE FROM shop_product_patterns WHERE prodID=:pid',
            ['pid' => $pid]
          );
        if($res && (count($patterns) > 0)) {
          foreach($patterns as $patternId) {
            $res = $res && static::Query(
                'REPLACE INTO shop_product_patterns SET prodID=:pid, patternId=:patternId',
                ['pid' => $pid, 'patternId' => $patternId]
              );
            if(!$res) break;
          }
        }
        if($res) $res = $res && static::Query('DELETE FROM shop_product_related WHERE  pid=:pid', ['pid' => $pid]);
        if($res && (count($related) > 0)) {
          foreach($related as $r_pid) {
            $res = $res && static::Query('REPLACE INTO shop_product_related SET pid = :pid, r_pid = :r_pid',
                ['pid' => $pid, 'r_pid' => $r_pid]
              );
            if(!$res) break;
          }
        }
        $result = $result && $res;
      }
      if(!$result) {
        throw new Exception(static::Error());
      }
      ModelCollectionTrigger::setTriggers();
      static::Commit();
    } catch(Exception $e) {
      static::RollBack();
      throw $e;
    }

    return $pid;
  }

  /**
   * @param $id
   * @throws \Exception
   */
  public static function Delete($id){
    static::BeginTransaction();
    try {
      if(isset($id)) {
        $data = static::get_by_id($id);
        $query = "DELETE FROM " . static::$table . " WHERE pid = :id";
        $res = static::Query($query, ['id' => $id]);
        $query = "DELETE FROM shop_product_related WHERE pid = :id OR r_pid = :r_id";
        if($res) $res = static::Query($query, ['id' => $id, 'r_id' => $id]);
        $query = "DELETE FROM shop_clearance WHERE pid = :id";
        if($res) $res = static::Query($query, ['id' => $id]);
        $query = "DELETE FROM shop_product_favorites WHERE pid = :id";
        if($res) $res = static::Query($query, ['id' => $id]);
        $query = "DELETE FROM shop_product_categories WHERE pid = :id";
        if($res) $res = static::Query($query, ['id' => $id]);
        $query = "DELETE FROM shop_product_colors WHERE prodId = :id";
        if($res) $res = static::Query($query, ['id' => $id]);
        $query = "DELETE FROM shop_product_patterns WHERE prodId = :id";
        if($res) $res = static::Query($query, ['id' => $id]);
        $query = "DELETE FROM shop_specials_products WHERE pid = :id";
        if($res) $res = static::Query($query, ['id' => $id]);
        if(!$res) throw new Exception(static::Error());
        static::delete_images($data);
      }
      ModelCollectionTrigger::setTriggers();
      static::Commit();
    } catch(Exception $e) {
      static::RollBack();
      throw $e;
    }
  }

//    public static function get_id_by_condition($condition) {
//      $res = null;
//      if(!empty(trim($condition))) {
//        $query = "select * from " . static::$table . " WHERE " . $condition;
//        $query .= " LIMIT 0, 1";
//        $results = static::Query($query, $prms);
//        if ($results && !empty($row = static::FetchAssoc($results)))  $res = $row['pid'];
//      }
//      return $res;
//    }

}