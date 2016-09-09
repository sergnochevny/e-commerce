<tr>
    <td>
        <center><?php echo $row['name'];?></center>
    </td>
    <td>
        <center>
            <?php
            if($row['amount']>0){
            ?>
            <a href="<?php echo $base_url;?>/admin_blog?cat=<?php echo $row['group_id'];?>" class="" rel="nofollow">
                <?php echo $row['amount'];?>
                <i class="fa fa-chevron-circle-right"></i>
            </a>
            <?php
            } else {
            ?>
                <?php echo $row['amount'];?>
            <?php
            }
            ?>

        </center>
    </td>
    <td>
        <center>
            <figcaption>

                <a href="<?php echo $base_url;?>/edit_blog_category?cat=<?php echo $row['group_id'];?>" class="" rel="nofollow"><i class="fa fa-pencil"></i></a>
                <a href="<?php echo $base_url;?>/del_blog_category?cat=<?php echo $row['group_id'];?>" id="del_blog_category" rel="nofollow"
                   class="text-danger"><i class=" fa fa-trash-o"></i></a>

            </figcaption>
    </td>
</tr>