<div class="row">
  <div class="col-xs-12 modal-view" data-title="<?= $view_title ?>">
    <div class="row">
      <div class="col-xs-12 col-sm-6">
        <b>Title:</b><br>
        <?= $rows['title'] ?>
      </div>
      <div class="col-xs-12 col-sm-6">
        <b>Status:</b><br>
        <?= $rows['moderated'] == 1 ? 'published' : 'hidden' ?>
      </div>
    </div>
    <div class="row">
      <br>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <b>Content:</b><br>
        <?= $rows['data'] ?>
      </div>
    </div>
  </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/comments/view.min.js'); ?>' type="text/javascript"></script>