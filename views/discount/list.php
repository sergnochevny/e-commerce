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
<?php
  $prms = null;
  if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
?>
<div class="text-center">
  <a href="<?= _A_::$app->router()->UrlTo('discount/add', $prms); ?>" data-modify class="button">
    ADD NEW DISCOUNT
  </a>
</div>
<p class="woocommerce-result-count">Showing <?= $count_rows; ?> results</p>
<?= isset($search_form) ? $search_form : '' ?>
<div>
  <?= $list; ?>
</div>
<nav class="paging-navigation" role="navigation">
  <h4 class="sr-only">Navigation</h4>
  <ul class="pagination">
    <?= isset($paginator) ? $paginator : ''; ?>
  </ul>
</nav>
<script src='<?= _A_::$app->router()->UrlTo('views/js/formsimple/list.js'); ?>' type="text/javascript"></script>
