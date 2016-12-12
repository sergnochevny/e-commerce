<link rel="stylesheet" type="text/css" href="<?= _A_::$app->router()->UrlTo('views/css/blog.css'); ?>">
<?php include('views/index/main_gallery.php'); ?>
<div class="container">
  <div id="blog" class="main-content-inner" role="main">
    <div class="row">
      <div class="col-xs-12">
        <article class="page type-page status-publish entry">
          <div class="col-xs-12 text-center afterhead-row">
            <h3 class="page-title">I Luv Fabrix Blog</h3>
          </div>
          <div id="content" class="entry-content">
            <?=$list?>
          </div>
        </article>
      </div>
    </div>

  </div>
</div>

<script src='<?= _A_::$app->router()->UrlTo('views/js/blog/view.min.js'); ?>' type="text/javascript"></script>