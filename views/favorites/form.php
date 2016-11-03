<div id="msg" style="color: red; text-align: center; font-weight: bold;">
  <div class="col-xs-12">
    <div class="row">
      <?php if (isset($warning)) { ?>
        <div class="col-xs-12">
          <?php foreach ($warning as $msg) {
            echo $msg . "<br/>";
          } ?>
        </div>
      <?php }
        if (isset($error)) { ?>
          <div class="col-xs-12">
            <?php foreach ($error as $msg) {
              echo $msg . "<br/>";
            } ?>
          </div>
        <?php } ?>
    </div>
  </div>
</div>