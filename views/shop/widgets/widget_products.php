<li>
    <div style="position: relative;">
        <?php if ($bProductDiscount) { ?>
            <span class="extra_discount_small">Extra Discount!</span>
        <?php } ?>
        <a href="<?= _A_::$app->router()->UrlTo('product',['p_id'=>$row[0]], $row['pname']); ?>"
           title="<?= $row['pname']; ?>">
            <div class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image coverDiv" style=
            "background-image:url(= $filename; ?>)"></div>
            <span class="product-title indexProductTitle">= $row['pname']; ?></span>
        </a>
        <?php if ($sys_hide_price == 0 && $hide_price == 0) { ?>
            <ins><span class="amount">= $format_price; ?></span></ins>
        <?php } ?>
        <?php if (isset($saleprice) && ($price != $saleprice)) { ?>
            <span class="price" style="float:right;color: red;font-size: 11px;">
            Sale:
            <ins>
                <span class="amount_wd">= $format_sale_price; ?></span>
            </ins>
        </span>
        <?php } ?>
    </div>
</li>
