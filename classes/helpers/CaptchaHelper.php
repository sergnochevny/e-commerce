<?php
/**
 * Date: 09.03.2018
 * Time: 12:14
 */

namespace classes\helpers;

use app\core\App;
use models\ModelAuth;

class CaptchaHelper{

  protected static $use_symbols = "abcdefghijklmnprtuvwxy23469";
  protected static $amplitude_min = 10;
  protected static $amplitude_max = 25;
  protected static $font_width = 35;
  protected static $rand_bsimb_min = 10;
  protected static $rand_bsimb_max = 15;
  protected static $margin_left = 10;
  protected static $margin_top = 45;
  protected static $font_size = 35;
  protected static $jpeg_quality = 100;
  protected static $length = 4;

  /**
   * @param $img
   * @param $x
   * @param $y
   * @param $width
   * @param $height
   * @param float $amplitude
   * @param int $period
   */
  private static function wave_region($img, $x, $y, $width, $height, $amplitude = 4.5, $period = 30){
    $mult = 2;
    $img2 = imagecreatetruecolor($width * $mult, $height * $mult);
    imagecopyresampled($img2, $img, 0, 0, $x, $y, $width * $mult, $height * $mult, $width, $height);
    for($i = 0; $i < ($width * $mult); $i += 2) {
      imagecopy($img2, $img2, $x + $i - 2, $y + sin($i / $period) * $amplitude, $x + $i, $y, 2, ($height * $mult));
    }
    imagecopyresampled($img, $img2, $x, $y, 0, 0, $width, $height, $width * $mult, $height * $mult);
    imagedestroy($img2);
  }

  /**
   * @param $im
   * @param $size
   * @param $colch
   */
  private static function image_make_interference(&$im, $size, $colch){
    $max_x = imagesx($im);
    $max_y = imagesy($im);
    for($i = 0; $i <= $colch; $i++) {
      $size = mt_rand(10, $size);
      $px1 = mt_rand(0, $max_x);
      $py1 = mt_rand(0, $max_y);
      $col = imagecolorresolve($im, 255, 255, 255);
      $pk1 = mt_rand(-1, 1);
      $pk2 = mt_rand(-1, 1);
      imageline($im, $px1, $py1, $px1 + $size * $pk1, $py1 + $size * $pk2, $col);
    }
  }

  /**
   *
   */
  public static function gen_captcha(){
    $use_symbols_len = strlen(static::$use_symbols);
    $key = '';
    for($i = 0; $i < static::$length; $i++) {
      $key .= static::$use_symbols{mt_rand(0, $use_symbols_len - 1)};
    }
    $im = imagecreatefrompng(APP_PATH . "/web/images/captcha/back.png");
    $width = imagesx($im);
    $height = imagesy($im);
    $rc = mt_rand(80, 100);
    $font_color = imagecolorresolve($im, $rc, $rc, 0);
    $px = static::$margin_left;
    For($i = 0; $i < static::$length; $i++) {
      imagettftext($im, static::$font_size, 0, $px, static::$margin_top, $font_color,
        APP_PATH . "/web/fonts/cartoon.ttf", $key[$i]
      );
      $px += static::$font_width + mt_rand(static::$rand_bsimb_min, static::$rand_bsimb_max);
    }

    $h_y = mt_rand(0, $height);
    $h_y1 = mt_rand(0, $height);
    imageline($im, mt_rand(0, 20), $h_y, mt_rand($width - 20, $width), $h_y1, $font_color);
    imageline($im, mt_rand(0, 20), $h_y, mt_rand($width - 20, $width), $h_y1, $font_color);
    $h_y = mt_rand(0, $height);
    $h_y1 = mt_rand(0, $height);
    imageline($im, mt_rand(0, 20), $h_y, mt_rand($width - 20, $width), $h_y1, $font_color);
    imageline($im, mt_rand(0, 20), $h_y, mt_rand($width - 20, $width), $h_y1, $font_color);
    self::image_make_interference($im, 50, 80);

    $rand = mt_rand(0, 1);
    if($rand) $rand = -1; else $rand = 1;
    static::wave_region($im, 0, 0, $width, $height, $rand * mt_rand(static::$amplitude_min, static::$amplitude_max), mt_rand(30, 40));
    $image_type = '';
    ob_start();
    ob_implicit_flush(false);
    if(function_exists("imagepng")) {
      imagepng($im);
      $image_type = 'data:image/x-png;base64,';
    } else if(function_exists("imagejpeg")) {
      imagejpeg($im, null, static::$jpeg_quality);
      $image_type = 'data:image/jpeg;base64,';
    } else if(function_exists("imagegif")) {
      imagegif($im);
      $image_type = 'data:image/gif;base64,';
    }
    $image = ob_get_clean();

    App::$app->setSession('captcha', $key);
    App::$app->setSession('captcha_time', time());

    if(!empty($image)) {
      $image = $image_type . base64_encode($image);
    }

    return $image;
  }

  /**
   * @param $captcha
   * @param null $error
   * @return bool
   */
  public static function check_captcha($captcha, &$error = null){
    $res = false;
    if(!is_null(App::$app->session('captcha')) && !empty(App::$app->session('captcha'))) {
      $captcha_relevant = (!is_null(App::$app->KeyStorage()->system_captcha_time) ? App::$app->KeyStorage()->system_captcha_time : CAPTCHA_RELEVANT);
      if($captcha_relevant > (time() - App::$app->session('captcha_time'))) {
        $salt = ModelAuth::GenerateStr();
        $hash = ModelAuth::getHash(strtolower($captcha), $salt, 12);
        if($hash == ModelAuth::check(App::$app->session('captcha'), $hash)) {
          $res = true;
        } else {
          $error[] = 'Invalid Captcha verification!';
        }
      } else $error[] = 'Captcha time is expired!';
    }

    return $res;
  }

}