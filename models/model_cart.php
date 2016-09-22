<?php

Class Model_Cart extends Model_Model
{
    public static function get_product_params($p_id)
    {

        $res = mysql_query("select * from fabrix_products WHERE pid='$p_id'");
        $row = mysql_fetch_array($res);
        return $row;
    }

    public static function get_price_in_cart()
    {
        $cart = $_SESSION['cart']['items'];
        $total = 0;
        foreach ($cart as $key => $item) {
            $total += ($item['quantity'] * $item['saleprice']);
        }
        if (!empty($total)) {
            setlocale(LC_MONETARY, 'en_US');
            $total = "$" . number_format($total, 2);
        } else {
            $total = "$0.00";
        }
        return array('am_total_cart' => $total);
    }

}