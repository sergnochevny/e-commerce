<?php

class Model_Router extends Model_Base{

  public static function set_sef_url($sef_url, $url){
    $_sef_url = $sef_url;
    $itherator = 0;
    while(true) {
      $sql = "SELECT * FROM url_sef WHERE sef = '" . static::escape($sef_url) . "'";
      $find_result = static::query($sql);
      if(!($res = static::fetch_assoc($find_result))) {
        $sql = "REPLACE INTO url_sef(url,sef) VALUES('" . $url . "', '" . static::escape($sef_url) . "')";
        $res = static::query($sql);
        if(!$res) $sef_url = $url;
        break;
      } else {
        if($res['url'] !== $url) {
          $itherator += 1;
          $sef_url = $_sef_url . '-' . $itherator;
        } else break;
      }
    }

    return $sef_url;
  }

  public static function get_sef_url($url){
    $sef_url = $url;
    if(!empty($sef_url)) {
      $sql = "SELECT * FROM url_sef WHERE url = :url";
      $prms = compact('url');
      $find_result = static::query($sql, $prms);
      if($find_result && static::num_rows($find_result)) {
        $res = static::fetch_assoc($find_result);
        $sef_url = $res['sef'];
      }
    }
    return $sef_url;
  }

  public static function get_url($sef_url){
    $url = $sef_url;
    if($sef_url != '') {
      $sql = 'SELECT * FROM url_sef WHERE sef = "' . static::escape($sef_url) . '"';
      $find_result = static::query($sql);
      if(static::num_rows($find_result)) {
        $res = static::fetch_assoc($find_result);
        $url = $res['url'];
      }
    }

    return $url;
  }

}