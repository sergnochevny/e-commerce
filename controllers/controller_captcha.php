<?php

  class Controller_Captcha extends Controller_Controller {
    protected $use_symbols = "abcdefghijklmnprtuvwxy23469";
    protected $use_symbols_len;
    protected $amplitude_min = 10;
    protected $amplitude_max = 25;
    protected $font_width = 35;
    protected $rand_bsimb_min = 10;
    protected $rand_bsimb_max = 15;
    protected $margin_left = 10;
    protected $margin_top = 45;
    protected $font_size = 35;
    protected $jpeg_quality = 100;
    protected $length = 4;
    public $key = '';

    public function __construct(Controller_Base $main = null) {
      $this->use_symbols_len = strlen($this->use_symbols);
      parent::__construct($main);
    }

    private function gen_captcha() {
      for($i = 0; $i < $this->length; $i++)
        $this->key .= $this->use_symbols{mt_rand(0, $this->use_symbols_len - 1)};
      $im = imagecreatefromgif(dirname(__DIR__)."/views/images/captcha/back.gif");
      $width = imagesx($im);
      $height = imagesy($im);
      $rc = mt_rand(80, 100);
      $font_color = imagecolorresolve($im, $rc, $rc, 0);
      $px = $this->margin_left;
      For($i = 0; $i < $this->length; $i++) {
        imagettftext($im, $this->font_size, 0, $px, $this->margin_top, $font_color, dirname(__DIR__)."/views/fonts/cartoon.ttf", $this->key[$i]);
        $px += $this->font_width + mt_rand($this->rand_bsimb_min, $this->rand_bsimb_max);
      }

      $h_y = mt_rand(0, $height);
      $h_y1 = mt_rand(0, $height);
      imageline($im, mt_rand(0, 20), $h_y, mt_rand($width - 20, $width), $h_y1, $font_color);
      imageline($im, mt_rand(0, 20), $h_y, mt_rand($width - 20, $width), $h_y1, $font_color);
      $h_y = mt_rand(0, $height);
      $h_y1 = mt_rand(0, $height);
      imageline($im, mt_rand(0, 20), $h_y, mt_rand($width - 20, $width), $h_y1, $font_color);
      imageline($im, mt_rand(0, 20), $h_y, mt_rand($width - 20, $width), $h_y1, $font_color);
      $this->image_make_interference($im, 50, 80);

      $rand = mt_rand(0, 1);
      if($rand)
        $rand = -1; else $rand = 1;
      $this->wave_region($im, 0, 0, $width, $height, $rand * mt_rand($this->amplitude_min, $this->amplitude_max), mt_rand(30, 40));
      if(function_exists("imagejpeg")) {
        header("Content-Type: image/jpeg");
        imagejpeg($im, null, $this->jpeg_quality);
      } else if(function_exists("imagegif")) {
        header("Content-Type: image/gif");
        imagegif($im);
      } else if(function_exists("imagepng")) {
        header("Content-Type: image/x-png");
        imagepng($im);
      }
    }

    private function wave_region($img, $x, $y, $width, $height, $amplitude = 4.5, $period = 30) {
      $mult = 2;
      $img2 = imagecreatetruecolor($width * $mult, $height * $mult);
      imagecopyresampled($img2, $img, 0, 0, $x, $y, $width * $mult, $height * $mult, $width, $height);
      for($i = 0; $i < ($width * $mult); $i += 2)
        imagecopy($img2, $img2, $x + $i - 2, $y + sin($i / $period) * $amplitude, $x + $i, $y, 2, ($height * $mult));
      imagecopyresampled($img, $img2, $x, $y, 0, 0, $width, $height, $width * $mult, $height * $mult);
      imagedestroy($img2);
    }

    private function image_make_interference(&$im, $size, $colch) {
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

    public static function check_captcha($captcha, &$error = null){
      $res = false;
      if(!is_null(_A_::$app->session('captcha')) && !empty(_A_::$app->session('captcha'))){
        $captcha_relevant = (!is_null(_A_::$app->keyStorage()->system_captcha_time) ? _A_::$app->keyStorage()->system_captcha_time : CAPTCHA_RELEVANT);
        if ($captcha_relevant > (time()-_A_::$app->session('captcha_time'))){
          $salt = Model_Auth::generatestr();
          $hash = Model_Auth::hash_(strtolower($captcha), $salt, 12);
          if($hash == Model_Auth::check(_A_::$app->session('captcha'), $hash)) {
            $res = true;
          } else {$error[] = 'Invalid Captcha verification!';}
        } else $error[] = 'Captcha time is expired!';
      }
      return $res;
    }

    /**
     * @export
     */
    public function captcha() {
      $this->gen_captcha();
      _A_::$app->setSession('captcha', $this->key);
      _A_::$app->setSession('captcha_time', time());
    }

  }