<link rel="stylesheet" type="text/css" href="<?= _A_::$app->router()->UrlTo('views/css/blog.min.css'); ?>">
<?php include('views/index/main_gallery.php'); ?>
<div class="container">
  <div id="blog" class="main-content-inner" role="main">
    <div class="row">
      <div class="col-xs-12">
        <article class="page type-page status-publish entry">
          <div class="col-xs-12 text-center afterhead-row">
            <h1 class="page-title" style="margin-bottom: 35px!important;">Blog</h1>
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