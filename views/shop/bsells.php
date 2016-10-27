<div class="col-xs-12 col-sm-6 col-md-4 product-item">
  <div class="product-inner">
    <span class="on-sale">Best!</span>
    <?php
      $href = _A_::$app->router()->UrlTo('shop/product', $url_prms, $row['pname'], ['cat', 'mnf', 'ptrn']);
    ?>
    <figure class="product-image-box" style="background-image:url(<?= $filename; ?>)">
      <a href="<?= $href; ?> ">
        <figcaption>
          <?php if($bProductDiscount) { ?>
            <span class="extra_discount">Extra Discount!</span>
          <?php }
          ?>
          <?php
            if($in_cart) {
              include('views/cart/basket.php');
            } else { ?>
              <a class="button add-to-basket" href="<?= $href; ?>">
                View Details
              </a>
            <?php } ?>
        </figcaption>
      </a>
    </figure>

    <a href="<?= $href; ?>">
      <span class="product-category"><?= $row['pname']; ?></span>
      <h3 class="descProduct"><?= (strlen($row['sdesc']) > 0) ? $row['sdesc'] : $row['ldesc']; ?></h3>
      <div class="product-price-box clearfix">
        <?php if($sys_hide_price == 0 && $hide_price == 0) { ?>
          <span class="price pull-left">
            <ins>
              <span class="amount"><?= $format_price; ?></span>
            </ins>
          </span>
        <?php } ?>
        <?php if(isset($saleprice) && ($price != $saleprice)) { ?>
          <span class="price pull-right" style="float:right;color: red;">
            Sale: <ins><span class="amount_wd"><?= $format_sale_price; ?></span></ins>
          </span>
        <?php } ?>
      </div>
    </a>
  </div>
</div>
