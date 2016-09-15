<?php

Class Model_Shipping extends Model_Model
{

#define the rates that are used outside the calculate shipping funciton
    function calculateShipping($ship, $aPrds, $bShipRoll)
    {
        #make sure that there are products here;
        if (count($aPrds) > 0) {
            #define the shipping total
            $iTtl = 0;
            #store the weight type, default is medium
            $iWid = 0;
            #create the list of product ids, and the ttl yardage
            $sPds = "";
            $iQty = 0;
            for ($i = 0; $i < count($aPrds); $i++) {
                if (strlen($sPds) > 0) {
                    $sPds .= ",";
                }
                $sPds .= $aPrds[$i];
                $iQty += $aPrds[++$i];
            }
            #grab the default cids or the weight_ids from the products
            $sSQL = sprintf("SELECT weight_id, cid FROM fabrix_products WHERE pid IN (%s);", $sPds);
            $result = mysql_query($sSQL) or die(mysql_error());
            while ($rs = mysql_fetch_assoc($result)) {
                $iTmpWid = 0;
                if ((int)$rs['weight_id'] > 0) {
                    $iTmpWid = (int)$rs['weight_id'];
                } else {
                    switch ((int)$rs['cid']) {
                        case 10:
                            $iTmpWid = LIGHT_FABRIC;
                            break;
                        case 2:
                        case 4:
                        case 8:
                        case 9:
                        case 11:
                        case 15:
                        case 22:
                            $iTmpWid = HEAVY_FABRIC;
                            break;
                        default:
                            $iTmpWid = MEDIUM_FABRIC;
                            break;
                    }
                }
                #check if the weight will go up
                if ($iTmpWid > $iWid) {
                    $iWid = $iTmpWid;
                }
                #check if we are already at the heaviest category, if so skip the rest of the iterations and go on
                if ($iWid == HEAVY_FABRIC) {
                    break;
                }
            }
            mysql_free_result($result);
            #ship = 1 is express shipping
            if ($ship == "1") {
                switch ($iWid) {
                    case LIGHT_FABRIC:
                        $iTtl = RATE_EXPRESS_LIGHT;
                        break;
                    case HEAVY_FABRIC:
                        $iTtl = RATE_EXPRESS_HEAVY;
                        break;
                    case MEDIUM_FABRIC:
                    default:
                        $iTtl = RATE_EXPRESS_MEDIUM;
                        break;
                }
                if ($iQty > 2.0) {
                    switch ($iWid) {
                        case LIGHT_FABRIC:
                            $iTtl += ($iQty - YRDS_FOR_MULTIPLIER) * RATE_EXPRESS_LIGHT_MULTIPLIER;
                            break;
                        case HEAVY_FABRIC:
                            $iTtl += ($iQty - YRDS_FOR_MULTIPLIER) * RATE_EXPRESS_HEAVY_MULTIPLIER;
                            break;
                        case MEDIUM_FABRIC:
                        default:
                            $iTtl += ($iQty - YRDS_FOR_MULTIPLIER) * RATE_EXPRESS_MEDIUM_MULTIPLIER;
                            break;
                    }
                }
            } else if ($ship == "3") {    #ship = 3 is ground shipping
                switch ($iWid) {
                    case LIGHT_FABRIC:
                        $iTtl = RATE_GROUND_LIGHT;
                        break;
                    case HEAVY_FABRIC:
                        $iTtl = RATE_GROUND_HEAVY;
                        break;
                    case MEDIUM_FABRIC:
                    default:
                        $iTtl = RATE_GROUND_MEDIUM;
                        break;
                }
                if ($iQty > 2.0) {
                    switch ($iWid) {
                        case LIGHT_FABRIC:
                            $iTtl += ($iQty - YRDS_FOR_MULTIPLIER) * RATE_GROUND_LIGHT_MULTIPLIER;
                            break;
                        case HEAVY_FABRIC:
                            $iTtl += ($iQty - YRDS_FOR_MULTIPLIER) * RATE_GROUND_HEAVY_MULTIPLIER;
                            break;
                        case MEDIUM_FABRIC:
                        default:
                            $iTtl += ($iQty - YRDS_FOR_MULTIPLIER) * RATE_GROUND_MEDIUM_MULTIPLIER;
                            break;
                    }
                }
            }
        }
        return $iTtl;
    }
}