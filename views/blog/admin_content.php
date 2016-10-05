<style>
    .just-posts-grid .just-post {
        margin: 0 0 20px;
    }

    .just-posts-grid .just-post-image {
        background-position: center center;
        background-size: cover;
        height: 200px;
        margin: 0 0 20px;
        overflow: hidden;
    }

    .just-posts-grid .just-post-image a {
        display: block;
        height: 200px;
    }

    .just-posts-grid .just-post-detail .post-title {
        margin: 0;
        font-size: 20px;
        font-weight: lighter;
        text-transform: uppercase;
        padding: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .just-posts-grid .just-post-detail .post-title a {
        color: #222222;
    }

    .just-posts-grid .just-post-detail .post-date {
        font-size: 14px !important;
        color: #5f5f5f !important;
        text-transform: uppercase;
        font-weight: normal;
        padding: 0;
    }

    .just-posts-grid .just-post-detail > p {
        display: block;
        font-size: 12px;
        font-weight: normal;
        height: 100px;
        margin: 0;
        overflow: hidden;
        padding: 0;
        position: relative;
    }

    .just-posts-grid .just-post-detail > p > span.opa {
        background-image: url("<?= _A_::$app->router()->UrlTo('views/images/bg-opa.png');?>");
        bottom: 0;
        display: block;
        height: 80px;
        position: absolute;
        width: 100%;
    }
    .just-post-image-admin{text-align: center;}
    .just-post-image-admin > a{
        display: inline-block !important;
        /*height: auto !important;
        margin-top: 77px !important;*/
    }
</style>
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
<section class="just-posts-grid">
    <div class="just-post-row row">
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
