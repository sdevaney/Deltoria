<?php
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
function smarty_function_optionsplit($params, &$smarty) {
	if (strstr($params['options'],",")) {
		$keydef = 1;
	} else {
		$keydef = 0;
	}

	$opt_data = array();
	$options = explode(";",$params['options']);
	foreach ($options as $data) {
		if ($keydef) {
			list($k,$v) = explode(",",$data);
			$opt_data[] = array("key" => $k, "value" => $v);
		} else {
			$opt_data[] = $data;
		}

	}
	$smarty->assign($params['return'],$opt_data);
}

?>