<tr>
    <td>
        <center><?= $row['name']; ?></center>
    </td>
    <td>
        <center>
            <?php
            if ($row['amount'] > 0) {
                ?>
                <a href="<?= _A_::$app->router()->UrlTo('blog/admin',['cat'=>$row['group_id']]); ?>"
                   class="" rel="nofollow"> <?= $row['amount']; ?> <i class="fa fa-chevron-circle-right"></i>
                </a>
            <?php } else { ?>
                <?= $row['amount']; ?>
            <?php } ?>
        </center>
    </td>
    <td>
        <center>
            <figcaption>
                <a href="<?= _A_::$app->router()->UrlTo('blogcategory/edit', ['cat' => $row['group_id']]); ?>"
                   class="" rel="nofollow"><i class="fa fa-pencil"></i></a>
                <a href="<?= _A_::$app->router()->UrlTo('blogcategory/del', ['cat' => $row['group_id']]); ?>"
                   id="del_blog_category" rel="nofollow"
                   class="text-danger"><i class=" fa fa-trash-o"></i></a>
            </figcaption>
        </center>
    </td>
</tr>