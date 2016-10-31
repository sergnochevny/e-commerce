<div class="col-xs-12 col-sm-6 col-md-4 product-item">
  <div class="product-inner">
    <?php
      $url_prms=['pid' => $row[0], 'back'=>''];
      $href = _A_::$app->router()->UrlTo('shop/product', $url_prms, $row['pname'], ['cat', 'mnf', 'ptrn']);
    ?>
    <figure class="product-image-box" style="background-image:url(<?= $filename; ?>)">
        <a href="<?= $href; ?>">
          <figcaption>
            <?php if($bProductDiscount) { ?><span class="extra_discount">Extra Discount!</span><?php } ?>
            <?php
              if($in_cart) {
                include('views/cart/basket.php');
              } else {
                ?>
                <a class="button add-to-basket <?= isset($search) ? 'a_search' : '' ?>"
                   href="<?= $href; ?>">
                  View Details
                </a>
                <?php
              }
            ?>
          </figcaption>
        </a>
      </figure>

      <span class="product-category">
        <a href="<?= $href; ?>">
          <?= $row['pname']; ?>
        </a>
      </span>

      <h3 class="descProduct">
        <a href="<?= $href; ?>">
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
