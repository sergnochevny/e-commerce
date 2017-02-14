<?php

Class Model_Router extends Model_Base
{

    public static function set_sef_url($sef_url, $url)
    {
        $_sef_url = $sef_url;
        $itherator = 0;
        while (true) {
            $sql = "SELECT * from url_sef where sef = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $sef_url) . "'";
            $find_result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $sql);
            if (!($res = mysqli_fetch_assoc($find_result))) {
                $sql = "REPLACE INTO url_sef(url,sef) VALUES('" . $url . "', '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $sef_url) . "')";
                $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $sql);
                if (!$res) $sef_url = $url;
                break;
            } else {
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
        $sql = "SELECT * from url_sef where url = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $url) . "'";
        $find_result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $sql);
        if ($find_result && mysqli_num_rows($find_result)) {
            $res = mysqli_fetch_assoc($find_result);
            $sef_url = $res['sef'];
        }
        return $sef_url;
    }

    public static function get_url($sef_url)
    {
        $url = $sef_url;
        if ($sef_url != '') {
            $sql = 'SELECT * FROM url_sef WHERE sef = "' . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $sef_url) . '"';
            $find_result = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $sql);
            if (mysqli_num_rows($find_result)) {
                $res = mysqli_fetch_assoc($find_result);
                $url = $res['url'];
            }
        }
        return $url;
    }

}