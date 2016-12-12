<div class="container">
  <div id="content" class="main-content-inner" role="main">
    <?= $list; ?>
  </div>
</div>

<div id="modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
        <h4 id="modal-title" class="modal-title text-center"></h4>
      </div>
      <div class="modal-body">
        <div id="modal_content">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-primary save-data" data-dismiss="modal">
          Save
        </button>
        <button type="button" class="btn-default" data-dismiss="modal">
          Cancel
        </button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src='<?= _A_::$app->router()->UrlTo('views/js/simple/simples.min.js'); ?>' type="text/javascript"></script>