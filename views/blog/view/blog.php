<link rel="stylesheet" type="text/css" href="<?= _A_::$app->router()->UrlTo('views/css/blog.min.css'); ?>">
<?php include('views/index/main_gallery.php'); ?>
<div class="container inner-offset-top half-outer-offset-bottom">
  <div id="blog" class="col-xs-12 main-content-inner box" role="main">
    <div class="col-xs-12">
      <article class="page type-page status-publish entry">
        <div class="col-xs-12 text-center">
          <h1 class="page-title">Blog</h1>
        </div>
        <div id="content" class="entry-content">
          <?= $list ?>
        </div>
      </article>
    </div>
  </div>
</div>

<script src='<?= _A_::$app->router()->UrlTo('views/js/blog/view.min.js'); ?>' type="text/javascript"></script>