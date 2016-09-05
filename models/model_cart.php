<?php

Class Model_Cart
{

    public function get_product_params($p_id)
    {

        $resulthatistim = mysql_query("select * from fabrix_products WHERE pid='$p_id'");
        $rowsni = mysql_fetch_array($resulthatistim);
        return $rowsni;
    }

    public function register_order($aid, $trid, $shipping_type, $shipping_cost, $on_roll,
                                   $express_samples, $handling, $shipping_discount,
                                   $coupon_discount, $total_discount, $taxes, $total)
    {
        $q = "insert into fabrix_orders (" .
            "aid, trid, shipping_type, shipping_cost, on_roll," .
            " roll_cost, express_samples, on_handling, handling, shipping_discount," .
            " coupon_discount, total_discount, taxes, total, order_date," .
            " samples_express_cost, samples_single_cost, samples_multiple_cost," .
            " samples_additional_cost, samples_products_cost, samples_min_qty," .
            " samples_max_qty)" .
            " values (%u, '%s', %u, %01.2f, %u," .
            " %01.2f, %u, %u, %01.2f, %01.2f," .
            " %01.2f, %01.2f, %01.2f, %01.2f, %u," .
            " %01.2f, %01.2f, %01.2f," .
            " %01.2f, %01.2f, %01.2f," .
            " %01.2f)";

        $sSQL = sprintf($q, $aid, $trid, $shipping_type, str_replace(",", "", $shipping_cost), $on_roll, str_replace(",", "", RATE_ROLL),
            str_replace(",", "", $express_samples), $handling, str_replace(",", "", RATE_HANDLING), str_replace(",", "", $shipping_discount),
            str_replace(",", "", $coupon_discount), str_replace(",", "", $total_discount), str_replace(",", "", $taxes),
            str_replace(",", "", $total), time(), SAMPLES_PRICE_EXPRESS_SHIPPING, SAMPLES_PRICE_SINGLE,
            SAMPLES_PRICE_MULTIPLE, SAMPLES_PRICE_ADDITIONAL, SAMPLES_PRICE_WITH_PRODUCTS, SAMPLES_QTY_MULTIPLE_MIN,
            SAMPLES_QTY_MULTIPLE_MAX);

        $res = mysql_query($sSQL);
        if ($res) return mysql_insert_id();
        return null;
    }

    public function insert_order_detail($order_id, $product_id, $product_number, $product_name,
                                        $quantity, $price, $discount, $sale_price, $is_sample = 0)
    {
        $q = "insert into  fabrix_order_details " .
            "(order_id, product_id, product_number, product_name, quantity, price, discount, sale_price, is_sample)" .
            " VALUES (%u, %u,'%s', '%s', '%s','%s', '%s', '%s', %u);";
        $sql = sprintf($q, $order_id, $product_id, $product_number, $product_name,
            $quantity, $price, $discount, $sale_price, $is_sample);
        $res = mysql_query($sql);
        return $res;
    }

    function save_discount_usage($discountIds, $oid) {
        if(isset($discountIds) && is_array($discountIds) && (count($discountIds)>0)){
            $discounts = array_unique($discountIds, SORT_NUMERIC);
            $delete = sprintf("DELETE from fabrix_specials_usage WHERE orderId = %u", $oid);
            $res = mysql_query($delete);
            foreach($discounts as $discount) {
                $sSQL = sprintf("INSERT INTO fabrix_specials_usage (specialId, orderId) values (%u, %u)", $discount, $oid);
                mysql_query($sSQL);
            }
        }
    }

}