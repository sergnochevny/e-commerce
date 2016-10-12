<link rel='stylesheet' charset="UTF-8"
      href='<?php echo _A_::$app->router()->UrlTo('views/css/simple-line-icons.css'); ?>' type='text/css' media='all'/>
<link rel='stylesheet' charset="UTF-8" href='<?php echo _A_::$app->router()->UrlTo('views/css/matches.css'); ?>'
      type='text/css' media='all'/>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <article class="page type-page status-publish entry">
        <br/><br/>

        <h1 class="entry-title">I Luv Fabrix Matches</h1>

        <div class="entry-content">
          <div class="vc_row wpb_row vc_row-fluid">
            <div class="wpb_column vc_column_container vc_col-sm-12">
              <div class="wpb_wrapper">
                <div class="vc_row wpb_row vc_inner vc_row-fluid">
                  <div class="wpb_column vc_column_container vc_col-sm-12">
                    <div class="wpb_wrapper">
                      <section class="just-posts-grid">
                        <div class="note">
                          <div class="matches-note">
                            NOTE:
                          </div>
                          <div class="matches-note-text">
                            <p align="left">
                              <b>In
                                &laquo;Matches&raquo; you can mix and match your
                                fabric samples by dragging them into the work
                                area below.
                                Experiment with possible combinations and have fun.
                                <br/>
                                If you want to purchase a fabric in matches area
                                press to &laquo;Add All to Basket&raquo;.
                                <br/>
                                If you want to remove a fabric from
                                your &laquo;Matches&raquo; drag it to the trash
                                can.
                                <br/>
                                If you want to remove all fabric from
                                your &laquo;Matches&raquo; press to &laquo;Clear
                                Matches&raquo;.<br>
                                Before experiment with other fabrics you need to
                                clear the area by clicking &laquo;Clear Matches&raquo;.
                              </b>
                            </p>
                          </div>
                        </div>
                        <div id="dragZone">
                          <div class="dragZoneTitle">Matches Area</div>
                          <div id="dragZoneArea">
                            <div class="deleteDragImg icon-delete"></div>
                            <div class="detailsDragImg"></div>
                            <?= isset($matches_items) ? $matches_items : '' ?>
                          </div>
                        </div>
                        <b id="b_in_product">
                          <a id="all_to_basket" href="<?= _A_::$app->router()->UrlTo('matches/all_to_cart'); ?>">
                            Add All to Basket
                          </a>
                          <a id="clear_matches"
                             href="<?= _A_::$app->router()->UrlTo('matches/clear'); ?>">
                            Clear Matches
                          </a>
                        </b>

                      </section>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </article>
    </div>
  </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/matches/matches.js'); ?>' type="text/javascript"></script>

<?php include('views/product/block_footer.php'); ?>