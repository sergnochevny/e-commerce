<?php
/**
 * Date: 25.10.2017
 * Time: 18:38
 */

include(APP_PATH . '/console/core/core.php');
include(APP_PATH . '/console/core/application.php');

class _A_{

  /* @var $app Application */
  static public $app;

  static function autoload($className){
    $filename = strtolower($className) . '.php';
    $expArr = explode('_', $className);
    $folder = 'console/core';
    if(file_exists(APP_PATH . DS . $folder . DS . $filename)) {
      include_once(APP_PATH . DS . $folder . DS . $filename);

      return true;
    }
    $folder = 'core';
    if(file_exists(APP_PATH . DS . $folder . DS . $filename)) {
      include_once(APP_PATH . DS . $folder . DS . $filename);

      return true;
    }
    switch(strtolower($expArr[0])) {
      case 'controller':
        $folder = 'console' . DS . 'controllers';
        break;
      case 'model':
        $folder = 'console' . DS . 'models';
        break;
      default:
        $folder = 'console' . DS . 'core';
        break;
    }
    $file = APP_PATH . DS . $folder . DS . $filename;
    if(file_exists($file)) {
      include_once($file);

      return true;
    }

    return false;
  }

  public static function start(){
    spl_autoload_register(['self', 'autoload']);
    (new Application(self::$app))->run();
  }

}
