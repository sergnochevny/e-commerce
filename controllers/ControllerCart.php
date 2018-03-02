<?php

namespace controllers;

use app\core\App;
use classes\controllers\ControllerController;
use Exception;
use models\ModelAddress;
use models\ModelOrders;
use models\ModelPrice;
use models\ModelProduct;
use models\ModelSamples;
use models\ModelShipping;
use models\ModelShop;

/**
 * Class ControllerCart
 * @package controllers
 */
class ControllerCart extends ControllerController{

  /**
   * @param string $template
   * @throws \Exception
   */
  private function products_in($template = 'product_in'){
    $cart_items = isset(App::$app->session('cart')['items']) ? App::$app->session('cart')['items'] : [];
    if(count($cart_items) > 0) {
      foreach($cart_items as $key => $item) {
        $this->product_in($key, $item, $template);
        $cart_items[$key] = $item;
      }
      $_cart = App::$app->session('cart');
      $_cart['items'] = $cart_items;
      App::$app->setSession('cart', $_cart);
    }
  }

  /**
   * @param $pid
   * @param $item
   * @param string $template
   * @throws \Exception
   */
  private function product_in($pid, &$item, $template = 'product_in'){
    $product = ModelProduct::get_by_id($pid);
    $filename = 'images/products/' . $item['image1'];
    if(!file_exists($filename) || !is_file($filename) || !is_readable($filename)) {
      $filename = "images/products/not_image.jpg";
    }
    $img_url = App::$app->router()
      ->UrlTo($filename);

    $cart = App::$app->session('cart');
    $price = $product['priceyard'];
    $inventory = $product['inventory'];
    $piece = $product['piece'];
    $format_price = '';
    $price = ModelPrice::getPrintPrice($price, $format_price, $inventory, $piece);

    $discountIds = isset($cart['discountIds']) ? $cart['discountIds'] : [];
    $saleprice = $product['priceyard'];
    $sDiscount = 0;
    $saleprice = round(ModelPrice::calculateProductSalePrice($pid, $saleprice, $discountIds), 2);

    $cart['discountIds'] = $discountIds;

    $format_sale_price = '';
    $saleprice = round(ModelPrice::getPrintPrice($saleprice, $format_sale_price, $inventory, $piece), 2);
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

    App::$app->setSession('cart', $cart);

    $this->template->vars('img_url', $img_url);
    $this->template->vars('item', $item);
    $this->template->vars('pid', $pid);
    $this->template->vars('t_pr', $t_pr);
    $this->template->view_layout($template);
  }

  /**
   * @param string $template
   * @throws \Exception
   */
  private function samples_in($template = 'sample_in'){
    $cart_samples_items = isset(App::$app->session('cart')['samples_items']) ? App::$app->session('cart')['samples_items'] : [];
    if(count($cart_samples_items) > 0) {
      foreach($cart_samples_items as $key => $item) {
        $this->sample_in($key, $item, $template);
        $cart_samples_items[$key] = $item;
      }
      $_cart = App::$app->session('cart');
      $_cart['samples_items'] = $cart_samples_items;
      App::$app->setSession('cart', $_cart);
    }
  }

  /**
   * @param $pid
   * @param $item
   * @param string $template
   * @throws \Exception
   */
  private function sample_in($pid, &$item, $template = 'sample_in'){
    $item = ModelShop::get_product_params($pid);
    $filename = 'images/products/' . $item['image1'];
    if(!file_exists($filename) || !is_file($filename) || !is_readable($filename)) {
      $filename = "images/products/not_image.jpg";
    }
    $img_url = App::$app->router()
      ->UrlTo($filename);
    $this->template->vars('img_url', $img_url);
    $this->template->vars('item', $item);
    $this->template->vars('pid', $pid);
    $this->template->view_layout($template);
  }

  /**
   *
   * @throws \Exception
   */
  private function proceed_bill_ship(){
    if(!is_null(App::$app->session('user'))) {
      $user = App::$app->session('user');
      $this->template->vars('bill_firstname', trim($user['bill_firstname']));
      $this->template->vars('bill_lastname', trim($user['bill_lastname']));
      $this->template->vars('bill_organization', trim($user['bill_organization']));
      $this->template->vars('bill_address1', trim($user['bill_address1']));
      $this->template->vars('bill_address2', trim($user['bill_address2']));
      $this->template->vars('bill_city', trim($user['bill_city']));
      $this->template->vars('bill_postal', trim($user['bill_postal']));
      $this->template->vars('bill_phone', trim($user['bill_phone']));
      $this->template->vars('ship_firstname', trim($user['ship_firstname']));
      $this->template->vars('ship_lastname', trim($user['ship_lastname']));
      $this->template->vars('ship_organization', trim($user['ship_organization']));
      $this->template->vars('ship_address1', trim($user['ship_address1']));
      $this->template->vars('ship_address2', trim($user['ship_address2']));
      $this->template->vars('ship_city', trim($user['ship_city']));
      $this->template->vars('ship_postal', trim($user['ship_postal']));
      $this->template->vars('ship_phone', trim($user['ship_phone']));
      $ship_country = trim($user['ship_country']);
      $bill_province = trim($user['bill_province']);
      $bill_country = trim($user['bill_country']);
      $ship_province = trim($user['ship_province']);

      $this->template->vars('bill_country', trim(ModelAddress::get_country_by_id($bill_country)));
      $this->template->vars('bill_province', trim(ModelAddress::get_province_by_id($bill_province)));
      $this->template->vars('ship_country', trim(ModelAddress::get_country_by_id($ship_country)));
      $this->template->vars('ship_province', trim(ModelAddress::get_province_by_id($ship_province)));
      $this->template->view_layout('bill_ship_info');
    }
  }

  /**
   *
   * @throws \Exception
   */
  private function pay_ok(){
    $shipcost = 0;
    $rollcost = 0;
    $handlingcost = 0;
    $express_samples_cost = 0;
    $total = 0;
    $rate_handling = (!is_null(App::$app->keyStorage()->shop_rate_handling) ? App::$app->keyStorage()->shop_rate_handling : RATE_HANDLING);
    $samples_price_express_shipping = (!is_null(App::$app->keyStorage()->shop_samples_price_express_shipping) ? App::$app->keyStorage()->shop_samples_price_express_shipping : SAMPLES_PRICE_EXPRESS_SHIPPING);
    $rate_roll = (!is_null(App::$app->keyStorage()->shop_rate_roll) ? App::$app->keyStorage()->shop_rate_roll : RATE_ROLL);

    if(!is_null(App::$app->session('cart')) && isset(App::$app->session('cart')['trid']) && !is_null(App::$app->session('user')) && isset(App::$app->session('cart')['payment']) && (App::$app->session('cart')['payment'] == 1)) {
      if((!is_null(App::$app->get('trid')) && (App::$app->get('trid') == App::$app->session('cart')['trid'])) || (!is_null(App::$app->post('trid')) && (App::$app->session('trid') == App::$app->session('cart')['trid']))) {

        $user = App::$app->session('user');
        $cart_items = isset(App::$app->session('cart')['items']) ? App::$app->session('cart')['items'] : [];
        $cart_samples_items = isset(App::$app->session('cart')['samples_items']) ? App::$app->session('cart')['samples_items'] : [];
        if((count($cart_samples_items) == 0) && (count($cart_items) == 0)) {
          $url = App::$app->router()
            ->UrlTo('shop');
          $this->redirect($url);
        }
        $pdiscount = 0;
        if(count($cart_items) > 0) {
          foreach($cart_items as $key => $item) {
            $pdiscount += $item['discount'];
          }
        }
        $aid = $user['aid'];
        $trid = App::$app->session('cart')['trid'];
        $shipcost = App::$app->session('cart')['shipcost'];
        $shipDiscount = App::$app->session('cart')['ship_discount'];
        $couponDiscount = App::$app->session('cart')['coupon_discount'];
        $discount = $pdiscount + $shipDiscount + $couponDiscount;
        $taxes = App::$app->session('cart')['taxes'];
        $total = App::$app->session('cart')['total'];

        $systemAllowExpressSamples = ModelSamples::systemAllowSamplesExpressShipping();
        $bExpressSamples = !$systemAllowExpressSamples ? false : isset(App::$app->session('cart')['express_samples']) ? App::$app->session('cart')['express_samples'] : false;
        if(count($cart_samples_items) == 0) $bExpressSamples = false;
        $bAcceptExpress = !$systemAllowExpressSamples ? false : isset(App::$app->session('cart')['accept_express']) ? App::$app->session('cart')['accept_express'] : false;
        $shipping = (isset(App::$app->session('cart')['ship']) && App::$app->session('cart')['ship'] > 0) ? (int)App::$app->session('cart')['ship'] : DEFAULT_SHIPPING;
        $bShipRoll = (isset(App::$app->session('cart')['ship_roll'])) ? (boolean)App::$app->session('cart')['ship_roll'] : false;
        $coupon_code = isset(App::$app->session('cart')['coupon']) ? App::$app->session('cart')['coupon'] : '';
        $samples_sum = App::$app->session('cart')['samples_sum'];

        $on_roll = 0;
        if((count($cart_items) > 0) && ($bShipRoll)) {
          $rollcost += $rate_roll;
          $on_roll = 1;
        }
        $express_samples = 0;
        if((count($cart_samples_items) > 0) && ($bExpressSamples) && !(count($cart_items) > 0)) {
          $express_samples_cost += $samples_price_express_shipping;
          $express_samples = 1;
        }
        $handling = 0;
        if(count($cart_items) > 0) {
          $handlingcost += $rate_handling;
          $handling = 1;
        }
        ModelOrders::transaction();
        try {
          $oid = ModelOrders::register_order($aid, $trid, $shipping, $shipcost, $on_roll, $express_samples, $handling, $shipDiscount, $couponDiscount, $discount, $taxes, $total);
          if(isset($oid)) {
            if(count($cart_items) > 0) {
              foreach($cart_items as $pid => $item) {
                $product = ModelShop::get_product_params($pid);
                $pnumber = $product['pnumber'];
                $pname = $product['pname'];
                $qty = $item['quantity'];
                $price = $item['price'];
                $discount = $item['discount'];
                $sale_price = $item['saleprice'];
                if(ModelOrders::insert_order_detail($oid, $pid, $pnumber, $pname, $qty, $price, $discount, $sale_price)) {
                  $qty = $item['quantity'];
                  $inventory = $product['inventory'];
                  $remainder = $inventory - $qty;
                  $remainder = ($remainder <= 0) ? 0 : $remainder;

                  ModelShop::set_inventory($pid, $remainder);
                }
              }
            }
            if(count($cart_samples_items) > 0) {
              foreach($cart_samples_items as $pid => $item) {
                $product = ModelShop::get_product_params($pid);
                $pnumber = $product['pnumber'];
                $pname = $product['pname'];
                $qty = 1;
                $price = $item['price'];
                $discount = 0;
                $sale_price = 0;
                $is_sample = 1;
                ModelOrders::insert_order_detail($oid, $pid, $pnumber, $pname, $qty, $price, $discount, $sale_price, $is_sample);
              }
            }

            $discountIds = isset(App::$app->session('cart')['discountIds']) ? App::$app->session('cart')['discountIds'] : [];
            ModelOrders::save_discount_usage($discountIds, $oid);
            $this->thanx_mail();
            App::$app->setSession('cart', null);
          } else {
            ModelOrders::rollback();
            $this->redirect(App::$app->router()
              ->UrlTo('shop'));
          }
          ModelOrders::commit();
        } catch(Exception $e) {
          ModelOrders::rollback();
        }
      } else $this->redirect(App::$app->router()
        ->UrlTo('shop'));
    } else $this->redirect(App::$app->router()
      ->UrlTo('shop'));
  }

  /**
   *
   * @throws \Exception
   */
  private function thanx_mail(){
    if(!is_null(App::$app->session('cart')) && !is_null(App::$app->session('user'))) {

      $user = App::$app->session('user');
      $email = trim($user['email']);
      $ship_firstname = trim($user['ship_firstname']);
      $ship_lastname = trim($user['ship_lastname']);

      $demo = (!is_null(App::$app->keyStorage()->system_demo) ? App::$app->keyStorage()->system_demo : DEMO);
      if($demo == 1) {
        $body = "                !!!THIS IS A TEST!!!                  \n\n";
        $body .= "Hi, $ship_firstname $ship_lastname ($email) \n\n";
        $subject = "!!!THIS IS A TEST!!! I Luv Fabrix purchase confirmation ";
      } else {
        $body = "Hi, $ship_firstname $ship_lastname ($email) \n\n";
        $subject = "I Luv Fabrix purchase confirmation ";
      }
      $body = $body . "Thank you for your purchase. The following items will be shipped to you.\n";

      $ma['subject'] = $subject;
      $ma['body'] = $body;

      $ma = $this->prepare_before_pay_mail($ma);
      if(isset($ma)) {
        $subject = $ma['subject'];
        $body = $ma['body'];

        $mailer = App::$app->getMailer();
        if(!empty($email)) {
          $messages[] = $mailer->compose(['text' => 'thanx_mail-text'], ['body' => $body])
            ->setSubject($subject)
            ->setTo([$email])
            ->setReplyTo([App::$app->keyStorage()->system_info_email])
            ->setFrom([App::$app->keyStorage()->system_send_from_email => App::$app->keyStorage()->system_site_name . ' robot']);
        }

        $emails = [
          App::$app->keyStorage()->system_info_email,
          "iluvfabrixsales@gmail.com"
        ];
        if($demo == 1) {
          $emails = ["sergnochevny@studionovi.co"];
        }
        foreach($emails as $email) {
          $messages[] = $mailer->compose(['text' => 'thanx_mail-text'], ['body' => $body])
            ->setSubject($subject)
            ->setTo([$email])
            ->setReplyTo([App::$app->keyStorage()->system_info_email])
            ->setFrom([App::$app->keyStorage()->system_send_from_email => App::$app->keyStorage()->system_site_name . ' robot']);
        }

        if(!empty($messages)) $mailer->sendMultiple($messages);
      }
    }
  }

  /**
   * @param null $ma
   * @return null
   * @throws \Exception
   */
  private function prepare_before_pay_mail($ma = null){
    $shipcost = 0;
    $rollcost = 0;
    $express_samples_cost = 0;
    $total = 0;
    $subject = $ma['subject'];
    $body = $ma['body'];

    $rate_handling = (!is_null(App::$app->keyStorage()->shop_rate_handling) ? App::$app->keyStorage()->shop_rate_handling : RATE_HANDLING);
    $rate_roll = (!is_null(App::$app->keyStorage()->shop_rate_roll) ? App::$app->keyStorage()->shop_rate_roll : RATE_ROLL);
    $samples_price_express_shipping = (!is_null(App::$app->keyStorage()->shop_samples_price_express_shipping) ? App::$app->keyStorage()->shop_samples_price_express_shipping : SAMPLES_PRICE_EXPRESS_SHIPPING);

    if(!is_null(App::$app->session('cart')) && !is_null(App::$app->session('user'))) {

      $user = App::$app->session('user');
      $ship_firstname = $user['ship_firstname'];
      $ship_lastname = $user['ship_lastname'];
      $email = $user['email'];

      $cart_items = isset(App::$app->session('cart')['items']) ? App::$app->session('cart')['items'] : [];
      $cart_samples_items = isset(App::$app->session('cart')['samples_items']) ? App::$app->session('cart')['samples_items'] : [];
      $systemAllowExpressSamples = ModelSamples::systemAllowSamplesExpressShipping();
      $bExpressSamples = !$systemAllowExpressSamples ? false : isset(App::$app->session('cart')['express_samples']) ? App::$app->session('cart')['express_samples'] : false;
      if(count($cart_samples_items) == 0) $bExpressSamples = false;
      $bAcceptExpress = !$systemAllowExpressSamples ? false : isset(App::$app->session('cart')['accept_express']) ? App::$app->session('cart')['accept_express'] : false;
      $uid = (!is_null(App::$app->session('user'))) ? (int)App::$app->session('user')['aid'] : 0;
      $shipping = (isset(App::$app->session('cart')['ship']) && App::$app->session('cart')['ship'] > 0) ? (int)App::$app->session('cart')['ship'] : DEFAULT_SHIPPING;
      $bShipRoll = (isset(App::$app->session('cart')['ship_roll'])) ? (boolean)App::$app->session('cart')['ship_roll'] : false;
      $coupon_code = isset(App::$app->session('cart')['coupon']) ? App::$app->session('cart')['coupon'] : '';
      $discount = 0;
      if(count($cart_items) > 0) {
        foreach($cart_items as $key => $item) {
          $product = ModelShop::get_product_params($key);
          $pname = $product['pname'];
          $pnumber = $product['pnumber'];
          $formatprice = $item['format_sale_price'];
          $qty = $item['quantity'];
          $subtotal = $item['format_subtotal'];
          $body .= "\nName: $pname $pnumber \nPrice: $formatprice  \nQuantity: $qty \nSUB Total: $subtotal\n";
          $discount += $item['discount'];
          $total += $item['subtotal'];
        }
      }

      if(count($cart_samples_items) > 0) {
        foreach($cart_samples_items as $key => $item) {
          $product = ModelShop::get_product_params($key);
          $pname = $product['pname'];
          $pnumber = $product['pnumber'];

          $body .= "\nName: SAMPLE - $pname $pnumber\n";
        }
        $samples_sum = App::$app->session('cart')['samples_sum'];
        $total += $samples_sum;
        $format_samples_sum = App::$app->session('cart')['format_samples_sum'];
        $body .= "SUB Total for samples: $format_samples_sum\n";
      }

      $shipcost = App::$app->session('cart')['shipcost'];
      $shipDiscount = App::$app->session('cart')['ship_discount'];
      $couponDiscount = App::$app->session('cart')['coupon_discount'];

      $body .= sprintf("\nShipping Method: %s\n", $this->get_shipping_name($shipping));
      $body .= "\nShipping:$" . number_format($shipcost, 2) . "\n";

      if((count($cart_items) > 0) && ($bShipRoll)) {
        $rollcost += $rate_roll;
        $body .= "Ship my fabric on a roll: $" . number_format($rollcost, 2) . "\n";
      }

      if((count($cart_samples_items) > 0) && ($bExpressSamples) && !(count($cart_items) > 0)) {
        $express_samples_cost += $samples_price_express_shipping;
        $body .= "Deliver my samples by Overnight Courier: $" . number_format($express_samples_cost, 2) . "\n";
      }
      $total = $total + $shipcost + (isset($rollcost) ? $rollcost : 0) + (isset($express_samples_cost) ? $express_samples_cost : 0);
      $body .= "\nSUB TOTAL with shipping:$" . number_format($total, 2) . "\n";

      $handlingcost = $rate_handling;
      if(count($cart_items) > 0) {
        $body .= "Handling:$" . number_format($handlingcost, 2) . " \n";
      }

      if($shipDiscount > 0) $body .= sprintf("\nShipping Discount:$%s \n", number_format($shipDiscount, 2));
      if($couponDiscount > 0) $body .= sprintf("\nCoupon Redemption: $%01.2f \n", $couponDiscount);
      $discount = $discount + $couponDiscount + $shipDiscount;
      $taxes = App::$app->session('cart')['taxes'];
      if($taxes > 0) $body .= sprintf("\nTaxes: $%01.2f \n", $taxes);
      $total = App::$app->session('cart')['total'];
      $body .= sprintf("\nTotal: $%01.2f \n", $total);
      if($discount > 0) $body .= sprintf("<b>You saved</b>: $%01.2f\n", $discount);

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

      $bill_country = trim(ModelAddress::get_country_by_id($bill_country));
      $bill_province = trim(ModelAddress::get_province_by_id($bill_province));
      $ship_country = trim(ModelAddress::get_country_by_id($ship_country));
      $ship_province = trim(ModelAddress::get_province_by_id($ship_province));

      $trid = App::$app->session('cart')['trid'];
      $trdate = App::$app->session('cart')['trdate'];

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

      $ma['subject'] = $subject;
      $ma['body'] = $body;
    }

    return $ma;
  }

  /**
   *
   * @throws \Exception
   */
  private function prepare(){
    ob_start();
    $cart = App::$app->session('cart');
    unset($cart['discountIds']);
    App::$app->setSession('cart', $cart);
    $this->products_in();
    $cart_items = ob_get_contents();
    ob_end_clean();
    ob_start();
    $this->items_amount();
    $sum_items = ob_get_contents();
    ob_end_clean();
    ob_start();
    $this->samples_amount();
    $sum_samples = ob_get_contents();
    ob_end_clean();
    ob_start();
    $this->samples_legend();
    $cart_samples_legend = ob_get_contents();
    ob_end_clean();
    ob_start();
    $this->samples_in();
    $cart_samples_items = ob_get_contents();
    ob_end_clean();
    ob_start();
    $this->shipping_calc();
    $shipping = ob_get_contents();
    ob_end_clean();
    ob_start();
    $this->coupon_total_calc();
    $coupon_total = ob_get_contents();
    ob_end_clean();
    $this->main->template->vars('cart_items', $cart_items);
    $this->main->template->vars('sum_items', $sum_items);
    $this->main->template->vars('sum_samples', $sum_samples);
    $this->main->template->vars('cart_samples_legend', $cart_samples_legend);
    $this->main->template->vars('cart_samples_items', $cart_samples_items);
    $this->main->template->vars('shipping', $shipping);
    $this->main->template->vars('coupon_total', $coupon_total);
  }

  /**
   *
   * @throws \Exception
   */
  private function shipping_proceed_calc(){
    $bCodeValid = false;
    $unused = '';
    $shipcost = 0;
    $rollcost = 0;
    $express_samples_cost = 0;
    $total = 0;
    $aPrds = [];

    $rate_roll = (!is_null(App::$app->keyStorage()->shop_rate_roll) ? App::$app->keyStorage()->shop_rate_roll : RATE_ROLL);
    $samples_price_express_shipping = (!is_null(App::$app->keyStorage()->shop_samples_price_express_shipping) ? App::$app->keyStorage()->shop_samples_price_express_shipping : SAMPLES_PRICE_EXPRESS_SHIPPING);

    $cart = App::$app->session('cart');
    $cart_items = isset($cart['items']) ? $cart['items'] : [];
    $cart_samples_items = isset($cart['samples_items']) ? $cart['samples_items'] : [];
    $coupon_code = isset($cart['coupon']) ? $cart['coupon'] : '';
    $systemAllowExpressSamples = ModelSamples::systemAllowSamplesExpressShipping();
    $bExpressSamples = isset($cart['express_samples']) ? $cart['express_samples'] : false;
    if(!$systemAllowExpressSamples) {
      $bExpressSamples = false;
    }
    if(count($cart_samples_items) == 0) $bExpressSamples = false;

    $bAcceptExpress = !$systemAllowExpressSamples ? false : isset($cart['accept_express']) ? $cart['accept_express'] : false;
    $uid = !is_null(App::$app->session('user')) ? (int)App::$app->session('user')['aid'] : 0;
    $shipping = (isset($cart['ship']) && $cart['ship'] > 0) ? (int)$cart['ship'] : DEFAULT_SHIPPING;
    $bShipRoll = isset($cart['ship_roll']) ? (boolean)$cart['ship_roll'] : false;
    $total_items = $this->calc_items_amount();
    $total += $total_items;
    $total_samples_items = $this->calc_samples_amount();
    $total += $total_samples_items;
    $shipcost = $cart['shipcost'];
    if(count($cart_items) > 0) {

      foreach($cart_items as $key => $item) {
        $aPrds[] = $key;
        $aPrds[] = $item['quantity'];
      }

      #calculate the discount
      if(count($aPrds) > 0) {
        $discountIds = isset($cart['discountIds']) ? $cart['discountIds'] : [];
        $shipDiscount = round(ModelPrice::calculateDiscount(DISCOUNT_CATEGORY_SHIPPING, $uid, $aPrds, $total, $shipcost, $coupon_code, $bCodeValid, false, $unused, $unused, $shipping, $discountIds), 2);
        $couponDiscount = round(ModelPrice::calculateDiscount(DISCOUNT_CATEGORY_COUPON, $uid, $aPrds, $total, $shipcost, $coupon_code, $bCodeValid, false, $unused, $unused, $shipping, $discountIds), 2);
        $cart['discountIds'] = $discountIds;
      }
    }
    if((count($cart_items) > 0) && ($bShipRoll)) {
      $rollcost += $rate_roll;
    }
    if((count($cart_samples_items) > 0) && ($bExpressSamples) && !(count($cart_items) > 0)) {
      $express_samples_cost += $samples_price_express_shipping;
    }
    $total = $total + $shipcost + (isset($rollcost) ? $rollcost : 0) + (isset($express_samples_cost) ? $express_samples_cost : 0);

    App::$app->setSession('cart', $cart);

    if((count($cart_items) > 0) || (count($cart_samples_items) > 0)) {
      $this->template->vars('shipping', $shipping);
      $this->template->vars('bShipRoll', $bShipRoll);
      $this->template->vars('rollcost', $rollcost);
      $this->template->vars('cart_samples_items', $cart_samples_items);
      $this->template->vars('cart_items', $cart_items);
      $this->template->vars('bExpressSamples', $bExpressSamples);
      $this->template->vars('express_samples_cost', $express_samples_cost);
      $this->template->vars('total', $total);
      $this->template->vars('shipcost', $shipcost);
      $this->template->view_layout('ship_in_proceed');
    }
  }

  /**
   * @return float|int
   */
  private function calc_items_amount(){
//      session_destroy();
//      unset($_SESSION);
    $cart_items = isset(App::$app->session('cart')['items']) ? App::$app->session('cart')['items'] : [];
    $SUM = 0;
    foreach($cart_items as $key => $item) {
      if(!empty($key)) {
        $SUM += round($item['quantity'] * $item['saleprice'], 2);
      }
    }

    return $SUM;
  }

  /**
   *
   * @throws \Exception
   */
  private function total_proceed_calc(){
    $bCodeValid = false;
    $unused = '';
    $shipDiscount = 0;
    $shipcost = 0;
    $total = 0;
    $couponDiscount = 0;
    $aPrds = [];

    $rate_handling = (!is_null(App::$app->keyStorage()->shop_rate_handling) ? App::$app->keyStorage()->shop_rate_handling : RATE_HANDLING);
    $rate_roll = (!is_null(App::$app->keyStorage()->shop_rate_roll) ? App::$app->keyStorage()->shop_rate_roll : RATE_ROLL);
    $samples_price_express_shipping = (!is_null(App::$app->keyStorage()->shop_samples_price_express_shipping) ? App::$app->keyStorage()->shop_samples_price_express_shipping : SAMPLES_PRICE_EXPRESS_SHIPPING);

    $cart = App::$app->session('cart');
    $cart_items = isset($cart['items']) ? $cart['items'] : [];
    $cart_samples_items = isset($cart['samples_items']) ? $cart['samples_items'] : [];
    $coupon_code = isset($cart['coupon']) ? $cart['coupon'] : '';
    $systemAllowExpressSamples = ModelSamples::systemAllowSamplesExpressShipping();
    $bExpressSamples = !$systemAllowExpressSamples ? false : isset($cart['express_samples']) ? App::$app->session('cart')['express_samples'] : false;
    if(count($cart_samples_items) == 0) $bExpressSamples = false;
    $bAcceptExpress = !$systemAllowExpressSamples ? false : isset($cart['accept_express']) ? App::$app->session('cart')['accept_express'] : false;
    $uid = (!is_null(App::$app->session('user'))) ? (int)App::$app->session('user')['aid'] : 0;
    $shipping = (isset($cart['ship']) && $cart['ship'] > 0) ? (int)App::$app->session('cart')['ship'] : DEFAULT_SHIPPING;
    $bShipRoll = (isset($cart['ship_roll'])) ? (boolean)$cart['ship_roll'] : false;
    $total_items = $this->calc_items_amount();
    $total += $total_items;
    $total_samples_items = $this->calc_samples_amount();
    $total += $total_samples_items;
    $discount = $this->calc_items_discount_amount();
    $shipcost = $cart['shipcost'];
    $shipDiscount = $cart['ship_discount'];
    $couponDiscount = $cart['coupon_discount'];

    if((count($cart_items) > 0) && ($bShipRoll)) $shipcost += $rate_roll;
    if((count($cart_samples_items) > 0) && ($bExpressSamples) && !(count($cart_items) > 0)) $shipcost += $samples_price_express_shipping;
    $handlingcost = 0;
    if(count($cart_items) > 0) {
      $handlingcost = $rate_handling;
      $total += $handlingcost;
    }
    $total = $total + $shipcost;
    if($shipDiscount > 0) $total = round($total - $shipDiscount, 2);
    if($couponDiscount > 0) $total = $total - $couponDiscount;
    $discount = $discount + $couponDiscount + $shipDiscount;
    $cart['total'] = $total;
    App::$app->setSession('cart', $cart);
    $taxes = App::$app->session('cart')['taxes'];

    $this->template->vars('cart_items', $cart_items);
    $this->template->vars('cart_samples_items', $cart_samples_items);
    $this->template->vars('handlingcost', $handlingcost);
    $this->template->vars('shipDiscount', $shipDiscount);
    $this->template->vars('couponDiscount', $couponDiscount);
    $this->template->vars('taxes', $taxes);
    $this->template->vars('total', $total);
    $this->template->vars('discount', $discount);
    $this->template->view_layout('total_in_proceed');
  }

  /**
   * @return float|int
   */
  private function calc_items_discount_amount(){
    $cart_items = isset(App::$app->session('cart')['items']) ? App::$app->session('cart')['items'] : [];
    $SUM = 0;
    foreach($cart_items as $key => $item) $SUM += round($item['quantity'] * $item['discount'], 2);

    return $SUM;
  }

  /**
   * @param $type
   * @return string
   */
  private function get_shipping_name($type){
    $ret = 'Shipping Type Not Found';
    switch($type) {
      case 1:
        $ret = 'Express Post';
        break;
      case 3:
        $ret = 'Ground Ship';
        break;
    }

    return $ret;
  }

  /**
   *
   * @throws \Exception
   */
  protected function proceed_checkout_prepare(){
    $prms = null;
    $back_url = App::$app->router()
      ->UrlTo('cart');
    $this->main->template->vars('back_url', $back_url);
    ob_start();
    $this->products_in('product_in_proceed');
    $cart_items = ob_get_contents();
    ob_end_clean();
    ob_start();
    $this->samples_in('sample_in_proceed');
    $cart_samples_items = ob_get_contents();
    ob_end_clean();
    ob_start();
    $this->samples_amount();
    $sum_samples = ob_get_contents();
    ob_end_clean();
    ob_start();
    $this->shipping_proceed_calc();
    $shipping = ob_get_contents();
    ob_end_clean();
    ob_start();
    $this->total_proceed_calc();
    $total_proceed = ob_get_contents();
    ob_end_clean();
    ob_start();
    $this->proceed_bill_ship();
    $bill_ship_info = ob_get_contents();
    ob_end_clean();
    $back_url = App::$app->router()
      ->UrlTo('cart', ['proceed' => 1]);

    $prms['url'] = urlencode(base64_encode($back_url));
    $change_user_url = App::$app->router()
      ->UrlTo('user/change', $prms);

    $this->main->template->vars('cart_items', $cart_items);
    $this->main->template->vars('cart_samples_items', $cart_samples_items);
    $this->main->template->vars('sum_samples', $sum_samples);
    $this->main->template->vars('shipping', $shipping);
    $this->main->template->vars('total_proceed', $total_proceed);
    $this->main->template->vars('bill_ship_info', $bill_ship_info);
    $this->main->template->vars('change_user_url', $change_user_url);
  }

  /**
   * @export
   * @throws \Exception
   */
  public function cart(){
    $this->main->is_user_authorized(true);
    if(!is_null(App::$app->get('proceed'))) {
      $this->proceed_checkout_prepare();
      $this->main->template->vars('content', $this->template->view_layout_return('proceed_checkout'));
    } elseif(!is_null(App::$app->get('pay_ok'))) {
      $this->pay_ok();
      $this->main->template->vars('content', $this->template->view_layout_return('pay_ok'));
    } elseif(!is_null(App::$app->get('pay_error'))) {
      $this->main->template->vars('content', $this->template->view_layout_return('pay_error'));
    } else {
      $this->prepare();
      $this->main->template->vars('content', $this->template->view_layout_return('cart'));
    }
    $this->main->view('container');
  }

  /**
   * @export
   */
  public function samples_amount(){
    $this->calc_samples_amount();
    $format_samples_sum = App::$app->session('cart')['format_samples_sum'];
    echo $format_samples_sum;
  }

  /**
   * @export
   */
  public function calc_samples_amount(){
    $cart_items = isset(App::$app->session('cart')['items']) ? App::$app->session('cart')['items'] : [];
    $cart_samples_items = isset(App::$app->session('cart')['samples_items']) ? App::$app->session('cart')['samples_items'] : [];
    $cart_samples_sum = round(ModelSamples::calculateSamplesPrice($cart_items, $cart_samples_items), 2);
    $format_samples_sum = "$" . number_format($cart_samples_sum, 2);
    $_cart = App::$app->session('cart');
    $_cart['samples_sum'] = $cart_samples_sum;
    $_cart['format_samples_sum'] = $format_samples_sum;
    App::$app->setSession('cart', $_cart);

    return $cart_samples_sum;
  }

  /**
   * @export
   */
  public function items_amount(){
    $SUM = $this->calc_items_amount();
    $cart_items_sum = "$" . number_format($SUM, 2);
    echo $cart_items_sum;
  }

  /**
   * @export
   * @throws \Exception
   */
  function samples_legend(){
    if(isset(App::$app->session('cart')['items']) && (count(App::$app->session('cart')['items']) > 0)) {
      $this->template->vars('cart_items', '_');
    }
    $this->template->view_layout('samples_legend');
  }

  /**
   * @export
   * @throws \Exception
   */
  public function shipping_calc(){
    $bCodeValid = false;
    $unused = '';
    $shipDiscount = 0;
    $shipcost = 0;
    $total = 0;
    $couponDiscount = 0;
    $aPrds = [];

    $rate_handling = (!is_null(App::$app->keyStorage()->shop_rate_handling) ? App::$app->keyStorage()->shop_rate_handling : RATE_HANDLING);
    $rate_roll = (!is_null(App::$app->keyStorage()->shop_rate_roll) ? App::$app->keyStorage()->shop_rate_roll : RATE_ROLL);
    $samples_price_express_shipping = (!is_null(App::$app->keyStorage()->shop_samples_price_express_shipping) ? App::$app->keyStorage()->shop_samples_price_express_shipping : SAMPLES_PRICE_EXPRESS_SHIPPING);

    $cart = App::$app->session('cart');
    $cart_samples_items = isset($cart['samples_items']) ? $cart['samples_items'] : [];
    $coupon_code = isset($cart['coupon']) ? $cart['coupon'] : '';
    $coupon_code = !is_null(App::$app->post('coupon')) ? App::$app->post('coupon') : $coupon_code;
    $cart['coupon'] = $coupon_code;
    $systemAllowExpressSamples = ModelSamples::systemAllowSamplesExpressShipping();
    $bExpressSamples = isset($cart['express_samples']) ? $cart['express_samples'] : false;
    if($systemAllowExpressSamples) {
      if(!is_null(App::$app->post('express_samples'))) {
        $bExpressSamples = (int)App::$app->post('express_samples') == 1;
      }
    } else $bExpressSamples = false;
    if(count($cart_samples_items) == 0) $bExpressSamples = false;
    $cart['express_samples'] = $bExpressSamples;

    $bAcceptExpress = isset($cart['accept_express']) ? $cart['accept_express'] : false;
    if($systemAllowExpressSamples) {
      if(!is_null(App::$app->post('accept_express'))) {
        $bAcceptExpress = App::$app->post('accept_express') == 1;
      }
    } else $bAcceptExpress = false;
    $cart['accept_express'] = $bAcceptExpress;
    if(!is_null(App::$app->post('ship'))) {
      $cart['ship'] = App::$app->post('ship');
    }

    if(!is_null(App::$app->post('roll'))) {
      $cart['ship_roll'] = App::$app->post('roll');
    }
    $cart_items = isset($cart['items']) ? $cart['items'] : [];
    $uid = !is_null(App::$app->session('user')) ? (int)App::$app->session('user')['aid'] : 0;
    if(isset($cart['ship']) && $cart['ship'] > 0) {
      $shipping = (int)$cart['ship'];
    } else {
      $shipping = DEFAULT_SHIPPING;
      $cart['ship'] = $shipping;
    }
    if(isset($cart['ship_roll'])) {
      $bShipRoll = (boolean)$cart['ship_roll'];
    } else {
      $bShipRoll = false;
      $cart['ship_roll'] = 0;
    }

    $total_items = $this->calc_items_amount();
    $total += $total_items;
    $total_samples_items = $this->calc_samples_amount();
    $total += $total_samples_items;

    $cart_sum = "$" . number_format($total, 2);
    $this->template->vars('sum_all_items', $cart_sum);

    if(count($cart_items) > 0) {
      foreach($cart_items as $key => $item) {
        if(!empty($key)) {
          $aPrds[] = $key;
          $aPrds[] = $item['quantity'];
        }
      }
      $shipcost = round(ModelShipping::calculateShipping($shipping, $aPrds, $bShipRoll), 2);
      if(count($aPrds) > 0) {
        $discountIds = isset($cart['discountIds']) ? $cart['discountIds'] : [];
        $shipDiscount = round(ModelPrice::calculateDiscount(DISCOUNT_CATEGORY_SHIPPING, $uid, $aPrds, $total, $shipcost, $coupon_code, $bCodeValid, false, $unused, $unused, $shipping, $discountIds), 2);
        $couponDiscount = round(ModelPrice::calculateDiscount(DISCOUNT_CATEGORY_COUPON, $uid, $aPrds, $total, $shipcost, $coupon_code, $bCodeValid, false, $unused, $unused, $shipping, $discountIds), 2);
        $cart['discountIds'] = $discountIds;
      }
    }
    $cart['shipcost'] = $shipcost;
    $cart['ship_discount'] = $shipDiscount;
    $cart['coupon_discount'] = $couponDiscount;

    if((count($cart_items) > 0) && ($bShipRoll)) $shipcost += $rate_roll;
    if((count($cart_samples_items) > 0) && ($bExpressSamples) && !(count($cart_items) > 0)) $shipcost += $samples_price_express_shipping;
    if(count($cart_items) > 0) $total += $rate_handling;
    $total = $total + $shipcost;
    if($shipDiscount > 0) $total = round($total - $shipDiscount, 2);
    $cart['subtotal_ship'] = $total;
    $this->template->vars('subtotal_ship', $total);
    if($couponDiscount > 0) $total = $total - $couponDiscount;
    $taxes = 0;
    if($uid > 0) {
      $tax_percentage = ModelPrice::user_TaxRate($uid);
      $taxes = round($total * ($tax_percentage / 100), 2);
      $total = round(($total + $taxes), 2);
    }

    $cart['taxes'] = $taxes;
    $cart['total'] = $total;
    App::$app->setSession('cart', $cart);

    $this->template->vars('taxes', $taxes);
    $this->template->vars('total', $total);
    $this->template->vars('coupon_discount', $couponDiscount);
    $this->template->vars('shipping', $shipping);
    $this->template->vars('bShipRoll', $bShipRoll);
    $this->template->vars('cart_samples_items', $cart_samples_items);
    $this->template->vars('cart_items', $cart_items);
    $this->template->vars('bExpressSamples', $bExpressSamples);
    $this->template->vars('total', $total);
    $this->template->vars('systemAllowExpressSamples', $systemAllowExpressSamples);
    $this->template->vars('bAcceptExpress', $bAcceptExpress);
    $this->template->vars('shipDiscount', $shipDiscount);
    $this->template->vars('shipcost', $shipcost);
    if(count($cart_items) > 0) {
      $this->template->view_layout('shipping');
    } else {
      if(count($cart_samples_items) > 0) {
        $this->template->view_layout('shipping_samples');
      }
    }
  }

  /**
   * @export
   * @throws \Exception
   */
  public function coupon_total_calc(){
    $cart_items = isset(App::$app->session('cart')['items']) ? App::$app->session('cart')['items'] : [];
    $cart_samples_items = isset(App::$app->session('cart')['samples_items']) ? App::$app->session('cart')['samples_items'] : [];
    $total = App::$app->session('cart')['total'];
    $coupon_discount = App::$app->session('cart')['coupon_discount'];
    $taxes = App::$app->session('cart')['taxes'];
    $coupon_code = isset(App::$app->session('cart')['coupon']) ? App::$app->session('cart')['coupon'] : '';
    $uid = (!is_null(App::$app->session('user'))) ? (int)App::$app->session('user')['aid'] : 0;

    if((count($cart_items) > 0) || (count($cart_samples_items) > 0)) {
      $this->template->vars('taxes', $taxes);
      $this->template->vars('total', $total);
      $this->template->vars('coupon_discount', $coupon_discount);
      $this->template->vars('cart_samples_items', $cart_samples_items);
      $this->template->vars('cart_items', $cart_items);
      $this->template->vars('total', $total);
      $this->template->vars('coupon_code', $coupon_code);
      $this->template->vars('uid', $uid);
      $this->template->view_layout('coupon_total');
    }
  }

  /**
   * @export
   * @throws \Exception
   */
  public function pay_mail(){
    if(!is_null(App::$app->session('cart')) && !is_null(App::$app->session('user'))) {

      $demo = (!is_null(App::$app->keyStorage()->system_demo) ? App::$app->keyStorage()->system_demo : DEMO);

      $user = App::$app->session('user');
      $email = trim($user['email']);
      $ship_firstname = trim($user['ship_firstname']);
      $ship_lastname = trim($user['ship_lastname']);

      if($demo == 1) {
        $body = "                !!!THIS IS A TEST!!!                  \n\n";
        $body .= "This email message was generated when $ship_firstname $ship_lastname ($email) viewed the confirmation page. At this point the transaction was not concluded.\n\n";
        $subject = "!!!THIS IS A TEST!!! I Luv Fabrix purchase confirmation ";
      } else {
        $body = "This email message was generated when $ship_firstname $ship_lastname ($email) viewed the confirmation page. At this point the transaction was not concluded.\n\n";
        $subject = "I Luv Fabrix purchase confirmation ";
      }

      $body = $body . "\n";
      $ma['subject'] = $subject;
      $ma['body'] = $body;

      $ma = $this->prepare_before_pay_mail($ma);
      if(isset($ma)) {
        $subject = $ma['subject'];
        $body = $ma['body'];

        $mailer = App::$app->getMailer();
        $emails = [
          App::$app->keyStorage()->system_info_email,
          "lanny1952@gmail.com",
          "iluvfabrixsales@gmail.com"
        ];
        if($demo == 1) {
          $emails = ["sergnochevny@studionovi.co"];
        }
        foreach($emails as $email) {
          $messages[] = $mailer->compose(['text' => 'thanx_mail-text'], ['body' => $body])
            ->setSubject($subject)
            ->setTo([$email])
            ->setReplyTo([App::$app->keyStorage()->system_info_email])
            ->setFrom([App::$app->keyStorage()->system_send_from_email => App::$app->keyStorage()->system_site_name . ' robot']);
        }

        if(!empty($messages)) $mailer->sendMultiple($messages);
      }
    }
  }

  /**
   * @export
   * @throws \Exception
   */
  public function proceed_checkout(){
    $this->proceed_checkout_prepare();
    $this->main->view_layout('proceed_checkout');
  }

  /**
   * @export
   * @throws \Exception
   */
  public function proceed_agreem(){
    $paypal_business = App::$app->keyStorage()->paypal_business;
    $paypal_url = App::$app->keyStorage()->paypal_url;
    if(!empty($paypal_business) && !empty($paypal_url)) {
      $prms = null;
      $back_url = App::$app->router()
        ->UrlTo('cart', ['proceed' => true]);
      $this->template->vars('back_url', $back_url);
      $total = App::$app->session('cart')['total'];
      $this->template->vars('total', $total);

      $user = App::$app->session('user');
      $email = trim($user['email']);
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

      if(!empty($bill_postal)) {
        $this->template->vars('email', $email);
        $this->template->vars('bill_firstname', $bill_firstname);
        $this->template->vars('bill_lastname', $bill_lastname);
        $this->template->vars('bill_organization', $bill_organization);
        $this->template->vars('bill_address1', $bill_address1);
        $this->template->vars('bill_address2', $bill_address2);
        $this->template->vars('bill_city', $bill_city);
        $this->template->vars('bill_postal', $bill_postal);
        $this->template->vars('bill_phone', $bill_phone);
        $bill_country = trim(ModelAddress::get_country_by_id($bill_country));
        $this->template->vars('bill_country', $bill_country);
        $bill_province = trim(ModelAddress::get_province_by_id($bill_province));
        $this->template->vars('bill_province', $bill_province);

        $trid = uniqid();
        $cart = App::$app->session('cart');
        $cart['trid'] = $trid;
        $cart['trdate'] = date('Y-m-d H:i');
        App::$app->setSession('cart', $cart);

//        if(DEMO == 1) {
//          $paypal['business'] = "sergnochevny-facilitator@gmail.com";
//          $paypal['url'] = "https://www.sandbox.paypal.com/cgi-bin/webscr";
//        } else {
//          $paypal['business'] = "info@iluvfabrix.com";
//          $paypal['url'] = "https://www.paypal.com/cgi-bin/webscr";
//        }
        $paypal['business'] = $paypal_business;
        $paypal['url'] = $paypal_url;

        $paypal['cmd'] = "_xclick";
        $paypal['image_url'] = App::$app->router()
          ->UrlTo('/');
        $paypal['return'] = App::$app->router()
          ->UrlTo('cart', ['pay_ok' => true, 'trid' => $trid]);
        $paypal['cancel_return'] = App::$app->router()
          ->UrlTo("cart", ['pay_error' => true]);
        $paypal['notify_url'] = App::$app->router()
          ->UrlTo("ipn", ['pay_notify' => session_id()]);
        $paypal['rm'] = "1";
        $paypal['currency_code'] = "USD";
        $paypal['lc'] = "US";
        $paypal['bn'] = "toolkit-php";

        $this->main->template->vars('paypal', $paypal);
        $this->main->view_layout('proceed_agreem');
      } else {
        $this->template->vars('error', ['Fill in the Billing and Shipping Information!']);
        $this->proceed_checkout();
      }
    } else {
      $this->template->vars('error', ['Please contact the administrator - must fill in the paypal account information!']);
      $this->proceed_checkout();
    }
  }

  /**
   * @export
   */
  public function get_subtotal_ship(){
    $total = 0;
    if(isset(App::$app->session('cart')['subtotal_ship'])) {
      $total = App::$app->session('cart')['subtotal_ship'];
    }
    echo '$' . number_format($total, 2) . ' USD';
  }

  /**
   * @export
   */
  public function amount(){

    $SUM = 0;
    $SUM += $this->calc_items_amount();
    $SUM += $this->calc_samples_amount();

    $cart_sum = "$" . number_format($SUM, 2);
    $this->template->vars('sum_all_items', $cart_sum);

    echo $cart_sum;
  }

  /**
   * @export
   * @throws \Exception
   */
  function add(){
    if(!empty(App::$app->get('pid'))) {
      $pid = ModelShop::sanitize(App::$app->get('pid'));
      $product = ModelShop::get_product_params($pid);
      $_cart = App::$app->session('cart');
      $cart_items = isset($_cart['items']) ? $_cart['items'] : [];
      if($product['inventory'] > 0) {

        $item_added = false;
        if(count($cart_items) > 0) {
          foreach($cart_items as $key => $item) {
            if($item['pid'] == $pid) {
              $cart_items[$key]['quantity'] += 1;
              $item_added = true;
            }
          }
        }

        if(!$item_added) {

          $pid = $pid;
          $price = $product['price'];
          $inventory = $product['inventory'];
          $piece = $product['piece'];
          $format_price = '';
          $price = ModelPrice::getPrintPrice($price, $format_price, $inventory, $piece);

          $discountIds = isset(App::$app->session('cart')['discountIds']) ? App::$app->session('cart')['discountIds'] : [];
          $saleprice = $product['price'];
          $sDiscount = 0;
          $saleprice = round(ModelPrice::calculateProductSalePrice($pid, $saleprice, $discountIds), 2);
          $bProductDiscount = ModelPrice::checkProductDiscount($pid, $sDiscount, $saleprice, $discountIds);
          $_cart['discountIds'] = $discountIds;
          $format_sale_price = '';
          $saleprice = round(ModelPrice::getPrintPrice($saleprice, $format_sale_price, $inventory, $piece), 2);
          $discount = round(($price - $saleprice), 2);
          $format_discount = "$" . number_format($discount, 2);

          $product['price'] = $price;
          $product['saleprice'] = $saleprice;
          $product['discount'] = $discount;
          $product['format_discount'] = $format_discount;
          $product['format_price'] = $format_price;
          $product['format_sale_price'] = $format_sale_price;
          $t_pr = round($product['quantity'] * $product['saleprice'], 2);
          $product['subtotal'] = $t_pr;
          $t_pr = "$" . number_format($t_pr, 2);
          $product['format_subtotal'] = $t_pr;

          $cart_items[$product['pid']] = $product;
        }

        $_cart['items'] = $cart_items;
        App::$app->setSession('cart', $_cart);

        $SUM = 0;
        $SUM += $this->calc_items_amount();
        $SUM += $this->calc_samples_amount();

        $cart_sum = "$" . number_format($SUM, 2);
        $this->template->vars('SUM', $cart_sum);

        $message = 'This Fabric has been added to your Cart.<br>Click the Cart to view your Order.';
        $message .= '<br>Subtotal sum of cart is ' . $cart_sum;
        $this->template->vars('message', $message);
        $msg = $this->template->view_layout_return('msg_add');
        $button = $this->template->view_layout_return('basket');
        exit(json_encode(['msg' => $msg, 'button' => $button, 'sum' => $cart_sum]));
      } else {

        $SUM = 0;
        $SUM += $this->calc_items_amount();
        $SUM += $this->calc_samples_amount();

        $cart_sum = "$" . number_format($SUM, 2);
        $this->template->vars('SUM', $cart_sum);

        $message = 'The product ' . $product['pname'] . ' is unavailable. The product was not added.<br>';
        $message .= '<br>Subtotal sum of cart is ' . $cart_sum;
        $this->template->vars('message', $message);
        $msg = $this->template->view_layout_return('msg_add');
        exit(json_encode(['msg' => $msg, 'sum' => $cart_sum]));
      }
    }
  }

  /**
   * @export
   * @throws \Exception
   */
  function add_samples(){
    if(!empty(App::$app->get('pid'))) {
      $pid = ModelShop::sanitize(App::$app->get('pid'));
      $product = ModelShop::get_product_params($pid);
      $cart = App::$app->session('cart');
      $cart_items = isset($cart['items']) ? $cart['items'] : [];
      $cart_samples_items = isset($cart['samples_items']) ? $cart['samples_items'] : [];
      if($product['inventory'] > 0) {

        $item_added = false;
        if(count($cart_samples_items) > 0 && isset($cart_samples_items[$pid])) {
          $item_added = true;
        }

        if(!$item_added) {

          $cart_samples_items[$product['pid']] = $product;
          $cart_samples_sum = round(ModelSamples::calculateSamplesPrice($cart_items, $cart_samples_items), 2);

          $format_samples_sum = '';
          $tmp = ModelPrice::getPrintPrice($cart_samples_sum, $format_samples_sum, 1, 1);
          $cart['samples_sum'] = $cart_samples_sum;
          $cart['format_samples_sum'] = $format_samples_sum;
        }

        $cart['samples_items'] = $cart_samples_items;
        App::$app->setSession('cart', $cart);

        $SUM = 0;
        $SUM += $this->calc_items_amount();
        $SUM += $this->calc_samples_amount();

        $cart_sum = "$" . number_format($SUM, 2);
        $this->template->vars('SUM', $cart_sum);

        $message = 'This Samples has been added to your Cart.<br>Click the Cart to view your Order.';
        $message .= '<br>Subtotal sum of cart is ' . $cart_sum;
        $this->template->vars('message', $message);
        $msg = $this->template->view_layout_return('msg_add');
        $button = $this->template->view_layout_return('basket');
        $res = json_encode(['msg' => $msg, 'button' => $button, 'sum' => $cart_sum]);
        echo $res;
      } else {

        $SUM = 0;
        $SUM += $this->calc_items_amount();
        $SUM += $this->calc_samples_amount();

        $cart_sum = "$" . number_format($SUM, 2);
        $this->template->vars('SUM', $cart_sum);

        $message = 'The product ' . $product['pname'] . ' is unavailable. The product was not added.<br>';
        $message .= '<br>Subtotal sum of cart is ' . $cart_sum;
        $this->template->vars('message', $message);
        $msg = $this->template->view_layout_return('masg_add');
        $res = json_encode(['msg' => $msg, 'sum' => $cart_sum]);
        echo $res;
      }
    }
  }

  /**
   *
   */
  public function get(){
    $cart_items = isset(App::$app->get('cart')['items']) ? App::$app->get('cart')['items'] : [];
    $SUM = 0;
    $SUM += $this->calc_items_amount();
    $SUM += $this->calc_samples_amount();

    $SUM = "$" . number_format($SUM, 2);
    $this->template->vars('SUM', $SUM);
    $this->template->vars('cart_items', $cart_items);
  }

  /**
   * @export
   * @throws \Exception
   */
  public function change_product(){
    $pid = App::$app->get('pid');
    $quantity = App::$app->get('qnt');
    $response = [];
    $cart_items = isset(App::$app->session('cart')['items']) ? App::$app->session('cart')['items'] : [];
    if(preg_match('/^\d+(\.\d{0,})?$/', $quantity)) {

      $product = ModelShop::get_product_params($pid);
      $inventory = $product['inventory'];
      $piece = $product['piece'];
      $whole = $product['whole'];

      if(isset($cart_items[$pid])) {

        if(($quantity > 0) && (floor($quantity) != $quantity) && ($whole == 1)) {
          if($quantity < 1) {
            $quantity = 1;
          } else {
            $quantity = floor($quantity);
          }
          $message = 'The quantity for ' . $product['pname'] . ' must be a whole number. The order was adjusted.<br>';
          $this->template->vars('message', $message);
          $response['msg'] = $this->template->view_layout_return('msg_change');
        }

        if($piece == 0) {
          if($inventory >= $quantity) {
            $cart_items[$pid]['quantity'] = $quantity;
          } else {
            $cart_items[$pid]['quantity'] = $inventory;
            $message = 'The available inventory for ' . $cart_items[$pid]['pname'] . ' is ' . $inventory . '. The order was adjusted.<br>';
            $this->template->vars('message', $message);
            $response['msg'] = $this->template->view_layout_return('msg_change');
          }
        }
      }
    } else {
      $message = 'The quantity must be a positive number. The order was adjusted.<br>';
      $this->template->vars('message', $message);
      $response['msg'] = $this->template->view_layout_return('msg_change');
    }

    $item = $cart_items[$pid];
    ob_start();
    $this->product_in($pid, $item);
    $response['product'] = ob_get_contents();
    ob_end_clean();
    $cart_items[$pid] = $item;
    $_cart = App::$app->session('cart');
    $_cart['items'] = $cart_items;
    App::$app->setSession('cart', $_cart);

    echo json_encode($response);
  }

  /**
   * @export
   */
  public function del_product(){
    if(!is_null(App::$app->get('pid'))) {

      $pid = App::$app->get('pid');
      $cart_items = isset(App::$app->session('cart')['items']) ? App::$app->session('cart')['items'] : [];
      if(isset($cart_items[$pid])) {
        unset($cart_items[$pid]);

        $_cart = App::$app->session('cart');
        $_cart['items'] = $cart_items;
        App::$app->setSession('cart', $_cart);
      }
      $this->calc_items_amount();
      $this->calc_samples_amount();
    }
  }

  /**
   * @export
   */
  public function del_sample(){
    if(!is_null(App::$app->get('pid'))) {
      $pid = App::$app->get('pid');
      $cart_samples_items = isset(App::$app->session('cart')['samples_items']) ? App::$app->session('cart')['samples_items'] : [];
      if(isset($cart_samples_items[$pid])) {
        unset($cart_samples_items[$pid]);
        $_cart = App::$app->session('cart');
        $_cart['samples_items'] = $cart_samples_items;
        App::$app->setSession('cart', $_cart);
      }
      $this->calc_items_amount();
      $this->calc_samples_amount();
    }
  }
}