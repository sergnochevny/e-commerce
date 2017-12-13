<?php
/**
 * Date: 25.10.2017
 * Time: 18:32
 */

include(APP_PATH . "/core/core.php");
include(APP_PATH . "/core/application.php");

class _A_{

  /* @var $app Application */
  static public $app;

  static function autoload($className){
    $filename = strtolower($className) . '.php';
    $expArr = explode('_', $className);
    $folder = 'core';
    if(file_exists(APP_PATH . DS . $folder . DS . $filename)) {
      include_once(APP_PATH . DS . $folder . DS . $filename);

      return true;
    }
    switch(strtolower($expArr[0])) {
      case 'controller':
        $folder = 'controllers/base';
        if(file_exists(APP_PATH . DS . $folder . DS . $filename)) {
          include_once(APP_PATH . DS . $folder . DS . $filename);

          return true;
        }
        $folder = 'controllers';
        break;
      case 'model':
        $folder = 'models';
        break;
      default:
        $folder = 'core';
        break;
    }
    $file = APP_PATH . DS . $folder . DS . $filename;
    if(file_exists($file)) {
      include_once($file);

            return true;
        }
        if ($className == 'PDOConnector' || $className == 'DBConnector') {
            $folder = 'DBConnector';
            include_once(APP_PATH . DS . $folder . DS . $className .'.php');

            return true;
        }
        return false;
    }

  public static function start(){
    spl_autoload_register(['self', 'autoload']);
    self::$app = new Application();
    self::$app->run();
  }
}
