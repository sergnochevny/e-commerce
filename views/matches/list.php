<section class="just-posts-grid">
  <div class="note afterhead-row">
    <div class="matches-note text-bold">
      <small>
        NOTE:
      </small>
    </div>
    <div class="matches-note-text">
      <p align="left">
        <small>
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
  <div id="dragZone">
    <div class="dragZoneTitle">Matches Area</div>
    <div id="dragZoneArea">
      <div class="deleteDragImg icon-delete"></div>
      <div class="detailsDragImg"></div>
      <?= isset($list) ? $list : '' ?>
    </div>
  </div>
  <div style="width: 100%" class="text-center inner-offset-vertical" id="b_in_product">
    <?php if(isset($list)): ?>
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
