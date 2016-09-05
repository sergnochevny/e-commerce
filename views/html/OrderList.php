<?php
 echo '<div class="CSSTableGenerator" ><table ><tr><td>Order Id</td><td >Order Date</td><td>Shipping Type</td><td>Discount</td><td>Total</td><td style="width:150px;"></td></tr>';
                $results=mysql_query("select * from fabrix_orders WHERE aid='$user_id'");
                while($row=mysql_fetch_array($results))
                { 
                 $row[22]= gmdate("F j, Y, g:i a", $row[22]);
                        echo '<tr><td ><center><b>'.$row[0].'</b></td><td><center><b>'.$row[22].'</td><td><center><b>ground ship</td><td><center><b>'.$row[12].'$</td><td><center><b>'.$row[14].'$</td><td ><center>
                        <a href="orderDetalList?order_id='.$row[0].'"><input type="submit" value="view order" name="login" class="button"></a>
                        </td></tr>';
                } 
                echo "</table></div>"; 
?>