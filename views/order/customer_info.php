<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">
<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">
                <a href="<?= $back_url ?>">
                    <input type="button" value="Back" class="button">
                </a>
                <br>
                <br>
                <?php if($status > 0){?>
                    <table cellspacing="0" class="shop_table shop_table_responsive proceed">
                        <thead></thead>
                        <tbody>
                        <tr class="subtotal" style="color: #a5b63f">
                            <td class="product-name"><b>Track Code</b></td>
                            <td data-title="Shipping Discount" style="text-align:right;">
                                <span class="track_code">
                                    <?= $track_code ?>
                                </span>
                            </td>
                            <td style="border-left: 1px solid rgba(0,0,0,.1)">
                                Delivery date
                            </td>
                            <td class="text-right">
                                 <span class="ending_date">
                                    <?= $end_date ?>
                                 </span>
                            </td>
                            <td class="product-name" style="border-left: 1px solid rgba(0,0,0,.1)"><b>Order status</b></td>
                            <td data-title="Shipping Discount" style="text-align:right;">
                                <span class="status">
                                    <i class="fa fa-check"></i>
                                </span>
                            </td>
                        </tr>
                        <tr class="subtotal"><td colspan="6"></td></tr>
                        </tbody>
                    </table>
                <?php } else {?>
                    <span style="color: red;">
                        Your order is being processed
                    </span>
                <?php }?>
                <table cellspacing="0" class="shop_table shop_table_responsive proceed">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th></th>
                        <th>Sale Price</th>
                        <th>Quantity</th>
                        <th class="text-right">Total</th>
                    </tr>
                    </thead>
                    <tbody>

                        <?php echo $detail_info_customer; ?>
                        <?php if($is_sample){ ?>
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
                        <?php if(!$shipping_cost == 0.00){ ?>
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
                            <?php if(!empty($handling)){ ?>
                                <tr class="subtotal">
                                    <td class="product-name">Handling</td>
                                    <td data-title="Handling" style="text-align:right;">
                                        <span class="amount">
                                            <?= $handling; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php if(!empty($shipping_discount)){ ?>
                                <tr class="subtotal">
                                    <td class="product-name">Shipping Discount</td>
                                    <td data-title="Shipping Discount" style="text-align:right;">
                                        <span class="amount">
                                            <?= $shipping_discount ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php if(!empty($taxes)){ ?>
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
                            <?php if(!empty($total_discount)){ ?>
                                <tr style="color: red">
                                    <td>You saved</td>
                                    <td class="text-right">
                                        <b><?= $total_discount; ?></b>
                                    </td>
                                </tr>
                            <?php } ?>
                           </tbody>
                        </table>
                        <hr>
                    </div>
                </div>

            </div>
        </div>
    </div>

