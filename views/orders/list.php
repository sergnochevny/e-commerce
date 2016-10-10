<?php if(isset($warning)) { ?>
  <div class="col-xs-12 alert-success danger" style="display: block;">
    <?php
      foreach($warning as $msg) {
        echo $msg . "<br/>";
      }
    ?>
  </div>
<?php } ?>
<?php if(isset($error)) { ?>
  <div class="col-xs-12 alert-danger danger" style="display: block;">
    <?php
      foreach($error as $msg) {
        echo $msg . "<br/>";
      }
    ?>
  </div>
<?php } ?>
<?php if(isset($back_url) || isset($user_id)): ?>
<div class="row">
  <?php if(isset($back_url)): ?>
    <div class="col-md-2 text-left">
      <a href="<?= $back_url; ?>" class="button back_button">Back</a>
    </div>
  <?php endif; ?>
  <?php if(isset($user_id)): ?>
    <div class="<?= isset($back_url)?'col-md-10':'col-md-12'?> text-center">
      <span><b class="h1"><?= $is_admin ? $rows[0]['username'] : 'My' ?> Orders</b></span>
    </div>
  <?php endif; ?>
</div>
<?php endif; ?>
<p class="woocommerce-result-count">Showing <?= $count_rows; ?> results</p>
<div class="">
  <?= $list; ?>
</div>
<nav role="navigation" class="paging-navigation">
  <h4 class="sr-only">Navigation</h4>
  <ul class='pagination'>
    <?= isset($paginator) ? $paginator : ''; ?>
  </ul>
</nav>
