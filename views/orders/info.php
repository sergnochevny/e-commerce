<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">
<link rel="stylesheet" href="<?= _A_::$app->router()->UrlTo('views/css/jquery-ui.css'); ?>">
<script src="<?= _A_::$app->router()->UrlTo('views/js/jquery-ui.js'); ?>"></script>
<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">
                <a href="<?= $back_url ?>">
                    <input type="button" value="Back" class="button">
                </a>
                <div class="col-lg-12" style="width: 100%; float:left;">
                    <div class="row">
                        <div class="col-xs-12 alert-success success" style="display: none; margin-bottom:0;"></div>
                        <div class="col-xs-12 alert-danger danger" style="display: none; margin-bottom:0;"></div>
                    </div>
                    <br>
                    <div class="row">
                        <form action="<?= _A_::$app->router()->UrlTo('orders/edit'); ?>" id="edit_orders_info"
                              method="post">
                            <div class="col-xs-4">
                                <div class="row">
                                    <input type="text" id="track_code" style="width: 100%"
                                           value="<?= ($track_code ? $track_code : null) ?>" name="track_code"
                                           class="col-lg-12" placeholder="Add track code">
                                </div>
                            </div>
                            <div class="col-xs-4">

                                <select id="status_select" style="width: 100%; margin: 0; padding: 6px 10px" size="1"
                                        name="status">
                                    <option value="0">In process</option>
                                    <option value="1">Completed</option>
                                </select>

                            </div>
                            <div class="col-xs-3" style="padding-left: 0">

                                <input type="text" style="width: 100%; padding-left: 15px; padding-right: 15px"
                                       name="end_date" id="dateFrom"
                                       value="<?= $end_date ?>" placeholder="Chose end date"
                                       class="input-text ">

                            </div>
                            <div class="col-xs-1 text-right" style="padding: 0 !important;">
                                <input type="hidden" name="order_id" value="<?= $order_id; ?>">
                                <button title="Search" style="height: 34px;" class="btn small" type="submit"
                                        id="edit_order_info" name="edit_order_info">
                                    <b>Save</b>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
                <table cellspacing="0" class="shop_table shop_table_responsive proceed">
                    <thead></thead>
                    <tbody>
                    <tr class="subtotal">
                        <td class="product-name"><b>Track Code</b></td>
                        <td data-title="Shipping Discount" style="text-align:right;">
                            <span class="track_code">
                                <?= ($track_code == 0) ? 'Missing' : $track_code?>
                            </span>
                        </td>
                        <td style="border-left: 1px solid rgba(0,0,0,.1)">
                            Delivery date
                        </td>
                        <td class="text-right">
                             <span class="end_date">
                                <?= ($end_date == 0) ? 'Not specified' : $end_date ?>
                             </span>
                        </td>
                        <td class="product-name" style="border-left: 1px solid rgba(0,0,0,.1)"><b>Order status</b></td>
                        <td data-title="Shipping Discount" style="text-align:right;">
                            <span class="status">
                                <?= $status ?>
                            </span>
                        </td>
                    </tr>
                    <tr class="subtotal">
                        <td colspan="6"></td>
                    </tr>
                    </tbody>
                </table>

                <table cellspacing="0"  class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th width="600">Product</th>
                        <th></th>
                        <th>Sale Price</th>
                        <th>Quantity</th>
                        <th class="text-right">Total</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?= $detail_info; ?>

                    <?php if ($is_sample) { ?>
                        <tr>
                            <td></td>
                            <td>Samples cost</td>
                            <td>
                                <?= $sample_cost ?>
                            </td>
                            <td></td>
                            <td class="text-right">
                                <?= $sample_cost ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if (!empty($shipping_cost)) { ?>
                        <tr>
                            <td></td>
                            <td><?= ($shipping_type == 3 ? 'Ground ship' : 'Express post') ?></td>
                            <td>
                                <?= $shipping_cost; ?>
                            </td>
                            <td>N/A</td>
                            <td class="text-right">
                                <?= $shipping_cost ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>Sub Total:</b></td>
                        <td class="text-right">
                            <b><?= $sub_price; ?></b>
                        </td>
                    </tr>

                    </tbody>
                </table>
                <div class="proceed_totals">
                    <div id="div_subtotal_table">
                        <table id="subtotal_table" cellspacing="0" class="shop_table shop_table_responsive cart">
                            <tbody>
                            <?php if (!empty($handling)) { ?>
                                <tr class="subtotal">
                                    <td class="product-name">Handling</td>
                                    <td data-title="Handling" style="text-align:right;">
                                            <span class="amount">
                                                <?= $handling; ?>
                                            </span>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php if (!empty($shipping_discount)) { ?>
                                <tr class="subtotal">
                                    <td class="product-name">Shipping Discount</td>
                                    <td data-title="Shipping Discount" style="text-align:right;">
                                            <span class="amount">
                                                <?= $shipping_discount ?>
                                            </span>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php if (!empty($taxes)) { ?>
                                <tr class="subtotal">
                                    <td class="product-name">Taxes</td>
                                    <td data-title="Shipping Discount" style="text-align:right;">
                                            <span class="amount">
                                                <?= $taxes ?>
                                            </span>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr class="subtotal">
                                <td class="product-name"><b>TOTAL</b></td>
                                <td data-title="Total" style="text-align:right;">
                                        <span class="amount">
                                            <b><?= $total ?></b>
                                        </span>
                                </td>
                            </tr>
                            <?php if (!empty($total_discount)) { ?>
                                <tr style="color: red">
                                    <td>Total discount</td>
                                    <td class="text-right">
                                        <b><?= $total_discount; ?></b>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src='<?= _A_::$app->router()->UrlTo('views/js/orders/info.js'); ?>' type="text/javascript"></script>