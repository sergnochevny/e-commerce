<link type='text/css' href='<?= _A_::$app->router()->UrlTo('views/css/admin_content.css'); ?>' rel='stylesheet' media='screen'/>

<div class="text-center">
    <a href="<?= $new_post_href; ?>"><input type="submit" value="ADD NEW POST" class="button"/></a><br><br>
</div>

<!--col-2-->
<?php if (isset($warning)) { ?>
    <div class="col-xs-12 alert-success danger" style="display: block;">
        <?php
        foreach ($warning as $msg) {
            echo $msg . "<br/>";
        }
        ?>
    </div>
<?php } ?>
<?php if (isset($error)) { ?>
    <div class="col-xs-12 alert-danger danger" style="display: block;">
        <?php
        foreach ($error as $msg) {
            echo $msg . "<br/>";
        }
        ?>
    </div>
<?php } ?>

<?php if (isset($error) || isset($warning)) { ?>
    <div class="col-xs-12 danger" style="display: block;">
        <br/>
        <br/>
    </div>
<?php } ?>

<p class="woocommerce-result-count">Showing <?= $count_rows; ?> results</p>

<form class="woocommerce-ordering" method="get">
    <select
        onChange="if( this.options[this.selectedIndex].value!='' ){window.location=this.options[this.selectedIndex].value}else{this.options[selectedIndex=0];}"
        class="orderby">
        <option value="<?= _A_::$app->router()->UrlTo('admin_blog'); ?>">--FILTER BY CATEGORY--</option>
        <?= $select_cat_option; ?>

    </select>
</form>
<div class="clear"></div>
<section class="toko-posts-grid">
    <div class="toko-post-row row">
        <?= $blog_posts; ?>
        <div class="clear"></div>
    </div>
</section>
<div class="clear"></div>
<nav role="navigation" class="paging-navigation">
    <h4 class="sr-only">Products navigation</h4>
    <ul class='pagination'>
        <?= isset($paginator) ? $paginator : ''; ?>
    </ul>
</nav>
