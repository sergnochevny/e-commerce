<?php

use app\core\App;

?>
<div class="row">
  <div class="col-xs-12 modal-view" data-title="<?= $view_title ?>">
    <div class="row">
      <div class="col-xs-12 col-sm-6">
        <b>Title:</b><br>
        <?= $data['title'] ?>
      </div>
      <div class="col-xs-12 col-sm-6">
        <b>Status:</b><br>
        <?= $data['moderated'] == 1 ? 'published' : 'hidden' ?>
      </div>
    </div>
    <div class="row">
      <br>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <b>Content:</b><br>
        <?= $data['data'] ?>
      </div>
    </div>
  </div>
</div>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/comments/view.min.js'), 4, true); ?>