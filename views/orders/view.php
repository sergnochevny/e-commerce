<div class="container">
    <div class="col-md-12">

        <div class="row">
            <div class="col-xs-12">
                <div class="row afterhead-row">

                    <div class="col-xs-12 back_button_container">
                        <div class="row">
                            <a href="<?= $back_url; ?>" class="button back_button">Back</a>
                        </div>
                    </div>
                    <div class="col-xs-12 text-center">
                        <div class="row">
                            <h3 class="page-title"><?= isset($user_id) && !$is_admin ? $rows[0]['username'] : '' ?>
                                Order details</h3>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="row order-details">
            <div class="panel panel-default ">
                <div class="row">

                    <div class="col-xs-12 col-sm-4">
                        <div class="text-center">
                            <div class="col-xs-6 col-md-6 order-detail-item">
                                <b>Track Code:</b>
                            </div>
                            <div class="col-xs-6 col-md-6 order-detail-item">
                                <?= ($track_code == 0) ? 'Not specified yet' : $track_code ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4">
                        <div class="text-center">
                            <div class="col-xs-6 col-md-6 order-detail-item">
                                <b>Delivery date:</b>
                            </div>
                            <div class="col-xs-6 col-md-6 order-detail-item">
                                <?= ($end_date == 0) ? 'Not specified yet' : $end_date ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4">
                        <div class="text-center">
                            <div class="col-xs-6 col-md-6 order-detail-item">
                                <b>Order status:</b>
                            </div>
                            <div class="col-xs-6 col-md-6 order-detail-item">
                                <?= $status ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="col-xs-12 table-list-header hidden-xs">
        <div class="row">
            <div class="col-sm-4 col">
                Product <a href="#">
                    <small><i class="fa fa-chevron-down"></i></small>
                </a>
            </div>
            <div class="col-sm-2 col">
                Item Price <a href="#">
                    <small><i class="fa fa-chevron-down"></i></small>
                </a>
            </div>
            <div class="col-sm-3 col">
                Sale Price <a href="#">
                    <small><i class="fa fa-chevron-down"></i></small>
                </a>
            </div>
            <div class="col-sm-2 col">
                Quantity <a href="#">
                    <small><i class="fa fa-chevron-down"></i></small>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xs-12 table-list-row orders-details" style="border-radius: 0 0 0 4px">
        <div class="row">

            <?= $detail_info; ?>
            <div class="col-xs-12 table-list-row-item">
                <div class="row">
                    <hr style="border-color: #D0D0D0; margin: 1px 0">
                </div>
            </div>
            <?php if ($is_sample) { ?>
                <div class="col-xs-12 table-list-row-item">
                    <div class="row">
                        <div class="col-xs-6 col-sm-4 helper-row text-left">
                            Samples cost
                        </div>
                        <div class="col-xs-6 col-sm-8 text-left">
                            <?= $sample_cost ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if (!empty($shipping_cost)) { ?>
                <div class="col-xs-12 table-list-row-item">
                    <div class="row">
                        <div class="col-xs-6 col-sm-4 helper-row text-left">
                            <?= ($shipping_type == 3 ? 'Ground ship' : 'Express post') ?>
                        </div>
                        <div class="col-xs-6 col-sm-8 text-left">
                            <?= $shipping_cost ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-sm-offset-8 table-total" style="border-radius: 0 0 4px 4px">
        <div class="table-list-row-item">
            <div class="col-xs-12 col-sm-12">
                <div class="row text-right">
                    <b>Sub Total:</b>
                    <?= $sub_price; ?>
                </div>
            </div>
        </div>
        <?php if (!empty($handling)) { ?>
            <div class="table-list-row-item">
                <div class="col-xs-12 col-sm-12">
                    <div class="row text-right">
                        <b>Handling:</b>
                        <?= $handling; ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if (!empty($shipping_discount)) { ?>
            <div class="table-list-row-item">
                <div class="col-xs-12 col-sm-12">
                    <div class="row text-right">
                        <b>Shipping Discount:</b>
                        <?= $shipping_discount; ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if (!empty($taxes)) { ?>
            <div class="table-list-row-item">
                <div class="col-xs-12 col-sm-12">
                    <div class="row text-right">
                        <b>Taxes:</b>
                        <?= $taxes; ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="table-list-row-item">
            <div class="col-xs-12 col-sm-12">
                <div class="row text-right">
                    <h5 class="text-danger">
                        Total:
                        <?= $total; ?>
                    </h5>
                </div>
            </div>
        </div>
        <div class="table-list-row-item">
            <div class="col-xs-12 col-sm-12">
                <div class="row text-right">
                    <b>Total discount:</b>
                    <?= $total_discount; ?>
                </div>
            </div>
        </div>
    </div>
</div>
