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
      <div class="modal-body clearfix">
        <div id="modal_content">

        </div>
      </div>
      <div class="modal-footer">
        <input type="button" class="button save-data" href="save" data-dismiss="modal" value="Save"/>
        <input type="button" class="button" data-dismiss="modal" value="Cancel"/>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src='<?= _A_::$app->router()->UrlTo('views/js/simple/simples.min.js'); ?>' type="text/javascript"></script>