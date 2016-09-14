<?php

Class Model_Category extends Model_Model
{

    function get_all($prms = null)
    {
        $q = "select * from fabrix_categories";
        if(isset($prms)){
            $where = isset($prms['where'])?$prms['where']:'';

        }

        $results = mysql_query($q);
        $rows = null;
        if($results){
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
                $rows[] = $row;
            }
        }
        return $rows;
    }

    public function del($id){
        if (!empty($id)) {
            $strSQL = "update fabrix_products set cid = NULL WHERE cid = $id";
            mysql_query($strSQL);

            $strSQL = "DELETE FROM fabrix_categories WHERE cid = $id";
            mysql_query($strSQL);
        }
    }

    public function get_category($id)
    {
        $row = null;
        $resul = mysql_query("select * from fabrix_categories WHERE cid='$id'");
        if ($resul){
            $row = mysql_fetch_array($resul);
        }
        return $row;
    }



}