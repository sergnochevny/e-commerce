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
          $res = Model_Base::query($q);
          if($res) {
            $row = Model_Base::fetch_assoc($res);
            if($row){
              $this->storage[$key] = $row['value'];
              return $row['value'];
            } else {
              return null;
            }
          } else {
            throw new Exception(Model_Base::error());
          }
        }
      }
      return null;
    }

    protected function set($key, $value) {

      if(isset($key) && isset($value)) {
        $value = Model_Base::escape(Model_Base::sanitize($value));
        $q = "replace into key_storage set `key` = '" . $key . "', `value` = '" . $value . "'";
        $res = Model_Base::query($q);
        if(!$res)
          throw new Exception(Model_Base::error());

        $this->storage[$key] = $value;
      }
    }

    public function init() {
      $q = "select value from key_storage";
      $res = Model_Base::query( $q);
      if($res) {
        while($row = Model_Base::fetch_row($res)) {
          $this->storage[$row['key']] = $row['value'];
        }
      } else {
        throw new Exception(Model_Base::error());
      }
    }

    public function __get($name) {
      return $this->get($name);
    }

    public function __set($name, $value) {
      $this->set($name, $value);
    }
  }