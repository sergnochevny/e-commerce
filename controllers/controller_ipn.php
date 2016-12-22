<?php

  class Controller_Ipn extends Controller_Controller {

    public function view() { }

    /**
     * @export
     */
    public function index($required_access = true) {
      if(!is_null(_A_::$app->get('pay_notify'))) {

        header('HTTP/1.1 200 OK');
        $req = 'cmd=_notify-validate';
        foreach($_POST as $key => $value) {
          if(function_exists('get_magic_quotes_gpc') == true && get_magic_quotes_gpc() == 1) {
            $value = urlencode(stripslashes($value));
          } else {
            $value = urlencode($value);
          }
          $req .= "&$key=$value";
        }

        $ch = curl_init(_A_::$app->keyStorage()->paypal_url);
        if($ch == false) return false;
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Connection: Close']);
        $res = curl_exec($ch);
        if(curl_errno($ch) != 0) // cURL error
        {
          curl_close($ch);
          file_put_contents('notify.log', 'error');
          exit;
        } else {
          curl_close($ch);
        }
        $tokens = explode("\r\n\r\n", trim($res));
        $res = trim(end($tokens));
        if(strcmp($res, "VERIFIED") == 0) {
          ob_start();
          print_r($_SESSION);
          print_r($_COOKIE);
          print_r($_GET);
          print_r($_POST);
          print_r($_SERVER);

          $body = ob_get_clean();
          ob_end_clean();
          file_put_contents('notify.log', $body, FILE_APPEND);
          mail('sergnochevny@studionovi.co', 'PayPall Payment', $body);
          $cart = _A_::$app->session('cart');
          $cart['payment'] = 1;
          _A_::$app->setSession('cart', $cart);
        }
      }
      exit;
    }

  }