<?php
    echo "<tr><td><center>$row[1]</td><td>$row[2]</td><td><center>$row[3]</td><td><center>$row[4]</td><td><center>$row[5]</td><td><center>";
    echo '
    <figcaption>
	
		<a href="edit_categories?category_id='.$row[0].'" class=""><i class="fa fa-pencil"></i></a>
    	<a href="del_categories?category_id='.$row[0].'" id="del_category" rel="nofollow" class="text-danger"><i class=" fa fa-trash-o"></i></a>
    	
    </figcaption>';		
    echo "</td></tr>";  
?>