<div class="just-post col-xs-12 col-sm-6 col-md-4">
    <div class="just-post-image just-post-image-admin">
        <figure>
            <img src="<?= $post_img; ?>" alt="">
            <figcaption>
                <a id="del_post"
                   href="<?= $post_del_href; ?>" rel="nofollow"
                   data-post_id="<?= $post_id ; ?>" data-product_sku="" data-quantity="1"
                   class="admin-button button icon-delete add_to_cart_button post_type_simple"></a>
                <a id="edit_post" href="<?= $post_edit_href; ?>"
                   class="admin-button button product-button icon-modify"></a>
            </figcaption>
        </figure>
    </div>
    <div class="just-post-detail">
        <h3 class="post-title"><a href="<?= $post_edit_href; ?>"><?= isset($post_title) ? $post_title : ''; ?></a></h3>

        <div class="just-divider text-center line-yes icon-hide">
            <div style="background-color: #fff" class="divider-inner">
                <span class="post-date"><?= $post_date; ?></span>
            </div>
        </div>
        <p class="text-justify"><span class="opa"></span><?= $post_content; ?></p>
    </div>
</div>
