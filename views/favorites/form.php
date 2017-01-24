<div id="modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-center">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
        <h4 id="modal-title" class="modal-title">Add To Favorites</h4>
      </div>
      <div class="modal-body clearfix">
        <div id="modal_content">
          <div class="form-row" style="color: red; text-align: center; font-weight: bold;">
            <div class="col-xs-12">
              <div class="row">
                <?php if(isset($warning)) { ?>
                  <div class="col-xs-12">
                    <?php foreach($warning as $msg) {
                      echo $msg . "<br/>";
                    } ?>
                  </div>
                <?php }
                  if(isset($error)) { ?>
                    <div class="col-xs-12">
                      <?php foreach($error as $msg) {
                        echo $msg . "<br/>";
                      } ?>
                    </div>
                  <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button data-dismiss="modal" aria-hidden="true" title="Go to Shop Page" class="button">Continue Shopping</button>
      </div>
    </div>
  </div>
</div>