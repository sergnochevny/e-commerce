<div class="col-xs-12 danger">
  <?php if (isset($warning)) { ?>
    <div class="col-xs-12 alert-success">
      <?php foreach ($warning as $msg) {
        echo $msg . "<br/>";
      } ?>
    </div>
  <?php } if (isset($error)) { ?>
    <div class="col-xs-12 alert-danger danger">
      <?php foreach ($error as $msg) {
        echo $msg . "<br/>";
      } ?>
    </div>
  <?php } ?>
</div>
