<?php
        if ($users_check=="4"){
            $result = mysql_query("INSERT INTO  `fabrix_specials_users` (`sid` ,`aid`)VALUES('$discounts_id',  '$users_list');");  }
        else{  
            $results=mysql_query("select * from fabrix_accounts");
            while($row=mysql_fetch_array($results))
            {  
                $result = mysql_query("INSERT INTO  `fabrix_specials_users` (`sid` ,`aid`)VALUES('$discounts_id',  '$row[0]');");
            }
        }
        if ($sel_fabrics=="1"){
            $result = mysql_query("INSERT INTO  `fabrix_specials_products` (`sid` ,`pid`)VALUES('$discounts_id',  '$fabric_list');");  }
        else{
            $results=mysql_query("select * from fabrix_products");
            while($row=mysql_fetch_array($results))
            {  
                $result = mysql_query("INSERT INTO  `fabrix_specials_users` (`sid` ,`aid`)VALUES('$discounts_id',  '$row[0]');");
            }
        }
?>