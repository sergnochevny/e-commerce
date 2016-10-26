<div class="col-xs-12 product-item">
  <div class="widget-info-container">
      <div class="col-xs-6 col-sm-4">
        <a href="<?= _A_::$app->router()->UrlTo('shop/product', ['pid' => $row[0]], $row['pname']); ?>" title="<?= $row['pname']; ?>">
          <div class="product-image" style="background-image:url(<?= $filename; ?>)">
              <?php if($bProductDiscount) { ?>  <span class="extra_discount_small">Extra Discount!</span> <?php } ?>
          </div>
        </a>
      </div>
      <div class="col-xs-6 col-sm-8">
        <div class="product-title">
          <a href="<?= _A_::$app->router()->UrlTo('shop/product', ['pid' => $row[0]], $row['pname']); ?>" title="<?= $row['pname']; ?>">
            <?= $row['pname']; ?>
          </a>
        </div>
        <div class="widget-price-container">
          <?php if($sys_hide_price == 0 && $hide_price == 0) { ?>
            <div class="col-md-12 text-left">
              <div class="row">
                <span class="amount"><?= $format_price; ?></span>
              </div>
            </div>
          <?php } ?>
          <?php if(isset($saleprice) && ($price != $saleprice)) { ?>
            <div class="col-md-12 text-left">
              <div class="row">
                <small class="text-sale price">Sale: <span class="amount_wd"><?= $format_sale_price; ?></span></small>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>

  </div>
</div>
