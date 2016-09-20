<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">
<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">
                <a href="discounts"><input type="submit" value="Back" class="button"></a>

                <h1 class="page-title">DISCOUNTS USAGE</h1>

                <div class="CSSTableGenerator">
                    <table>
                        <tr>
                            <td>Details</td>
                            <td>Enabled</td>
                            <td>Multiple</td>
                            <td>Coupon Code</td>
                            <td>Start Date</td>
                            <td>End Date</td>
                        </tr>
                        <?= $data_usage_discounts;?>
                    </table>
                </div>
                <hr>
                Discount Usage
                <hr/>
                <div class="CSSTableGenerator">
                    <table>
                        <tr>
                            <td></td>
                            <td>Order Date</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td style="width:200px;"></td>
                        </tr>
                        <?= $data_usage_order_discounts;?>
                    </table>
                </div>
                <br/><br/>
            </div>
        </div>