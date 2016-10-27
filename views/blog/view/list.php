<div class="row">
  <div class="col-xs-12">

    <div class="row">
      <div class="col-xs-12 search-result-header">
        <div class="row">
          <div class="col-sm-4">
            <p class="woocommerce-result-count">
              <?php
                if(!empty(_A_::$app->get('cat'))) {
                  echo 'CATEGORY: ' . $category_name . '<br/>';
                }
              ?>
            </p>
          </div>
          <div class="col-sm-4"></div>
          <div class="col-sm-4 search-result-container">
            <span class="woocommerce-result-count pull-right">Showing <?= $count_rows; ?> results</span>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <div class="row products">
          <?= $list; ?>
        </div>
      </div>
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