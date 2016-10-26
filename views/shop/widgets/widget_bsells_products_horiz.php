<div class="col-xs-12 col-sm-6 col-md-4 product-item">
  <div class="product-inner">
      <figure class="product-image-box">
        <a href="<?= _A_::$app->router()->UrlTo('shop/product', ['pid' => $row[0]], $row['pname']); ?>">
          <img src="<?= $filename; ?>" alt="">
        </a>
        <figcaption>
          <?php if($bProductDiscount) { ?><span class="extra_discount">Extra Discount!</span><?php } ?>
        </figcaption>
      </figure>

      <span class="product-category">
        <a href="<?= _A_::$app->router()->UrlTo('shop/product', ['pid' => $row[0]], $row['pname']); ?>">
          <?= $row['pname']; ?>
        </a>
      </span>

      <h3 class="descProduct">
        <a href="<?= _A_::$app->router()->UrlTo('shop/product', ['pid' => $row[0]], $row['pname']); ?>">
          <?= (strlen($row['sdesc']) > 0) ? $row['sdesc'] : $row['ldesc']; ?>
        </a>
      </h3>

      <div class="product-price-box clearfix">
        <?php if($sys_hide_price == 0 && $hide_price == 0) { ?>
          <span class="price pull-left"><span class="amount"><?= $format_price; ?></span></span>
        <?php } ?>
        <?php if(isset($saleprice) && ($price != $saleprice)) { ?>
          <span class="text-sale pull-right">
              Sale: <span class="amount_wd"><?= $format_sale_price; ?></span>
          </span>
        <?php } ?>
      </div>

  </div>
</div>
