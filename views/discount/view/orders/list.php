<div class="row">
  <div class="col-xs-12 text-center" style="margin-top: 30px">
    <h3>ORDERS</h3>
  </div>
</div>

<div class="row">
  <div class="col-xs-12 search-result-header text-right">
    <span class="search-result">Showing <?= $count_rows; ?> results</span>
    <?= isset($show_by) ? $show_by : ''; ?>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <?= $list; ?>
  </div>
</div>

<div class="row">
  <nav class="paging-navigation" role="navigation">
    <h4 class="sr-only">Navigation</h4>
    <ul class="pagination">
      <?= isset($paginator) ? $paginator : ''; ?>
    </ul>
  </nav>
</div>

<script src='<?= _A_::$app->router()->UrlTo('js/formsimple/list.min.js'); ?>' type="text/javascript"></script>
