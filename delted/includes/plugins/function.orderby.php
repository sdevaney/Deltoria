<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
function smarty_function_orderby($params, &$smarty) {
    if ($_GET['OrderBy'] == $params['Name']) {
        print $params['Name']."+DESC";
    } else {
        print $params['Name'];
    }
}
?>