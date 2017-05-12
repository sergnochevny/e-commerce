<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $row): ?>
    <div class="col-xs-12 col-sm-6 col-md-4 product-item">
      <div class="product-inner">
        <div class="product-price-box clearfix">
          <div class="price-header">
            <?= (($row['sys_hide_price'] == 0 && $row['hideprice'] == 0) || isset($row['saleprice'])) ? 'Price' : ''; ?>
          </div>
          <?php if($row['sys_hide_price'] == 0 && $row['hideprice'] == 0) : ?>
            <div class="price">
              <?= (isset($row['saleprice']) && ($row['price'] != $row['saleprice'])) ? '<hr>' : '' ?>
              <span class="amount">
                <?= $row['format_price']; ?>
              </span>
            </div>
          <?php endif;
            if(isset($row['saleprice']) && ($row['price'] != $row['saleprice'])) : ?>
              <div class="price sale-price">
                <span class="amount_wd"><?= $row['format_sale_price']; ?></span>
              </div>
            <?php endif; ?>
        </div>
        <figure class="product-image-box" style="background-image:url(<?= $row['filename']; ?>)">
          <?php if(!empty($row['inventory']) && ($row['inventory'] > 0)) : ?>
            <?php if($row['bProductDiscount']) : ?>
              <span class="extra_discount">Extra Discount!</span>
            <?php endif;
          else: ?>
            <div class="sold_out_1">
              <hr>
            </div>
            <div class="sold_out_2">
              <hr>
            </div>
            <span class="extra_discount">Sold Out!</span>
          <?php endif; ?>
          <?php
            $url_prms['pid'] = $row['pid'];
            $url_prms['back'] = 'favorites';
            $href = _A_::$app->router()->UrlTo('shop/product', $url_prms, $row['pname'], ['cat', 'mnf', 'ptrn', 'clr', 'prc']);
            $del_href = _A_::$app->router()->UrlTo('shop/product', $url_prms, $row['pname'], ['cat', 'mnf', 'ptrn', 'clr', 'prc']);
          ?>
          <figcaption data-product>
            <?php if($row['in_cart']) :
              include('views/cart/basket.php');
            else : ?>
              <?php if(!empty($row['inventory']) && ($row['inventory'] > 0)) : ?>
                <a data-waitloader class="button add-to-basket" href="<?= $href; ?>">View Details</a>
              <?php endif; ?>
            <?php endif; ?>
            <a data-delete href="<?= _A_::$app->router()->UrlTo('favorites/delete', ['id' => $row['id']]); ?>"
               rel="nofollow"
               class="button icon-delete add_to_cart_button product_type_simple"></a>
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
