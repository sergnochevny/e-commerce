<div class="container">
  <div id="content" class="main-content-inner" role="main">
    <a id="back_url" href="<?= $back_url; ?>" class="button back_button">Back</a>

    <div class="b_orderList_main">
      <div class="b_orderList_date"><b>Order Date: <?php $data['order_date']; ?></b></div>
      <div class="CSSTableGenerator">
        <table>
          <tr>
            <td>Product Number</td>
            <td>Product Name</td>
            <td>Quantity</td>
            <td>Price</td>
          </tr>
          <?= $order_details; ?>
        </table>
      </div>
      <br><br>
      <div class="b_orderList_detal">
        <div class="b_orderList_detal_date_left"><b>Shipping Method:</b></div>
        <div class="b_orderList_detal_date_right">ground ship</div>
        <div class="b_orderList_detal_date_left"><b>Shipping:</b></div>
        <div class="b_orderList_detal_date_right"><?= $data['shipping_cost']; ?></div>
        <div class="b_orderList_detal_date_left"><b>Handling:</b></div>
        <div class="b_orderList_detal_date_right"><?= $data['handling']; ?></div>
        <div class="b_orderList_detal_date_left"><b>Shipping Discount:</b></div>
        <div class="b_orderList_detal_date_right"><?= $data['shipping_discount']; ?></div>
        <div class="b_orderList_detal_date_left"><b>Coupon Discount:</b></div>
        <div class="b_orderList_detal_date_right"><?= $data['coupon_discount']; ?></div>
        <div class="b_orderList_detal_date_left"><b>Total Discount:</b></div>
        <div class="b_orderList_detal_date_right"><?= $data['total_discount']; ?></div>
        <div class="b_orderList_detal_date_left"><b>Taxes:</b></div>
        <div class="b_orderList_detal_date_right"><?= $data['taxes']; ?></div>
        <div class="b_orderList_detal_date_left"><b>Total:</b></div>
        <div class="b_orderList_detal_date_right" style="color: black;"><b><?= $data['total']; ?>$</b></div>
      </div>
    </div>
    <br/>
  </div>
</div>