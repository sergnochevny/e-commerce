<?php

  Class Controller_Index Extends Controller_Controller {

    protected function build_sitemap_url($row, $view) {
      return $row['loc'];
    }

    protected function sitemap_get_list($page = 0, $view = false, $per_page = 1000) {
      $data = [
        [
          'loc' => _A_::$app->router()->UrlTo(''),
          'changefreq' => 'monthly',
          'priority' => 0.9,
        ],
        [
          'loc' => _A_::$app->router()->UrlTo('shop'),
          'changefreq' => 'daily',
          'priority' => 0.7,
        ],
        [
          'loc' => _A_::$app->router()->UrlTo('service'),
          'changefreq' => 'monthly',
          'priority' => 0.7,
        ],
        [
          'loc' => _A_::$app->router()->UrlTo('estimator'),
          'changefreq' => 'monthly',
          'priority' => 0.7,
        ],
        [
          'loc' => _A_::$app->router()->UrlTo('newsletter'),
          'changefreq' => 'monthly',
          'priority' => 0.7,
        ],
        [
          'loc' => _A_::$app->router()->UrlTo('privacy'),
          'changefreq' => 'monthly',
          'priority' => 0.5,
        ],
        [
          'loc' => _A_::$app->router()->UrlTo('about'),
          'changefreq' => 'monthly',
          'priority' => 0.5,
        ],
        [
          'loc' => _A_::$app->router()->UrlTo('contact'),
          'changefreq' => 'monthly',
          'priority' => 0.5,
        ],
        [
          'loc' => _A_::$app->router()->UrlTo('shop/specials'),
          'changefreq' => 'daily',
          'priority' => 0.6,
        ],
        [
          'loc' => _A_::$app->router()->UrlTo('clearance'),
          'changefreq' => 'daily',
          'priority' => 0.6,
        ],
        [
          'loc' => _A_::$app->router()->UrlTo('blog/view'),
          'changefreq' => 'daily',
          'priority' => 0.6,
        ],
        [
          'loc' => _A_::$app->router()->UrlTo('prices/view'),
          'changefreq' => 'daily',
          'priority' => 0.6,
        ],
        [
          'loc' => _A_::$app->router()->UrlTo('colours/view'),
          'changefreq' => 'daily',
          'priority' => 0.6,
        ],
        [
          'loc' => _A_::$app->router()->UrlTo('categories/view'),
          'changefreq' => 'daily',
          'priority' => 0.6,
        ],
        [
          'loc' => _A_::$app->router()->UrlTo('patterns/view'),
          'changefreq' => 'daily',
          'priority' => 0.6,
        ],
        [
          'loc' => _A_::$app->router()->UrlTo('manufacturers/view'),
          'changefreq' => 'daily',
          'priority' => 0.6,
        ],
      ];
      return ($page > 1) ? null : $data;
    }

    public static function sitemap_order() { return 0; }

    /**
     * @export
     */
    public function index($required_access = true) {
      $this->main->view('index');
    }

    /**
     * @export
     */
    public function service() {
      $this->main->view('static/service');
    }

    /**
     * @export
     */
    public function estimator() {
      $this->main->view('static/estimate');
    }

    /**
     * @export
     */
    public function newsletter() {
      $this->main->view('static/newsletter');
    }

    /**
     * @export
     */
    public function privacy() {
      $this->main->view('static/privacy');
    }

    /**
     * @export
     */
    public function about() {
      $this->main->view('static/about');
    }

    /**
     * @export
     */
    public function message() {
      $this->main->message();
    }

    /**
     * @export
     */
    public function error404() {
      $this->main->error404();
    }

    public function view() { }



//    function show_break_img_count()
//    {
//        set_time_limit(14400);
//        $q_total = "SELECT COUNT(*) FROM fabrix_products a" .
//            " WHERE  a.pnumber is not null and a.pvisible = '1'";
//        $res = mysql_query($q_total);
//        $total = mysql_fetch_row($res);
//        $total = $total[0];
//
//        $q = "SELECT pid FROM fabrix_products a" .
//            " WHERE  a.pnumber is not null and a.pvisible = '1'";
//        $res = mysql_query($q);
//        $model = new Model_Users();
//        $f = [1, 2, 3, 4, 5];
//        $total_break = 0;
//        $total_break_p = 0;
//        $total_break_v = 0;
//        while ($row = mysql_fetch_assoc($res)) {
//            $pid = $row['pid'];
//            $images = $model->getImage($pid);
//            foreach ($f as $idx) {
//                $img = $images['image' . $idx];
//                if (!empty($img)) {
//                    $filename = 'upload/upload/' . $img;
//                    if (file_exists($filename) && is_readable($filename)) {
//                        $size_img = getimagesize($filename);
//                        if ($size_img) {
//                            $h = $size_img[0];
//                            $w = $size_img[1];
//                            if ($w == 0 || $h == 0) {
//                                $total_break++;
//                            }
//                        } else {
//                            $total_break++;
//                        }
//                    } else {
//                        $total_break++;
//                    }
//                    $filename = 'upload/upload/p_' . $img;
//                    if (file_exists($filename) && is_readable($filename)) {
//                        $size_img = getimagesize($filename);
//                        if ($size_img) {
//                            $h = $size_img[0];
//                            $w = $size_img[1];
//                            if ($w == 0 || $h == 0) {
//                                $total_break_p++;
//                            }
//                        } else {
//                            $total_break_p++;
//                        }
//                    } else {
//                        $total_break_p++;
//                    }
//                    $filename = 'upload/upload/v_' . $img;
//                    if (file_exists($filename) && is_readable($filename)) {
//                        $size_img = getimagesize($filename);
//                        if ($size_img) {
//                            $h = $size_img[0];
//                            $w = $size_img[1];
//                            if ($w == 0 || $h == 0) {
//                                $total_break_v++;
//                            }
//                        } else {
//                            $total_break_v++;
//                        }
//                    } else {
//                        $total_break_v++;
//                    }
//                }
//            }
//        }
//        echo $total . ' | ' . $total_break . ' | ' . $total_break_p . ' | ' . $total_break_v;
//    }

  }
