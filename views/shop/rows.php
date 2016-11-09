<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $row): ?>
    <div class="col-xs-12 col-sm-6 col-md-4 product-item">
      <div class="product-inner">
          <figure data-product class="product-image-box" style="background-image:url(<?= $row['filename']; ?>)">
            <?php if($row['bProductDiscount']) { ?>
              <span class="extra_discount">Extra Discount!</span>
            <?php }
              $url_prms['pid'] = $row[0];
              $url_prms['back'] = 'shop';
              $href = _A_::$app->router()->UrlTo('shop/product', $url_prms, $row['pname'], ['cat', 'mnf', 'ptrn']);
            ?>

            <figcaption>
              <?php
                if($row['in_cart']) {
                  include('views/cart/basket.php');
                } else {
                  ?>
                  <a data-waitloader class="button add-to-basket" href="<?= $href; ?>">View Details</a>
                  <?php
                }
              ?>
            </figcaption>
          </figure>
        <span class="product-category">
          <a data-waitloader href="<?= $href; ?>"><?= $row['pname']; ?></a>
        </span>
        <p class="description">
          <?= (strlen($row['sdesc']) > 0) ? $row['sdesc'] : $row['ldesc']; ?>
        </p>
        <div class="product-price-box clearfix">
          <?php if($row['sys_hide_price'] == 0 && $row['hideprice'] == 0) { ?>
            <span class="price pull-left"><span class="amount"><?= $row['format_price']; ?></span></span>
          <?php }
            if(isset($row['saleprice']) && ($row['price'] != $row['saleprice'])) { ?>
              <span class="text-sale pull-right">
            Sale: <span class="amount_wd"><?= $row['format_sale_price']; ?></span>
          </span>
            <?php } ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="col-sm-12 text-center offset-top">
    <h2 class="offset-top page-title">No results found</h2>
  </div>
<?php endif; ?>
