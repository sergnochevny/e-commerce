<link rel='stylesheet' charset="UTF-8"
      href='<?php echo _A_::$app->router()->UrlTo('views/css/simple-line-icons.css'); ?>' type='text/css' media='all'/>
<link rel='stylesheet' charset="UTF-8" href='<?php echo _A_::$app->router()->UrlTo('views/css/matches.css'); ?>'
      type='text/css' media='all'/>
<div id="content" class="container">
  <div class="entry-content">
    <div class="row">
      <div class="col-xs-12">
        <div class="col-xs-12">
          <section class="just-posts-grid">
            <div id="dragZone">
              <div class="dragZoneTitle">Matches Area</div>
              <div id="dragZoneArea">
                <div class="deleteDragImg icon-delete"></div>
                <div class="detailsDragImg"></div>
                <?= isset($matches_items) ? $matches_items : '' ?>
              </div>
            </div>
            <div class="note">
              <hr>
              <div class="matches-note text-bold">
                <small style="color:#999;">
                  NOTE:
                </small>
              </div>
              <div class="matches-note-text">
                <p align="left">
                  <small style="color:#999;">
                    In
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
                  </small>
                </p>
              </div>
              <hr>
            </div>
            <div style="width: 100%" class="text-center inner-offset-vertical" id="b_in_product">
              <?php if(isset($matches_items)): ?>
                <a class="button" id="all_to_basket"
                   href="<?= _A_::$app->router()->UrlTo('matches/all_to_cart'); ?>">
                  Add All to Basket
                </a>
                <a class="button" id="clear_matches"
                   href="<?= _A_::$app->router()->UrlTo('matches/clear'); ?>">
                  Clear Matches
                </a>
              <?php else: ?>
                <a class="button" href="<?= _A_::$app->router()->UrlTo('shop'); ?>">
                  Go shopping
                </a>
              <?php endif; ?>
            </div>

          </section>
        </div>
      </div>
    </div>
  </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/matches/matches.js'); ?>' type="text/javascript"></script>

<?php include('views/index/block_footer.php'); ?>