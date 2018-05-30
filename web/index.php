<?php

use app\core\App;

define('APP_PATH', realpath(__DIR__ . '/../'));
include(APP_PATH . '/vendor/autoload.php');

App::Run();
