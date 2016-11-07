<div class="row">
  <div class="col-xs-12">

    <div class="row">
      <div class="col-xs-12 search-result-header">
        <div class="row">
          <div class="col-sm-4">
            <?php if(!empty(_A_::$app->get('cat'))): ?>
              <p class="woocommerce-result-count">
                CATEGORY: <?= $category_name ?> '<br/>
              </p>
            <?php endif; ?>
          </div>
          <div class="col-sm-4"></div>
          <div class="col-sm-4 search-result-container text-right">
            <span class="search-result">Showing <?= $count_rows; ?> results</span>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <div class="products">
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