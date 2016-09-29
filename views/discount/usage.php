<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">
<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">
                <a href="<?= _A_::$app->router()->UrlTo('discount')?>"><input type="submit" value="Back" class="button"></a>

                <h1 class="page-title">DISCOUNTS USAGE</h1>

                <div>
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td>Details</td>
                            <td class="text-center">Enabled</td>
                            <td class="text-center">Multiple</td>
                            <td class="text-center">Coupon</td>
                            <td class="text-center">Start Date</td>
                            <td class="text-center">End Date</td>
                            <td style="width:70px;"></td>
                        </tr>
                        <?= $data_usage_discounts;?>
                    </table>
                </div>
                <hr>
                Discount Usage
                <hr/>
                <div>
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td></td>
                            <td style="width:220px;" class="text-center">Order Date</td>
                            <td class="text-center">Name</td>
                            <td class="text-center">Email</td>
                            <td style="width:190px;" class="text-center">Start Date</td>
                            <td style="width:230px;" class="text-center">End Date</td>
                        </tr>
                        <?= $data_usage_order_discounts;?>
                    </table>
                </div>
                <br/><br/>
            </div>
        </div>