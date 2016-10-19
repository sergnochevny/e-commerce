<?php

Class Model_Router extends Model_Base
{

    public static function set_sef_url($sef_url, $url)
    {
        $_sef_url = $sef_url;
        $itherator = 0;
        while (true) {
            $sql = "SELECT * from url_sef where sef = '" . mysql_escape_string($sef_url) . "'";
            $find_result = mysql_query($sql);
            if (!mysql_num_rows($find_result)) {
                $sql = "INSERT INTO url_sef(url,sef) VALUES('" . $url . "', '" . mysql_escape_string($sef_url) . "')";
                $res = mysql_query($sql);
                if (!$res) $sef_url = $url;
                break;
            } else {
                $res = mysql_fetch_assoc($find_result);
                if ($res['url'] !== $url) {
                    $itherator += 1;
                    $sef_url = $_sef_url . '-' . $itherator;
                } else break;
            }
        }
        return $sef_url;
    }

    public static function get_sef_url($url)
    {
        $sef_url = $url;
        $sql = "SELECT * from url_sef where url = '" . mysql_escape_string($url) . "'";
        $find_result = mysql_query($sql);
        if ($find_result && mysql_num_rows($find_result)) {
            $res = mysql_fetch_assoc($find_result);
            $sef_url = $res['sef'];
        }
        return $sef_url;
    }

    public static function get_url($sef_url)
    {
        $url = $sef_url;
        if ($sef_url != '') {
            $sql = 'SELECT * FROM url_sef WHERE sef = "' . mysql_escape_string($sef_url) . '"';
            $find_result = mysql_query($sql);
            if (mysql_num_rows($find_result)) {
                $res = mysql_fetch_assoc($find_result);
                $url = $res['url'];
            }
        }
        return $url;
    }

}