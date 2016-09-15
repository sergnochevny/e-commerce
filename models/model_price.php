<?php

Class Model_Price extends Model_Model
{

    function sysHideAllRegularPrices()
    {
        $hideAllRegularPrices = false;
        $sqlGetGlobalPrice = 'SELECT * FROM fabrix_system_master;';
        $resultGetGlobalPrice = mysql_query($sqlGetGlobalPrice);
        if ($resultGetGlobalPrice) {
            $rsgbp = mysql_fetch_assoc($resultGetGlobalPrice);
            $hideAllRegularPrices = (bool)$rsgbp['hide_all_regular_prices'];
        }
        return $hideAllRegularPrices;
    }

    function getPrintPrice($price, &$format_price, $inventory = 0, $piece = 0)
    {
        if ($piece == 1 && $inventory > 0) {
            $price = $price * $inventory;
            $format_price = $this->formatPrice($price);
            $format_price = sprintf('%s /piece', $format_price);
        } else {
            $format_price = $this->formatPrice($price);
            $format_price = sprintf('%s /yard', $format_price);
        }
        return $price;
    }

    function formatPrice($price)
    {
        $price = "$" . number_format($price, 2);
        return $price;
    }

    function calculateDiscount($discount_category, $uid, $aPrdcts, $rPrice, $rShip, $sCoupon, &$bCodeValid, $bReturnString, &$sPriceDiscount, &$sShippingDiscount, $shipType, &$discountIds)
    {

        #strings for the single and multiple discounts
        $sSingle = '';
        $sMultiple = '';
        $iCountSingle = 0;
        $iCountMultiple = 0;

        $sShippingDiscount1 = '';
        $sShippingDiscount2 = '';
        $sShippingDiscount3 = '';
        $uid = (int)$uid;

        #make sure that the user is entering a coupon code when we are checking for a coupon
        if (($discount_category == DISCOUNT_CATEGORY_COUPON) && strlen($sCoupon) == 0) {
            return 0;
        }

        $rDiscount = 0;
        $rMultDiscount = 0;
        $rPrice = preg_replace('/[^\.|\d]/', '', $rPrice);
        $rShip = preg_replace('/[^\.|\d]/', '', $rShip);

        /*
            user_type = 1 - All users
            user_type = 2 - All new users
            user_type = 3 - All registered users
            user_type = 4 - All selected users

            discount_amount_type = 1 - $
            discount_amount_type = 2 - %

            discount_type = 1 - total
            discount_type = 2 - shipping

            required_type 1 purchases - 2 total amount
            required_type 1 purchases - 2 total amount

        */

        #check the discounts for the users
        $sSQL = "SELECT DISTINCT s.sid, s.required_type, s.required_amount, s.date_start, s.promotion_type," .
            " s.discount_type, s.shipping_type, s.discount_amount, s.discount_amount_type, s.product_type, " .
            "s.allow_multiple, s.coupon_code " .
            "FROM fabrix_specials s " .
            "LEFT OUTER JOIN fabrix_specials_users su ON su.sid=s.sid " .
            "LEFT OUTER JOIN fabrix_specials_products sp ON s.sid = sp.sid " .
            "WHERE (s.user_type=1";

        if ($uid > 0) {
            $sSQL .= sprintf(" OR (s.user_type=4 AND su.aid=%u)", $uid);
            $sSQL .= sprintf(" OR (user_type=%u)", $this->getUserType($uid));
        }
        $sSQL .= ")";

        #CHANGED PRODUCT DISCOUNT SHOWN IN PRICE, NO LONGER CALCULATED HERE
        $sPds = '';
        $sSQL .= " AND (s.product_type = 1)";

        #add a check to ensure the function only checks shipping discounts
        if ($discount_category == DISCOUNT_CATEGORY_SHIPPING) {
            $sSQL .= sprintf(" AND (s.discount_type = %u)", DISCOUNT_TYPE_SHIPPING);

            #add the shipping type restriction
            if ($shipType == 3) {            #ground shipping
                $sSQL .= ' AND (s.shipping_type = 2 OR s.shipping_type = 1)';
            } else if ($shipType == 1) {    #express shipping
                $sSQL .= ' AND (s.shipping_type = 3 OR s.shipping_type = 1)';
            }

        } else if (($discount_category != DISCOUNT_CATEGORY_ALL) && ($discount_category != DISCOUNT_CATEGORY_COUPON)) {
            $sSQL .= sprintf(" AND (s.discount_type != %u)", DISCOUNT_TYPE_SHIPPING);
        }

        #check the coupon code if the discount category is for coupon code
        if ($discount_category == DISCOUNT_CATEGORY_COUPON) {
            $sSQL .= sprintf(" AND (s.coupon_code='%s')", $sCoupon);

            #add the shipping type restriction
            if ($shipType == 3) {            #ground shipping
                $sSQL .= ' AND (s.shipping_type = 2 OR s.shipping_type = 1 OR s.shipping_type = 0)';
            } else if ($shipType == 1) {    #express shipping
                $sSQL .= ' AND (s.shipping_type = 3 OR s.shipping_type = 1 OR s.shipping_type = 0)';
            }

        } else {
            $sSQL .= sprintf(" AND (s.coupon_code='')");
        }

        $iNow = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $sSQL .= sprintf(" AND (s.enabled=1) AND (s.date_start<=%u) AND (s.date_end>=%u)", $iNow, $iNow);
        $sSQL .= " ORDER BY allow_multiple;";

        $result = mysql_query($sSQL) or die(mysql_error());
        if (mysql_num_rows($result) > 0) {
            $shipFullSumDiscount1 = false;
            $shipFullSumDiscount2 = false;
            $shipFullSumDiscount3 = false;

            while ($rs = mysql_fetch_assoc($result)) {

                $bDoDiscount = $this->checkDiscountApplies($rs, $uid, $rPrice);

                if ($bDoDiscount) {

                    if ($bReturnString) {

                        #get the string for the discount amount
                        $tempAmt = number_format($rs['discount_amount'], 2, '.', '');
                        $tempAmtString = '';
                        $temp = '';
                        if ($rs['discount_amount_type'] == 1) {        #$
                            $tempAmtString = sprintf("$%s", $tempAmt);
                        } else if ($rs['discount_amount_type'] == 2) {    #%
                            $tempAmtString = sprintf("%s%%", $tempAmt);
                        }

                    }

                    #check if we are returning a string or the new price
                    if ($bReturnString && $rs['discount_type'] == DISCOUNT_TYPE_SHIPPING) {

                        $strShp = '';
                        if ($rs['shipping_type'] == 1) {
                            $strShp = 'Shipping';
                            if (!$shipFullSumDiscount1) {
                                if (strlen($sShippingDiscount1) > 0) {
                                    $sShippingDiscount1 .= DISCOUNT_STRING_JOINER;
                                }
                                if ($tempAmtString == "100.00%") {
                                    $sShippingDiscount1 = sprintf("%s FREE.", $strShp);
                                    $shipFullSumDiscount1 = true;
                                } else {
                                    $sShippingDiscount1 .= sprintf("%s will be reduced by %s.", $strShp, $tempAmtString);
                                }
                            }
                        } else if ($rs['shipping_type'] == 2) {
                            $strShp = 'Ground shipping';
                            if (!$shipFullSumDiscount2) {
                                if (strlen($sShippingDiscount2) > 0) {
                                    $sShippingDiscount2 .= DISCOUNT_STRING_JOINER;
                                }
                                if ($tempAmtString == "100.00%") {
                                    $sShippingDiscount2 = sprintf("%s FREE.", $strShp);
                                    $shipFullSumDiscount2 = true;
                                } else {
                                    $sShippingDiscount2 .= sprintf("%s will be reduced by %s.", $strShp, $tempAmtString);
                                }
                            }
                        } else if ($rs['shipping_type'] == 3) {
                            $strShp = 'Express shipping';
                            if (!$shipFullSumDiscount3) {
                                if (strlen($sShippingDiscount3) > 0) {
                                    $sShippingDiscount3 .= DISCOUNT_STRING_JOINER;
                                }
                                if ($tempAmtString == "100.00%") {
                                    $sShippingDiscount3 = sprintf("%s FREE.", $strShp);
                                    $shipFullSumDiscount3 = true;
                                } else {
                                    $sShippingDiscount3 .= sprintf("%s will be reduced by %s.", $strShp, $tempAmtString);
                                }
                            }
                        }

                    } else {

                        #check if we need to return a string here
                        if ($bReturnString) {

                            if ($rs['discount_type'] == DISCOUNT_TYPE_SUBTOTAL) {
                                $temp = sprintf("Reduced by %s.", $tempAmtString);
                            } else if ($rs['discount_type'] == DISCOUNT_TYPE_TOTAL) {
                                $temp = sprintf("Your total order is reduced by %s.", $tempAmtString);
                            }

                        }

                        $tmpDiscount = $this->discountIt($discount_category, $rPrice, $rShip, $rs['discount_amount'], $rs['discount_amount_type'], $rs['discount_type'], $rs['product_type'], $rs['sid'], $aPrdcts, $sPds);
                        if ($discount_category == DISCOUNT_CATEGORY_SHIPPING) {
                            $rShip -= $tmpDiscount;
                        } else $rPrice -= $tmpDiscount;
                        #determine whether we are using a multiple or single discount
                        #the system will take the highest not multiple discount and add it to the sum of all the multiple discounts
                        if ((int)$rs['allow_multiple'] == 1) {
                            $rMultDiscount += $tmpDiscount;
                            $discountIds[] = $rs['sid'];
                            #check if we need to return a string here
                            if ($bReturnString) {
                                if (strlen($sMultiple) > 0) {
                                    $sMultiple .= DISCOUNT_STRING_JOINER;
                                }
                                $sMultiple .= $temp;
                            }
                        } else if ($tmpDiscount > $rDiscount) {

                            if ($rDiscount == 0) {
                                $discountIds[] = $rs['sid'];
                            } else {
                                $discountIds[count($discountIds) - 1] = $rs['sid'];
                            }

                            $rDiscount = $tmpDiscount;

                            #check if we need to return a string here
                            if ($bReturnString) {
                                $sSingle = $temp;
                            }
                        }

                        if ((strlen($sCoupon)) && ($rs['coupon_code'] == $sCoupon)) {
                            $bCodeValid = true;
                        }

                    }

                }

            }

        }
        mysql_free_result($result);

        #check if we need to return a string here
        if ($bReturnString) {
            $sPriceDiscount = $sSingle;
            if ((strlen($sSingle) > 0) && (strlen($sMultiple) > 0)) {
                $sPriceDiscount .= DISCOUNT_STRING_JOINER;
            }
            $sPriceDiscount .= $sMultiple;
        }

        $rDiscount = $rDiscount + $rMultDiscount;

        $sShippingDiscount .= $sShippingDiscount1;
        if (strlen($sShippingDiscount) > 0 && strlen($sShippingDiscount2) > 0) {
            $sShippingDiscount .= DISCOUNT_STRING_JOINER;
        }
        $sShippingDiscount .= $sShippingDiscount2;
        if (strlen($sShippingDiscount) > 0 && strlen($sShippingDiscount3) > 0) {
            $sShippingDiscount .= DISCOUNT_STRING_JOINER;
        }
        $sShippingDiscount .= $sShippingDiscount3;

        return $rDiscount;

    }

    function checkDiscountApplies($rs, $uid, $rPrice)
    {

        $bDoDiscount = false;

        $iType = (int)$rs['promotion_type'];
        switch ($iType) {
            case 1: #Any purchase
                if ($rPrice >= $rs['required_amount']) {
                    $bDoDiscount = true;
                }
                break;

            case 2: #First purchase
                $iPur = $this->getTransactionDetails($uid, false, true);
                if ($iPur == 0) {
                    $bDoDiscount = true;
                }
                break;

            case 3: #Next Purchase
                if ($this->isNextPurchase($uid, $rs['date_start'])) {
                    if ((int)$rs['required_amount'] > 0) {
                        if ($rs['required_type'] == 1) {            #number of purchases
                            $iPur = $this->getTransactionDetails($uid, false, true);
                            if ($iPur >= $rs['required_amount']) {
                                $bDoDiscount = true;
                            }
                        } else if ($rs['required_type'] == 2) {        #amount spent
                            if ($rPrice >= $rs['required_amount']) {
                                $bDoDiscount = true;
                            }
                        }
                    } else {
                        $bDoDiscount = true;
                    }
                }
                break;

            case 4: #Account Total
                if ($rs['required_type'] == 1) {            #number of purchases
                    $iPur = $this->getTransactionDetails($uid, false, true);
                    if ($iPur >= $rs['required_amount']) {
                        $bDoDiscount = true;
                    }
                } else if ($rs['required_type'] == 2) {        #amount spent
                    $iPur = $this->getTransactionDetails($uid, true, true);
                    if ($iPur >= $rs['required_amount']) {
                        $bDoDiscount = true;
                    }
                }
                break;

            case 5: #Account Total For Last Month

                if ($rs['required_type'] == 1) {            #number of purchases
                    $iPur = $this->getTransactionDetails($uid, false, false);
                    if ($iPur >= $rs['required_amount']) {
                        $bDoDiscount = true;
                    }
                } else if ($rs['required_type'] == 2) {        #amount spent
                    $iPur = $this->getTransactionDetails($uid, true, false);
                    if ($iPur >= $rs['required_amount']) {
                        $bDoDiscount = true;
                    }
                }
                break;

        }

        return $bDoDiscount;

    }

    function isNextPurchase($id, $iStart)
    {

        $bNext = false;

        $sSQL = sprintf("SELECT oid FROM fabrix_orders WHERE aid=%u AND order_date > %u ORDER BY order_date DESC;", $id, $iStart);

        $result = mysql_query($sSQL) or die(mysql_error());
        if (mysql_num_rows($result) == 0) {
            $bNext = true;
        }
        mysql_free_result($result);

        return $bNext;

    }

    function checkProductDiscount($id, &$discount, &$price, &$discountIds)
    {

        if ((int)$id == 0) {
            return false;
        }

        $bol = false;
        $iNow = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $tempPrice = $price;

        /*
            discount_amount_type = 1 - $
            discount_amount_type = 2 - %

            discount_type = 1 - sub total
            discount_type = 2 - shipping
            discount_type = 3 - total
        */

        #check the discounts for the users
        $sql = sprintf("SELECT DISTINCT s.discount_type, s.discount_amount, s.discount_amount_type, p.priceyard, s.sid FROM fabrix_specials s LEFT OUTER JOIN fabrix_specials_users su ON su.sid=s.sid LEFT OUTER JOIN fabrix_specials_products sp ON s.sid = sp.sid INNER JOIN fabrix_products p ON sp.pid = p.pid WHERE (s.user_type=1) AND (s.product_type = 2 AND sp.pid IN (%s)) AND (s.coupon_code='') AND (s.enabled=1) AND (s.date_start<=%u) AND (s.date_end>=%u) AND (required_type = 0) AND (promotion_type=1);", $id, $iNow, $iNow);

        $result = mysql_query($sql) or die(mysql_error());

        if (mysql_num_rows($result) > 0) {

            if ($rs = mysql_fetch_assoc($result)) {

                $amt = $rs['discount_amount'];

                if ($rs['discount_amount_type'] == 1) {

                    $type = '$';
                    $discount = sprintf("%s%s", $type, $amt);
                    $tempPrice = $tempPrice - $amt;

                } else {

                    $type = '%';
                    $discount = sprintf("%s%s", $amt, $type);
                    $tempPrice = $tempPrice * (1 - ($amt / 100));

                }

                if ($tempPrice != $price) {
                    $bol = true;
                    $price = $tempPrice;
                    $discountIds[] = $rs['sid'];
                }

            }

        }

        mysql_free_result($result);

        return $bol;

    }

    function calculateProductSalePrice($pid, $price, &$discountIds)
    {

        #do the check to see if there is a system wide discount
        $aPrds = array();
        $aPrds[] = $pid;    #add product id
        $aPrds[] = 1;        #add qty

        #set the return price to the current price, the return price will be changed if needed
        $ret = $price;

        #get the shipping
        if ((array_key_exists('cship', $_COOKIE)) && ((int)$_COOKIE['cship'] > 0)) {
            $shipping = (int)$_COOKIE['cship'];
        } else {
            $shipping = DEFAULT_SHIPPING;
        }
        if ((array_key_exists('cshproll', $_COOKIE)) && ((int)$_COOKIE['cshproll'] > 0)) {
            $bShipRoll = true;
        } else {
            $bShipRoll = false;
        }

        #grab the user id
        if (isset($_SESSION['user'])) {
            $uid = (int)$_SESSION['user']['aid'];
        } else {
            $uid = 0;
        }

        #create the fake variables as they will not be needed
        $bTemp = false;        #passed in by reference, not needed anywhere
        $NOT_USED = '';
        $shipcost = 0;

        $rSystemDiscount = $this->calculateDiscount(DISCOUNT_CATEGORY_PRODUCT, $uid, $aPrds, $price, $shipcost, '', $bTemp, false, $NOT_USED, $NOT_USED, $shipping, $discountIds);
        if ($rSystemDiscount > 0) {
            $ret = $price - $rSystemDiscount;
        }

        return $ret;

    }

    function doDiscount($rAmt, $rDis, $iType)
    {

        $rRet = 0;

        //discount_amount_type = 1 - $ off
        //discount_amount_type = 2 - % off
        if ($iType == 1) {
            $rRet = $rDis;
        } else if ($iType == 2) {
            $rRet = $rAmt * ($rDis / 100);
        }

        return $rRet;

    }

    /*function validateCoupon($sCoupon){

        $iNow = time();
        $sSQL .= sprintf("SELECT * FROM fabrix_specials WHERE enabled=1 AND date_start<=%u AND date_end>=%u AND coupon_code='%s';",$iNow,$iNow,ilter($bCodeValid));
        $result = mysql_query($sSQL) or die(mysql_error());
        if(mysql_num_rows($result)>0){
            $bRet = true;
        } else {
            $bRet = false;
        }
        mysql_free_result($result);

        return $bRet;

    }*/

    function discountIt($discount_category, $rTtl, $rShip, $rDis, $iDisAmntType, $iDisType, $iPrdType, $iSid, $aPrd, $sPds)
    {

        $rRet = 0;

        $rDis = preg_replace('/[^\.|\d]/', '', $rDis);

        #CHANGED PRODUCT DISCOUNT SHOWN IN PRICE, NO LONGER CALCULATED HERE
        #see if the product discount is for all products or only the chosen product
        #if iPrdType = 2 then it applies only to that product and we have to get the price associated with that product
        /*if($iPrdType == 2){

            $rTtl = getProductsTotal($aPrd,$iSid, $sPds);

            #force the discount type to be the sub total
            $iDisType = 1;

        }*/

        //discount_type = 1 - total wo shipping	- default
        //discount_type = 2 - shipping
        //discount_type = 3 - total w/ shipping
        if ($iDisType == 2) {
            $rRet = $this->doDiscount($rShip, $rDis, $iDisAmntType);
        } else if ($iDisType == 3) {
            $rRet = $this->doDiscount(($rTtl + $rShip + RATE_HANDLING), $rDis, $iDisAmntType);
        } else {

            if (($discount_category != DISCOUNT_CATEGORY_COUPON) && ($iDisAmntType == 1)) {    #$ amount
                $iQty = 0;
                for ($i = 1; $i < count($aPrd); $i++) {

                    $iQty += (int)$aPrd[$i];

                    #skip one as qty is every other
                    $i++;

                }

            } else {
                $iQty = 1;
            }

            $rRet = $this->doDiscount($rTtl, $rDis, $iDisAmntType, $iQty);
            $rRet = $iQty * $rRet;

        }

        return $rRet;

    }


    function getProductsTotal($aPrd, $iSid, $sPds)
    {

        #make sure we receive an special id and a list of the product ids
        if (((int)$iSid == 0) && (strlen($sPds) > 0)) {
            return 0;
        }

        #define the total
        $rTtl = 0;

        #get the list of all the products that this special applies to, narrow down to only those that may be in the cart
        $sql = sprintf("SELECT sp.pid, p.priceyard FROM fabrix_specials_products sp INNER JOIN fabrix_products p ON sp.pid = p.pid WHERE sp.sid=%u AND sp.pid IN (%s);", $iSid, $sPds);

        $result = mysql_query($sql) or die(mysql_error());

        while ($rs = mysql_fetch_row($result)) {

            $iPid = (int)$rs[0];
            $iPrice = (real)$rs[1];

            #examine the products array and return the qty for that product
            $idx = array_search($iPid, $aPrd);

            #make sure that the product id was found
            if ($idx === false) {
                continue;
            }

            $qty = (int)$aPrd[++$idx];

            #calculate the subtotal for this product
            $rTtl += $iPrice * $qty;

        }

        mysql_free_result($result);

        return $rTtl;

    }

    function getUserType($uid)
    {

        $iTtl = $this->getTransactionDetails($uid, false, true);

        if ($iTtl > 0) {
            return 3;
        } else {
            return 2;
        }

    }

    function getTransactionDetails($id, $bVolume, $bTotal)
    {

        $rRet = 0;

        if ($bVolume) {
            $chk = "SUM(total)";
        } else {
            $chk = "COUNT(oid)";
        }

        $sSQL = sprintf("SELECT %s FROM fabrix_orders WHERE aid=%u", $chk, $id);

        if (!$bTotal) {

            $iMonth = date('m');
            $iYear = date('Y');
            $iBeginMonth = mktime(0, 0, 0, ($iMonth - 1), 1, $iYear);
            $iEndMonth = mktime(0, 0, 0, $iMonth, 1, $iYear);

            $sSQL .= sprintf(" AND order_date<=%u AND order_date>=%u;", $iEndMonth, $iBeginMonth);

        }

        $result = mysql_query($sSQL) or die(mysql_error());
        if (mysql_num_rows($result)) {
            $rs = mysql_fetch_row($result);
            $rRet = (real)$rs[0];
        }
        mysql_free_result($result);

        return $rRet;

    }


    function saveDiscountUsage($discountIds, $oid)
    {

        #delete any record of discounts on this order, in case thankyou.php is refreshed.
        $delete = sprintf("DELETE from fabrix_specials_usage WHERE orderId = %u", $oid);
        mysql_query($delete) or die(mysql_error());

        #loop through the discountIds and add them and the order id to the specials_usage table
        foreach ($discountIds as $discount) {
            $sSQL = sprintf("INSERT INTO fabrix_specials_usage (specialId, orderId) values (%u, %u)", $discount, $oid);
            mysql_query($sSQL) or die(mysql_error());

        }

    }

    function getNextChangeInDiscoutDate($discountIds)
    {
        $query = "";
        if (count($discountIds) > 0) {
            $ids = implode(',', $discountIds);
            $query = sprintf("SELECT MIN(date_end) AS next_date FROM fabrix_specials WHERE sid IN (%s) AND countdown = 0;", $ids);
        }

        if (strlen($query) > 0) {
            $result = mysql_query($query) or die(mysql_error());
            $rs = mysql_fetch_assoc($result);
            return $rs['next_date'];
        } else {
            return 0;
        }
    }

    function displayDiscountTimeRemaining($discountIds)
    {

        $changeDate = $this->getNextChangeInDiscoutDate($discountIds);
        $changeDate += 86399;

        $now = time();
        $difference = $changeDate - $now;
        $days_left = floor($difference / 60 / 60 / 24);
        $hours_left = floor(($difference - $days_left * 60 * 60 * 24) / 60 / 60);
        $minutes_left = floor(($difference - $days_left * 60 * 60 * 24 - $hours_left * 60 * 60) / 60);

        $displayString = "";
        if ($days_left > 0) {
            $displayString = $days_left;
            if ($days_left == 1) {
                $displayString .= " day";
            } else {
                $displayString .= " days";
            }
        } elseif ($days_left == 0 && $hours_left > 0) {
            $displayString = $hours_left . " hours";
        } elseif ($days_left == 0 && $hours_left == 0) {
            $displayString = $minutes_left . " minutes";
        }

        return $displayString;
    }

    public function user_TaxRate($aid)
    {

        $sql = sprintf('SELECT bill_province FROM fabrix_accounts WHERE aid =' . $aid);
        $result = mysql_query($sql);

        if($result){
            if ($rs = mysql_fetch_row($result)) {
                $userProvince = $rs[0];
                if(!(empty($userProvince))){
                    $sql = sprintf('SELECT tax_rate FROM fabrix_taxrates WHERE province_state_id = ' . $userProvince);
                    $result = mysql_query($sql);
                    if($result){
                        if ($rs = mysql_fetch_row($result)) {
                            $tax = $rs[0];
                            if(!empty($tax)) return $tax;
                        }
                    }
                }
            }
        }

        return 0;
    }

}