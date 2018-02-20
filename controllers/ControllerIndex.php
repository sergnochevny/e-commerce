<?php

namespace controllers;

use app\core\App;
use classes\controllers\ControllerController;

/**
 * class ControllerIndex
 */
class ControllerIndex extends ControllerController{

  /**
   * @param $row
   * @param $view
   * @return mixed
   */
  protected function build_sitemap_url($row, $view){
    return $row['loc'];
  }

  /**
   * @param int $page
   * @param bool $view
   * @param int $per_page
   * @return array|null
   * @throws \Exception
   */
  protected function sitemap_get_list($page = 0, $view = false, $per_page = 1000){
    $data = [
      ['loc' => App::$app->router()->UrlTo(''), 'changefreq' => 'monthly', 'priority' => 0.9,],
      ['loc' => App::$app->router()->UrlTo('shop'), 'changefreq' => 'daily', 'priority' => 0.7,],
      ['loc' => App::$app->router()->UrlTo('service'), 'changefreq' => 'monthly', 'priority' => 0.7,],
      ['loc' => App::$app->router()->UrlTo('estimator'), 'changefreq' => 'monthly', 'priority' => 0.7,],
      ['loc' => App::$app->router()->UrlTo('newsletter'), 'changefreq' => 'monthly', 'priority' => 0.7,],
      ['loc' => App::$app->router()->UrlTo('privacy'), 'changefreq' => 'monthly', 'priority' => 0.5,],
      ['loc' => App::$app->router()->UrlTo('about'), 'changefreq' => 'monthly', 'priority' => 0.5,],
      ['loc' => App::$app->router()->UrlTo('contact'), 'changefreq' => 'monthly', 'priority' => 0.5,],
      ['loc' => App::$app->router()->UrlTo('shop/specials'), 'changefreq' => 'daily', 'priority' => 0.6,],
      ['loc' => App::$app->router()->UrlTo('clearance'), 'changefreq' => 'daily', 'priority' => 0.6,],
      ['loc' => App::$app->router()->UrlTo('blog/view'), 'changefreq' => 'daily', 'priority' => 0.6,]
    ];

    return ($page > 1) ? null : $data;
  }

  /**
   * @return int
   */
  public static function sitemap_order(){
    return 0;
  }

  /**
   * @export
   * @param bool $required_access
   * @throws \Exception
   */
  public function index($required_access = true){
    $this->main->view('index');
  }

  /**
   * @export
   * @throws \Exception
   */
  public function service(){
    App::$app->router()->parse_referrer_url($route, $controller, $action, $args);
    if($controller == 'shop' && $action == 'product') {
      $this->template->vars('back_url', App::$app->server('HTTP_REFERER'));
    }
    $this->main->view('static/service');
  }

  /**
   * @export
   * @throws \Exception
   */
  public function estimator(){
    App::$app->router()->parse_referrer_url($route, $controller, $action, $args);
    if($controller == 'shop' && $action == 'product') {
      $this->template->vars('back_url', App::$app->server('HTTP_REFERER'));
    }
    $this->main->view('static/estimate');
  }

  /**
   * @export
   * @throws \Exception
   */
  public function newsletter(){
    App::$app->router()->parse_referrer_url($route, $controller, $action, $args);
    if($controller == 'shop' && $action == 'product') {
      $this->template->vars('back_url', App::$app->server('HTTP_REFERER'));
    }
    $this->main->view('static/newsletter');
  }

  /**
   * @export
   * @throws \Exception
   */
  public function privacy(){
    $this->main->view('static/privacy');
  }

  /**
   * @export
   * @throws \Exception
   */
  public function about(){
    $this->main->view('static/about');
  }

  /**
   * @export
   * @throws \Exception
   */
  public function message(){
    $this->main->message();
  }

  /**
   * @export
   * @throws \Exception
   */
  public function error404(){
    $this->main->error404();
  }

  /**
   * @param bool $partial
   * @param bool $required_access
   */
  public function view($partial = false, $required_access = false){
  }



//    function show_break_img_count()
//    {
//        set_time_limit(14400);
//        $q_total = "SELECT COUNT(*) FROM shop_products a" .
//            " WHERE a.priceyard > 0 and a.pnumber is not null and a.pvisible = '1'";
//        $res = mysqli_query(App::$app->getDBConnection('default'), $q_total);
//        $total = mysqli_fetch_row($res);
//        $total = $total[0];
//
//        $q = "SELECT pid FROM shop_products a" .
//            " WHERE a.priceyard > 0 and a.pnumber is not null and a.pvisible = '1'";
//        $res = mysqli_query(App::$app->getDBConnection('default'), $q);
//        $model = new ModelUsers();
//        $f = [1, 2, 3, 4, 5];
//        $total_break = 0;
//        $total_break_p = 0;
//        $total_break_v = 0;
//        while ($row = mysqli_fetch_assoc($res)) {
//            $pid = $row['pid'];
//            $images = $model->getImage($pid);
//            foreach ($f as $idx) {
//                $img = $images['image' . $idx];
//                if (!empty($img)) {
//                    $filename = 'images/products/' . $img;
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
//                    $filename = 'images/products/p_' . $img;
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
//                    $filename = 'images/products/v_' . $img;
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
