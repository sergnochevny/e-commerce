<?php

include("classes/application.php");

class Core
{

    protected $router;
    protected $registry;
    protected $session;
    protected $post;
    protected $get;
    protected $server;
    protected $cookie;
    protected $request;

    protected $db;
    protected $connections;
    protected $config = [];

    public function __construct()
    {
        $this->init();
    }

    protected function init()
    {
        $this->initConfig();
        $this->initDBConnections();
        $this->initRegistry();
        $this->initGlobals();
        $this->initSession();
    }

    private function initConfig()
    {
        $config = $this->getAppConfig();
        if (is_array($config)) {
            foreach ($config as $key => $value) {
                if (function_exists($key)) {
                    if (is_array($value)) {
                        if (count(array_filter(array_keys($value), "is_int")) == count($value)){
                            call_user_func_array($key, $value);
                        } else {
                            $closure = [];
                            foreach ($value as $var => $val) {
                                if ($val instanceof Closure)
                                    $closure[$var] = $val;
                                else call_user_func_array($key, [$var, $val]);
                            }
                            foreach ($closure as $var => $func) {
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

    private function getAppConfig()
    {
        return include('config.php');
    }

    private function initDBConnections()
    {
        $DBS = $this->config('DBS');
        if (isset($DBS) && is_array($DBS)) {
            foreach ($DBS as $key => $val) {
                foreach ($val as $con => $prms) {
                    extract($prms);
                    /* @var $connection
                     * @var $user
                     * @var $password
                     * @var $db
                     */
                    $db_connection = mysql_connect($connection, $user, $password);
                    $this->{$key}[$con] = [
                        'connection' => $db_connection,
                        'db' => $db
                    ];
                    foreach ($db as $name_db) $this->db[$name_db] = $db_connection;
                }
            }
        } else {
            new Exception(
                'Application is not configured...'
            );
        }
    }

    private function initRegistry()
    {
        $this->registry = new Registry();
    }

    private function initGlobals()
    {
        $this->post = array_filter($_POST);
        $this->get = array_filter($_GET);
        $this->server = array_filter($_SERVER);
        $this->cookie = array_filter($_COOKIE);
        $this->request = array_filter($_REQUEST);
    }

    private function initSession()
    {
        session_start();
        $this->session = array_filter($_SESSION);
    }

    function __get($name)
    {
        if (property_exists($this, $name)) {
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
    }

    function __call($name, $arguments)
    {
        $direct_set = strpos($name, 'set') !== false;
        $name = strtolower(str_replace(['set', ' '], '', $name));
        if (property_exists($this, $name)) {
            $class = (new ReflectionClass($this))->getShortName();
            if (is_array($this->{$name}) && !$direct_set) {
                $getProperty = new ReflectionMethod($class, 'getArrayProperty');
                $setProperty = new ReflectionMethod($class, 'setArrayProperty');
                array_unshift($arguments, $name);
                switch (count($arguments)) {
                    case $getProperty->getNumberOfParameters():
                        return $getProperty->invokeArgs($this, $arguments);
                    case $setProperty->getNumberOfParameters():
                        return $setProperty->invokeArgs($this, $arguments);
                    default:
                        $getProperty = new ReflectionMethod($class, 'getProperty');
                        return $getProperty->invokeArgs($this, $arguments);
                }
            } else {
                if(method_exists($this, 'set'.$name)){
                    call_user_func_array([$this,'set'.$name],$arguments);
                } else{
                    $getProperty = new ReflectionMethod($class, 'getProperty');
                    $setProperty = new ReflectionMethod($class, 'setProperty');
                    array_unshift($arguments, $name);
                    switch (count($arguments)) {
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

    public function getArrayProperty($property, $key)
    {
        if (isset($this->{$property}[$key])) return $this->{$property}[$key];
        return null;
    }

    public function setArrayProperty($property, $key, $value)
    {
        if (is_null($value)) unset($this->{$property}[$key] );
        else $this->{$property}[$key] = $value;
    }

    public function getProperty($property)
    {
        if (isset($this->{$property})) return $this->{$property};
        return null;
    }

    public function setProperty($property, $value)
    {
        $this->{$property} = $value;
    }

    public function setSession($key, $value){
        $this->setArrayProperty('session', $key, $value);
        if(is_null($value)){
            unset($_SESSION[$key]);
        } else {
            $_SESSION[$key] = $value;
        }
    }

    public function setCookie($key, $value){
        $this->setArrayProperty('session', $key, $value);
        if(is_null($value)){
            unset($_COOKIE[$key]);
            setcookie($key, '');
        } else {
            $_COOKIE[$key] = $value;
            setcookie($key, $value);
        }
    }

    public function SelectDB($name)
    {
        if (isset($this->db[$name])) {
            mysql_select_db($name);
        } else {
            new Exception(
                strtr('Data Base "{db}" not present in Application',
                    [
                        "{dn}" => $name
                    ]
                )
            );
        }
    }
}

class _A_
{
    /* @var $app Application */
    static public $app;

    static function autoload($className)
    {
        $filename = strtolower($className) . '.php';
        $expArr = explode('_', $className);
        if (empty($expArr[1]) OR $expArr[1] == 'Base') {
            $folder = 'classes';
        } else {
            switch (strtolower($expArr[0])) {
                case 'controller':
                    if (count($expArr) > 1) $filename = '_' . strtolower($expArr[1]) . '.php';
                    $folder = 'controllers';
                    break;

                case 'model':
                    $folder = 'models';
                    break;

                default:
                    $folder = 'classes';
                    break;
            }
        }
        $file = SITE_PATH . $folder . DS . $filename;
        if (file_exists($file)) {
            include_once($file);
            return true;
        }
        return false;
    }

    static public function start()
    {
        spl_autoload_register([self, 'autoload']);
        self::$app = new Application();
        self::$app->run();
    }
}
