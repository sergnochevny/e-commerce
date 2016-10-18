<div class="row">
  <div class="col-md-12 modal-view" data-title="<?= $view_title ?>">
    <div class="row">
      <div class="col-md-6">
        <b>Title:</b><br>
        <?= $data['title'] ?>
      </div>
      <div class="col-md-6">
        <b>Status:</b><br>
        <?= $data['moderated'] == 1 ? 'published' : 'hidden' ?>
      </div>
    </div>
    <div class="row">
      <br>
    </div>
    <div class="row">
      <div class="col-md-12">
        <b>Content:</b><br>
        <?= $data['data'] ?>
      </div>
    </div>
  </div>
</div>

<script>
  (function($){
    $('#modal-title').html($('.modal-view').attr('data-title'));
    $('#modal').modal('show').find('.modal-footer').stop().hide();
  })(jQuery)
</script>