<?php

use app\core\App;

?>

<div class="container inner-offset-top half-outer-offset-bottom">
  <div class="box col-xs-12">
    <div class="col-xs-12 text-center">
      <div class="row">
        <h1 class="page-title"><?= $form_title ?></h1>
      </div>
    </div>

    <div data-role="form_content" class="row">
      <?= $form; ?>
    </div>
  </div>
</div>

<?php $this->registerJSFile(App::$app->router()->UrlTo('tinymce/tinymce.min.js'), 4); ?>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/info/edit.min.js'), 5); ?>
