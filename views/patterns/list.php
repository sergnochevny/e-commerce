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
  <a href="<?= _A_::$app->router()->UrlTo('patterns/add',$prms); ?>" data-modify class="button colour-create">
    ADD NEW PATTERN
  </a>
</div>
<p class="woocommerce-result-count">Showing <?= $count_rows; ?> results</p>

<div class="col-xs-12 panel panel-default search-panel">
    <h4 class="panel-heading search-container-title"><b>Search</b></h4>
    <form action="" class="panel-body">
      <div class="form-row">
        <div class="row">

          <div class="col-xs-12 col-md-6">
            <div class="row">
              <div class="col-xs-12">
                Pattern Name:
              </div>
              <div class="col-xs-12">
                <input type="text" class="input-text" placeholder="Name like">
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-md-6">
            <div class="row">
              <div class="col-xs-12">
                Contain Products:
              </div>
              <div class="col-xs-6">
                <input type="text" class="input-text" placeholder="From">
              </div>
              <div class="col-xs-6">
                <input type="text" class="input-text" placeholder="To">
              </div>
            </div>
          </div>

        </div>
      </div>
    </form>
    <div class="panel-footer">
      <button type="reset" class="btn">Reset</button>
      <button type="button" class="btn pull-right">Search</button>
    </div>
</div>
<div id="colours">
  <?=$list?>
</div>
<nav class="paging-navigation" role="navigation">
  <h4 class="sr-only">Navigation</h4>
  <ul class="pagination">
    <?= isset($paginator) ? $paginator : ''; ?>
  </ul>
</nav>

<script src='<?= _A_::$app->router()->UrlTo('views/js/simple/list.js'); ?>' type="text/javascript"></script>
