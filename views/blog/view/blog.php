<link rel="stylesheet" type="text/css" href="<?= _A_::$app->router()->UrlTo('views/css/blog.min.css'); ?>">
<?php include('views/index/main_gallery.php'); ?>
<div class="container inner-offset-top half-outer-offset-bottom">
  <div id="blog" class="col-xs-12 main-content-inner box" role="main">
    <article class="page type-page status-publish entry">
      <?php $back_url = _A_::$app->router()->UrlTo('shop'); ?>

      <div class="col-xs-12 col-sm-2 back_button_container">
        <div class="row">
          <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
            To Shop
          </a>
        </div>
      </div>
      <div class="col-xs-12 col-sm-8 text-center">
        <h1 class="page-title">Blog</h1>
      </div>

      <div id="content" class="entry-content">
        <?= $list ?>
      </div>
    </article>
  </div>
</div>

<script src='<?= _A_::$app->router()->UrlTo('views/js/blog/view.min.js'); ?>' type="text/javascript"></script>