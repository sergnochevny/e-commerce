<?php if(sizeof($rows) > 0): ?>
  <ul class="products">
    <?php foreach($rows as $row): ?>
      <?php $prms['pid'] = $row[0];
      if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page'); ?>
      <li
        class="last product type-product status-publish has-post-thumbnail product_cat-brooches product_tag-fashion product_tag-jewelry sale featured shipping-taxable purchasable product-type-simple product-cat-brooches product-tag-fashion product-tag-jewelry instock">
        <div class="product-inner">
          <a href="<?= _A_::$app->router()->UrlTo('product/edit', $prms); ?>">
            <figure class="product-image-box">
              <a href="#">
                <img width="#" height="266" src="<?= $row['filename']; ?>"
                     class="attachment-shop_catalog size-shop_catalog wp-post-image" alt=""/>
              </a>
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
                    <span class="amount"><?= $row['format_price']; ?></span>
                </ins>
              </span>
            </div>
          </a>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
<?php else: ?>
  <div class="col-sm-12 text-center offset-top">
    <h2 class="offset-top">No results found</h2>
  </div>
<?php endif; ?>
