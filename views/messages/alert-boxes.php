<div class="col-xs-12 alert-container">
  <div class="row">
    <?php if (isset($warning)) { ?>
      <div class="col-xs-12 alert-success danger">
        <?php foreach ($warning as $msg) {
          echo $msg . "<br/>";
        } ?>
      </div>
    <?php }
      if (isset($error)) { ?>
        <div class="col-xs-12 alert-danger danger">
          <?php foreach ($error as $msg) {
            echo $msg . "<br/>";
          } ?>
        </div>
      <?php } ?>
  </div>
</div>
