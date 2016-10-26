<div class="row">
  <div class="col-xs-12">
    <div class="vc_row wpb_row vc_row-fluid">
      <div class="wpb_column vc_column_container vc_col-sm-12">
        <div class="wpb_wrapper">
          <div class="vc_row wpb_row vc_inner vc_row-fluid">
            <div class="wpb_column vc_column_container vc_col-sm-12">
              <div class="wpb_wrapper">
                <p class="woocommerce-result-count" style="font-size: 18px;">
                  <?php
                    if(!empty(_A_::$app->get('cat'))) {
                      echo 'CATEGORY: ' . $category_name . '<br/>';
                    }
                    echo isset($count_rows) ? "Showing " . $count_rows . " results" : "Showing ... results";
                  ?>
                </p>
                <section class="just-posts-grid">
                  <div class="just-post-row row">
                    <?= isset($list) ? $list : ''; ?>
                    <div class="clearfix visible-md visible-lg"></div>
                  </div>
                </section>
              </div>
            </div>
          </div>
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
