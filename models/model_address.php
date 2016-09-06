<?php
Class Model_Address extends Model_Model
{
    function get_total_count_province_state()
    {
        $total = 0;
        $q_total = "SELECT COUNT(*) FROM `fabrix_province_state`";

        if ($res = mysql_query($q_total)) {
            $total = mysql_fetch_row($res)[0];
        }

        return $total;
    }

    function get_total_count_countries()
    {
        $total = 0;
        $q_total = "SELECT COUNT(*) FROM `fabrix_countries`";

        if ($res = mysql_query($q_total)) {
            $total = mysql_fetch_row($res)[0];
        }

        return $total;
    }

    function get_countries_all()
    {
        $list = [];
        $q = "SELECT * FROM `fabrix_countries` ORDER BY display_order, name";
        if ($res = mysql_query($q)) {
            while ($row = mysql_fetch_array($res)) {
                $list[] = $row;
            }
        }

        return $list;
    }

    function get_province_all()
    {
        $list = [];
        $q = "SELECT * FROM `fabrix_province_state` ORDER BY name";
        if ($res = mysql_query($q)) {
            while ($row = mysql_fetch_array($res)) {
                $list[] = $row;
            }
        }

        return $list;
    }

    function get_country_province($country)
    {
        $list = [];
        $q = "SELECT * FROM `fabrix_province_state` WHERE country = '$country' ORDER BY name";
        if ($res = mysql_query($q)) {
            while ($row = mysql_fetch_array($res)) {
                $list[] = $row;
            }
        }

        return $list;
    }

    function get_country_by_id($id)
    {
        $country = '';
        $q = "SELECT * FROM `fabrix_countries` WHERE id = '$id'";
        if ($res = mysql_query($q)) {
            $row = mysql_fetch_array($res);
            $country = trim($row['name']);
        }
        return $country;
    }

    function get_province_by_id($id)
    {
        $province = '';
        $q = "SELECT * FROM `fabrix_province_state` WHERE id = '$id'";
        if ($res = mysql_query($q)) {
            $row = mysql_fetch_array($res);
            $province = trim($row['name']);
        }
        return $province;
    }
    
}