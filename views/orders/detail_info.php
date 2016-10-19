<div class="table-list-row-item">
    <div class="col-xs-12 col-sm-4">
        <div class="col-xs-4 visible-xs helper-row">
            <div class="row">Product</div>
        </div>
        <div class="col-xs-8 col-sm-12">
            <div class="row cut-text-in-one-line">
                <?= $is_sample ? 'SAMPLE &mdash; '.$product_name : $product_name; ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-3">
        <div class="col-xs-4 visible-xs helper-row">
            <div class="row"></div>
        </div>
        <div class="col-xs-8 col-sm-12">
            <div class="row cut-text-in-one-line"><?= $sale_price ?></div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-3">
        <div class="col-xs-4 visible-xs helper-row">
            <div class="row">Sale Price</div>
        </div>
        <div class="col-xs-8 col-sm-12">
            <div class="row cut-text-in-one-line"><?= $sale_price ?></div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-2">
        <div class="col-xs-4 visible-xs helper-row">
            <div class="row">Quantity</div>
        </div>
        <div class="col-xs-8 col-sm-12">
            <div class="row cut-text-in-one-line"><?= $quantity ?></div>
        </div>
    </div>
</div>
