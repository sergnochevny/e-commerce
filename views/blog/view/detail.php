<link rel="stylesheet" type="text/css" href="<?= _A_::$app->router()->UrlTo('views/css/blog.css'); ?>">
<?php include('views/index/main_gallery.php'); ?>
<div id="blog" class="container">
  <section class="just-posts-grid">
    <div class="just-post-row row">
      <div class="just-post col-xs-12" id="blog-page">
        <a href="<?= $back_url; ?>" class="button back_button">Back</a>
        <h1 class="page-title"><?= $data['post_title']; ?></h1>
        <?php if(isset($data['img'])) { ?>
          <div class="just-post-image" style="background-image: url('<?= $data['img']; ?>');"></div>
        <?php } ?>
        <div class="just-post-detail">
          <div class="just-divider text-center line-yes icon-hide">
            <div class="divider-inner" style="background-color: #fff">
              <span class="post-date"><?= $data['post_date']; ?></span>
            </div>
          </div>
          <div><?= $data['post_content']; ?></div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/blog/view.js'); ?>' type="text/javascript"></script>