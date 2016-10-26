<link rel="stylesheet" type="text/css" href="<?= _A_::$app->router()->UrlTo('views/css/blog.css'); ?>">
<?php include('views/index/main_gallery.php'); ?>
<div id="blog" class="container">
  <div class="row">
    <div class="col-md-12">
      <article class="page type-page status-publish entry">
        <h1 class="entry-title">I Luv Fabrix Blog</h1>
        <div id="content" class="entry-content">
          <?=$list?>
        </div>
      </article>
    </div>
  </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/blog/blog.js'); ?>' type="text/javascript"></script>