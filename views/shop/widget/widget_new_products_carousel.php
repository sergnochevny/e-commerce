<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $row): ?>
    <div class="product-item">
      <div class="product-inner">
        <?php
          $url_prms['pid'] = $row['pid'];
          $url_prms['back'] = '';
          $href = _A_::$app->router()->UrlTo('shop/product', $url_prms, $row['pname'], ['cat', 'mnf', 'ptrn']);
        ?>
        <figure class="product-image-box" style="background-image:url(<?= $row['filename']; ?>)">
          <a data-waitloader href="<?= $href; ?>">
            <?php if($row['bProductDiscount']) { ?>
              <span class="extra_discount">Extra Discount!</span>
            <?php } ?>
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
          </a>
        </figure>

        <span class="on-sale">New!</span>
        <span class="product-category"><a href="<?= $href; ?>"><?= $row['pname']; ?></a></span>
        <p class="description">
          <?= (strlen($row['sdesc']) > 0) ? $row['sdesc'] : $row['ldesc']; ?>
        </p>
        <div class="product-price-box clearfix">
          <?php if($row['sys_hide_price'] == 0 && $row['hideprice'] == 0) { ?>
            <span class="price pull-left"><ins><span class="amount"><?= $row['format_price']; ?></span></ins></span>
          <?php }
            if(isset($row['saleprice']) && ($row['price'] != $row['saleprice'])) { ?>
              <span class="text-sale pull-right" style="float:right;color: red;">Sale: <ins><span
                    class="amount_wd"><?= $row['format_sale_price']; ?></span></ins></span>
            <?php } ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>
