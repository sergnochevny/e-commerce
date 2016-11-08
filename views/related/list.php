<?php
  $prms = null;
  if(!is_null(_A_::$app->get('page'))) {
    $prms['page'] = _A_::$app->get('page');
  }
?>
<div class="col-xs-12">
  <div class="col-xs-12 text-center">
    <b class="h3">Select Related Fabrics</b>
  </div>

  <?= isset($search_form) ? $search_form : '' ?>

  <div class="row">
    <div class="col-xs-12 search-result-container text-right">
      <span class="search-result">Showing <?= $count_rows; ?> results</span>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12 data-view">
      <div class="row related_products">
        <?= $list; ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">

      <nav class="paging-navigation" role="navigation">
        <h4 class="sr-only">Navigation</h4>
        <ul class="pagination">
          <?= isset($paginator) ? $paginator : ''; ?>
        </ul>
      </nav>

    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="text-center">
        <a data-related_add_ok class="button" style="width: 150px;">Ok</a>
      </div>
    </div>
  </div>
</div>

<script src='<?= _A_::$app->router()->UrlTo('views/js/product/related/add.js'); ?>' type="text/javascript"></script>
<script src='<?= _A_::$app->router()->UrlTo('views/js/formsimple/list.js'); ?>' type="text/javascript"></script>
