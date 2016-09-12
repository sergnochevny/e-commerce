<center>
    <a href="<?php echo _A_::$app->router()->UrlTo('mnf'); ?>/new_blog_category">
        <input type="submit" value="ADD NEW CATEGORY" class="button"/>
    </a><br><br><br>
</center>
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
        <?php echo $blog_categories_list; ?>
        </tbody>
    </table>
</div>
<br/>