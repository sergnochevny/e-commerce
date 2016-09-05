<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">
<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">


                <?php
                    if(!empty($no_orders)){
                        ?>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <h1 class="text-center"><?= $no_orders; ?></h1>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <?php
                    }else{
                ?>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Transaction id</th>
                            <th>Order date</th>
                            <th>Delivery date</th>
                            <th>Track code</th>
                            <th class="text-center">Status</th>
                            <th>Shipping cost</th>
                            <th class="text-right">Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= isset($customer_orders_list) ? $customer_orders_list : ''; ?>
                    </tbody>
                </table>

            </div>
            <nav role="navigation" class="paging-navigation">
                <h4 class="sr-only">Orders history navigation</h4>
                <ul class='pagination'>
                    <?php echo $orders_paginator; ?>
                </ul>
            </nav>
            <?php } ?>
        </div>
    </div>