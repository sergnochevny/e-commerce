<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $row): ?>
    <?php $prms['pid'] = $row['pid'];?>
    <div class="col-xs-12 col-sm-6 col-md-4 product-item">
      <div class="product-inner">
        <div class="product-price-box clearfix">
          <div class="price-header">Price</div>
            <div class="price">
              <span class="amount">
                <?= $row['format_price']; ?>
              </span>
            </div>
        </div>
        <figure class="product-image-box" style="background-image: url(<?= $row['filename']; ?>)">
          <figcaption>
            <a data-delete href="<?= _A_::$app->router()->UrlTo('product/delete', $prms); ?>" rel="nofollow"
               class="button icon-delete add_to_cart_button   product_type_simple"></a>
            <a data-waitloader data-modify href="<?= _A_::$app->router()->UrlTo('product/edit', $prms); ?>"
               class="button product-button icon-modify">
            </a>
          </figcaption>
        </figure>
        <div class="product-description">
          <div class="product-name"><?= $row['pname']; ?></div>
          <div class="description"><?= (strlen($row['sdesc']) > 0) ? $row['sdesc'] : $row['ldesc']; ?></div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="col-sm-12 text-center offset-top">
    <h2 class="offset-top page-title">No results found</h2>
  </div>
<?php endif; ?>