<?php $href = _A_::$app->router()->UrlTo('shop/product', ['pid' => $pid, 'back' => 'cart'], $item['Product_name']);?>
<div class="col-xs-12 table-list-row" data-block="sample_item" data-pid="<?= $pid; ?>" data-row="samples">
    <div class="row">
        <div class="col-xs-12 col-sm-10 table-list-row-item">
            <div class="row">
                <div class="col-sm-2">
                    <img alt="" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image"
                         src="<?= $img_url; ?>">
                </div>
                <div class="col-sm-10">
                    <a href="<?= $href; ?>"><?= $item['Product_name']; ?></a>
                </div>
            </div>

        </div>
        <div class="col-xs-12 col-sm-1 table-list-row-item">
            <span class="quantity"><?= $item['quantity']; ?></span>
        </div>
        <div class="col-xs-12 col-sm-1 table-list-row-item">
            <a data-block="del_sample_cart" href="<?= _A_::$app->router()->UrlTo('cart/del_sample');?>"><i class=" fa fa-trash-o"></i></a>
        </div>
    </div>
</div>