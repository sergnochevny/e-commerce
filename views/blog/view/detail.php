<?php

use app\core\App;

?>
<?php //$this->registerCSSFile(App::$app->router()->UrlTo('css/blog_common.min.css'), 0); ?>
<?php $this->registerCSSFile(App::$app->router()->UrlTo('css/blog.min.css'), 1); ?>

<div class="container inner-offset-top half-outer-offset-bottom">
  <div class="col-xs-12 static box">

    <div class="row">
      <div class="col-xs-12 col-sm-2 back_button_container">
        <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
          <i class="fa fa-angle-left" aria-hidden="true"></i>
          Back
        </a>
      </div>
      <div class="col-xs-12 col-sm-8 text-center">
        <div class="row">
          <h3 class="page-title"><?= $data['post_title']; ?></h3>
        </div>
      </div>
    </div>
    <?php if(isset($data['img']) && !$data['img'] == App::$app->router()->UrlTo('images/not_image.jpg')) { ?>
      <div class="row">
        <div class="just-post-image" style="background-image: url('<?= $data['img']; ?>'); height: 220px"></div>
      </div>
    <?php } ?>
    <div class="row">
      <div class="col-xs-12 ">
        <div class="just-divider text-center line-yes icon-hide">
          <div class="divider-inner">
            <span class="post-date"><?= $data['post_date']; ?></span>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 text-justify just-post-detail">
        <?= $data['post_content']; ?>
      </div>
    </div>

  </div>
</div>

