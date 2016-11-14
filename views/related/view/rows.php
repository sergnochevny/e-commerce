<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $row): ?>
    <div class="product-item">
      <div class="product-inner">
        <?php
          $url_prms['pid'] = $row['pid'];
          $url_prms['back'] = urlencode(base64_encode(_A_::$app->router()->UrlTo('shop/product', ['pid' => $row['cpid']], $row['cpname'], ['cat', 'mnf', 'ptrn'])));
          $href = _A_::$app->router()->UrlTo('shop/product', $url_prms, $row['pname'], ['cat', 'mnf', 'ptrn']);
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
          <?php if($row['bProductDiscount']) { ?>
            <span class="extra_discount">Extra Discount!</span>
          <?php } ?>
          <figcaption data-product>
            <a data-waitloader class="button add-to-basket" href="<?= $href; ?>">View Details</a>
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
<?php endif; ?>
