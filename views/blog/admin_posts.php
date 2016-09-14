<div class="toko-post col-xs-12 col-sm-6 col-md-4">
    <div style="background-image: url('<?php echo $post_img; ?>');" class="toko-post-image toko-post-image-admin">
				<a id="del_post"
                   href="<?php echo $post_del_href; ?>" rel="nofollow"
                   data-post_id="<?php echo $row['ID']; ?>" data-product_sku="" data-quantity="1"
                   class="button icon-delete add_to_cart_button   post_type_simple"></a>
                <a id="edit_post" href="<?php echo $post_edit_href;?>"
                   class="button product-button icon-modify"></a>
    </div>
    <div class="toko-post-detail">
        <h3 class="post-title"><a href="<?php echo $post_edit_href;?>"><?php echo isset($post_title)?$post_title:'';?></a></h3>

        <div class="toko-divider text-center line-yes icon-hide">
            <div style="background-color: #fff" class="divider-inner">
                <span class="post-date"><?php echo $post_date;?></span>
            </div>
        </div>
        <p><span class="opa"></span><?php echo $post_content;?></p>
    </div>
</div>

<!--<li class="last product type-product status-publish has-post-thumbnail product_cat-brooches product_tag-fashion product_tag-jewelry sale featured shipping-taxable purchasable product-type-simple product-cat-brooches product-tag-fashion product-tag-jewelry instock">
    <div class="post-inner">
        <figure class="post-image-box">
            <img width="#" height="266" src="<?php echo $post_img; ?>"
                 class="attachment-shop_catalog size-shop_catalog wp-post-image" alt=""/>
            <figcaption>
                <a id="del_post"
                   href="<?php echo $post_del_href; ?>" rel="nofollow"
                   data-post_id="<?php echo $row['ID']; ?>" data-product_sku="" data-quantity="1"
                   class="button icon-delete add_to_cart_button   post_type_simple"></a>
                <a id="edit_post" href="<?php echo $post_edit_href;?>"
                   class="button product-button icon-modify"></a>

            </figcaption>
        </figure>
        <a href="<?php echo $post_edit_href;?>">

            <h3 class="post-title"><?php echo isset($post_title)?$post_title:'';?></h3>

            <div
                class="toko-divider text-center line-yes icon-hide">
                <div class="divider-inner"
                     style="background-color: #fff">
                    <span class="post-date"><?php echo $post_date;?></span>
                </div>
            </div>
            <p><span class="opa"></span><?php echo $post_content;?></p>
        </a>
    </div>
</li>-->