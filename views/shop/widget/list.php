<?php if(count($data) > 0): ?>
  <?php foreach($data as $row): ?>
    <div class="col-xs-12 product-item">
      <div class="row">
        <div class="widget-info-container">
          <div class="product-price-box clearfix">
            <div class="price-header">
              <?= (($row['sys_hide_price'] == 0 && $row['hideprice'] == 0) || isset($row['saleprice'])) ? 'Price' : ''; ?>
            </div>
            <?php if($row['sys_hide_price'] == 0 && $row['hideprice'] == 0) { ?>
              <div class="price">
                <?= (isset($row['saleprice']) && ($row['price'] != $row['saleprice'])) ? '<hr>' : '' ?>
                <span class="amount">
                <?= $row['format_price']; ?>
              </span>
              </div>
            <?php }
              if(isset($row['saleprice']) && ($row['price'] != $row['saleprice'])) { ?>
                <div class="price sale-price">
                  <span class="amount_wd"><?= $row['format_sale_price']; ?></span>
                </div>
              <?php } ?>
          </div>
          <div class="col-xs-6 col-sm-4">
            <div class="row">
              <?php
                $url_prms['pid'] = $row['pid'];
                $url_prms['back'] = '';
                $href = _A_::$app->router()->UrlTo('shop/product', $url_prms, $row['pname'], ['cat', 'mnf', 'ptrn', 'clr','prc']);
              ?>
              <a data-waitloader href="<?= $href; ?>" title="<?= $row['pname']; ?>">
                <figure class=="product-image" style="background-image:url(<?= $row['filename']; ?>)">
                  <figcaption>
                    <?php if($row['bProductDiscount']) { ?>  <span
                      class="extra_discount_small">Extra Discount!</span> <?php } ?>
                  </figcaption>
                </figure>
              </a>
            </div>
          </div>
          <div class="col-xs-6 col-sm-8">
            <div class="product-title">
              <a data-waitloader href="<?= $href; ?>" title="<?= $row['pname']; ?>">
                <?= $row['pname']; ?>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="col-sm-12 text-center offset-top">
    <h2 class="offset-top page-title">No results found</h2>
  </div>
<?php endif; ?>
