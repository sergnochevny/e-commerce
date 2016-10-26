<div class="col-xs-12 col-sm-6 col-md-4 product-item">
  <div class="product-inner">

    <figure class="product-image-box" style="background-image:url(<?= $filename; ?>)">
      <?php if($bProductDiscount) { ?>
        <span class="extra_discount">Extra Discount!</span>
      <?php }
        $opt['pid'] = $row[0];
      ?>
      <a <?= isset($search) ? 'class="a_search"' : '' ?> href="<?= _A_::$app->router()->UrlTo('shop/product', $opt, $row['pname']); ?>"></a>
      <figcaption>
        <?php
          if($in_cart) {
            include('views/cart/basket.php');
          } else {
            ?>
            <a class="button add-to-basket <?= isset($search) ? 'a_search' : '' ?>"
               href="<?= _A_::$app->router()->UrlTo('shop/product', $opt, $row['pname']); ?>">
              View Details
            </a>
            <?php
          }
        ?>
      </figcaption>
    </figure>
      <span class="product-category"><?= $row['pname']; ?></span>
      <h3>
        <a <?= isset($search) ? 'class="a_search"' : '' ?> href="<?= _A_::$app->router()->UrlTo('shop/product', $opt, $row['pname']); ?>">
          <?= (strlen($row['sdesc']) > 0) ? $row['sdesc'] : $row['ldesc']; ?>
        </a>
      </h3>
      <div class="product-price-box clearfix">
        <?php if($sys_hide_price == 0 && $hide_price == 0) { ?>
          <span class="price"><span class="amount"><?= $format_price; ?></span></span>
        <?php } if(isset($saleprice) && ($price != $saleprice)) { ?>
          <span class="text-sale">
            Sale: <span class="amount_wd"><?= $format_sale_price; ?></span>
          </span>
        <?php } ?>
      </div>
  </div>
</div>
