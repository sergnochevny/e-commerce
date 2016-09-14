<?php

class Controller_Matches extends Controller_Base
{

    function matches()
    {
        $base_url = _A_::$app->router()->UrlTo('/');
        $matches = null;
        if (!is_null(_A_::$app->session('matches')['items'])) {
            $matches_items = _A_::$app->session('matches')['items'];
            if (count($matches_items) > 0) {
                ob_start();
                $left = 2; $top = 2;
                foreach ($matches_items as $key => $item) {
                    $product_id = $item['p_id'];
                    $img = _A_::$app->router()->UrlTo('upload/upload/' . $item['img']);
                    include('views/matches/matches_item.php');
                    $left += 6; $top += 4;
                }
                $matches = ob_get_contents();
                ob_end_clean();
            }
        }

        $this->template->vars('matches_items', $matches);
        $this->main->view('matches/matches');
    }

    function add()
    {
        $added = 0;
        $model = new Model_Product();

        if (!is_null(_A_::$app->get('p_id')) && !empty(_A_::$app->get('p_id'))) {
            $p_id = _A_::$app->get('p_id');
            if (!is_null(_A_::$app->session('matches')['items'])) {
                $matches_items = _A_::$app->session('matches')['items'];
            } else {
                $matches_items = [];
            }

            $item_added = false;
            if (count($matches_items) > 0) {
                foreach ($matches_items as $key => $item) {
                    if ($item['p_id'] == $p_id) {
                        $item_added = true;
                    }
                }
            }

            if (!$item_added) {
                $suffix_img = 'b_';
                $images = $model->getImage($p_id);

                if (isset($images['image1'])){
                    $file_img = 'upload/upload/'.$images['image1'];
                    if (file_exists($file_img) && is_file($file_img)) {
                        $images['image1'] = $suffix_img . $images['image1'];
                        $matches_items[] = ['p_id' => $p_id, 'img' => $images['image1']];
                    }
                }
            }
            $_matches = _A_::$app->get('matches');
            $_matches['items'] = $matches_items;
            _A_::$app->get('matches', $_matches);

            $message = 'This Fabric has been added to your Matches.<br>Click the Matches to view your list.';
            $added = 1;
        } else
            $message = 'Error with added fabric to Matches.';
        $this->template->vars('message',$message);

        ob_start();
        $this->main->view_layout('msgs/msg_add_matches');
        $data = ob_get_contents();
        ob_end_clean();
        echo json_encode(['data' => $data, 'added' => $added]);
    }

    function del()
    {

        if (!is_null(_A_::$app->post('p_id')) && !empty(_A_::$app->post('p_id'))) {
            $p_id = _A_::$app->post('p_id');
            if (!is_null(_A_::$app->session('matches')['items'])) {
                $matches_items = _A_::$app->session('matches')['items'];
            } else {
                $matches_items = [];
            }

            if (count($matches_items) > 0) {
                foreach ($matches_items as $key => $item) {
                    if ($item['p_id'] == $p_id) {
                        unset($matches_items[$key]);
                    }
                }
            }

            $_matches = _A_::$app->session('matches');
            _A_::$app->session('matches')['items'] = $matches_items;
            _A_::$app->setSession('matches', $_matches);

        }
    }

    function clear()
    {
        if (!is_null(_A_::$app->session('matches')['items'])) {
            _A_::$app->setSession('matches', null);
        }
    }

    function all_to_cart()
    {
        $added = 0;
        if (!is_null(_A_::$app->post('data')) && !empty(_A_::$app->post('data'))) {
            $model = new Model_Cart();
            try{

                $products = json_decode(_A_::$app->post('data'));
                if (isset(_A_::$app->session('cart')['items'])) {
                    $cart_items = _A_::$app->session('cart')['items'];
                } else {
                    $cart_items = [];
                }

                $message = '';
                if(is_array($products) && (count($products)>0)){
                    foreach($products as $product_id){
                        $item_added = false;

                        foreach ($cart_items as $key => $item) {
                            if ($item['p_id'] == $product_id) {
                               // $cart_items[$key]['quantity'] += 1;
                                $item_added = true;
                            }
                        }
                        if (!$item_added) {
                            $product=$model->get_product_params($product_id);

                            ////////////
                            $pid = $product_id;
                            $price = $product['Price'];
                            $inventory = $product['inventory'];
                            $piece = $product['piece'];

                            if($inventory > 0) {

                                $mp = new Model_Price();
                                $format_price='';
                                $price = $mp->getPrintPrice($price, $format_price, $inventory, $piece);

                                $discountIds = array();
                                $saleprice = $product['Price'];
                                $sDiscount = 0;
                                $saleprice = $mp->calculateProductSalePrice($pid, $saleprice, $discountIds);
                                $bProductDiscount = $mp->checkProductDiscount($pid,$sDiscount,$saleprice, $discountIds);
                                $format_sale_price ='';
                                $saleprice = $mp->getPrintPrice($saleprice,$format_sale_price,$inventory,$piece);
                                $discount = $price - $saleprice;
                                $format_discount = "$" . number_format($discount, 2);;

                                $product['Price'] = $price;
                                $product['saleprice'] = $saleprice;
                                $product['discount'] = $discount;
                                $product['format_discount'] = $format_discount;
                                $product['format_price'] = $format_price;
                                $product['format_sale_price'] = $format_sale_price;

                                $cart_items[$product['p_id']] = $product;

                                $message .= 'The product '.$product['Product_name'].' have been added to your Basket.<br>';

                            } else {
                                $message .= 'The product '.$product['Product_name'].' is unavailable. The product was not added.<br>';

                            }
                        }
                    }
                    $cart = _A_::$app->session('cart');
                    $cart ['items'] = $cart_items;
                    _A_::$app->setSession('cart', $cart);

                    $SUM = 0;
                    foreach ($cart_items as $key => $item) {
                        $SUM += $item['quantity'] * $item['saleprice'];
                    }

                    $cart_sum = "$" . number_format($SUM, 2);

                    $message .= '<br>Click the Basket to view your Order.';
                    $message .= '<br>Subtotal sum of basket is '.$cart_sum;
                    $added = 1;
                }
                else
                    $message = 'Empty Matches Area. Nothing added to the Basket.';

            } catch (Exception $e ){

                $message = 'Empty Matches Area. Nothing added to the Basket.';
            }
        }
        else
            $message = 'Empty Matches Area. Nothing added to the Basket.';

        $this->template->vars('message',$message);
        $this->main->view_layout('msgs/msg_add_matches');
    }

    function product_in($p_id)
    {
        if (!is_null(_A_::$app->session('matches')['items'])) {
            $matches_items = _A_::$app->session('matches')['items'];
        } else {
            return false;

        }

        $item_added = false;
        foreach ($matches_items as $key => $item) {
            if ($item['p_id'] == $p_id) {
                $item_added = true;
                break;
            }
        }
        return $item_added;
    }

}