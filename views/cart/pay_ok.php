<?php

use app\core\App;

?>
<div class="row">
  <div class="col-xs-12">
    <article class="page type-page status-publish entry" style="overflow:hidden;">
      <div class="pay_ok">
        <p>
          <span class="title">
              THANK YOU
          </span>
        </p>
        <p>
          <span class="msg">
              for your purchase.
              The confirmation will be emailed to you shortly.
          </span>
        <p>
      </div>

      <div class="entry-content">
        <div class="wc-proceed-to-checkout text-center">
          <a class="checkout-button button alt wc-forward" href="<?= App::$app->router()->UrlTo('shop') ?>">
            WOULD YOU LIKE TO CONTINUE SHOPPING? CLICK HERE
          </a>
        </div>
      </div>
    </article>
  </div>
</div>
