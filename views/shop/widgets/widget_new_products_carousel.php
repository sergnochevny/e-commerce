<div class="col-xs-12  product-item">
  <div class="product-inner">
      <figure class="product-image-box">
        <a href="<?= _A_::$app->router()->UrlTo('shop/product', ['pid' => $row[0]], $row['pname']); ?>">
          <img src="<?= $filename; ?>" alt="">
        </a>
        <?php if($bProductDiscount) { ?>
          <span class="extra_discount">Extra Discount!</span>
        <?php } ?>
        <figcaption></figcaption>
      </figure>

      <span class="on-sale">New!</span>
      <span class="product-category"><?= $row['pname']; ?></span>
      <h3 class="descProduct">
        <a href="<?= _A_::$app->router()->UrlTo('shop/product', ['pid' => $row[0]], $row['pname']); ?>">
          <?= (strlen($row['sdesc']) > 0) ? $row['sdesc'] : $row['ldesc']; ?>
        </a>
      </h3>
      <div class="product-price-box clearfix">
        <?php if($sys_hide_price == 0 && $hide_price == 0) { ?>
          <span class="price pull-left"><ins><span class="amount"><?= $format_price; ?></span></ins></span>
        <?php }
          if(isset($saleprice) && ($price != $saleprice)) { ?>
            <span class="text-sale pull-right" style="float:right;color: red;">Sale: <ins><span
                  class="amount_wd"><?= $format_sale_price; ?></span></ins></span>
          <?php } ?>
      </div>

  </div>
</div>
