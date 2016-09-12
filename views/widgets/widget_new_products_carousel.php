<li class="<?php echo $first ? 'first' : '';
echo $last ? 'last' : ''; ?> product type-product status-publish has-post-thumbnail product_cat-brooches product_tag-fashion product_tag-jewelry sale featured shipping-taxable purchasable product-type-simple product-cat-brooches product-tag-fashion product-tag-jewelry instock">
    <div class="product-inner">
        <?php if ($bProductDiscount) { ?>
            <span class="extra_discount">Extra Discount!</span>
        <?php } ?>
        <figure class="product-image-box" style="background-image:url(<?php echo $filename; ?>)">

            <figcaption>

            </figcaption>
        </figure>
        <a href="<?php _A_::$app->router()->UrlTo('product',['p_id'=>$row[0]], $row['pname']); ?>">
            <span class="onsale">New!</span>
            <span class="product-category"><?php echo $row['pname']; ?></span>

            <h3 class="descProduct"><?php echo (strlen($row['sdesc']) > 0) ? $row['sdesc'] : $row['ldesc']; ?></h3>

            <div class="product-price-box clearfix">
                <?php if ($sys_hide_price == 0 && $hide_price == 0) { ?>
                    <span class="price">
                        <ins>
                            <span class="amount"><?php echo $format_price; ?></span>
                        </ins>
                    </span>
                <?php } ?>
                <?php if (isset($saleprice) && ($price != $saleprice)) { ?>
                    <span class="price" style="float:right;color: red;">
                        Sale:
                        <ins>
                            <span class="amount_wd"><?php echo $format_sale_price; ?></span>
                        </ins>
                    </span>
                <?php } ?>
            </div>
        </a>

    </div>
</li>
