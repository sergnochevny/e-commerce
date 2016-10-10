<?php if (isset($warning)) { ?>
  <div class="col-xs-12 alert-success danger" style="display: block;">
    <?php
      foreach ($warning as $msg) {
        echo $msg . "<br/>";
      }
    ?>
  </div>
<?php } ?>
<?php if (isset($error)) { ?>
  <div class="col-xs-12 alert-danger danger" style="display: block;">
    <?php
      foreach ($error as $msg) {
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
  <a href="<?= _A_::$app->router()->UrlTo('colours/add',$prms); ?>" data-modify class="button colour-create">
    ADD NEW COLOUR
  </a>
</div>
<p class="woocommerce-result-count">Showing <?= $count_rows; ?> results</p>
<?php include "views/colours/filter_form.php"; ?>
<div id="colours">
  <?=$list?>
</div>
<nav class="paging-navigation" role="navigation">
  <h4 class="sr-only">Navigation</h4>
  <ul class="pagination">
    <?= isset($paginator) ? $paginator : ''; ?>
  </ul>
</nav>

<div id="modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 id="modal-title" class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <div id="modal_content">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-primary save-data" data-dismiss="modal">
          Save
        </button>
        <button type="button" class="btn-default" data-dismiss="modal">
          Cancel
        </button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src='<?= _A_::$app->router()->UrlTo('views/js/simple/list.js'); ?>' type="text/javascript"></script>
