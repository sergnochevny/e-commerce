<div id="modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-center">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 id="modal-title" class="modal-title">Add To Favorites</h4>
      </div>
      <div class="modal-body">
        <div id="modal_content" style="display: inline-block;">
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
        <a data-waitloader id="continue" href="#" class="button pull-left">Continue Shopping</a>
        <a class="button"  href="close" data-dismiss="modal">Close</a>
      </div>
    </div>
  </div>
</div>