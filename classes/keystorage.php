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
          $res = mysql_query($q);
          if($res) {
            $row = mysql_fetch_assoc($res);
            $this->storage[$key] = $row['value'];
            return $row['value'];
          } else {
            throw new Exception(mysql_error());
          }
        }
      }
      return null;
    }

    protected function set($key, $value) {

      if(isset($key) && isset($value)) {
        $value = mysql_real_escape_string(Model_Base::sanitize($value));
        $q = "replace into key_storage set `key` = '" . $key . "', `value` = '" . $value . "'";
        $res = mysql_query($q);
        if(!$res)
          throw new Exception(mysql_error());

        $this->storage[$key] = $value;
      }
    }

    public function init() {
      $q = "select value from key_storage";
      $res = mysql_query($q);
      if($res) {
        while($row = mysql_fetch_row($res)) {
          $this->storage[$row['key']] = $row['value'];
        }
      } else {
        throw new Exception(mysql_error());
      }
    }

    public function __get($name) {
      return $this->get($name);
    }

    public function __set($name, $value) {
      $this->set($name, $value);
    }
  }