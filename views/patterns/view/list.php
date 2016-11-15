<div class="col-xs-12 search-result-header">
  <div class="row">
    <div class="col-xs-12 search-result-container text-right">
      <span class="search-result">Showing <?= $count_rows; ?> results</span>
    </div>
  </div>

</div>
<div class="col-xs-12">
  <div class="row">
    <div class="products">
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
