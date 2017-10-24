<?php

include("console/classes/application.php");

class Core{

  protected $router;
  protected $registry;
  protected $server;

  protected $db;
  protected $connections;
  protected $config = [];

  public function __construct(){
    $this->init();
  }

  private function initConfig(){
    $config = $this->getAppConfig();
    if(is_array($config)) {
      foreach($config as $key => $value) {
        if(function_exists($key)) {
          if(is_array($value)) {
            if(count(array_filter(array_keys($value), "is_int")) == count($value)) {
              call_user_func_array($key, $value);
            } else {
              $closure = [];
              foreach($value as $var => $val) {
                if($val instanceof Closure)
                  $closure[$var] = $val;
                else call_user_func_array($key, [$var, $val]);
              }
              foreach($closure as $var => $func) {
                $val = call_user_func($func);
                call_user_func_array($key, [$var, $val]);
              }
            }
          } else {
            call_user_func($key, $value);
          }
        } else {
          $this->config($key, $value);
        }
      }
    } else {
      new Exception(
        'Application is not configured...'
      );
    }
  }

  private function getAppConfig(){
    return include('config.php');
  }

  private function initDBConnections(){
    $DBS = $this->config('DBS');
    if(isset($DBS) && is_array($DBS)) {
      foreach($DBS as $key => $val) {
        foreach($val as $con => $prms) {
          extract($prms);
          /* @var $connection
           * @var $user
           * @var $password
           * @var $db
           */
          $db_connection = mysqli_connect($connection, $user, $password);
          $this->{$key}[$con] = [
            'connection' => $db_connection,
            'db' => $db
          ];
          foreach($db as $key => $db_name) $this->db[$key] = [$db_name, $db_connection];
        }
      }
    } else {
      new Exception(
        'Application is not configured...'
      );
    }
  }

  private function initRegistry(){
    $this->registry = new Registry();
  }

  private function initGlobals(){
    $this->server = array_slice($_SERVER, 0);
  }

  protected function init(){
    $this->initConfig();
    $this->initDBConnections();
    $this->initRegistry();
    $this->initGlobals();
  }

  function __get($name){
    if(property_exists($this, $name)) {
      return $this->$name;
    } else {
      new Exception(
        strtr('Member "{member}" not exists in "{class}"',
          [
            "{member}" => $name,
            "{class}" => (new ReflectionClass($this))->getShortName()
          ]
        )
      );
    }

    return null;
  }

  public function __call($name, $arguments){
    $direct_set = strpos($name, 'set') !== false;
    $name = strtolower(str_replace(['set', ' '], '', $name));
    if(property_exists($this, $name)) {
      $class = (new ReflectionClass($this))->getShortName();
      if(is_array($this->{$name}) && !$direct_set) {
        $getProperty = new ReflectionMethod($class, 'getArrayProperty');
        $setProperty = new ReflectionMethod($class, 'setArrayProperty');
        array_unshift($arguments, $name);
        switch(count($arguments)) {
          case $getProperty->getNumberOfParameters():
            return $getProperty->invokeArgs($this, $arguments);
          case $setProperty->getNumberOfParameters():
            return $setProperty->invokeArgs($this, $arguments);
          default:
            $getProperty = new ReflectionMethod($class, 'getProperty');

            return $getProperty->invokeArgs($this, $arguments);
        }
      } else {
        if(method_exists($this, 'set' . $name)) {
          call_user_func_array([$this, 'set' . $name], $arguments);
        } else {
          $getProperty = new ReflectionMethod($class, 'getProperty');
          $setProperty = new ReflectionMethod($class, 'setProperty');
          array_unshift($arguments, $name);
          switch(count($arguments)) {
            case $getProperty->getNumberOfParameters():
              return $getProperty->invokeArgs($this, $arguments);
            case $setProperty->getNumberOfParameters():
              return $setProperty->invokeArgs($this, $arguments);
            default:
              return $getProperty->invoke($this);
          }
        }
      }
    }

    return false;
  }

  public function getArrayProperty($property, $key){
    if(isset($this->{$property}[$key])) return $this->{$property}[$key];

    return null;
  }

  public function getProperty($property){
    if(isset($this->{$property})) return $this->{$property};

    return null;
  }

  public function setProperty($property, $value){
    $this->{$property} = $value;
  }

  public function setArrayProperty($property, $key, $value){
    if(is_null($value)) unset($this->{$property}[$key]);
    else $this->{$property}[$key] = $value;
  }

  public function SelectDB($name){
    if(isset($this->db[$name]) && is_array($this->db[$name])) {
      if(!mysqli_select_db($this->db[$name][1], $this->db[$name][0])) {
        throw new Exception(
          strtr('Data Base "{db}" do not select: {reason}',
            [
              "{db}" => $name,
              '{reason}' => $this->db[$name][1]->error
            ]
          )
        );
      } else {
        if($this->db[$name][1]->errno > 0) {
          throw new Exception($this->db[$name][1]->error);
        }
      }
    } else {
      throw new Exception(
        strtr('Data Base "{db}" not present in Application',
          [
            "{db}" => $name
          ]
        )
      );
    }
  }

  public function getDBConnection($name){
    if(isset($this->db[$name]) && is_array($this->db[$name])) {
      return $this->db[$name][1];
    } else {
      new Exception(
        strtr('Data Base configuration "{db}" not present in Application',
          [
            "{db}" => $name
          ]
        )
      );
    }

    return null;
  }

}

class _A_{

  /* @var $app Application */
  static public $app;

  static function autoload($className){
    $filename = strtolower($className) . '.php';
    $expArr = explode('_', $className);
    $folder = 'console/classes';
    if(file_exists(SITE_PATH . $folder . DS . $filename)) {
      include_once(SITE_PATH . $folder . DS . $filename);

      return true;
    }
    $folder = 'classes';
    if(file_exists(SITE_PATH . $folder . DS . $filename)) {
      include_once(SITE_PATH . $folder . DS . $filename);

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
        $folder = 'console' . DS . 'classes';
        break;
    }
    $file = SITE_PATH . $folder . DS . $filename;
    if(file_exists($file)) {
      include_once($file);

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
