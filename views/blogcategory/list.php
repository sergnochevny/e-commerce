<div class="text-center">
    <a href="<?= _A_::$app->router()->UrlTo('blogcategory/add'); ?>" class="button">
        ADD NEW CATEGORY
    </a>
</div>
<div class="">
    <!--col-2-->
    <?php
    if (isset($warning)) {
        ?>
        <div class="col-xs-12 alert-success danger" style="display: block;">
            <?php
            foreach ($warning as $msg) {
                echo $msg . "<br/>";
            }
            ?>
        </div>
        <?php
    }
    ?>
    <?php
    if (isset($error)) {
        ?>
        <div class="col-xs-12 alert-danger danger" style="display: block;">
            <?php
            foreach ($error as $msg) {
                echo $msg . "<br/>";
            }
            ?>
        </div>
        <?php
    }
    ?>
    <?php
    if (isset($error) || isset($warning)) {
        ?>
        <div class="col-xs-12 danger" style="display: block;">
            <br/>
            <br/>
        </div>
        <?php
    }
    ?>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>
                Category
            </th>
            <th>
                Amount Posts
            </th>
            <th>
                Actions
            </th>
        </tr>
        </thead>
        <tbody>
        <?= $blog_categories_list; ?>
        </tbody>
    </table>
</div>
<br/>