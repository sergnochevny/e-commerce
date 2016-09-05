<?php
echo "
<script>
    function call$row[0]() {
      var msg   = $('#formx$row[0]').serialize();
        $.ajax({
          type: 'GET',
          url: 'add_cart?p_id=$row[0]',
          data: msg,
          success: function(data) {

             $('#get_prise_in_cart').load('get_prise_in_cart');
             $('#in_product').load('main_produkt_list');
             return false;

          }
        });
 
    }
</script>";
echo '<form method="POST" id="formx" action="javascript:void(null);" onsubmit="call' . $row[0] . '()">';

$str = $_SESSION['rand_session_UserId'];
$substr_count = substr_count($str, $row[0]);
$r = ($substr_count);
if ($r > 0) {
    echo '<a href="cart" class="button" style="color: goldenrod;">Product to basket</a>';
} else {
    echo '<input type="submit" value="add to basket" class="button"/>';
}

echo '</form>';
?>