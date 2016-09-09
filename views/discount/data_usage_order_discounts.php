<tr>
    <td>
        <center><?php echo $i ?></center>
    </td>
    <td>
        <center><?php echo $order_date ?></center>
    </td>
    <td>
        <center><?php echo $u_bill_firstname . ' ' . $u_bill_lastname ?></center>
    </td>
    <td>
        <center><?php echo $u_email ?></center>
    </td>
    <td>
        <center>
            <a href="discount_order?order_id=<?php echo $row[2] ?><?php echo isset($_GET['discounts_id']) ? '&discounts_id=' . $_GET['discounts_id'] : '' ?>"><input
                    type="submit" value="View Order" class="button">
            </a>
        </center>
    </td>
<tr>
