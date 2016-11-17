<div class="col-xs-12 pull-right">
  <div class="row afterhead-row">
    <div class="col-sm-10 col-sm-offset-2 text-center">
      <div class="row">
        <h3 class="page-title">Type</h3>
      </div>
    </div>
  </div>
</div>
<div class="col-xs-12 search-result-header search-result-container text-right">
  <div class="row">
    <span class="search-result">Showing <?= $count_rows; ?> results</span>
  </div>
</div>
<div class="col-xs-12">
  <div class="row products-wrap">
    <div class="products product_groups">
      <?= $list; ?>
    </div>
  </div>
</div>
<div class="col-xs-12">
  <div class="row">
    <nav class="paging-navigation" role="navigation">
      <h4 class="sr-only">Navigation</h4>
      <ul class="pagination">
        <?= isset($paginator) ? $paginator : ''; ?>
      </ul>
    </nav>
  </div>
</div>
