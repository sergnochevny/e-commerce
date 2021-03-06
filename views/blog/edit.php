<?php

use app\core\App;

?>
<?php $this->registerCSSFile(App::$app->router()->UrlTo('css/upload.min.css'), 1); ?>
  <div class="container inner-offset-top half-outer-offset-bottom">
    <div class="box col-xs-12">
      <div class="row">
        <div class="col-xs-12 col-sm-2 back_button_container">
          <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
            Back
          </a>
        </div>
        <div class="col-xs-12 col-sm-8 text-center">
          <div class="row">
            <h1 class="page-title"><?= $form_title ?></h1>
          </div>
        </div>
        <div class="col-sm-2 text-center"></div>
      </div>

      <div data-role="form_content" class="row">
        <?= $form; ?>
      </div>
      <input type="hidden" data-filemanager="<?= App::$app->router()->UrlTo('filemanager/') ?>">
    </div>
  </div>
<?php $this->registerJSFile(App::$app->router()->UrlTo('tinymce/tinymce.min.js'), 4); ?>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/blog/edit.min.js'), 5); ?>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/blog/image.min.js'), 5); ?>