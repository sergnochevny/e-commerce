<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $row): ?>
    <div class="col-xs-12 product-item">
      <div class="widget-info-container">
        <div class="col-xs-6 col-sm-4">
          <?php
            $url_prms['pid'] = $row['pid'];
            $url_prms['back'] = '';
            $href = _A_::$app->router()->UrlTo('shop/product', $url_prms, $row['pname'], ['cat', 'mnf', 'ptrn']);
          ?>
          <a href="<?= $href; ?>" title="<?= $row['pname']; ?>">
            <div class="product-image" style="background-image:url(<?= $row['filename']; ?>)">
              <?php if($row['bProductDiscount']) { ?>  <span
                class="extra_discount_small">Extra Discount!</span> <?php } ?>
            </div>
          </a>
        </div>
        <div class="col-xs-6 col-sm-8">
          <div class="product-title">
            <a href="<?= $href; ?>" title="<?= $row['pname']; ?>">
              <?= $row['pname']; ?>
            </a>
          </div>
          <div class="widget-price-container">
            <?php if($row['sys_hide_price'] == 0 && $row['hideprice'] == 0) { ?>
              <div class="col-md-12 text-left">
                <div class="row">
                  <span class="amount"><?= $row['format_price']; ?></span>
                </div>
              </div>
            <?php } ?>
            <?php if(isset($row['saleprice']) && ($row['price'] != $row['saleprice'])) { ?>
              <div class="col-md-12 text-left">
                <div class="row">
                  <small class="text-sale price">Sale: <span class="amount_wd"><?= $row['format_sale_price']; ?></span>
                  </small>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="col-sm-12 text-center offset-top">
    <h2 class="offset-top page-title">No results found</h2>
  </div>
<?php endif; ?>
