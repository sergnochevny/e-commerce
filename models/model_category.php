<?php

Class Model_Category extends Model_Model
{

    function get_categories_list()
    {
        $this->main->test_access_rights();
        $results = mysql_query("select * from fabrix_categories");
        $categories = '';
        while ($row = mysql_fetch_array($results)) {
            if ($row[4] == 1) {
                $row[4] = "Yes";
            } else {
                $row[4] = "No";
            }
            if ($row[5] == 1) {
                $row[5] = "Yes";
            } else {
                $row[5] = "No";
            }
            ob_start();
            include('./views/category/get_list.php');
            $categories .= ob_get_contents();
            ob_end_clean();
        }
        $this->template->vars('get_categories_list', $categories);
    }

}