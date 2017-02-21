<div class="col-xs-12 pull-right">
  <div class="row afterhead-row text-center">
    <h3 class="page-title sb">Color</h3>
  </div>
</div>
<?= isset($search_form) ? $search_form : '' ?>
<div class="col-xs-12 search-result-header search-result-container text-right">
  <div class="row">
    <span class="search-result">Showing <?= $count_rows; ?> results</span>
    <?= isset($show_by) ? $show_by : ''; ?>
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
<script src='<?= /** @noinspection PhpUndefinedMethodInspection */
  _A_::$app->router()->UrlTo('views/js/formsimple/list.min.js'); ?>' type="text/javascript"></script>
