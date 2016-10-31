<?php if(sizeof($rows) > 0): ?>
    <?php foreach($rows as $row): ?>
      <?php $prms['pid'] = $row[0];
      if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page'); ?>
      <div class="col-xs-12 col-sm-6 col-md-4 product-item">
        <div class="product-inner">
          <figure class="product-image-box" style="background: url(<?= $row['filename']; ?>) top center no-repeat; background-size: cover;">
            <figcaption>
              <a data-delete href="<?= _A_::$app->router()->UrlTo('product/delete', $prms); ?>" rel="nofollow"
                 class="button icon-delete add_to_cart_button   product_type_simple"></a>
              <a data-modify href="<?= _A_::$app->router()->UrlTo('product/edit', $prms); ?>"
                 class="button product-button icon-modify">
              </a>
            </figcaption>
          </figure>
          <span class="product-category"><?= $row['pname']; ?></span>
          <h3><?= $row[8]; ?></h3>
          <div class="product-price-box clearfix">
            <span class="price">
              <ins>
                  <span class="amount"><?= '$' . $row['format_price']; ?></span>
              </ins>
            </span>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
<?php else: ?>
  <div class="col-sm-12 text-center offset-top">
    <h2 class="offset-top page-title">No results found</h2>
  </div>
<?php endif; ?>