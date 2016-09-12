<?php

class Controller_Cart extends Controller_Base
{

    private function cart_prepare()
    {
        ob_start();
        $cart = _A_::$app->session('cart');
        unset($cart['discountIds']);
        _A_::$app->session('cart', $cart);
        $this->products_in_cart();
        $cart_items = ob_get_contents();
        ob_end_clean();
        $this->template->vars('cart_items', $cart_items);
        ob_start();
        $this->cart_items_amount();
        $sum_items = ob_get_contents();
        ob_end_clean();
        $this->template->vars('sum_items', $sum_items);
        ob_start();
        $this->cart_samples_amount();
        $sum_samples = ob_get_contents();
        ob_end_clean();
        $this->template->vars('sum_samples', $sum_samples);
        ob_start();
        $this->cart_samples_legend();
        $cart_samples_legend = ob_get_contents();
        ob_end_clean();
        $this->template->vars('cart_samples_legend', $cart_samples_legend);
        ob_start();
        $this->samples_in_cart();
        $cart_samples_items = ob_get_contents();
        ob_end_clean();
        $this->template->vars('cart_samples_items', $cart_samples_items);
        ob_start();
        $this->shipping_calc();
        $shipping = ob_get_contents();
        ob_end_clean();
        $this->template->vars('shipping', $shipping);
        ob_start();
        $this->coupon_total_calc();
        $coupon_total = ob_get_contents();
        ob_end_clean();
        $this->template->vars('coupon_total', $coupon_total);

    }

    function cart()
    {
        if (!is_null(_A_::$app->get('proceed'))) {
            $this->proceed_checkout_prepare();
            ob_start();
            $this->main->view_layout('basket/proceed_checkout');
            $cart_content = ob_get_contents();
            ob_end_clean();
            $this->template->vars('cart_content', $cart_content);

        } elseif (!is_null(_A_::$app->get('pay_ok'))) {
            $this->pay_ok();
            ob_start();
            $this->main->view_layout('basket/pay_ok');
            $cart_content = ob_get_contents();
            ob_end_clean();
            $this->template->vars('cart_content', $cart_content);

        } elseif (!is_null(_A_::$app->get('pay_error'))) {

            ob_start();
            $this->main->view_layout('basket/pay_error');
            $cart_content = ob_get_contents();
            ob_end_clean();
            $this->template->vars('cart_content', $cart_content);

        } else {
            $this->cart_prepare();
            ob_start();
            $this->main->view_layout('basket/cart');
            $cart_content = ob_get_contents();
            ob_end_clean();
            $this->template->vars('cart_content', $cart_content);

        }

        $this->main->view('basket/cart_container');
    }

    function get_shipping_name($type)
    {
        $ret = 'Shipping Type Not Found';
        switch ($type) {
            case 1:
                $ret = 'Express Post';
                break;
            case 3:
                $ret = 'Ground Ship';
                break;
        }
        return $ret;
    }

    private function prepare_before_pay_mail($mail = null)
    {
        $shipcost = 0;
        $rollcost = 0;
        $express_samples_cost = 0;
        $total = 0;
        $t = new Model_Shipping();
        $headers = $mail['headers'];
        $subject = $mail['subject'];
        $body = $mail['body'];
        if (!is_null(_A_::$app->session('cart')) && !is_null(_A_::$app->session('user'))) {

            $user = _A_::$app->session('user');
            $ship_firstname = $user['ship_firstname'];
            $ship_lastname = $user['ship_lastname'];
            $email = $user['email'];

            if (!is_null(_A_::$app->session('cart')['items'])) {
                $cart_items = _A_::$app->session('cart')['items'];
            } else {
                $cart_items = [];
            }

            if (!is_null(_A_::$app->session('cart')['samples_items'])) {
                $cart_samples_items = _A_::$app->session('cart')['samples_items'];
            } else {
                $cart_samples_items = [];
            }

            $ms = new Model_Samples();
            $systemAllowExpressSamples = $ms->systemAllowSamplesExpressShipping();
            $bExpressSamples = !is_null(_A_::$app->session('cart')['express_samples']) ? _A_::$app->session('cart')['express_samples'] : false;
            if (!$systemAllowExpressSamples) {
                $bExpressSamples = false;
            }
            if (count($cart_samples_items) == 0) $bExpressSamples = false;

            $bAcceptExpress = !is_null(_A_::$app->session('cart')['accept_express']) ? _A_::$app->session('cart')['accept_express'] : false;
            if (!$systemAllowExpressSamples) {
                $bAcceptExpress = false;
            }

            if (!is_null(_A_::$app->session('cart')['items'])) {
                $cart_items = _A_::$app->session('cart')['items'];
            } else {
                $cart_items = [];
            }

            #grab the user id
            if (!is_null(_A_::$app->session('user'))) {
                $uid = (int)_A_::$app->session('user')['aid'];
            } else {
                $uid = 0;
            }

            #get the shipping
            if (!is_null(_A_::$app->session('cart')['ship']) && _A_::$app->session('cart')['ship'] > 0) {
                $shipping = (int)_A_::$app->session('cart')['ship'];
            } else {
                $shipping = DEFAULT_SHIPPING;
            }

            if (!is_null(_A_::$app->session('cart')['ship_roll'])) {
                $bShipRoll = (boolean)_A_::$app->session('cart')['ship_roll'];
            } else {
                $bShipRoll = false;
            }
            $coupon_code = !is_null(_A_::$app->session('cart')['coupon']) ? _A_::$app->session('cart')['coupon'] : '';

            $discount = 0;
            $model = new Model_Cart();
            if (count($cart_items) > 0) {
                foreach ($cart_items as $key => $item) {
                    $product = $model->get_product_params($key);
                    $pname = $product['Product_name'];
                    $pnumber = $product['Product_number'];
                    $formatprice = $item['format_sale_price'];
                    $qty = $item['quantity'];
                    $subtotal = $item['format_subtotal'];
                    $body .= "\nName: $pname $pnumber \nPrice: $formatprice  \nQuantity: $qty \nSUB Total: $subtotal\n";
                    $discount += $item['discount'];
                    $total += $item['subtotal'];
                }
            }

            if (count($cart_samples_items) > 0) {
                foreach ($cart_samples_items as $key => $item) {
                    $product = $model->get_product_params($key);
                    $pname = $product['Product_name'];
                    $pnumber = $product['Product_number'];

                    $body .= "\nName: SAMPLE - $pname $pnumber\n";
                }
                $samples_sum = _A_::$app->session('cart')['samples_sum'];
                $total += $samples_sum;
                $format_samples_sum = _A_::$app->session('cart')['format_samples_sum'];
                $body .= "SUB Total for samples: $format_samples_sum\n";
            }

            $shipcost = _A_::$app->session('cart')['shipcost'];
            $shipDiscount = _A_::$app->session('cart')['ship_discount'];
            $couponDiscount = _A_::$app->session('cart')['coupon_discount'];

            $body .= sprintf("\nShipping Method: %s\n", $this->get_shipping_name($shipping));
            $body .= "\nShipping:$" . number_format($shipcost, 2) . "\n";

            if ((count($cart_items) > 0) && ($bShipRoll)) {
                $rollcost += RATE_ROLL;
                $body .= "Ship my fabric on a roll: $" . number_format($rollcost, 2) . "\n";
            }

            if ((count($cart_samples_items) > 0) && ($bExpressSamples) && !(count($cart_items) > 0)) {
                $express_samples_cost += SAMPLES_PRICE_EXPRESS_SHIPPING;
                $body .= "Deliver my samples by Overnight Courier: $" . number_format($express_samples_cost, 2) . "\n";
            }
            $total = $total + $shipcost + (isset($rollcost) ? $rollcost : 0) + (isset($express_samples_cost) ? $express_samples_cost : 0);
            $body .= "\nSUB TOTAL with shipping:$" . number_format($total, 2) . "\n";

            $handlingcost = RATE_HANDLING;
            if (count($cart_items) > 0) {
                $body .= "Handling:$" . number_format($handlingcost, 2) . " \n";
            }

            if ($shipDiscount > 0) {
                $body .= sprintf("\nShipping Discount:$%s \n", number_format($shipDiscount, 2));
            }

            if ($couponDiscount > 0) {
                $body .= sprintf("\nCoupon Redemption: $%01.2f \n", $couponDiscount);
            }

            $discount = $discount + $couponDiscount + $shipDiscount;

            $taxes = _A_::$app->session('cart')['taxes'];
            if ($taxes > 0) {
                $body .= sprintf("\nTaxes: $%01.2f \n", $taxes);
            }

            $total = _A_::$app->session('cart')['total'];
            $body .= sprintf("\nTotal: $%01.2f \n", $total);

            if ($discount > 0) {
                $body .= sprintf("You saved: $%01.2f\n", $discount);
            }

            $bill_firstname = trim($user['bill_firstname']);
            $bill_lastname = trim($user['bill_lastname']);
            $bill_organization = trim($user['bill_organization']);
            $bill_address1 = trim($user['bill_address1']);
            $bill_address2 = trim($user['bill_address2']);
            $bill_province = trim($user['bill_province']);
            $bill_city = trim($user['bill_city']);
            $bill_country = trim($user['bill_country']);
            $bill_postal = trim($user['bill_postal']);
            $bill_phone = trim($user['bill_phone']);
            $bill_fax = trim($user['bill_fax']);
            $ship_firstname = trim($user['ship_firstname']);
            $ship_lastname = trim($user['ship_lastname']);
            $ship_organization = trim($user['ship_organization']);
            $ship_address1 = trim($user['ship_address1']);
            $ship_address2 = trim($user['ship_address2']);
            $ship_city = trim($user['ship_city']);
            $ship_province = trim($user['ship_province']);
            $ship_country = trim($user['ship_country']);
            $ship_postal = trim($user['ship_postal']);
            $ship_phone = trim($user['ship_phone']);
            $ship_fax = trim($user['ship_fax']);

            $ma = new Model_Address();
            $bill_country = trim($ma->get_country_by_id($bill_country));
            $bill_province = trim($ma->get_province_by_id($bill_province));
            $ship_country = trim($ma->get_country_by_id($ship_country));
            $ship_province = trim($ma->get_province_by_id($ship_province));

            $trid = _A_::$app->session('cart')['trid'];
            $trdate = _A_::$app->session('cart')['trdate'];

            $body = $body . "\n\nOrder Details:\n";
            $body = $body . "Transaction: $trid\n Transaction Date: $trdate \n";
            $body = $body . "\n\nBill To:\n";
            $body = $body . "$bill_firstname $bill_lastname\n";
            $body = $body . "$bill_organization\n";
            $body = $body . "$bill_address1 $bill_address2\n";
            $body = $body . "$bill_city\n";
            $body = $body . "$bill_province\n";
            $body = $body . "$bill_postal\n";
            $body = $body . "$bill_country\n";
            $body = $body . "$bill_phone\n";
            $body = $body . "$bill_fax\n\n";
            $body = $body . "Ship To:\n";
            $body = $body . "$ship_firstname $ship_lastname\n";
            $body = $body . "$ship_organization\n";
            $body = $body . "$ship_address1 $ship_address2\n";
            $body = $body . "$ship_city\n";
            $body = $body . "$ship_province\n";
            $body = $body . "$ship_postal\n";
            $body = $body . "$ship_country\n";
            $body = $body . "$ship_phone\n";
            $body = $body . "$ship_fax\n\n";

            $mail['headers'] = $headers;
            $mail['subject'] = $subject;
            $mail['body'] = $body;
        }
        return $mail;
    }

    public function pay_mail()
    {
        if (!is_null(_A_::$app->session('cart')) && !is_null(_A_::$app->session('user'))) {

            $user = _A_::$app->session('user');
            $email = trim($user['email']);
            $ship_firstname = trim($user['ship_firstname']);
            $ship_lastname = trim($user['ship_lastname']);

            if (DEMO == 1) {
                $body = "                !!!THIS IS A TEST!!!                  \n\n";
                $body .= "This email message was generated when $ship_firstname $ship_lastname ($email) viewed the confirmation page. At this point the transaction was not concluded.\n\n";
                $subject = "!!!THIS IS A TEST!!! I Luv Fabrix purchase confirmation ";
            } else {
                $body = "This email message was generated when $ship_firstname $ship_lastname ($email) viewed the confirmation page. At this point the transaction was not concluded.\n\n";
                $subject = "I Luv Fabrix purchase confirmation ";
            }

            $headers = "From: \"I Luv Fabrix\"<info@iluvfabrix.com>\n";
            $body = $body . "\n";

            $mail['headers'] = $headers;
            $mail['subject'] = $subject;
            $mail['body'] = $body;

            $mail = $this->prepare_before_pay_mail($mail);
            if (isset($mail)) {
                $headers = $mail['headers'];
                $subject = $mail['subject'];
                $body = $mail['body'];

                if (DEMO == 1) {
                    mail("dev@9thsphere.com", $subject, $body, $headers);
                    mail("info@iluvfabrix.com", $subject, $body, $headers);
                    mail("max@maxportland.com", $subject, $body, $headers);
                    mail("mmitchell_houston@yahoo.com", $subject, $body, $headers);
                    mail("lanny1952@gmail.com", $subject, $body, $headers);
                    mail("iluvfabrixsales@gmail.com", $subject, $body, $headers);
                    mail("sergnochevny@studionovi.co", $subject, $body, $headers);
                } else {
                    mail("dev@9thsphere.com", $subject, $body, $headers);
                    mail("info@iluvfabrix.com", $subject, $body, $headers);
                    mail("max@maxportland.com", $subject, $body, $headers);
                    mail("mmitchell_houston@yahoo.com", $subject, $body, $headers);
                    mail("lanny1952@gmail.com", $subject, $body, $headers);
                    mail("iluvfabrixsales@gmail.com", $subject, $body, $headers);
                }
            }
        }
    }

    private function thanx_mail()
    {
        if (!is_null(_A_::$app->session('cart')) && !is_null(_A_::$app->session('user'))) {

            $user = _A_::$app->session('user');
            $email = trim($user['email']);
            $ship_firstname = trim($user['ship_firstname']);
            $ship_lastname = trim($user['ship_lastname']);

            $headers = "From: \"I Luv Fabrix\"<info@iluvfabrix.com>\n";
            if (DEMO == 1) {
                $body = "                !!!THIS IS A TEST!!!                  \n\n";
                $body .= "Hi, $ship_firstname $ship_lastname ($email) \n\n";
                $subject = "!!!THIS IS A TEST!!! I Luv Fabrix purchase confirmation ";
            } else {
                $body = "Hi, $ship_firstname $ship_lastname ($email) \n\n";
                $subject = "I Luv Fabrix purchase confirmation ";
            }
            $body = $body . "Thank you for your purchase. The following items will be shipped to you.\n";

            $mail['headers'] = $headers;
            $mail['subject'] = $subject;
            $mail['body'] = $body;

            $mail = $this->prepare_before_pay_mail($mail);
            if (isset($mail)) {
                $headers = $mail['headers'];
                $subject = $mail['subject'];
                $body = $mail['body'];

                mail($email, $subject, $body, $headers);

                $headers = "From: Web Customer <$email>\n";

                if (DEMO == 1) {
                    mail("info@iluvfabrix.com", $subject, $body, $headers);
                    mail("mmitchell_houston@yahoo.com", $subject, $body, $headers);
                    mail("iluvfabrixsales@gmail.com", $subject, $body, $headers);
                    mail("max@maxportland.com", $subject, $body, $headers);
                    mail("sergnochevny@studionovi.co", $subject, $body, $headers);
                } else {
                    mail("info@iluvfabrix.com", $subject, $body, $headers);
                    mail("mmitchell_houston@yahoo.com", $subject, $body, $headers);
                    mail("iluvfabrixsales@gmail.com", $subject, $body, $headers);
                    mail("max@maxportland.com", $subject, $body, $headers);
                }
            }
        }
    }

    private function pay_ok()
    {
        $base_url = BASE_URL;

        $shipcost = 0;
        $rollcost = 0;
        $handlingcost = 0;
        $express_samples_cost = 0;
        $total = 0;

        if (!is_null(_A_::$app->session('cart')) && !is_null(_A_::$app->session('cart')['trid']) && !is_null(_A_::$app->session('user')) &&
            !is_null(_A_::$app->session('cart')['payment']) && (_A_::$app->session('cart')['payment'] == 1)
        ) {
            if ((!is_null(_A_::$app->get('trid')) && (_A_::$app->get('trid') == _A_::$app->session('cart')['trid'])) ||
                (!is_null(_A_::$app->post('trid')) && (_A_::$app->session('trid') == _A_::$app->session('cart')['trid']))
            ) {

                $user = _A_::$app->session('user');

                if (!is_null(_A_::$app->session('cart')['items'])) {
                    $cart_items = _A_::$app->session('cart')['items'];
                } else {
                    $cart_items = [];
                }

                if (isset(_A_::$app->session('cart')['samples_items'])) {
                    $cart_samples_items = _A_::$app->session('cart')['samples_items'];
                } else {
                    $cart_samples_items = [];
                }

                if ((count($cart_samples_items) == 0) && (count($cart_items) == 0)) {
                    $url = $base_url . '/shop';
                    $this->redirect($url);
                }
                $pdiscount = 0;
                $model = new Model_Cart();
                if (count($cart_items) > 0) {
                    foreach ($cart_items as $key => $item) {
                        $pdiscount += $item['discount'];
                    }
                }
                $aid = $user['aid'];
                $trid = _A_::$app->session('cart')['trid'];
                $shipcost = _A_::$app->session('cart')['shipcost'];
                $shipDiscount = _A_::$app->session('cart')['ship_discount'];
                $couponDiscount = _A_::$app->session('cart')['coupon_discount'];
                $discount = $pdiscount + $shipDiscount + $couponDiscount;
                $taxes = _A_::$app->session('cart')['taxes'];
                $total = _A_::$app->session('cart')['total'];

                $ms = new Model_Samples();
                $msh = new Model_Shipping();
                $systemAllowExpressSamples = $ms->systemAllowSamplesExpressShipping();
                $bExpressSamples = !is_null(_A_::$app->session('cart')['express_samples']) ? _A_::$app->session('cart')['express_samples'] : false;
                if (!$systemAllowExpressSamples) {
                    $bExpressSamples = false;
                }
                if (count($cart_samples_items) == 0) $bExpressSamples = false;

                $bAcceptExpress = !is_null(_A_::$app->session('cart')['accept_express']) ? _A_::$app->session('cart')['accept_express'] : false;
                if (!$systemAllowExpressSamples) {
                    $bAcceptExpress = false;
                }
                if (!is_null(_A_::$app->session('cart')['ship']) && _A_::$app->session('cart')['ship'] > 0) {
                    $shipping = (int)_A_::$app->session('cart')['ship'];
                } else {
                    $shipping = DEFAULT_SHIPPING;
                }
                if (!is_null(_A_::$app->session('cart')['ship_roll'])) {
                    $bShipRoll = (boolean)_A_::$app->session('cart')['ship_roll'];
                } else {
                    $bShipRoll = false;
                }
                $coupon_code = !is_null(_A_::$app->session('cart')['coupon']) ? _A_::$app->session('cart')['coupon'] : '';
                $samples_sum = _A_::$app->session('cart')['samples_sum'];

                $on_roll = 0;
                if ((count($cart_items) > 0) && ($bShipRoll)) {
                    $rollcost += RATE_ROLL;
                    $on_roll = 1;
                }
                $express_samples = 0;
                if ((count($cart_samples_items) > 0) && ($bExpressSamples) && !(count($cart_items) > 0)) {
                    $express_samples_cost += SAMPLES_PRICE_EXPRESS_SHIPPING;
                    $express_samples = 1;
                }
                $handling = 0;
                if (count($cart_items) > 0) {
                    $handlingcost += RATE_HANDLING;
                    $handling = 1;
                }
                $mc = new Model_Order();
                $oid = $mc->register_order($aid, $trid, $shipping, $shipcost, $on_roll,
                    $express_samples, $handling, $shipDiscount,
                    $couponDiscount, $discount, $taxes, $total);
                if (isset($oid)) {
                    if (count($cart_items) > 0) {
                        $mp = new Model_Product();
                        foreach ($cart_items as $pid => $item) {
                            $product = $model->get_product_params($pid);
                            $pnumber = $product['pnumber'];
                            $pname = $product['pname'];
                            $qty = $item['quantity'];
                            $price = $item['price'];
                            $discount = $item['discount'];
                            $sale_price = $item['saleprice'];
                            if ($mc->insert_order_detail($oid, $pid, $pnumber, $pname,
                                $qty, $price, $discount, $sale_price)
                            ) {
                                $qty = $item['quantity'];
                                $inventory = $product['inventory'];
                                $remainder = $inventory - $qty;
                                $remainder = ($remainder <= 0) ? 0 : $remainder;

                                $mp->set_product_inventory($pid, $remainder);
                            }
                        }
                    }
                    if (count($cart_samples_items) > 0) {
                        foreach ($cart_samples_items as $pid => $item) {
                            $product = $model->get_product_params($pid);
                            $pnumber = $product['pnumber'];
                            $pname = $product['pname'];
                            $qty = 1;
                            $price = $item['Price'];
                            $discount = 0;
                            $sale_price = 0;
                            $is_sample = 1;
                            $mc->insert_order_detail($oid, $pid, $pnumber, $pname,
                                $qty, $price, $discount, $sale_price, $is_sample);
                        }
                    }

                    $discountIds = !is_null(_A_::$app->session('cart')['discountIds']) ? _A_::$app->session('cart')['discountIds'] : [];
                    $mc->save_discount_usage($discountIds, $oid);
                    $this->thanx_mail();
                    _A_::$app->session('cart', null);
                } else {
                    $url = $base_url . '/shop';
                    $this->redirect($url);
                }
            } else {
                $url = $base_url . '/shop';
                $this->redirect($url);
            }
        } else {
            $url = $base_url . '/shop';
            $this->redirect($url);
        }
    }

    protected function proceed_checkout_prepare()
    {
        $base_url = BASE_URL;
        $back_url = $base_url . '/cart';
        $this->template->vars('back_url', $back_url);
        $cart = _A_::$app->session('cart');
        unset($cart['discountIds']);
        _A_::$app->session('cart', $cart);
        ob_start();
        $this->products_in_cart('views/basket/product_in_proceed.php');
        $cart_items = ob_get_contents();
        ob_end_clean();
        $this->template->vars('cart_items', $cart_items);
        ob_start();
        $this->samples_in_cart('views/basket/sample_in_proceed.php');
        $cart_samples_items = ob_get_contents();
        ob_end_clean();
        $this->template->vars('cart_samples_items', $cart_samples_items);
        ob_start();
        $this->cart_samples_amount();
        $sum_samples = ob_get_contents();
        ob_end_clean();
        $this->template->vars('sum_samples', $sum_samples);
        ob_start();
        $this->shipping_proceed_calc();
        $shipping = ob_get_contents();
        ob_end_clean();
        $this->template->vars('shipping', $shipping);
        ob_start();
        $this->total_proceed_calc();
        $total_proceed = ob_get_contents();
        ob_end_clean();
        $this->template->vars('total_proceed', $total_proceed);
        ob_start();
        $this->proceed_bill_ship();
        $bill_ship_info = ob_get_contents();
        ob_end_clean();
        $this->template->vars('bill_ship_info', $bill_ship_info);
        $back_url = '/cart?proceed';
        $change_user_url = $base_url . '/change_registration_data?url=' . urlencode(base64_encode($back_url));
        $this->template->vars('change_user_url', $change_user_url);

    }

    private function proceed_bill_ship()
    {
        if (!is_null(_A_::$app->session('user'))) {
            $user = _A_::$app->session('user');
            $bill_firstname = trim($user['bill_firstname']);
            $bill_lastname = trim($user['bill_lastname']);
            $bill_organization = trim($user['bill_organization']);
            $bill_address1 = trim($user['bill_address1']);
            $bill_address2 = trim($user['bill_address2']);
            $bill_province = trim($user['bill_province']);
            $bill_city = trim($user['bill_city']);
            $bill_country = trim($user['bill_country']);
            $bill_postal = trim($user['bill_postal']);
            $bill_phone = trim($user['bill_phone']);
            $ship_firstname = trim($user['ship_firstname']);
            $ship_lastname = trim($user['ship_lastname']);
            $ship_organization = trim($user['ship_organization']);
            $ship_address1 = trim($user['ship_address1']);
            $ship_address2 = trim($user['ship_address2']);
            $ship_city = trim($user['ship_city']);
            $ship_province = trim($user['ship_province']);
            $ship_country = trim($user['ship_country']);
            $ship_postal = trim($user['ship_postal']);
            $ship_phone = trim($user['ship_phone']);

            $ma = new Model_Address();
            $bill_country = trim($ma->get_country_by_id($bill_country));
            $bill_province = trim($ma->get_province_by_id($bill_province));
            $ship_country = trim($ma->get_country_by_id($ship_country));
            $ship_province = trim($ma->get_province_by_id($ship_province));

            include('views/basket/bill_ship_info.php');
        }
    }

    function proceed_checkout()
    {
        $base_url = BASE_URL;
        $this->proceed_checkout_prepare();

        $this->main->view_layout('basket/proceed_checkout');
    }

    function proceed_agreem()
    {
        $base_url = BASE_URL;
        $back_url = $base_url . '/cart?proceed';
        $this->template->vars('back_url', $back_url);
        $total = _A_::$app->session('cart')['total'];
        $this->template->vars('total', $total);

        $user = _A_::$app->session('user');
        $email = trim($user['email']);
        $this->template->vars('email', $email);
        $bill_firstname = trim($user['bill_firstname']);
        $this->template->vars('bill_firstname', $bill_firstname);
        $bill_lastname = trim($user['bill_lastname']);
        $this->template->vars('bill_lastname', $bill_lastname);
        $bill_organization = trim($user['bill_organization']);
        $this->template->vars('bill_organization', $bill_organization);
        $bill_address1 = trim($user['bill_address1']);
        $this->template->vars('bill_address1', $bill_address1);
        $bill_address2 = trim($user['bill_address2']);
        $this->template->vars('bill_address2', $bill_address2);
        $bill_province = trim($user['bill_province']);
        $bill_city = trim($user['bill_city']);
        $this->template->vars('bill_city', $bill_city);
        $bill_country = trim($user['bill_country']);
        $bill_postal = trim($user['bill_postal']);
        $this->template->vars('bill_postal', $bill_postal);
        $bill_phone = trim($user['bill_phone']);
        $this->template->vars('bill_phone', $bill_phone);

        $ma = new Model_Address();
        $bill_country = trim($ma->get_country_by_id($bill_country));
        $this->template->vars('bill_country', $bill_country);
        $bill_province = trim($ma->get_province_by_id($bill_province));
        $this->template->vars('bill_province', $bill_province);

        $trid = uniqid();
        $cart = _A_::$app->session('cart');
        $cart['trid'] = $trid;
        $cart['trdate'] = date('Y-m-d H:i');
        _A_::$app->session('cart', $cart);

        if (DEMO == 1) {
            $paypal['business'] = "sergnochevny-facilitator@gmail.com";
            $paypal['url'] = "https://www.sandbox.paypal.com/cgi-bin/webscr";

        } else {
            $paypal['business'] = "info@iluvfabrix.com";
            $paypal['url'] = "https://www.paypal.com/cgi-bin/webscr";

        }

        $paypal['cmd'] = "_xclick";
        $paypal['image_url'] = $base_url;
        $paypal['return'] = $base_url . "/cart?pay_ok&trid=" . $trid;
        $paypal['cancel_return'] = $base_url . "/cart?pay_error";
        $paypal['notify_url'] = $base_url . '/ipn/ipn.php?pay_notify=' . session_id();
        $paypal['rm'] = "1";
        $paypal['currency_code'] = "USD";
        $paypal['lc'] = "US";
        $paypal['bn'] = "toolkit-php";

        $this->template->vars('paypal', $paypal);

        $this->main->view_layout('basket/proceed_agreem');
    }

    public function shipping_proceed_calc()
    {
        $bCodeValid = false;
        $unused = '';
        $shipcost = 0;
        $rollcost = 0;
        $express_samples_cost = 0;
        $total = 0;

        $aPrds = [];

        if (!is_null(_A_::$app->session('cart')['samples_items'])) {
            $cart_samples_items = _A_::$app->session('cart')['samples_items'];
        } else {
            $cart_samples_items = [];
        }

        $coupon_code = !is_null(_A_::$app->session('cart')['coupon']) ? _A_::$app->session('cart')['coupon'] : '';

        $ms = new Model_Samples();
        $systemAllowExpressSamples = $ms->systemAllowSamplesExpressShipping();
        $bExpressSamples = !is_null(_A_::$app->session('cart')['express_samples']) ? _A_::$app->session('cart')['express_samples'] : false;
        if (!$systemAllowExpressSamples) {
            $bExpressSamples = false;
        }
        if (count($cart_samples_items) == 0) $bExpressSamples = false;

        $bAcceptExpress = !is_null(_A_::$app->session('cart')['accept_express']) ? _A_::$app->session('cart')['accept_express'] : false;
        if (!$systemAllowExpressSamples) {
            $bAcceptExpress = false;
        }

        if (!is_null(_A_::$app->session('cart')['items'])) {
            $cart_items = _A_::$app->session('cart')['items'];
        } else {
            $cart_items = [];
        }

        #grab the user id
        if (!is_null(_A_::$app->session('user'))) {
            $uid = (int)_A_::$app->session('user')['aid'];
        } else {
            $uid = 0;
        }

        #get the shipping
        if (!is_null(_A_::$app->session('cart')['ship']) && _A_::$app->session('cart')['ship'] > 0) {
            $shipping = (int)_A_::$app->session('cart')['ship'];
        } else {
            $shipping = DEFAULT_SHIPPING;
        }

        if (!is_null(_A_::$app->session('cart')['ship_roll'])) {
            $bShipRoll = (boolean)_A_::$app->session('cart')['ship_roll'];
        } else {
            $bShipRoll = false;
        }

        $total_items = $this->calc_items_amount();
        $total += $total_items;
        $total_samples_items = $this->calc_samples_amount();
        $total += $total_samples_items;

        $shipcost = _A_::$app->session('cart')['shipcost'];

        $ship_model = new Model_Shipping();
        $price_model = new Model_Price();
        if (count($cart_items) > 0) {

            foreach ($cart_items as $key => $item) {
                $aPrds[] = $key;
                $aPrds[] = $item['quantity'];
            }

            #calculate the discount
            if (count($aPrds) > 0) {
                $discountIds = !is_null(_A_::$app->session('cart')['discountIds']) ? _A_::$app->session('cart')['discountIds'] : [];
                $shipDiscount = round($price_model->calculateDiscount(DISCOUNT_CATEGORY_SHIPPING, $uid, $aPrds, $total, $shipcost, $coupon_code, $bCodeValid, false, $unused, $unused, $shipping, $discountIds), 2);
                $couponDiscount = round($price_model->calculateDiscount(DISCOUNT_CATEGORY_COUPON, $uid, $aPrds, $total, $shipcost, $coupon_code, $bCodeValid, false, $unused, $unused, $shipping, $discountIds), 2);
                $cart = _A_::$app->session('cart');
                $cart['discountIds'] = $discountIds;
                _A_::$app->session('cart', $cart);
            }

        }

        if ((count($cart_items) > 0) && ($bShipRoll)) {
            $rollcost += RATE_ROLL;
        }

        if ((count($cart_samples_items) > 0) && ($bExpressSamples) && !(count($cart_items) > 0)) {
            $express_samples_cost += SAMPLES_PRICE_EXPRESS_SHIPPING;
        }

        $total = $total + $shipcost + (isset($rollcost) ? $rollcost : 0) + (isset($express_samples_cost) ? $express_samples_cost : 0);

        if ((count($cart_items) > 0) || (count($cart_samples_items) > 0)) {
            include('views/basket/ship_in_proceed.php');
        }
    }

    public function total_proceed_calc()
    {
        $bCodeValid = false;
        $unused = '';
        $shipDiscount = 0;
        $shipcost = 0;
        $total = 0;
        $couponDiscount = 0;

        $aPrds = [];

        if (!is_null(_A_::$app->session('cart')['samples_items'])) {
            $cart_samples_items = _A_::$app->session('cart')['samples_items'];
        } else {
            $cart_samples_items = [];
        }

        $coupon_code = !is_null(_A_::$app->session('cart')['coupon']) ? _A_::$app->session('cart')['coupon'] : '';

        $ms = new Model_Samples();
        $systemAllowExpressSamples = $ms->systemAllowSamplesExpressShipping();
        $bExpressSamples = !is_null(_A_::$app->session('cart')['express_samples']) ? _A_::$app->session('cart')['express_samples'] : false;
        if (!$systemAllowExpressSamples) {
            $bExpressSamples = false;
        }
        if (count($cart_samples_items) == 0) $bExpressSamples = false;

        $bAcceptExpress = !is_null(_A_::$app->session('cart')['accept_express']) ? _A_::$app->session('cart')['accept_express'] : false;
        if (!$systemAllowExpressSamples) {
            $bAcceptExpress = false;
        }

        if (!is_null(_A_::$app->session('cart')['items'])) {
            $cart_items = _A_::$app->session('cart')['items'];
        } else {
            $cart_items = [];
        }

        #grab the user id
        if (!is_null(_A_::$app->session('user'))) {
            $uid = (int)_A_::$app->session('user')['aid'];
        } else {
            $uid = 0;
        }

        #get the shipping
        if (!is_null(_A_::$app->session('cart')['ship']) && _A_::$app->session('cart')['ship'] > 0) {
            $shipping = (int)_A_::$app->session('cart')['ship'];
        } else {
            $shipping = DEFAULT_SHIPPING;
        }

        if (!is_null(_A_::$app->session('cart')['ship_roll'])) {
            $bShipRoll = (boolean)_A_::$app->session('cart')['ship_roll'];
        } else {
            $bShipRoll = false;
        }

        $total_items = $this->calc_items_amount();
        $total += $total_items;
        $total_samples_items = $this->calc_samples_amount();
        $total += $total_samples_items;
        $discount = $this->calc_items_discount_amount();

        $shipcost = _A_::$app->session('cart')['shipcost'];
        $shipDiscount = _A_::$app->session('cart')['ship_discount'];
        $couponDiscount = _A_::$app->session('cart')['coupon_discount'];

        if ((count($cart_items) > 0) && ($bShipRoll)) {
            $shipcost += RATE_ROLL;
        }

        if ((count($cart_samples_items) > 0) && ($bExpressSamples) && !(count($cart_items) > 0)) {
            $shipcost += SAMPLES_PRICE_EXPRESS_SHIPPING;
        }

        $handlingcost = 0;
        if (count($cart_items) > 0) {
            $handlingcost = RATE_HANDLING;
            $total += $handlingcost;
        }

        $total = $total + $shipcost;

        if ($shipDiscount > 0) {
            $total = round($total - $shipDiscount, 2);
        }

        if ($couponDiscount > 0) {
            $total = $total - $couponDiscount;
        }

        $discount = $discount + $couponDiscount + $shipDiscount;

        $taxes = _A_::$app->session('cart')['taxes'];
        $total = _A_::$app->session('cart')['total'];

        include('views/basket/total_in_proceed.php');
    }

    function cart_samples_legend()
    {
        if (!is_null(_A_::$app->session('cart')['items']) && (count(_A_::$app->session('cart')['items']) > 0)) {
            $cart_items = '_';
        }
        $ms = new Model_Samples();
        include('views/basket/cart_samples_legend.php');
    }

    public function shipping_calc()
    {
        $bCodeValid = false;
        $unused = '';
        $shipDiscount = 0;
        $shipcost = 0;
        $total = 0;
        $couponDiscount = 0;

        $aPrds = [];

        if (!is_null(_A_::$app->session('cart')['samples_items'])) {
            $cart_samples_items = _A_::$app->session('cart')['samples_items'];
        } else {
            $cart_samples_items = [];
        }

        $coupon_code = !is_null(_A_::$app->session('cart')['coupon']) ? _A_::$app->session('cart')['coupon'] : '';
        $coupon_code = !is_null(_A_::$app->post('coupon')) ? _A_::$app->post('coupon') : $coupon_code;
        _A_::$app->session('cart')['coupon'] = $coupon_code;

        $ms = new Model_Samples();
        $systemAllowExpressSamples = $ms->systemAllowSamplesExpressShipping();
        $bExpressSamples = !is_null(_A_::$app->session('cart')['express_samples']) ? _A_::$app->session('cart')['express_samples'] : false;
        if ($systemAllowExpressSamples) {
            if (!is_null(_A_::$app->post('express_samples'))) {
                $bExpressSamples = (int)_A_::$app->post('express_samples') == 1;
            }
        } else {
            $bExpressSamples = false;
        }
        if (count($cart_samples_items) == 0) $bExpressSamples = false;
        $cart = _A_::$app->session('cart');
        $cart['express_samples'] = $bExpressSamples;
        _A_::$app->session('cart', $cart);

        $bAcceptExpress = !is_null(_A_::$app->session('cart')['accept_express']) ? _A_::$app->session('cart')['accept_express'] : false;
        if ($systemAllowExpressSamples) {
            if (!is_null(_A_::$app->post('accept_express'))) {
                $bAcceptExpress = _A_::$app->post('accept_express') == 1;
            }
        } else {
            $bAcceptExpress = false;
        }

        $cart = _A_::$app->session('cart');
        $cart['accept_express'] = $bAcceptExpress;
        _A_::$app->session('cart', $cart);

        if (!is_null(_A_::$app->post('ship'))) {
            $cart = _A_::$app->session('cart');
            $cart['ship'] = _A_::$app->post('ship');
            _A_::$app->session('cart', $cart);
        }

        if (!is_null(_A_::$app->post('roll'))) {
            $cart = _A_::$app->session('cart');
            $cart['ship_roll'] = _A_::$app->post('roll');
            _A_::$app->session('cart', $cart);
        }

        if (!is_null(_A_::$app->session('cart')['items'])) {
            $cart_items = _A_::$app->session('cart')['items'];
        } else {
            $cart_items = [];
        }

        #grab the user id
        if (!is_null(_A_::$app->session('user'))) {
            $uid = (int)_A_::$app->session('user')['aid'];
        } else {
            $uid = 0;
        }

        #get the shipping
        if (!is_null(_A_::$app->session('cart')['ship']) && _A_::$app->session('cart')['ship'] > 0) {
            $shipping = (int)_A_::$app->session('cart')['ship'];
        } else {
            $shipping = DEFAULT_SHIPPING;
            _A_::$app->session('cart')['ship'] = $shipping;
        }

        if (!is_null(_A_::$app->session('cart')['ship_roll'])) {
            $bShipRoll = (boolean)_A_::$app->session('cart')['ship_roll'];
        } else {
            $bShipRoll = false;
            _A_::$app->session('cart')['ship_roll'] = 0;
        }

        $total_items = $this->calc_items_amount();
        $total += $total_items;
        $total_samples_items = $this->calc_samples_amount();
        $total += $total_samples_items;

        $cart_sum = "$" . number_format($total, 2);
        $this->template->vars('sum_all_items', $cart_sum);

        $price_model = new Model_Price();
        if (count($cart_items) > 0) {

            foreach ($cart_items as $key => $item) {
                $aPrds[] = $key;
                $aPrds[] = $item['quantity'];
            }

            $ship_model = new Model_Shipping();
            $shipcost = round($ship_model->calculateShipping($shipping, $aPrds, $bShipRoll), 2);

            #calculate the discount
            if (count($aPrds) > 0) {
                $discountIds = !is_null(_A_::$app->session('cart')['discountIds']) ? _A_::$app->session('cart')['discountIds'] : [];
                $shipDiscount = round($price_model->calculateDiscount(DISCOUNT_CATEGORY_SHIPPING, $uid, $aPrds, $total, $shipcost, $coupon_code, $bCodeValid, false, $unused, $unused, $shipping, $discountIds), 2);
                $couponDiscount = round($price_model->calculateDiscount(DISCOUNT_CATEGORY_COUPON, $uid, $aPrds, $total, $shipcost, $coupon_code, $bCodeValid, false, $unused, $unused, $shipping, $discountIds), 2);
                $cart = _A_::$app->session('cart');
                $cart['discountIds'] = $discountIds;
                _A_::$app->session('cart', $cart);
            }

        }
        $cart = _A_::$app->session('cart');
        $cart['shipcost'] = $shipcost;
        $cart['ship_discount'] = $shipDiscount;
        $cart['coupon_discount'] = $couponDiscount;
        _A_::$app->session('cart', $cart);

        if ((count($cart_items) > 0) && ($bShipRoll)) {
            $shipcost += RATE_ROLL;
        }

        if ((count($cart_samples_items) > 0) && ($bExpressSamples) && !(count($cart_items) > 0)) {
            $shipcost += SAMPLES_PRICE_EXPRESS_SHIPPING;
        }

        if (count($cart_items) > 0) {
            $total += RATE_HANDLING;
        }

        $total = $total + $shipcost;

        if ($shipDiscount > 0) {
            $total = round($total - $shipDiscount, 2);
        }

        _A_::$app->session('cart', $cart);
        $cart['subtotal_ship'] = $total;
        _A_::$app->session('cart', $cart);

        $this->template->vars('subtotal_ship', $total);

        if ($couponDiscount > 0) {
            $total = $total - $couponDiscount;
        }

        $taxes = 0;
        if ($uid > 0) {
            $tax_percentage = $price_model->user_TaxRate($uid);
            $taxes = round($total * ($tax_percentage / 100), 2);
            $total = round(($total + $taxes), 2);
        }

        $cart['taxes'] = $taxes;
        $cart['total'] = $total;
        _A_::$app->session('cart', $cart);

        $this->template->vars('taxes', $taxes);
        $this->template->vars('total', $total);
        $this->template->vars('coupon_discount', $couponDiscount);


        if (count($cart_items) > 0) {
            include('views/basket/cart_shipping.php');
        } else {
            if (count($cart_samples_items) > 0) {
                include('views/basket/cart_shipping_samples.php');
            }
        }
    }

    public function coupon_total_calc()
    {

        if (!is_null(_A_::$app->session('cart')['samples_items'])) {
            $cart_samples_items = _A_::$app->session('cart')['samples_items'];
        } else {
            $cart_samples_items = [];
        }

        if (!is_null(_A_::$app->session('cart')['items'])) {
            $cart_items = _A_::$app->session('cart')['items'];
        } else {
            $cart_items = [];
        }

        $total = _A_::$app->session('cart')['total'];
        $coupon_discount = _A_::$app->session('cart')['coupon_discount'];
        $taxes = _A_::$app->session('cart')['taxes'];

        $coupon_code = !is_null(_A_::$app->session('cart')['coupon']) ? _A_::$app->session('cart')['coupon'] : '';

        #grab the user id
        if (!is_null(_A_::$app->session('user'))) {
            $uid = (int)_A_::$app->session('user')['aid'];
        } else {
            $uid = 0;
        }

        if ((count($cart_items) > 0) || (count($cart_samples_items) > 0)) {
            include('views/basket/cart_coupon_total.php');
        }

    }

    public function get_cart_subtotal_ship()
    {
        $total = 0;
        if (!is_null(_A_::$app->session('cart')['subtotal_ship'])) {
            $total = _A_::$app->session('cart')['subtotal_ship'];
        }
        echo '$' . number_format($total, 2) . ' USD';
    }

    private function products_in_cart($template = 'views/basket/product_in_cart.php')
    {
        $base_url = BASE_URL;

        if (!is_null(_A_::$app->session('cart')['items'])) {
            $cart_items = _A_::$app->session('cart')['items'];
        } else {
            $cart_items = [];
        }

        if (count($cart_items) > 0) {
            foreach ($cart_items as $key => $item) {
                $this->product_in_cart($key, $item, $template);
                $cart_items[$key] = $item;
            }
            $_cart = _A_::$app->session('cart');
            $_cart['items'] = $cart_items;
            _A_::$app->session('cart', $_cart);
        }

    }

    private function samples_in_cart($template = 'views/basket/sample_in_proceed.php')
    {
        $base_url = BASE_URL;

        if (!is_null(_A_::$app->session('cart')['samples_items'])) {
            $cart_samples_items = _A_::$app->session('cart')['samples_items'];
        } else {
            $cart_samples_items = [];
        }

        if (count($cart_samples_items) > 0) {
            foreach ($cart_samples_items as $key => $item) {
                $this->sample_in_cart($key, $item, $template);
                $cart_samples_items[$key] = $item;
            }
            $_cart = _A_::$app->session('cart');
            $_cart['samples_items'] = $cart_samples_items;
            _A_::$app->session('cart', $_cart);
        }

    }

    private function sample_in_cart($p_id, &$item, $template = 'views/basket/sample_in_proceed.php')
    {
        $model = new Model_Cart();
        $base_url = BASE_URL;

        $rowsni = $model->get_product_params($p_id);

        $filename = 'upload/upload/' . $rowsni['image1'];
        if (!file_exists($filename) || !is_file($filename) || !is_readable($filename)) {
            $filename = "upload/upload/not_image.jpg";
        }
        $img_url = $base_url . '/' . $filename;

        include($template);
    }


    private function product_in_cart($p_id, &$item, $template = 'views/basket/product_in_cart.php')
    {
        $model = new Model_Cart();
        $base_url = BASE_URL;

        $rowsni = $model->get_product_params($p_id);

        $filename = 'upload/upload/' . $rowsni['image1'];
        if (!file_exists($filename) || !is_file($filename) || !is_readable($filename)) {
            $filename = "upload/upload/not_image.jpg";
        }
        $img_url = $base_url . '/' . $filename;


        $mp = new Model_Price();
        $pid = $p_id;
        $price = $rowsni['priceyard'];
        $inventory = $rowsni['inventory'];
        $piece = $rowsni['piece'];
        $format_price = '';
        $price = $mp->getPrintPrice($price, $format_price, $inventory, $piece);

        $discountIds = !is_null(_A_::$app->session('cart')['discountIds']) ? _A_::$app->session('cart')['discountIds'] : [];
        $saleprice = $rowsni['priceyard'];
        $sDiscount = 0;
        $saleprice = round($mp->calculateProductSalePrice($pid, $saleprice, $discountIds), 2);
        $bProductDiscount = $mp->checkProductDiscount($pid, $sDiscount, $saleprice, $discountIds);

        $_cart = _A_::$app->session('cart');
        $_cart['discountIds'] = $discountIds;
        _A_::$app->session('cart', $_cart);

        $format_sale_price = '';
        $saleprice = round($mp->getPrintPrice($saleprice, $format_sale_price, $inventory, $piece), 2);
        $discount = round($price - $saleprice, 2);
        $format_discount = "$" . number_format($discount, 2);

        $item['price'] = $price;
        $item['saleprice'] = $saleprice;
        $item['discount'] = $discount;
        $item['format_discount'] = $format_discount;
        $item['format_price'] = $format_price;
        $item['format_sale_price'] = $format_sale_price;

        $t_pr = round($item['quantity'] * $item['saleprice'], 2);
        $item['subtotal'] = $t_pr;
        $t_pr = "$" . number_format($t_pr, 2);
        $item['format_subtotal'] = $t_pr;

        include($template);

    }

    function calc_items_amount()
    {
        if (!is_null(_A_::$app->session('cart')['items'])) {
            $cart_items = _A_::$app->session('cart')['items'];

        } else {
            $cart_items = [];
        }

        $SUM = 0;
        foreach ($cart_items as $key => $item) {
            $SUM += round($item['quantity'] * $item['saleprice'], 2);
        }

        return $SUM;
    }

    function calc_items_discount_amount()
    {
        if (!is_null(_A_::$app->session('cart')['items'])) {
            $cart_items = _A_::$app->session('cart')['items'];

        } else {
            $cart_items = [];
        }

        $SUM = 0;
        foreach ($cart_items as $key => $item) {
            $SUM += round($item['quantity'] * $item['discount'], 2);
        }

        return $SUM;
    }


    function cart_items_amount()
    {
        $SUM = $this->calc_items_amount();
        $cart_items_sum = "$" . number_format($SUM, 2);

        echo $cart_items_sum;
    }

    function calc_samples_amount()
    {

        if (!is_null(_A_::$app->session('cart')['items'])) {
            $cart_items = _A_::$app->session('cart')['items'];
        } else {
            $cart_items = [];
        }

        if (!is_null(_A_::$app->session('cart')['samples_items'])) {
            $cart_samples_items = _A_::$app->session('cart')['samples_items'];
        } else {
            $cart_samples_items = [];
        }

        $ms = new Model_Samples();
        $cart_samples_sum = round($ms->calculateSamplesPrice($cart_items, $cart_samples_items), 2);

        $format_samples_sum = "$" . number_format($cart_samples_sum, 2);

        $_cart = _A_::$app->session('cart');
        $_cart['samples_sum'] = $cart_samples_sum;
        $_cart['format_samples_sum'] = $format_samples_sum;
        _A_::$app->session('cart', $_cart);

        return $cart_samples_sum;
    }

    function cart_samples_amount()
    {

        $this->calc_samples_amount();
        $format_samples_sum = _A_::$app->session('cart')['format_samples_sum'];

        echo $format_samples_sum;
    }

    function cart_amount()
    {

        $SUM = 0;
        $SUM += $this->calc_items_amount();
        $SUM += $this->calc_samples_amount();

        $cart_sum = "$" . number_format($SUM, 2);
        $this->template->vars('sum_all_items', $cart_sum);

        echo $cart_sum;
    }

    function add_cart()
    {

        $base_url = BASE_URL;
        if (!empty(_A_::$app->get('p_id'))) {
            $model = new Model_Cart();
            $produkt_id = $model->validData(_A_::$app->get('p_id'));

            $product = $model->get_product_params($produkt_id);

            if (!is_null(_A_::$app->session('cart')['items'])) {
                $cart_items = _A_::$app->session('cart')['items'];
            } else {
                $cart_items = [];
            }

            if ($product['inventory'] > 0) {

                $item_added = false;
                if (count($cart_items) > 0) {
                    foreach ($cart_items as $key => $item) {
                        if ($item['produkt_id'] == $produkt_id) {
                            $cart_items[$key]['quantity'] += 1;
                            $item_added = true;
                        }
                    }
                }

                if (!$item_added) {

                    $mp = new Model_Price();
                    $pid = $produkt_id;
                    $price = $product['Price'];
                    $inventory = $product['inventory'];
                    $piece = $product['piece'];
                    $format_price = '';
                    $price = $mp->getPrintPrice($price, $format_price, $inventory, $piece);

                    $discountIds = !is_null(_A_::$app->session('cart')['discountIds']) ? _A_::$app->session('cart')['discountIds'] : [];
                    $saleprice = $product['Price'];
                    $sDiscount = 0;
                    $saleprice = round($mp->calculateProductSalePrice($pid, $saleprice, $discountIds), 2);
                    $bProductDiscount = $mp->checkProductDiscount($pid, $sDiscount, $saleprice, $discountIds);
                    $_cart = _A_::$app->session('cart');
                    $_cart['discountIds'] = $discountIds;
                    _A_::$app->session('cart', $_cart);
                    $format_sale_price = '';
                    $saleprice = round($mp->getPrintPrice($saleprice, $format_sale_price, $inventory, $piece), 2);
                    $discount = round(($price - $saleprice), 2);
                    $format_discount = "$" . number_format($discount, 2);;

                    $product['Price'] = $price;
                    $product['saleprice'] = $saleprice;
                    $product['discount'] = $discount;
                    $product['format_discount'] = $format_discount;
                    $product['format_price'] = $format_price;
                    $product['format_sale_price'] = $format_sale_price;
                    $t_pr = round($product['quantity'] * $product['saleprice'], 2);
                    $product['subtotal'] = $t_pr;
                    $t_pr = "$" . number_format($t_pr, 2);
                    $product['format_subtotal'] = $t_pr;

                    $cart_items[$product['produkt_id']] = $product;

                }

                $_cart['items'] = $cart_items;
                _A_::$app->session('cart', $_cart);

                $SUM = 0;
                $SUM += $this->calc_items_amount();
                $SUM += $this->calc_samples_amount();

                $cart_sum = "$" . number_format($SUM, 2);
                $this->template->vars('SUM', $cart_sum);

                ob_start();
                $message = 'This Fabric has been added to your Basket.<br>Click the Basket to view your Order.';
                $message .= '<br>Subtotal sum of basket is ' . $cart_sum;
                $this->template->vars('message', $message);
                $this->main->view_layout('msgs/msg_add_cart');
                $msg = ob_get_contents();
                ob_end_clean();
                ob_start();
                $this->main->view_layout('basket/main_product_basket');
                $button = ob_get_contents();
                ob_end_clean();

                $res = json_encode(['msg' => $msg, 'button' => $button, 'sum' => $cart_sum]);
                echo $res;
            } else {

                $SUM = 0;
                $SUM += $this->calc_items_amount();
                $SUM += $this->calc_samples_amount();

                $cart_sum = "$" . number_format($SUM, 2);
                $this->template->vars('SUM', $cart_sum);

                ob_start();
                $message = 'The product ' . $product['Product_name'] . ' is unavailable. The product was not added.<br>';
                $message .= '<br>Subtotal sum of basket is ' . $cart_sum;
                $this->template->vars('message', $message);
                $this->main->view_layout('msgs/msg_add_cart');
                $msg = ob_get_contents();
                ob_end_clean();

                $res = json_encode(['msg' => $msg, 'sum' => $cart_sum]);
                echo $res;
            }

        }

    }

    function add_samples_cart()
    {
        $base_url = BASE_URL;
        if (!empty(_A_::$app->get('p_id'))) {
            $model = new Model_Cart();
            $produkt_id = $model->validData(_A_::$app->get('p_id'));

            $product = $model->get_product_params($produkt_id);

            if (!is_null(_A_::$app->session('cart')['items'])) {
                $cart_items = _A_::$app->session('cart')['items'];
            } else {
                $cart_items = [];
            }

            if (!is_null(_A_::$app->session('cart')['samples_items'])) {
                $cart_samples_items = _A_::$app->session('cart')['samples_items'];
            } else {
                $cart_samples_items = [];
            }

            if ($product['inventory'] > 0) {

                $item_added = false;
                if (count($cart_samples_items) > 0 && isset($cart_samples_items[$produkt_id])) {
                    $item_added = true;
                }

                if (!$item_added) {

                    $cart_samples_items[$product['produkt_id']] = $product;
                    $mp = new Model_Price();
                    $ms = new Model_Samples();
                    $cart_samples_sum = round($ms->calculateSamplesPrice($cart_items, $cart_samples_items), 2);

                    $format_samples_sum = '';
                    $tmp = $mp->getPrintPrice($cart_samples_sum, $format_samples_sum, 1, 1);
                    $_cart = _A_::$app->session('cart');
                    $_cart['samples_sum'] = $cart_samples_sum;
                    $_cart['format_samples_sum'] = $format_samples_sum;
                    _A_::$app->session('cart', $_cart);
                }

                $_cart = _A_::$app->session('cart');
                $_cart['samples_items'] = $cart_samples_items;
                _A_::$app->session('cart', $_cart);

                $SUM = 0;
                $SUM += $this->calc_items_amount();
                $SUM += $this->calc_samples_amount();

                $cart_sum = "$" . number_format($SUM, 2);
                $this->template->vars('SUM', $cart_sum);

                ob_start();
                $message = 'This Samples has been added to your Basket.<br>Click the Basket to view your Order.';
                $message .= '<br>Subtotal sum of basket is ' . $cart_sum;
                $this->template->vars('message', $message);
                $this->main->view_layout('msgs/msg_add_cart');
                $msg = ob_get_contents();
                ob_end_clean();
                ob_start();
                $this->main->view_layout('basket/main_product_basket');
                $button = ob_get_contents();
                ob_end_clean();

                $res = json_encode(['msg' => $msg, 'button' => $button, 'sum' => $cart_sum]);
                echo $res;
            } else {

                $SUM = 0;
                $SUM += $this->calc_items_amount();
                $SUM += $this->calc_samples_amount();

                $cart_sum = "$" . number_format($SUM, 2);
                $this->template->vars('SUM', $cart_sum);

                ob_start();
                $message = 'The product ' . $product['Product_name'] . ' is unavailable. The product was not added.<br>';
                $message .= '<br>Subtotal sum of basket is ' . $cart_sum;
                $this->template->vars('message', $message);
                $this->main->view_layout('msgs/msg_add_cart');
                $msg = ob_get_contents();
                ob_end_clean();

                $res = json_encode(['msg' => $msg, 'sum' => $cart_sum]);
                echo $res;
            }

        }
    }

    function get_cart()
    {
        if (!is_null(_A_::$app->get('cart')['items'])) {
            $cart_items = _A_::$app->get('cart')['items'];
        } else {
            $cart_items = [];
        }

        $SUM = 0;
        $SUM += $this->calc_items_amount();
        $SUM += $this->calc_samples_amount();

        $SUM = "$" . number_format($SUM, 2);
        $this->template->vars('SUM', $SUM);
        $this->template->vars('cart_items', $cart_items);

    }

    function change_product_cart()
    {
        $pid = _A_::$app->get('p_id');
        $quantity = _A_::$app->get('qnt');
        $response = [];
        if (!is_null(_A_::$app->session('cart')['items'])) {
            $cart_items = _A_::$app->session('cart')['items'];
        } else {
            $cart_items = [];
        }
        if (preg_match('/^\d+(\.\d{0,})?$/', $quantity)) {

            $model = new Model_Cart();

            $product = $model->get_product_params($pid);
            $inventory = $product['inventory'];
            $piece = $product['piece'];
            $whole = $product['whole'];

            if (isset($cart_items[$pid])) {

                if (($quantity > 0) && (floor($quantity) != $quantity) && ($whole == 1)) {
                    if ($quantity < 1) {
                        $quantity = 1;
                    } else {
                        $quantity = floor($quantity);
                    }
                    ob_start();
                    $message = 'The quantity for ' . $product['Product_name'] . ' must be a whole number. The order was adjusted.<br>';
                    $this->template->vars('message', $message);
                    $this->main->view_layout('msgs/msg_add_cart');
                    $response['msg'] = ob_get_contents();
                    ob_end_clean();
                }

                if ($piece == 0) {
                    if ($inventory >= $quantity) {
                        $cart_items[$pid]['quantity'] = $quantity;
                    } else {
                        $cart_items[$pid]['quantity'] = $inventory;
                        ob_start();
                        $message = 'The available inventory for ' . $cart_items[$pid]['Product_name'] . ' is ' . $inventory . '. The order was adjusted.<br>';
                        $this->template->vars('message', $message);
                        $this->main->view_layout('msgs/msg_add_cart');
                        $response['msg'] = ob_get_contents();
                        ob_end_clean();
                    }
                }
            }
        } else {
            ob_start();
            $message = 'The quantity must be a positive number. The order was adjusted.<br>';
            $this->template->vars('message', $message);
            $this->main->view_layout('msgs/msg_add_cart');
            $response['msg'] = ob_get_contents();
            ob_end_clean();
        }

        ob_start();
        $item = $cart_items[$pid];
        $this->product_in_cart($pid, $item);
        $cart_items[$pid] = $item;
        $_cart = _A_::$app->session('cart');
        $_cart['items'] = $cart_items;
        _A_::$app->session('cart', $_cart);
        $response['product'] = ob_get_contents();
        ob_end_clean();

        echo json_encode($response);

    }

    function del_product_cart()
    {
        if (!is_null(_A_::$app->get('p_id'))) {

            $pid = _A_::$app->get('p_id');

            if (!is_null(_A_::$app->session('cart')['items'])) {
                $cart_items = _A_::$app->session('cart')['items'];
            } else {
                $cart_items = [];
            }

            if (isset($cart_items[$pid])) {
                unset($cart_items[$pid]);

                $_cart = _A_::$app->session('cart');
                $_cart['items'] = $cart_items;
                _A_::$app->session('cart', $_cart);

            }

            $this->calc_items_amount();
            $this->calc_samples_amount();
        }
    }

    function del_sample_cart()
    {
        if (!is_null(_A_::$app->get('p_id'))) {

            $pid = _A_::$app->session('p_id');

            if (!is_null(_A_::$app->session('cart')['samples_items'])) {
                $cart_samples_items = _A_::$app->session('cart')['samples_items'];
            } else {
                $cart_samples_items = [];
            }

            if (isset($cart_samples_items[$pid])) {
                unset($cart_samples_items[$pid]);
                $_cart = _A_::$app->session('cart');
                $_cart['samples_items'] = $cart_samples_items;
                _A_::$app->session('cart', $_cart);
            }

            $this->calc_items_amount();
            $this->calc_samples_amount();
        }
    }
}