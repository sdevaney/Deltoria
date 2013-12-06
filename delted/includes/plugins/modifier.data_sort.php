<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
function smarty_modifier_data_sort($modifier,$array,$key = "",$direction = "a") {

    if (sizeof($array) == 0) return;

    for ($i = 0; $i < sizeof($array); $i++) {
        $sort_values[$i] = $array[$i][$key];
    }
    if ($direction == "r") {
        arsort($sort_values);
    } else {
        asort ($sort_values);
    }
    reset ($sort_values);
    while (list ($arr_key, $arr_val) = each ($sort_values)) {
        $sorted_arr[] = $array[$arr_key];
    }
    return $sorted_arr;
}
?>