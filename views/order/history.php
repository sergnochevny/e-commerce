<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">
<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">

                <div class="col-lg-12">
                    <div class="row">
                        <form action="orders_history" method="get">

                            <div class="col-xs-11" style="padding-right: 0;">
                                <div class="row">
                                    <input type="text" style="width: 100%" value="<?= (!is_null(_A_::$app->get('orders_search_query')) ? _A_::$app->get('orders_search_query') : null) ?>" name="orders_search_query" class="col-lg-12" placeholder="Search...">
                                </div>
                            </div>
                            <div class="col-xs-1 text-right" style="padding-right: 0 !important;">
                                <button title="Search" style="height: 34px" class="btn small" type="submit" name="find"><i class="fa fa-search"></i></button>
                            </div>

                        </form>
                        <br>
                    </div>
                </div>

                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Transaction id</th>
                        <th>User</th>
                        <th>Order date</th>
                        <th>Delivery date</th>
                        <th>Track code</th>
                        <th class="text-center">Status</th>
                        <th class="text-right">Total</th>
                        <th></th>

                    </tr>
                    </thead>
                    <tbody>
                        <?= isset($admin_orders_list) ? $admin_orders_list : ''; ?>
                    </tbody>
                </table>
            </div>
            
            <nav role="navigation" class="paging-navigation">
                <h4 class="sr-only">Orders history navigation</h4>
                <ul class='pagination'>
                    <?= isset($paginator) ? $paginator : ''; ?>
                </ul>
            </nav>

        </div>
    </div>