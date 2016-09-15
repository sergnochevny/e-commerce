<tr>
    <td><b><?php echo $row[2];?>% off </b><?php echo $row[17];?></td>
    <td>
        <center><?php echo $row[14];?></center>
    </td>
    <td>
        <center><?php echo $row[11];?></center>
    </td>
    <td>
        <center><?php echo !empty($row[1]) ? $row[1] : 'N/A'; ?></center>
    </td>
    <?php
    $row[12] = gmdate("F j, Y, g:i a", $row[12]);
    $row[13] = gmdate("F j, Y, g:i a", $row[13]);
    ?>
    <td><?php echo $row[12];?></td>
    <td>
        <center><?php echo $row[13];?></center>
    </td>
    <td>
        <center>
            <a  rel="nofollow" href="edit_discounts?discount_id=<?php echo $row[0];?>">
                <i class="fa fa-pencil"></i>
            </a>
            <a id="del_discount"  rel="nofollow" href="del_discounts?discount_id=<?php echo $row[0];?>">
                <i class=" fa fa-trash-o"></i>
            </a>
            <a class="text-success"  rel="nofollow" href="usage_discounts?discount_id=<?php echo $row[0];?>">
                <i class="fa fa-check-circle"></i>
            </a>
        </center>
    </td>
</tr>