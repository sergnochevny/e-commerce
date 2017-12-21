<?php

use app\core\App;

?>

<div id="modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-center">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          <i class="fa fa-times" aria-hidden="true"></i>
        </button>
        <h4 id="modal-title" class="modal-title">Add To Matches</h4>
      </div>
      <div class="modal-body clearfix">
        <div id="modal_content">
          <div class="form-row" style="color: red; text-align: center; font-weight: bold;">
            <div class="col-xs-12 text-center">
              <?= $message; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button data-dismiss="modal" aria-hidden="true" title="Go to Shop Page" class="button pull-left">
          Continue Shopping
        </button>
        <a class="button" href="<?= App::$app->router()->UrlTo('matches'); ?>">Matches</a>
      </div>
    </div>
  </div>
</div>