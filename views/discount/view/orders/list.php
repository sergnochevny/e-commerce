<div class="row">
  <div class="col-xs-12 text-center" style="margin-top: 30px">
    <h4>ORDERS</h4>
  </div>
</div>

<div class="row">
  <div class="col-xs-12 search-result-header text-right">
    <span class="search-result">Showing <?= $count_rows; ?> results</span>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <?= $list; ?>
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
<script src='<?= _A_::$app->router()->UrlTo('views/js/formsimple/list.min.js'); ?>' type="text/javascript"></script>
