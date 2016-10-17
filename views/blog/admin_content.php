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


<div class="col-xs-12 text-center">
    <h2>Posts</h2>
</div>


<?= isset($search_form) ? $search_form : '' ?>

<div class="row">
    <div class="col-xs-12 search-result-header">

        <div class="row">
            <div class="col-sm-6 action-button-add">
                <a href="<?= $new_post_href; ?>"><input type="submit" value="ADD NEW POST" class="button"/></a><br><br>
            </div>
            <div class="col-sm-6 search-result-container text-right">
                <span class="search-result">Showing <?= $count_rows; ?> results</span>
            </div>
        </div>

    </div>
</div>

<section class="just-post-row row">
    <div class="just-posts-grid">
        <?= $blog_posts; ?>
    </div>
</section>

<div class="clear"></div>


<div class="row">
    <div class="col-xs-12">

        <nav class="paging-navigation" role="navigation">
            <h4 class="sr-only">Navigation</h4>
            <ul class="pagination">
                <?= isset($paginator) ? $paginator : ''; ?>
            </ul>
        </nav>

    </div>
</div>