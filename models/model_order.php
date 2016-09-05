<?php

class Model_Order{

    /**
     * @return null|array
     */
    public static function getOrdersHistoryLength(){
        $total = null;
        $query =
            '
                SELECT 
                    COUNT(`fo`.`oid`) 
                FROM
                    `fabrix_orders` `fo` 
            ';
        if ($res = mysql_query($query)) {
            $total = mysql_fetch_row($res)[0];
        }
        return $total;
    }
    /**
     * @param  integer $aid
     * @return int|null
     */
    public static function getOrderLength($aid){
        $total = null;
        $query =
            '
                SELECT 
                    COUNT(`fo`.`oid`) 
                FROM
                    `fabrix_orders` `fo` 
                WHERE 
                    `fo`.`aid` = '.$aid.' 
            ';
        if ($res = mysql_query($query)) {
            $total = mysql_fetch_row($res)[0];
        }
        return $total;
    }

    public static function getOrderDetailInfo($arr){
        if(isset($arr) && count($arr) === 1){

            $data = (array) [];

            $query = '
               SELECT
                `fod`.`id`,
                `fod`.`order_id`,
                `fod`.`product_name`,
                `fod`.`quantity`,
                `fod`.`sale_price`,
                
                `fod`.`discount`,
                `fod`.`is_sample`,
                `fo`.`oid`,
                `fo`.`shipping_type`,
                `fo`.`total_discount`,
                
                `fo`.`shipping_cost`,
                `fo`.`shipping_discount`,
                `fo`.`track_code`,
                `fo`.`total`,
                `fo`.`handling`,
                
                `fo`.`status`,
                `fo`.`taxes`,
                `fo`.`end_date`,
                `fo`.`order_date`
                  
                FROM
                    `fabrix_order_details` `fod`
                LEFT JOIN
                    `fabrix_orders` `fo`
                ON
                    `fod`.`order_id` = `fo`.`oid`
                WHERE
                    `fo`.`oid` = '.$arr['oid'].'
            ';

            if ($res = mysql_query($query))
            {
                while ($row = mysql_fetch_assoc($res)) {
                    $data[] = $row;
                }

                return $data;
            }

            else
            {
                return null;
            }

        }

        else
        {
            return null;
        }
    }

    /**
    * @param  array $arr
    * @return array|null
    */
    public static function getUserOrdersList($arr){
        if(isset($arr) && count($arr) === 3){

            $data = (array) [];

            $query = '
                SELECT 
                
                `fo`.`oid`, 
                `fo`.`aid`, 
                `fo`.`trid`, 
                `fo`.`shipping_cost`, 
                `fo`.`handling`,
                `fo`.`shipping_discount`,
                
                `fo`.`coupon_discount`, 
                `fo`.`order_date`, 
                `fo`.`end_date`, 
                `fo`.`total`,
                `fo`.`status`,
                `fo`.`track_code`
                
                FROM  
                `fabrix_orders` `fo` 
                WHERE 
                `fo`.`aid` = '.$arr['aid'].'
                ORDER BY
                `fo`.`order_date` DESC
                LIMIT
                '.$arr['from'].', '.$arr['to'].'
            
            ';

            if ($res = mysql_query($query))
            {
                while ($row = mysql_fetch_assoc($res)) {
                    $data[] = $row;
                }

                return $data;
            }

            else
            {
                return null;
            }

        }

        else
        {
            return null;
        }

    }


    /**
    * @param  array $arr
    * @return array|null
    */
    public static function getOrdersList($arr){
        if(isset($arr) && count($arr) === 2){

            $data = (array) [];

            $query = '
                SELECT
                    `order`.`oid`,
                    `order`.`aid`,
                    `order`.`trid`,
                    `order`.`order_date` AS `date`,
                    `order`.`status`,
                    `order`.`handling`,
                    `order`.`track_code`,
                    `order`.`end_date`,
                    `order`.`total` AS `total_price`,
                    `user`.`aid` AS `id`,
                    CONCAT(`user`.`bill_firstname`,\' \',`user`.`bill_lastname`) AS `username`
                
                FROM
                    `fabrix_orders` `order`
                LEFT JOIN
                    `fabrix_accounts` `user`
                ON
                    `order`.`aid` = `user`.`aid`
                ORDER BY
                    `order`.`order_date` DESC
                LIMIT
    
                '.$arr['from'].', '.$arr['to'].'
            
            ';

            if ($res = mysql_query($query))
            {
                while ($row = mysql_fetch_assoc($res)) {
                    $data[] = $row;
                }

                return $data;
            }

            else
            {
                return null;
            }

        }

        else
        {
            return null;
        }

    }

    public static function getOrdersListLengthByQuery($like){
        $total = null;
        $query =
            '
                SELECT 
                     COUNT(`order`.`oid`),
                    `order`.`aid`,
                    `order`.`trid`,
                    
                     CONCAT(`user`.`bill_firstname`,\' \',`user`.`bill_lastname`)
                FROM
                    `fabrix_orders` `order`
                LEFT JOIN
                    `fabrix_accounts` `user`
                ON
                    `order`.`oid` = `user`.`aid`
                WHERE
                    (`order`.`trid` like "%'.$like.'%"
                OR
                    `user`.`bill_firstname` like "%'.$like.'%"
                OR
                    `user`.`bill_lastname` like "%'.$like.'%")
            ';
        if ($res = mysql_query($query)) {
            $total = mysql_fetch_row($res)[0];
        }
        return $total;
    }

    public static function getOrdersListByQuery($params){
        if(isset($params) && count($params) === 3){
            $data = (array) [];

            $query = '
                SELECT
                    `order`.`oid`,
                    `order`.`aid`,
                    `order`.`trid`,
                    `order`.`track_code`,
                    `order`.`end_date`,
                    `order`.`order_date` AS `date`,
                    `order`.`status`,
                    
                    `order`.`total` AS `total_price`,
                    `user`.`aid` AS `id`,
                    
                    CONCAT(`user`.`bill_firstname`,\' \',`user`.`bill_lastname`) as username
                    
                    FROM
                        `fabrix_orders` `order`
                    LEFT JOIN
                        `fabrix_accounts` `user`
                    ON
                        `order`.`aid` = `user`.`aid`
                    WHERE
                        (`order`.`trid` like "%'.$params['like'].'%"
                    OR
                        `user`.`bill_firstname` like "%'.$params['like'].'%"
                    OR
                        `user`.`bill_lastname` like "%'.$params['like'].'%")
                    ORDER BY
                        `order`.`order_date` DESC
                    LIMIT
                        '.$params['from'].', '.$params['to'].'
            
            ';

            if ($res = mysql_query($query))
            {
                while ($row = mysql_fetch_assoc($res)) {
                    $data[] = $row;
                }

                return $data;
            }

            else
            {
                return null;
            }

        }
    }

}