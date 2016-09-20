<li class="last product type-product status-publish has-post-thumbnail product_cat-brooches product_tag-fashion product_tag-jewelry sale featured shipping-taxable purchasable product-type-simple product-cat-brooches product-tag-fashion product-tag-jewelry instock">
    <div class="product-inner">
        <?php if ($bProductDiscount) { ?>
            <span class="extra_discount">Extra Discount!</span>
        <?php }
            $opt['p_id'] = $row[0];
        ?>
        <figure class="product-image-box" style="background-image:url(<?= $filename; ?>)">
            <a <?= isset($search)?'class="a_search"':''?> href="<?= _A_::$app->router()->UrlTo('product', $opt, $row['pname']); ?>">
            </a>
            <figcaption>
                <?php
                    if ($in_cart) {
                        include('views/cart/basket.php');
                    } else {
//                        include('views/basket/main_product_addtobasket.php');
                        ?>
                        <a class="button productsAddBasket <?= isset($search)?'a_search':''?>" href="<?= _A_::$app->router()->UrlTo('product', $opt, $row['pname']); ?>">
                            View Details
                        </a>                
                        <?php
                    }
                ?>
            </figcaption>
        </figure>
        <a <?= isset($search)?'class="a_search"':''?> href="<?= _A_::$app->router()->UrlTo('product', $opt, $row['pname']); ?>">
            <span class="product-category"><?= $row['pname']; ?></span>

            <h3 class="descProduct"><?= (strlen($row['sdesc']) > 0) ? $row['sdesc'] : $row['ldesc']; ?></h3>

            <div class="product-price-box clearfix">
                <?php if ($sys_hide_price == 0 && $hide_price == 0) { ?>
                    <span class="price">
                        <ins>
                            <span class="amount"><?= $format_price; ?></span>
                        </ins>
                    </span>
                <?php } ?>
                <?php if (isset($saleprice) && ($price != $saleprice)) { ?>
                    <span class="price salePrice" style="float:right;color: red;">
                    Sale:
                    <ins>
                        <span class="amount_wd"><?= $format_sale_price; ?></span>
                    </ins>
                </span>
                <?php } ?>
            </div>
        </a>
    </div>
</li>
