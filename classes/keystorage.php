<?php

  class KeyStorage {

    protected $storage = [];

    protected function get($key) {
      if(isset($key)) {
        if(isset($this->storage[$key])) {
          return $this->storage[$key];
        } else {
          $q = "select value from key_storage";
          $q .= "  where `key` = '" . $key . "'";
          $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q);
          if($res) {
            $row = mysqli_fetch_assoc($res);
            if($row){
              $this->storage[$key] = $row['value'];
              return $row['value'];
            } else {
              return null;
            }
          } else {
            throw new Exception(mysqli_error(_A_::$app->getDBConnection('iluvfabrix'), _A_::$app->getDBConnection('iluvfabrix')));
          }
        }
      }
      return null;
    }

    protected function set($key, $value) {

      if(isset($key) && isset($value)) {
        $value = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), Model_Base::sanitize($value));
        $q = "replace into key_storage set `key` = '" . $key . "', `value` = '" . $value . "'";
        $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q);
        if(!$res)
          throw new Exception(mysqli_error(_A_::$app->getDBConnection('iluvfabrix'), _A_::$app->getDBConnection('iluvfabrix')));

        $this->storage[$key] = $value;
      }
    }

    public function init() {
      $q = "select value from key_storage";
      $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q);
      if($res) {
        while($row = mysqli_fetch_row($res)) {
          $this->storage[$row['key']] = $row['value'];
        }
      } else {
        throw new Exception(mysqli_error(_A_::$app->getDBConnection('iluvfabrix'), _A_::$app->getDBConnection('iluvfabrix')));
      }
    }

    public function __get($name) {
      return $this->get($name);
    }

    public function __set($name, $value) {
      $this->set($name, $value);
    }
  }