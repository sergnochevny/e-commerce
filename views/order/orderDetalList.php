<body class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">
<div class="site-container">
<?php include "views/header.php"; ?>
<div class="main-content main-content-shop">
		<div class="container">
			<div id="content" class="main-content-inner" role="main">
<input type="submit" value="Back" onclick="window.history.back();" class="button">
<div class="b_orderList_main">
<div class="b_orderList_date"><b>Order Date:  <?=$userInfo['order_date'];?></b></div>
<div class="CSSTableGenerator" >
    <table >
        <tr>
            <td>
            Product Number 	
            </td>
            <td >
            Product Name
            </td>
            <td>
            Quantity	
            </td>
            <td>
            Price
            </td>
        </tr>
        <?=$object->getOrderDetalList();?>
    </table>
</div>
        <div class="b_orderList_detal">
            <div class="b_orderList_detal_date_left"><b>Shipping Method:</b></div>
            <div class="b_orderList_detal_date_right">ground ship</div>
            <div class="b_orderList_detal_date_left"><b>Shipping:</b></div>
            <div class="b_orderList_detal_date_right"><?=$userInfo['shipping_cost'];?></div>
            <div class="b_orderList_detal_date_left"><b>Handling:</b></div>
            <div class="b_orderList_detal_date_right"><?=$userInfo['handling'];?></div>
            <div class="b_orderList_detal_date_left"><b>Shipping Discount:</b></div>
            <div class="b_orderList_detal_date_right"><?=$userInfo['shipping_discount'];?></div>
            <div class="b_orderList_detal_date_left"><b>Coupon Discount:</b></div>
            <div class="b_orderList_detal_date_right"><?=$userInfo['coupon_discount'];?></div>
            <div class="b_orderList_detal_date_left"><b>Total Discount:</b></div>
            <div class="b_orderList_detal_date_right"><?=$userInfo['total_discount'];?></div>
            <div class="b_orderList_detal_date_left"><b>Taxes:</b></div>
            <div class="b_orderList_detal_date_right"><?=$userInfo['taxes'];?></div>
                <div class="b_orderList_detal_date_left"><b>Total:</b></div>
            <div class="b_orderList_detal_date_right" style="color: black;"><b><?=$userInfo['total'];?>$</b></div>
        </div>
        </div>
        <br />
	</div>
</div>
<br /><br /><br />