<li class="last product type-product status-publish has-post-thumbnail product_cat-brooches product_tag-fashion product_tag-jewelry sale featured shipping-taxable purchasable product-type-simple product-cat-brooches product-tag-fashion product-tag-jewelry instock">
    <div class="product-inner">
        <figure class="product-image-box">
            <a href="#">
                <img width="#" height="266" src="<?php echo $filename; ?>"
                     class="attachment-shop_catalog size-shop_catalog wp-post-image" alt=""/>
            </a>
            <figcaption>
                <a id="del_product"
                   href="<?php echo _A_::$app->router()->UrlTo('mnf'); ?>/del_produkt?produkt_id=<?php echo $row[0] . $href; ?>" rel="nofollow"
                   data-product_id="<?php echo $row[0]; ?>" data-product_sku="" data-quantity="1"
                   class="button icon-delete add_to_cart_button   product_type_simple"></a>
                <a href="<?php echo _A_::$app->router()->UrlTo('mnf'); ?>/edit?produkt_id=<?php echo $row[0] . $href; ?>"
                   class="button product-button icon-modify"></a>

            </figcaption>
        </figure>
        <a href="<?php echo _A_::$app->router()->UrlTo('mnf'); ?>/edit?produkt_id=<?php echo $row[0] . $href; ?>">
            <span class="product-category"><?php echo $row['pname']; ?></span>

            <h3><?php echo $row[8]; ?></h3>

            <div class="product-price-box clearfix">
                <span class="price">
                    <ins>
                        <span class="amount"><?php echo $format_price; ?></span>
                    </ins>
                </span>
            </div>
        </a>
    </div>
</li>