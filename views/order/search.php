<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">
<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Transaction id</th>
                            <th>User</th>
                            <th>Order date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th></th>

                        </tr>
                    </thead>

                    <tbody>
                        <?php

                            if(!empty($orders)){
                                $length = (integer) count($orders);
                                $result = (string) '';
                                for($i=0; $i < $length; $i++){
                                    $result .= '<tr>';

                                        $result .= '<td>';
                                            $result .= $orders[$i][2];
                                        $result .= '</td>';

                                        $result .= '<td>';
                                            $result .= $orders[$i][7];
                                        $result .= '</td>';
    
                                        $result .= '<td>';
                                            $result .= date('Y.m.d \a\t H:i', $orders[$i][3]);
                                        $result .= '</td>';

                                        $result .= '<td>';
                                            $result .= $orders[$i][4];
                                        $result .= '</td>';

                                        $result .= '<td>';
                                            $result .=  money_format('%.2n',$orders[$i][5]);
                                        $result .= '</td>';

                                        $result .= '<td>';
                                            $result .= '<a href="'._A_::$app->router()->UrlTo('order/customer_info',['oid'=>urlencode(base64_encode($orders[$i][0])),'page'=>$page,'orders_search_query'=>_A_::$app->get('orders_search_query')]).'" title="View more information" class="fa fa-eye"></a>';
                                        $result .= '</td>';

                                    $result .= '</tr>';
                                }
                                echo $result;
                            }
                        ?>

                    </tbody>
                </table>
            </div>
            <nav role="navigation" class="paging-navigation">
                <h4 class="sr-only">Orders navigation</h4>
                <ul class='pagination'>
                    <?= isset($paginator) ? $paginator : ''; ?>
                </ul>
            </nav>
        </div>
    </div>