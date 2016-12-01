<?php
  $prms = null;
  if(!is_null(_A_::$app->get('page'))) {
    $prms['page'] = _A_::$app->get('page');
  }
?>
<div class="col-xs-12">

  <?= isset($search_form) ? $search_form : '' ?>

  <div class="row">
    <div class="col-xs-12 search-result-header text-right">
      <span class="search-result">Showing <?= $count_rows; ?> results</span>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <div class="row clearance_products">
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
</div>
