<?php

use app\core\App;

?>
<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $row): ?>
    <div class="col-xs-12 col-sm-6 col-md-4 product-item">
      <div class="product-inner">
        <div class="product-price-box clearfix">
          <div class="price-header">Price</div>
          <div class="price">
            <?= (isset($row['saleprice']) && ($row['price'] != $row['saleprice'])) ? '<hr>' : '' ?>
            <span class="amount"> <?= $row['format_price']; ?></span>
          </div>
          <?php if(!empty($row['saleprice']) && ($row['price'] != $row['saleprice'])) : ?>
            <div class="price sale-price">
              <span class="amount_wd"><?= $row['format_sale_price']; ?></span>
            </div>
          <?php endif; ?>
        </div>
        <figure class="product-image-box" style="background-image:url(<?= $row['filename']; ?>)">
          <?php if($row['bProductDiscount']) { ?>
            <span class="extra_discount">Extra Discount!</span>
          <?php }
          $url_prms['pid'] = $row[0];
          $url_prms['back'] = 'recommends';
          if(!empty($scenario)) $url_prms['method'] = $scenario;
          $href = App::$app->router()->UrlTo('shop/product', $url_prms, $row['pname'], ['method']); ?>
          <figcaption data-product>
            <?php if($row['in_cart']) :
              include(APP_PATH . '/views/cart/basket.php');
            else : ?>
              <a data-waitloader class="button add-to-basket" href="<?= $href; ?>">View Details</a>
            <?php endif; ?>
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
