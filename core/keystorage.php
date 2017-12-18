<?php

class KeyStorage{

  /**
   * @var array
   */
  protected $storage = [];

  /**
   * @param $key
   * @return mixed|null
   * @throws \Exception
   */
  protected function get($key){
    if(isset($key)) {
      if(isset($this->storage[$key])) {
        return $this->storage[$key];
      } else {
        $q = "SELECT value FROM key_storage";
        $q .= "  where `key` = :key";
        $res = Model_Base::query($q, ['key' => $key]);
        if($res) {
          $value = Model_Base::fetch_value($res);
          if(!empty($value)) {
            $this->storage[$key] = $value;

            return $value;
          }
        } else {
          throw new Exception(Model_Base::error());
        }
      }
    }

    return null;
  }

  /**
   * @param $key
   * @param $value
   * @throws \Exception
   */
  protected function set($key, $value){

    if(isset($key) && isset($value)) {
      $value = Model_Base::sanitize($value);
      $q = "REPLACE INTO key_storage SET `key` = :key, `value` = :value";
      $res = Model_Base::query($q, compact($key, $value));
      if(!$res)
        throw new Exception(Model_Base::error());

      $this->storage[$key] = $value;
    }
  }

  /**
   * @throws \Exception
   */
  public function init(){
    $q = "SELECT `key`, `value` FROM key_storage";
    $res = Model_Base::query($q);
    if($res) {
      while($row = Model_Base::fetch_assoc($res)) {
        $this->storage[$row['key']] = $row['value'];
      }
    } else {
      throw new Exception(Model_Base::error());
    }
  }

  /**
   * @param $name
   * @return mixed|null
   * @throws \Exception
   */
  public function __get($name){
    return $this->get($name);
  }

  /**
   * @param $name
   * @param $value
   * @throws \Exception
   */
  public function __set($name, $value){
    $this->set($name, $value);
  }
}