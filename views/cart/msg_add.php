<div id="confirm_dialog" class="overlay"></div>
<div id="modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 id="modal-title" class="modal-title text-center"></h4>
      </div>
      <div class="modal-body">
        <div id="modal_content">
          <?= $message;?>
        </div>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary pull-left to-cart" href="<?= _A_::$app->router()->UrlTo('cart') ?>">Go to cart</a>
        <a class="btn btn-primary pull-left hidden matches" href="<?= _A_::$app->router()->UrlTo('matches') ?>">Go to matches</a>
        <a class="btn btn-default cancel" data-dismiss="modal">Cancel</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->