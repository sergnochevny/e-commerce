<?php
define('APP_PATH', realpath(__DIR__));
$core_path = realpath(APP_PATH . '/console/core');
include($core_path . '/app-init.php');
_A_::start();
