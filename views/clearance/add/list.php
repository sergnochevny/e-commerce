<div class="col-xs-12" style="padding-bottom: 30px">
  <div class="row products">

    <div class="col-xs-12">
      <div class="col-xs-12">
        <div class="row">
          <p class="required_field legend">
            Click an inactive Item to select it for Clearence. And click an active - to remove it.
          </p>
        </div>
      </div>

      <?= isset($search_form) ? $search_form : '' ?>

      <div class="row">
        <div class="col-xs-12 search-result-header text-right">
          <span class="search-result">Showing <?= $count_rows; ?> results</span>
          <?= isset($show_by) ? $show_by : ''; ?>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <div class="row clearance_products">
            <?= $list; ?>
          </div>
        </div>
      </div>

      <?php if(isset($paginator)): ?>
        <div class="row">
          <nav class="paging-navigation" role="navigation">
            <h4 class="sr-only">Navigation</h4>
            <ul class="pagination">
              <?= isset($paginator) ? $paginator : ''; ?>
            </ul>
          </nav>
        </div>
      <?php endif; ?>
    </div>

  </div>
</div>
