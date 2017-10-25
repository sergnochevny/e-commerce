<?php
define('APP_PATH', realpath(__DIR__ . '/../'));
$core_path = realpath(APP_PATH . '/core');
if(substr(php_sapi_name(), 0, 3) == 'cli') {
  $core_path = realpath(APP_PATH . '/console/core');
}
include($core_path . '/app-init.php');
_A_::start();
