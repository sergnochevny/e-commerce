<?php
define('DEMO',1);
$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
if (DEMO == 1) $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";

if (isset($_GET['pay_notify'])){
    $s_id = $_GET['pay_notify'];
    session_id($s_id);
    session_start();

    header('HTTP/1.1 200 OK');
    $req = 'cmd=_notify-validate';
    if(function_exists('get_magic_quotes_gpc')) {
        $get_magic_quotes_exists = true;
    }
    foreach ($_POST as $key => $value) {
        if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
            $value = urlencode(stripslashes($value));
        } else {
            $value = urlencode($value);
        }
        $req .= "&$key=$value";
    }

    $ch = curl_init($paypal_url);
    if ($ch == FALSE) {
        return FALSE;
    }
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
    $res = curl_exec($ch);
    if (curl_errno($ch) != 0) // cURL error
    {
        curl_close($ch);
        file_put_contents('notify.log', 'error');
        exit;
    } else {
        curl_close($ch);
    }
    $tokens = explode("\r\n\r\n", trim($res));
    $res = trim(end($tokens));
    if (strcmp ($res, "VERIFIED") == 0) {
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
        $_SESSION['cart']['payment'] = 1;
    }
}
exit;
