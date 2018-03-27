<?php

use app\core\console\Console;

define('APP_PATH', realpath(__DIR__));
include(APP_PATH . '/vendor/autoload.php');

Console::run();
