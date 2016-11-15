<div class="col-xs-12">
  <div class="row afterhead-row">
    <div class="col-sm-2 back_button_container">
      <div class="row">
        <a data-waitloader id="back_url" href="<?= _A_::$app->router()->UrlTo('shop'); ?>" class="button back_button">Back</a>
      </div>
    </div>
    <div class="col-sm-8 text-center">
      <div class="row">
        <h3 class="page-title">Manufacturers</h3>
      </div>
    </div>
    <div class="col-sm-2"></div>
  </div>
</div>
<div class="col-xs-12 search-result-header">
  <div class="row">
    <div class="col-xs-12 search-result-container text-right">
      <span class="search-result">Showing <?= $count_rows; ?> results</span>
    </div>
  </div>

</div>
<div class="col-xs-12">
  <div class="row products-wrap">
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
