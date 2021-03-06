<?php

use app\core\App;

?>

<section class="just-posts-grid">
  <div class="col-xs-12">
    <div class="row">

      <?php if(empty($back_url)) {
        $to_shop = true;
        $back_url = App::$app->router()->UrlTo('shop');
      } ?>
      <div class="col-xs-12 col-sm-2 back_button_container">
        <div class="row">
          <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
            <?= !empty($to_shop) ? 'To Shop' : 'Back' ?>
          </a>
        </div>
      </div>
      <div class="col-xs-12 <?= empty($back_url) ? '' : 'col-sm-8' ?> text-center">
        <h1 class="page-title">Fabric Pattern Tool</h1>
      </div>
    </div>
  </div>
  <div class="col-xs-12">
    <div class="row">
      <div class="note_matches">
        <div class="matches-note text-bold">
          <small>
            NOTE:
          </small>
        </div>
        <div class="matches-note-text">
          <p align="left">
            In “Matches” you can mix and match your fabric samples by dragging them into the work area below. Experiment
            with various combinations. You can overlap fabrics to see what they look like together.
            <br/>
            If you want to purchase a fabric, highlight it and drag it to the Cart symbol.
            <br/>
            If you want to remove a fabric from the Matches area, highlight it and drag it to the trash can symbol.
            <br/>
            If you want to remove all fabric currently in the “Matches screen", simply press “Clear Matches”.
            <br>
            Before experimentation with other fabrics you need to clear the area by clicking &laquo;Clear
            Matches&raquo;.
          </p>
        </div>
      </div>
      <div id="dragZone" class="dragZone">
        <div class="dragZoneTitle">Matches Area</div>
        <div id="dragZoneArea" class="dragZoneArea">
          <div
            class="AddToCartDragImg <?= $cart_not_empty ? 'simple-icon-basket-loaded' : 'simple-icon-basket'; ?>"
            data-href="<?= App::$app->router()->UrlTo('matches/add_to_cart'); ?>"></div>
          <div class="deleteDragImg simple-icon-trash"></div>
          <div class="detailsDragImg"></div>
          <?= isset($list) ? $list : '' ?>
        </div>
      </div>
      <div style="width: 100%" class="text-center inner-offset-vertical" id="b_in_product">
        <?php if(isset($list)): ?>
          <a class="button" id="all_to_basket"
             href="<?= App::$app->router()->UrlTo('matches/add_to_cart'); ?>">
            Add All to Cart
          </a>
          <a class="button" id="clear_matches"
             href="<?= App::$app->router()->UrlTo('matches/clear'); ?>">
            Clear Matches
          </a>
        <?php else: ?>
          <a class="button" href="<?= App::$app->router()->UrlTo('shop'); ?>">
            Go shopping
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
