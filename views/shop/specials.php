<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $row): ?>
    <div class="col-xs-12 col-sm-6 col-md-4 product-item">
      <div class="product-inner">
        <span class="on-sale">Specials!</span>
        <?php
          $url_prms['pid'] = $row['pid'];
          /** @noinspection PhpUndefinedMethodInspection */
          $href = _A_::$app->router()->UrlTo('shop/product', $url_prms, $row['pname'], ['cat', 'mnf', 'ptrn', 'clr', 'prc']);
        ?>
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
        <figure class="product-image-box" style="background-image:url(<?= $row['filename']; ?>)">
          <?php if($row['bProductDiscount']) { ?> <span class="extra_discount">Extra Discount!</span> <?php } ?>
          <figcaption data-product>
            <?php
              if($row['in_cart']) {
                include('views/cart/basket.php');
              } else { ?>
                <a class="button add-to-basket" href="<?= $href; ?>">
                  View Details
                </a>
              <?php } ?>
          </figcaption>
        </figure>
        <div class="product-description">
          <div class="product-name">
            <a data-waitloader href="<?= $href; ?>"><?= $row['pname']; ?></a>
          </div>
          <div class="description">
            <?= (strlen($row['sdesc']) > 0) ? $row['sdesc'] : $row['ldesc']; ?>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="col-xs-12 text-center inner-offset-vertical">
    <span class="h3">No results found</span>
  </div>
<?php endif; ?>

<script src='<?= /** @noinspection PhpUndefinedMethodInspection */
  _A_::$app->router()->UrlTo('views/js/formsimple/list.min.js'); ?>' type="text/javascript"></script>

